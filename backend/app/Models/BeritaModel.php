<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table = 't_berita';
    protected $primaryKey = 'id_berita';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

protected $allowedFields = [
    'hash_berita', 'judul', 'topik', 'id_kategori', 'id_sub_kategori', 'slug',
    'is_berita_terkait', 'content', 'id_berita_terkait', 'content2',
    'id_berita_terkait2', 'intro', 'id_photo', 'feat_image', 'caption', 'sumber',
    'link_video', 'status', 'status_berita', 'hit', 'count_copy', 'keyword',
    'created_by_role_id', 'created_by_id', 'created_by_name',
    'created_at', 'updated_by_id', 'updated_by_name', 'updated_at',
    'is_delete_by_id', 'is_delete_by_name', 'is_delete', 'delete_at', 'posted_at',
    'dokumen_title', 'dokumen_duo_title', 'dokumen_tigo_title', 'dokumen_quatro_title',
    'dokumen', 'dokumen_duo', 'dokumen_tigo', 'dokumen_quatro',
    'old_berita', 'note', 'note_revisi', 'trash',
    'additional_images'  // ✅ tambahkan ini
];


    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    
    // =========================================================
    // Ambil berita + join kategori, hanya kategori aktif
    // =========================================================
// ... di dalam class BeritaModel ...
public function getBeritaWithKategori($onlyActive = true)
{
    $berita = $this->db->table($this->table)
                       ->where('trash', '0')
                       ->orderBy('created_at', 'DESC')
                       ->get()
                       ->getResultArray();

    foreach ($berita as &$b) {
        $b['kategori'] = $this->getKategoriBerita($b['id_berita']);
    }

    return $berita;
}


// Ambil kategori untuk berita tertentu
public function getKategoriByBerita($idBerita)
{
    $db = \Config\Database::connect();
    return $db->table('t_berita_kategori as bk')
              ->select('k.id_kategori, k.kategori')
              ->join('m_kategori_berita k', 'k.id_kategori = bk.id_kategori')
              ->where('bk.id_berita', $idBerita)
              ->get()->getResultArray();
}

    public function getKategoriBerita($id_berita)
{
    return $this->db->table('t_berita_kategori')
                    ->select('m_kategori_berita.*')
                    ->join('m_kategori_berita', 'm_kategori_berita.id_kategori = t_berita_kategori.id_kategori')
                    ->where('t_berita_kategori.id_berita', $id_berita)
                    ->get()
                    ->getResultArray();
}

public function saveKategoriBerita($idBerita, array $kategoriIds)
{
    $db = \Config\Database::connect();
    $builder = $db->table('t_berita_kategori');

    // Hapus dulu kategori lama
    $builder->where('id_berita', $idBerita)->delete();

    // Simpan kategori baru
    foreach ($kategoriIds as $idKat) {
        $builder->insert([
            'id_berita' => $idBerita,
            'id_kategori' => $idKat
        ]);
    }
}



// ...


    
public function getTrashBerita()
{
    return $this->db->table($this->table)
        ->select('t_berita.*, m_kategori_berita.kategori AS nama_kategori')
        ->join('m_kategori_berita', 'm_kategori_berita.id_kategori = t_berita.id_kategori', 'left')
        ->where('t_berita.trash', '1') // hanya yang sudah dihapus
        ->orderBy('t_berita.updated_at', 'DESC')
        ->get()
        ->getResultArray();
}


    // =========================================================
    // Berita berdasarkan slug
    // =========================================================
    public function getBySlug($slug)
    {
return $this->db->table($this->table)
                ->where('t_berita.slug', $slug)
                ->join('m_kategori_berita', 'm_kategori_berita.id_kategori = t_berita.id_kategori', 'left')
                ->get()
                ->getRowArray();

    }

    // =========================================================
    // Berita berdasarkan kategori (kategori aktif)
    // =========================================================
    public function getByKategori($id_kategori)
    {
        return $this->db->table($this->table)
                    ->where('id_kategori', $id_kategori)
                    ->where('trash', '0')
                    ->join('m_kategori_berita', 'm_kategori_berita.id_kategori = t_berita.id_kategori', 'left')
                    ->where('m_kategori_berita.status', '1')
                    ->orderBy('created_at', 'DESC')
                    ->get()
                    ->getResultArray();
    }

    // =========================================================
    // Berita terbaru
    // =========================================================
    public function getLatest($limit = 5)
    {
        return $this->where('trash', '0')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->find();
    }

    // =========================================================
    // Berita populer (berdasarkan hit)
    // =========================================================
    public function getPopular($limit = 5)
    {
        return $this->where('trash', '0')
                    ->orderBy('hit', 'DESC')
                    ->limit($limit)
                    ->find();
    }

    // =========================================================
    // Tambah jumlah pengunjung (hit)
    // =========================================================
    public function incrementHit($id_berita)
    {
        $this->set('hit', 'hit + 1', false)
             ->where('id_berita', $id_berita)
             ->update();
    }

    // =========================================================
    // Ambil berita terkait
    // =========================================================
    public function getRelatedBerita($id_kategori, $excludeId = null, $limit = 4)
    {
        $builder = $this->where('id_kategori', $id_kategori)
                        ->where('trash', '0');

        if ($excludeId) {
            $builder->where('id_berita !=', $excludeId);
        }

        return $builder->orderBy('created_at', 'DESC')
                       ->limit($limit)
                       ->find();
    }

    // =========================================================
    // Ambil kategori aktif
    // =========================================================
    public function getKategoriAktif()
    {
        return $this->db->table('m_kategori_berita')
                        ->where('status', '1') // hanya kategori aktif
                        ->where('trash', '0')
                        ->orderBy('kategori', 'ASC')
                        ->get()
                        ->getResultArray();

        
    }

    // =========================================================
    // Validasi
    // =========================================================
    protected $validationRules = [
        'judul' => 'required|min_length[5]|max_length[255]',
        'slug' => 'permit_empty|is_unique[t_berita.slug,id_berita,{id_berita}]',
        'content' => 'permit_empty|string',
        'status' => 'permit_empty|in_list[0,1,2,3,4,5]',
        'status_berita' => 'permit_empty|in_list[0,2,3,4,6]',
    ];

    protected $validationMessages = [
        'judul' => [
            'required' => 'Judul berita wajib diisi.',
            'min_length' => 'Judul minimal 5 karakter.',
            'max_length' => 'Judul maksimal 255 karakter.'
        ],
        'slug' => [
            'is_unique' => 'Slug sudah digunakan, gunakan judul lain.'
        ],
        'status' => [
            'in_list' => 'Status tidak valid.'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // =========================================================
    // Hooks (auto slug)
    // =========================================================
    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    protected function generateSlug(array $data)
    {
        if (!empty($data['data']['judul'])) {
            helper('text');
            $data['data']['slug'] = url_title($data['data']['judul'], '-', true);
        }
        return $data;
    }
}
