<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BeritaModel;
use App\Models\BeritaUtamaModel;
use App\Models\KategoriModel;
use App\Models\BeritaTagModel;

class ApiBeritaController extends ResourceController
{
    protected $modelName = BeritaModel::class; // model default bawaan CI
    protected $format = 'json';

    protected $utamaModel; // model kedua
    protected $katemodel;
    protected $tagmodel;

    public function __construct()
    {
        $this->utamaModel = new BeritaUtamaModel(); // instance manual model kedua
        $this->katemodel = new KategoriModel();
        $this->tagmodel = new BeritaTagModel();
    }

    // ==========================================================
    // HELPER: Ambil Kategori (Manual Query Builder)
    // ==========================================================
    private function getKategoriByBerita($id_berita)
    {
        return $this->model->db->table('t_berita_kategori')
            ->select('m_kategori_berita.id_kategori, m_kategori_berita.kategori')
            ->join('m_kategori_berita', 'm_kategori_berita.id_kategori = t_berita_kategori.id_kategori')
            ->where('t_berita_kategori.id_berita', $id_berita)
            ->get()
            ->getResultArray();
    }

    // ==========================================================
    // ✅ HELPER BARU: Ambil Tags (Manual Query Builder)
    // ==========================================================
    private function getTagsByBerita($id_berita)
    {
        // Asumsi: Tabel Pivot = t_berita_tag, Tabel Master = m_berita_tag
        // Sesuaikan nama kolom (id_tags / id_tag) dengan database Anda
        return $this->model->db->table('t_berita_tag')
            ->select('m_berita_tag.id_tags, m_berita_tag.nama_tag') 
            ->join('m_berita_tag', 'm_berita_tag.id_tags = t_berita_tag.id_tags')
            ->where('t_berita_tag.id_berita', $id_berita)
            ->get()
            ->getResultArray();
    }

    // ================================
    // TAMPILKAN SEMUA AGENDA (API)
    // ================================
    public function index()
    {
        $tagmodes = $this->tagmodel->orderBy('created_at', 'DESC')->findAll();

        $kategories = $this->katemodel
            ->where('trash', '0')
            ->where('is_show_nav', '1')
            ->orderBy('created_on', 'DESC')
            ->findAll();

        $beritautama = $this->utamaModel
            ->where('status', '1')
            ->orderBy('created_date', 'DESC')
            ->findAll();

        $beritas = $this->model
            ->where('trash', '0')
            ->where('status', '1')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // === Tambahkan kategori ke setiap berita ===
        foreach ($beritas as &$b) {
            // Kategori
            $kats = $this->getKategoriByBerita($b['id_berita']);
            $b['kategori'] = array_column($kats, 'kategori');
            $b['kategori_ids'] = array_column($kats, 'id_kategori');
            
            // ✅ Tags di Index (Opsional, jika ingin muncul di list)
            $tags = $this->getTagsByBerita($b['id_berita']);
            $b['tags'] = array_column($tags, 'nama_tag');
        }

        return $this->respond([
            'status'  => true,
            'message' => 'Data berita berhasil diambil.',
            'data'    => [
                'utama'    => $beritautama,
                'berita'  => $beritas,
                'kategori'=> $kategories,
                'tag'     => $tagmodes
            ]
        ]);
    }

    // ==========================================================
    // ANTI SPAM HIT (IP + CACHE)
    // ==========================================================
    private function canCountHit($id_berita)
    {
        $ip = $this->request->getIPAddress();
        $cacheKey = "hit_lock_" . md5($ip) . "_" . $id_berita;
        $cache = \Config\Services::cache();

        if ($cache->get($cacheKey)) {
            return false;
        }

        $cache->save($cacheKey, true, 60);
        return true;
    }

    // =================================================================
    // TAMPILKAN DETAIL BERITA (SHOW)
    // =================================================================
    public function show($id = null)
    {
        try {
            // 1. Cek berita regular
            $berita = $this->model
                ->where('id_berita', $id)
                ->where('trash', '0')
                ->first();

            // 2. Cek berita utama jika tidak ada
            $isUtama = false;
            if (!$berita) {
                $berita = $this->utamaModel
                    ->where('id_berita', $id)
                    ->where('trash', '0')
                    ->first();
                if ($berita) $isUtama = true;
            }

            // 3. 404 Not Found
            if (!$berita) {
                return $this->failNotFound('Berita tidak ditemukan.');
            }

            // ======================================================
            // 4. AMBIL KATEGORI BERITA
            // ======================================================
            $kategoriBerita = $this->getKategoriByBerita($id);
            $berita['kategori'] = array_column($kategoriBerita, 'kategori');
            $berita['kategori_ids'] = array_column($kategoriBerita, 'id_kategori');

            // ======================================================
            // ✅ 4B. AMBIL TAGS BERITA (INI YANG DITAMBAHKAN)
            // ======================================================
            $tagsBerita = $this->getTagsByBerita($id);
            // Menampilkan array nama tags (contoh: ["Politik", "Ekonomi"])
            $berita['tags'] = array_column($tagsBerita, 'nama_tag');
            // Menampilkan detail tags (opsional, ada id dan nama)
            $berita['tags_detail'] = $tagsBerita;

            // ======================================================
            // 5. UPDATE HIT + ANTI SPAM
            // ======================================================
            if ($this->canCountHit($id)) {
                if ($isUtama) {
                    $this->utamaModel->set('hit', 'hit + 1', false)
                        ->where('id_berita', $id)->update();
                } else {
                    $this->model->set('hit', 'hit + 1', false)
                        ->where('id_berita', $id)->update();
                }
                $berita['hit'] = (int)$berita['hit'] + 1;
            }

            // ======================================================
            // 6. FORMAT DATA (Gambar & JSON)
            // ======================================================
            if (!empty($berita['feat_image'])) {
                $berita['feat_image'] = base_url($berita['feat_image']);
            }

            $gallery = [];
            if (!empty($berita['additional_images'])) {
                $decoded = json_decode($berita['additional_images'], true);
                if (is_array($decoded)) {
                    foreach ($decoded as $item) {
                        $path = is_array($item) ? $item['path'] : $item;
                        $caption = is_array($item) ? ($item['caption'] ?? '') : '';
                        
                        if (!empty($path)) {
                            $gallery[] = [
                                'url'     => base_url($path),
                                'caption' => $caption
                            ];
                        }
                    }
                }
            }
            $berita['additional_images'] = $gallery;

            // ======================================================
            // 7. AMBIL BERITA TERKAIT
            // ======================================================
            $beritaTerkait = [];
            if (!empty($berita['id_berita_terkait'])) {
                $related = $this->model->find($berita['id_berita_terkait']);
                if ($related) {
                    $beritaTerkait[] = [
                        'id_berita' => $related['id_berita'],
                        'judul' => $related['judul'],
                        'slug' => $related['slug'] ?? '',
                        'feat_image' => !empty($related['feat_image']) ? base_url($related['feat_image']) : null
                    ];
                }
            }
            if (!empty($berita['id_berita_terkait2'])) {
                $related2 = $this->model->find($berita['id_berita_terkait2']);
                if ($related2) {
                    $beritaTerkait[] = [
                        'id_berita' => $related2['id_berita'],
                        'judul' => $related2['judul'],
                        'slug' => $related2['slug'] ?? '',
                        'feat_image' => !empty($related2['feat_image']) ? base_url($related2['feat_image']) : null
                    ];
                }
            }
            $berita['berita_terkait'] = $beritaTerkait;

            // 8. Response
            return $this->respond([
                'status'  => true,
                'message' => 'Detail berita berhasil diambil.',
                'data'    => $berita
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
}