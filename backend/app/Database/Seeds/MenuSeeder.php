<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Menonaktifkan pemeriksaan Foreign Key sementara
        $this->db->disableForeignKeyChecks();

        $data = [
            // =========================================================
            // LEVEL 1: MENU UTAMA (parent_id = 0)
            // =========================================================
            
            // ID 1: PROFILE
            [ 'menu_name' => 'PROFILE', 'menu_url' => '#', 'menu_icon' => 'fa-home', 'order_number' => 1, 'parent_id' => 0 ],
            
            // ID 2: BERITA
            [ 'menu_name' => 'BERITA', 'menu_url' => '#', 'menu_icon' => 'fa-database', 'order_number' => 2, 'parent_id' => 0 ],
            
            // ID 3: PROGRAM
            [ 'menu_name' => 'PROGRAM', 'menu_url' => '#', 'menu_icon' => 'fa-chart', 'order_number' => 3, 'parent_id' => 0 ],
            
            // ID 4: INFORMASI PUBLIK
            [ 'menu_name' => 'INFORMASI PUBLIK', 'menu_url' => '#', 'menu_icon' => 'fa-database', 'order_number' => 4, 'parent_id' => 0 ],
            
            // ID 5: PPID
            [ 'menu_name' => 'PPID', 'menu_url' => '#', 'menu_icon' => 'fa-database', 'order_number' => 5, 'parent_id' => 0 ],
            
            // ID 6: GALERI
            [ 'menu_name' => 'GALERI', 'menu_url' => '#', 'menu_icon' => 'fa-database', 'order_number' => 6, 'parent_id' => 0 ],
            
            // ID 7: KONTAK
            [ 'menu_name' => 'KONTAK', 'menu_url' => '#', 'menu_icon' => 'fa-database', 'order_number' => 7, 'parent_id' => 0 ],
            
            
            // =========================================================
            // LEVEL 2: SUB-MENU (parent_id dikoreksi ke Induk yang Benar: 1, 3, 4, 5, 6)
            // =========================================================
            
            // Sub-menu PROFILE (parent_id: 1)
            [ 'menu_name' => 'Tentang', 'menu_url' => '#', 'menu_icon' => 'fa-users', 'order_number' => 1, 'parent_id' => 1 ],
            [ 'menu_name' => 'Profil Pejabat Struktural', 'menu_url' => '#', 'menu_icon' => 'fa-users', 'order_number' => 2, 'parent_id' => 1 ],
            [ 'menu_name' => 'Tugas Dan Fungsi', 'menu_url' => '#', 'menu_icon' => 'fa-users', 'order_number' => 3, 'parent_id' => 1 ],
            [ 'menu_name' => 'Struktur Organisasi', 'menu_url' => '#', 'menu_icon' => 'fa-users', 'order_number' => 4, 'parent_id' => 1 ],
            [ 'menu_name' => 'Seketariat', 'menu_url' => '#', 'menu_icon' => 'fa-users', 'order_number' => 5, 'parent_id' => 1 ],
            [ 'menu_name' => 'Bidang Diseminasi Informasi Dan Komunikasi Publik', 'menu_url' => '#', 'menu_icon' => 'fa-users', 'order_number' => 6, 'parent_id' => 1 ],
            [ 'menu_name' => 'Bidang Saran, Prasarana TIK dan Persandian', 'menu_url' => '#', 'menu_icon' => 'fa-users', 'order_number' => 7, 'parent_id' => 1 ],
            [ 'menu_name' => 'Bidang Statistika Dan Pemberdayaan TIK', 'menu_url' => '#', 'menu_icon' => 'fa-users', 'order_number' => 8, 'parent_id' => 1 ],
            [ 'menu_name' => 'Bidang Pengembangan E-Goverment', 'menu_url' => '#', 'menu_icon' => 'fa-users', 'order_number' => 9, 'parent_id' => 1 ],
            
            // Sub-menu PROGRAM (parent_id: 3)
            [ 'menu_name' => 'Program SKPD', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 1, 'parent_id' => 3 ],

            // Sub-menu INFORMASI PUBLIK (parent_id: 4)
            [ 'menu_name' => 'Perencanaan', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 1, 'parent_id' => 4 ],
            [ 'menu_name' => 'Pengadaan Barang dan Jasa', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 2, 'parent_id' => 4 ],
            [ 'menu_name' => 'Laporan Keuangan', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 3, 'parent_id' => 4 ],
            [ 'menu_name' => 'Laporan Kinerja', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 4, 'parent_id' => 4 ],
            [ 'menu_name' => 'Pendidikan dan Pelatihan', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 5, 'parent_id' => 4 ],
            [ 'menu_name' => 'Permohonan Informasi', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 6, 'parent_id' => 4 ],
            [ 'menu_name' => 'Daftar Informasi Publik', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 7, 'parent_id' => 4 ],
            [ 'menu_name' => 'Kerjasama Daerah', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 8, 'parent_id' => 4 ],
            [ 'menu_name' => 'Regulasi', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 9, 'parent_id' => 4 ],

            // Sub-menu PPID (parent_id: 5)
            [ 'menu_name' => 'Ajukan Permohonan', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 1, 'parent_id' => 5 ],
            [ 'menu_name' => 'Lacak Permohonan', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 2, 'parent_id' => 5 ],
            [ 'menu_name' => 'Keberatan', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 3, 'parent_id' => 5 ],
            [ 'menu_name' => 'Klasifikasi Informasi', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 4, 'parent_id' => 5 ],

            // Sub-menu GALERI (parent_id: 6)
            [ 'menu_name' => 'Galeri Foto', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 1, 'parent_id' => 6 ],
            [ 'menu_name' => 'Galeri Video', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 2, 'parent_id' => 6 ],
            
            
            // =========================================================
            // LEVEL 3: SUB-SUB-MENU (parent_id: 5 - Anak dari PPID)
            // Order number diatur 1, 2, 3, 4 untuk pengurutan yang benar
            // =========================================================
            
            [ 'menu_name' => 'Berkala', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 1, 'parent_id' => 5 ],
            [ 'menu_name' => 'Setiap Saat', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 2, 'parent_id' => 5 ],
            [ 'menu_name' => 'Serta Meta', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 3, 'parent_id' => 5 ],
            [ 'menu_name' => 'Dikecualikan', 'menu_url' => '#', 'menu_icon' => 'fa-box', 'order_number' => 4, 'parent_id' => 5 ],
        ];

        $this->db->table('m_menu')->insertBatch($data);
        $this->db->enableForeignKeyChecks();
    }
}