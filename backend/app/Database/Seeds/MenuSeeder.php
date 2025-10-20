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
                'menu_name' => 'Beranda', 
                'menu_url' => '/dashboard', 
                'menu_icon' => 'fa-home', 
                'order_number' => 1, 
                'parent_id' => 0
            ],
            [
                'menu_name' => 'Master Data', 
                'menu_url' => '#', 
                'menu_icon' => 'fa-database', 
                'order_number' => 2, 
                'parent_id' => 0
            ],
            [
                'menu_name' => 'Laporan', 
                'menu_url' => '/reports', 
                'menu_icon' => 'fa-chart', 
                'order_number' => 3, 
                'parent_id' => 0
            ],
            
            // Level 2 (Sub-Menu dari Master Data: parent_id = 2)
            [
                'menu_name' => 'Pengguna', 
                'menu_url' => '/master/users', 
                'menu_icon' => 'fa-users', 
                'order_number' => 1, 
                'parent_id' => 2
            ],
            [
                'menu_name' => 'Produk', 
                'menu_url' => '/master/products', 
                'menu_icon' => 'fa-box', 
                'order_number' => 2, 
                'parent_id' => 2
            ],
            
            // Level 3 (Sub-Menu dari Produk: parent_id = 5)
            [
                'menu_name' => 'Kategori Produk', 
                'menu_url' => '/master/products/categories', 
                'menu_icon' => 'fa-tags', 
                'order_number' => 1, 
                'parent_id' => 5
            ],
            [
                'menu_name' => 'Varian Produk', 
                'menu_url' => '/master/products/variants', 
                'menu_icon' => 'fa-cubes', 
                'order_number' => 2, 
                'parent_id' => 5
            ],
        ];

        $this->db->table('m_menu')->insertBatch($data);

        // 2. AKTIFKAN kembali pemeriksaan Foreign Key
        $this->db->enableForeignKeyChecks();
    }
}