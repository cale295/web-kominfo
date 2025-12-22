<?php 

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    // Properti Dasar Model
    protected $table            = 'm_menu';
    protected $primaryKey       = 'id_menu'; // Kolom Primary Key
    protected $returnType       = 'array';
    protected $allowedFields    = ['menu_name', 'menu_url','admin_url', 'menu_icon', 'order_number', 'parent_id', 'status','allowed_roles']; 
    
    // Properti Lainnya (Disusun rapi)
    protected $useTimestamps    = false;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';
    protected $deletedField     = 'deleted_at';
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];
    


    // =========================================================
    // FUNGSI PENGAMBIL DATA
    // =========================================================

    public function getAllMenu()
    {
        // Mengambil semua data, diurutkan untuk membantu rekursi
        return $this->orderBy('parent_id', 'ASC')
            ->orderBy('order_number', 'ASC')
            ->orderBy('id_menu', 'ASC')   // <— FIX STABIL
            ->findAll();

    }

    // =========================================================
    // FUNGSI REKURSIF PEMBANGUN POHON
    // =========================================================

    /**
     * Mengubah daftar menu datar menjadi struktur hierarki (Tree Structure).
     * @param array $elements Daftar menu datar.
     * @param int|string $parentId ID Induk awal (0 atau "0").
     * @return array Struktur menu berjenjang.
     */
    public function buildTree(array $elements, $parentId = 0) 
    {
        $branch = [];

        // Konversi parentId awal ke string jika data dari DB berupa string (misalnya "0")
        $targetParentId = (string)$parentId; 
        
        foreach ($elements as $element) {
            
            // Perbaikan Kritis: Gunakan perbandingan non-strict (==) atau 
            // pastikan tipe datanya sama. Karena DB mengembalikan ID sebagai string, 
            // kita bandingkan dengan string.
            if ($element['parent_id'] == $targetParentId) { 
                
                // Cari anak-anak item ini secara rekursif
                // Menggunakan 'id_menu' sebagai Parent ID baru
                $children = $this->buildTree($elements, $element['id_menu']);
                
                if ($children) {
                    // Perbaikan: Ganti 'children' menjadi 'sub_menu' (lebih deskriptif)
                    // Anda harus memastikan nama key ini ('sub_menu') yang digunakan di React
                    $element['sub_menu'] = $children;
                }
                
                $branch[] = $element;
            }
        }

        return $branch;
    }
    
}