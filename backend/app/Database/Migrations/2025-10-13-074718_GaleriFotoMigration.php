<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GaleriFotoMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_foto' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'judul_foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'path_file' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'slug' => [ // Ditambahkan: Untuk URL/SEO
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
                'null' => false,
            ],
            'id_album' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            
        ]);
        ## Tambahkan foreign key
        $this->forge->addForeignKey('id_album', 'm_album', 'id_album', 'CASCADE', 'CASCADE');

        $this->forge->addKey('id_foto', true);
        $this->forge->createTable('t_galeri_foto');
        
        
    }
        
        

    public function down()
    {
        $this->forge->dropTable('t_galeri_foto');
    }
}
