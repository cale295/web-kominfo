<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BeritaMigration extends Migration
{
    public function up()
    {
        $this->forge->addField(
            [
                'id_berita' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'judul' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ],
                'slug' => [ // Ditambahkan: Untuk URL/SEO
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'unique' => true,
                    'null' => true,
                ],
                'isi' => [
                    'type' => 'TEXT',
                    'null' => false,
                ],
                'gambar' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true, // Boleh kosong jika tidak ada gambar
                ],
                'id_kategori' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => false, // Wajib memiliki kategori
                ],
                'id_user' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => false, // Wajib memiliki penulis
                ],
                'status' => [
                    'type' => 'ENUM', 
                    'constraint' => ['draft', 'published', 'archived'],
                    'default' => 'draft',
                    'null' => false,
                ],
                'jumlah_pembaca' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'default' => 0, // Pastikan default 0
                ],
                // Gunakan created_at dan updated_at untuk fitur Timestamp Model CI4
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'deleted_at' => [ // Untuk Soft Deletes
                    'type' => 'DATETIME',
                    'null' => true,
                ],

            ]
        );
                // Foreign Keys (Aksi CASCADE Anda sudah jelas)
        $this->forge->addForeignKey('id_kategori', 'm_kategori_berita', 'id_kategori', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'm_user', 'id_user', 'CASCADE', 'CASCADE');

        $this->forge->addKey('id_berita', true);
        $this->forge->createTable('t_berita');


    }


    public function down()
    {
        $this->forge->dropTable('t_berita');
    }
}