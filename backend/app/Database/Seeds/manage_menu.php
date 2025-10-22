<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class manage_menu extends Seeder
{
    public function run()
    {
        $data = [
            // Dashboard
            [
                'role' => 'superadmin',
                'module_name' => 'dashboard',
                'can_create' => 0,
                'can_read' => 1,
                'can_update' => 0,
                'can_delete' => 0,
                'can_publish' => 0
            ],
            [
                'role' => 'admin',
                'module_name' => 'dashboard',
                'can_create' => 0,
                'can_read' => 1,
                'can_update' => 0,
                'can_delete' => 0,
                'can_publish' => 0
            ],
            [
                'role' => 'editor',
                'module_name' => 'dashboard',
                'can_create' => 0,
                'can_read' => 1,
                'can_update' => 0,
                'can_delete' => 0,
                'can_publish' => 0
            ],

            // Berita - Admin (Full Access)
            [
                'role' => 'admin',
                'module_name' => 'berita',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 1,
                'can_publish' => 1
            ],
            // Berita - Editor (No Delete & Publish)
            [
                'role' => 'editor',
                'module_name' => 'berita',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 0,
                'can_publish' => 0
            ],

            // Kategori Berita - Admin Only
            [
                'role' => 'admin',
                'module_name' => 'berita_kategori',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 1,
                'can_publish' => 0
            ],

            // Tema Berita - Admin Only
            [
                'role' => 'admin',
                'module_name' => 'berita_tema',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 1,
                'can_publish' => 0
            ],

            // Tag Berita - Admin Only
            [
                'role' => 'admin',
                'module_name' => 'berita_tag',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 1,
                'can_publish' => 0
            ],

            // Berita Featured - Admin
            [
                'role' => 'admin',
                'module_name' => 'berita_featured',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 1,
                'can_publish' => 1
            ],
            // Berita Featured - Editor
            [
                'role' => 'editor',
                'module_name' => 'berita_featured',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 0,
                'can_publish' => 0
            ],

            // Agenda - Admin
            [
                'role' => 'admin',
                'module_name' => 'agenda',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 1,
                'can_publish' => 1
            ],
            // Agenda - Editor
            [
                'role' => 'editor',
                'module_name' => 'agenda',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 0,
                'can_publish' => 0
            ],

            // Galeri Album - Admin
            [
                'role' => 'admin',
                'module_name' => 'galeri_album',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 1,
                'can_publish' => 1
            ],
            // Galeri Album - Editor
            [
                'role' => 'editor',
                'module_name' => 'galeri_album',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 0,
                'can_publish' => 0
            ],

            // Galeri Foto - Admin
            [
                'role' => 'admin',
                'module_name' => 'galeri_foto',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 1,
                'can_publish' => 1
            ],
            // Galeri Foto - Editor
            [
                'role' => 'editor',
                'module_name' => 'galeri_foto',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 0,
                'can_publish' => 0
            ],

            // Dokumen - Admin
            [
                'role' => 'admin',
                'module_name' => 'dokumen',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 1,
                'can_publish' => 1
            ],
            // Dokumen - Editor
            [
                'role' => 'editor',
                'module_name' => 'dokumen',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 0,
                'can_publish' => 0
            ],

            // Kategori Dokumen - Admin Only
            [
                'role' => 'admin',
                'module_name' => 'dokumen_kategori',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 1,
                'can_publish' => 0
            ],

            // Layanan - Admin Only
            [
                'role' => 'admin',
                'module_name' => 'layanan',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 1,
                'can_publish' => 1
            ],

            // Menu - Superadmin Only
            [
                'role' => 'superadmin',
                'module_name' => 'menu',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 1,
                'can_publish' => 0
            ],

            // Manage User - Superadmin Only
            [
                'role' => 'superadmin',
                'module_name' => 'manage_user',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 1,
                'can_publish' => 0
            ],

            // Access Rights - Superadmin Only
            [
                'role' => 'superadmin',
                'module_name' => 'access_rights',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 1,
                'can_publish' => 0
            ],

            // Settings - Superadmin
            [
                'role' => 'superadmin',
                'module_name' => 'settings',
                'can_create' => 1,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 0,
                'can_publish' => 0
            ],
            // Settings - Admin
            [
                'role' => 'admin',
                'module_name' => 'settings',
                'can_create' => 0,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 0,
                'can_publish' => 0
            ],

            // Profile - All Roles
            [
                'role' => 'superadmin',
                'module_name' => 'profile',
                'can_create' => 0,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 0,
                'can_publish' => 0
            ],
            [
                'role' => 'admin',
                'module_name' => 'profile',
                'can_create' => 0,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 0,
                'can_publish' => 0
            ],
            [
                'role' => 'editor',
                'module_name' => 'profile',
                'can_create' => 0,
                'can_read' => 1,
                'can_update' => 1,
                'can_delete' => 0,
                'can_publish' => 0
            ],
        ];

        // Menggunakan Query Builder
        $builder = $this->db->table('t_access_rights');
        
        // Insert data
        foreach ($data as $row) {
            $builder->insert($row);
        }

        echo "Access rights data seeded successfully!\n";
    }
}