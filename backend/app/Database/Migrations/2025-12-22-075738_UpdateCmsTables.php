<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateCmsTables extends Migration
{
    public function up()
{
    // 1. Cek dulu, kalau kolom 'has_content' belum ada, baru tambah
    if (!$this->db->fieldExists('has_content', 'm_menu')) {
        $this->forge->addColumn('m_menu', [
            'has_content' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'parent_id'
            ],
        ]);
    }

    // 2. Tambah kolom ke t_dokumen (Gunakan pengecekan juga agar aman)
    if ($this->db->tableExists('t_dokumen')) {
        $fieldsToUpdate = [];

        if (!$this->db->fieldExists('id_menu', 't_dokumen')) {
            $fieldsToUpdate['id_menu'] = [
                'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'id_document_category'
            ];
        }
        if (!$this->db->fieldExists('tahun', 't_dokumen')) {
            $fieldsToUpdate['tahun'] = [
                'type' => 'YEAR', 'null' => true, 'after' => 'file_path'
            ];
        }
        if (!$this->db->fieldExists('deskripsi', 't_dokumen')) {
            $fieldsToUpdate['deskripsi'] = [
                'type' => 'TEXT', 'null' => true, 'after' => 'document_name'
            ];
        }

        if (!empty($fieldsToUpdate)) {
            $this->forge->addColumn('t_dokumen', $fieldsToUpdate);
        }
    }
}

    public function down()
    {
        // Menghapus kolom jika migration di-rollback
        $this->forge->dropColumn('m_menu', 'has_content');
        
        $this->db->query("ALTER TABLE t_dokumen DROP FOREIGN KEY fk_dokumen_menu");
        $this->forge->dropColumn('t_dokumen', ['id_menu', 'tahun', 'deskripsi']);
    }
}