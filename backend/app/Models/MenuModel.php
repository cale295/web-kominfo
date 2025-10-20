<?php 

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    // ... (Properti Model lainnya, sudah benar) ...
    protected $table          = 'm_menu';
    protected $primaryKey     = 'id_menu'; // PK: id_menu
    protected $returnType     = 'array';
    protected $allowedFields  = ['menu_name', 'menu_url', 'menu_icon', 'order_number', 'parent_id']; // Parent ID: parent_id

    public function getallmenu(){
        return $this->orderBy('parent_id','asc')->orderBy('order_number','asc')->findAll();
    }

    /**
     * Fungsi yang sudah diperbaiki
     * @param array $elements 
     * @param int $parent_id
     * @return array
     */
    public function buildTree(array $elements, $parentId = 0) 
    {
        $branch = [];

        foreach ($elements as $element) {
            // TIDAK PERLU lagi casting (array)$element karena returnType sudah di set 'array'
            // $element = (array)$element; 
            
            // Perbaikan 1: Menggunakan 'parent_id' (sesuai allowedFields)
            // Cek apakah item ini adalah anak dari parentId yang dicari
            if ($element['parent_id'] == $parentId) { 
                
                // Perbaikan 2: Menggunakan 'id_menu' (sesuai primaryKey)
                // Cari anak-anak item ini secara rekursif
                $children = $this->buildTree($elements, $element['id_menu']);
                
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    

    // ... (Properti Model lainnya) ...
}
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
