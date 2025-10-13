<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KategoriBeritaMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kategori' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id_kategori', true);
        $this->forge->createTable('m_kategori_berita');
    }

    public function down()
    {
        $this->forge->dropTable('m_kategori_berita');
    }
}
