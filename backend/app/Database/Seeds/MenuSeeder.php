<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // 1. NONAKTIFKAN pemeriksaan Foreign Key sementara
        $this->db->disableForeignKeyChecks();

        $data = [
            // Level 1 (Menu Utama: parent_id = 0)
            [
                'menu_name' => 'PROFILE', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-home', 
                'order_number' => 1, 
                'parent_id' => 0
            ],
            [
                'menu_name' => 'BERITA', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-database', 
                'order_number' => 2, 
                'parent_id' => 0
            ],
            [
                'menu_name' => 'PROGRAM', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-chart', 
                'order_number' => 3, 
                'parent_id' => 0
            ],
            [
                'menu_name' => 'INFORMASI PUBLIK', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-database', 
                'order_number' => 4, 
                'parent_id' => 0
            ],
            [
                'menu_name' => 'PPID', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-database', 
                'order_number' => 5, 
                'parent_id' => 0
            ],
            [
                'menu_name' => 'GALERI', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-database', 
                'order_number' => 6, 
                'parent_id' => 0
            ],
            [
                'menu_name' => 'KONTAK', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-database', 
                'order_number' => 7, 
                'parent_id' => 0
            ],
            
            // Level 2 (Sub-Menu dari Master Data: parent_id = 2)
            // level 2 Untuk Profile
            [
                'menu_name' => 'Tentang', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-users', 
                'order_number' => 1, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Profil Pejabat Struktural', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-users', 
                'order_number' => 1, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Tugas Dan Fungsi', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-users', 
                'order_number' => 1, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Struktur Organisasi', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-users', 
                'order_number' => 1, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Seketariat', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-users', 
                'order_number' => 1, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Bidang Diseminasi Informasi Dan Komunikasi Publik', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-users', 
                'order_number' => 1, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Bidang Saran, Prasarana TIK dan Persandian', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-users', 
                'order_number' => 1, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Bidang Statistika Dan Pemberdayaan TIK', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-users', 
                'order_number' => 1, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Bidang Pengembangan E-Goverment', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-users', 
                'order_number' => 1, 
                'parent_id' => 2
            ],
            
            // level 2 Untuk Program
            [
                'menu_name' => 'Program SKPD', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 3, 
                'parent_id' => 2
            ],

            // level 2 Untuk Informasi Publik
            [
                'menu_name' => 'Perencanaan', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 4, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Pengadaan Barang dan Jasa', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 4, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Laporan Keuangan', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 4, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Laporan Kinerja', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 4, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Pendidikan dan Pelatihan', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 4, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Permohonan Informasi', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 4, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Daftar Informasi Publik', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 4, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Kerjasama Daerah', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 4, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Regulasi', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 4, 
                'parent_id' => 2
            ],

            // lvl 2 untuk ppibd
            [
                'menu_name' => 'Ajukan Permohonan', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 5, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Lacak Permohonan', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 5, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Keberatan', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 5, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Klasifikasi Informasi', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 5, 
                'parent_id' => 2
            ],

            // level 2 dari galeri
            [
                'menu_name' => 'Galeri Foto', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 6, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Galeri Video', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 6, 
                'parent_id' => 2
            ],
            // Level 3 dari PPIBD
            [
                'menu_name' => 'Berkala', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 5, 
                'parent_id' => 5
            ],
            [
                'menu_name' => 'Setiap Saat', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 5, 
                'parent_id' => 5
            ],
            [
                'menu_name' => 'Serta Meta', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 5, 
                'parent_id' => 5
            ],
            [
                'menu_name' => 'Dikecualikan', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-box', 
                'order_number' => 5, 
                'parent_id' => 5
            ],
        ];

        $this->db->table('m_menu')->insertBatch($data);

        // 2. AKTIFKAN kembali pemeriksaan Foreign Key
        $this->db->enableForeignKeyChecks();
    }
}