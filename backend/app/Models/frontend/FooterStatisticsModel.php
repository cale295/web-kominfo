<?php

namespace App\Models\frontend;

use CodeIgniter\Model;
use CodeIgniter\Validation\Rules;

class FooterStatisticsModel extends Model
{
    // Konfigurasi Tabel
    protected $table            = 'm_footer_statistics';
    protected $primaryKey       = 'id_footer_statis';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // Kolom yang boleh diisi
    protected $allowedFields    = [
        'stat_type',    // Unik, misal: visitors_today
        'stat_label',   // Label Frontend: Pengunjung Hari Ini
        'stat_value',   // Nilai: 1024
        'is_active',
        'auto_update',  // 1 = Hitung otomatis sistem, 0 = Input manual
        'sorting',
        'created_by',
        'updated_by'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Casting
    protected array $casts = [
        'id_footer_statis' => 'int',
        'stat_value'       => 'int',
        'is_active'        => 'int',
        'auto_update'      => 'int',
        'sorting'          => 'int',
    ];

    // Dates Management
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at'; // Otomatis update sesuai definisi tabel

    // Validation Rules
    protected $validationRules = [


        'id_footer_statis' => [
            'rules' => 'permit_empty'
        ],

        'stat_type' => [
            'rules'  => 'required|max_length[50]|is_unique[m_footer_statistics.stat_type,id_footer_statis,{id_footer_statis}]',
            'label'  => 'Tipe Statistik'
        ],
        'stat_label' => [
            'rules'  => 'required|max_length[100]',
            'label'  => 'Label Tampilan'
        ],
        'sorting' => [
            'rules'  => 'required|numeric',
            'label'  => 'Urutan'
        ],
        'is_active' => [
            'rules'  => 'required|in_list[0,1]',
            'label'  => 'Status Aktif'
        ],
        'auto_update' => [
            'rules'  => 'required|in_list[0,1]',
            'label'  => 'Auto Update'
        ],
    ];

    // Custom Messages
    protected $validationMessages = [
        'stat_type' => [
            'required'  => '{field} wajib diisi.',
            'is_unique' => '{field} ini sudah digunakan, harap pilih tipe lain.'
        ],
        'stat_value' => [
            'numeric' => '{field} harus berupa angka.'
        ]
    ];

        public function syncAutoStats()
    {
        $db = \Config\Database::connect();
        
        // 1. Hitung Total Visitors (Semua row di t_visitors)
        $totalVisitors = $db->table('t_visitors')->countAllResults();

        // 2. Hitung Today Visitors (Row dengan access_date hari ini)
        $todayVisitors = $db->table('t_visitors')
                            ->where('access_date', date('Y-m-d'))
                            ->countAllResults();

        // 3. Hitung Online Visitors (Row dengan last_activity 5 menit terakhir)
        // Interval bisa diubah sesuai kebutuhan
        $fiveMinutesAgo = date('Y-m-d H:i:s', strtotime('-5 minutes'));
        $onlineVisitors = $db->table('t_visitors')
                            ->where('last_activity >=', $fiveMinutesAgo)
                            ->countAllResults();

        // 4. Update ke tabel m_footer_statistics
        // Hanya update jika auto_update = 1
        
        // Update Total
        $this->where('stat_type', 'total_visitors')
             ->where('auto_update', 1)
             ->set(['stat_value' => $totalVisitors])
             ->update();

        // Update Today
        $this->where('stat_type', 'today_visitors')
             ->where('auto_update', 1)
             ->set(['stat_value' => $todayVisitors])
             ->update();
             
        // Update Online
        $this->where('stat_type', 'online_visitors')
             ->where('auto_update', 1)
             ->set(['stat_value' => $onlineVisitors])
             ->update();
    }
}