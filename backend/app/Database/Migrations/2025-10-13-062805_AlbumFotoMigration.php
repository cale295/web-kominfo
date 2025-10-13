<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlbumFotoMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_album' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_album' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'gambar_sampul' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true, // Boleh kosong jika tidak ada gambar
            ],

        ]);
        $this->forge->addKey('id_album', true);
        $this->forge->createTable('m_album_foto');
    }

    public function down()
    {
        $this->forge->dropTable('m_album_foto');
    }
}
