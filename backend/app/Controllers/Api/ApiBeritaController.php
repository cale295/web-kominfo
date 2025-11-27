<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BeritaModel;
use App\Models\BeritaUtamaModel;
use App\Models\KategoriModel;
use App\Models\BeritaTagModel;

class ApiBeritaController extends ResourceController
{
    protected $modelName = BeritaModel::class;
    protected $format    = 'json';

    protected $utamaModel;
    protected $katemodel;
    protected $tagmodel;

    public function __construct()
    {
        $this->utamaModel = new BeritaUtamaModel();
        $this->katemodel  = new KategoriModel();
        $this->tagmodel   = new BeritaTagModel();
    }

    // ==========================================================
    // HELPER: Ambil Kategori
    // ==========================================================
    private function getKategoriByBerita($id_berita)
    {
        return $this->model->db->table('t_berita_kategori')
            ->select('m_kategori_berita.id_kategori, m_kategori_berita.kategori, m_kategori_berita.slug')
            ->join('m_kategori_berita', 'm_kategori_berita.id_kategori = t_berita_kategori.id_kategori')
            ->where('t_berita_kategori.id_berita', $id_berita)
            ->get()
            ->getResultArray();
    }

    // ==========================================================
    // HELPER: Ambil Tags
    // ==========================================================
    private function getTagsByBerita($id_berita)
    {
        return $this->model->db->table('t_berita_tag')
            ->select('m_berita_tag.id_tags, m_berita_tag.nama_tag, m_berita_tag.slug')
            ->join('m_berita_tag', 'm_berita_tag.id_tags = t_berita_tag.id_tags')
            ->where('t_berita_tag.id_berita', $id_berita)
            ->get()
            ->getResultArray();
    }

    // ==========================================================
    // ANTI SPAM HIT
    // ==========================================================
    private function canCountHit($id_berita)
    {
        $ip       = $this->request->getIPAddress();
        $cacheKey = "hit_lock_" . md5($ip) . "_" . $id_berita;
        $cache    = \Config\Services::cache();

        if ($cache->get($cacheKey)) {
            return false;
        }

        $cache->save($cacheKey, true, 60);
        return true;
    }

    // ================================
    // TAMPILKAN SEMUA BERITA (INDEX)
    // ================================
    public function index()
    {
        try {
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

            // Fungsi Format Data
            $formatData = function (&$listBerita) {
                foreach ($listBerita as &$b) {
                    // ❌ PERBAIKAN: JANGAN PAKAI base_url() DI SINI
                    // Biarkan path mentah (misal: "uploads/berita/foto.jpg")
                    // Frontend akan menambahkan ROOT URL sendiri.
                    
                    // Kategori
                    $kats = $this->getKategoriByBerita($b['id_berita']);
                    $b['kategori']       = array_column($kats, 'kategori');
                    $b['kategori_ids']   = array_column($kats, 'id_kategori');
                    $b['kategori_slugs'] = array_column($kats, 'slug');

                    // Tags
                    $tags = $this->getTagsByBerita($b['id_berita']);
                    $b['tags']       = array_column($tags, 'nama_tag');
                    $b['tags_slugs'] = array_column($tags, 'slug');
                }
            };

            $formatData($beritautama);
            $formatData($beritas);

            return $this->respond([
                'status'  => true,
                'message' => 'Data berita berhasil diambil.',
                'data'    => [
                    'utama'    => $beritautama,
                    'berita'   => $beritas,
                    'kategori' => $kategories,
                    'tag'      => $tagmodes
                ]
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
    // ==========================================================
    // FILTER BERITA BY TAG SLUG
    // ==========================================================
public function getByTag($slug = null)
    {
        try {
            if (empty($slug)) return $this->failNotFound('Slug kosong');

            // 1. Cari ID Tag
            $tagData = $this->tagmodel->where('slug', $slug)->first();
            if (!$tagData) return $this->failNotFound('Tag tidak ditemukan.');

            // 2. Query Builder
            $beritas = $this->model
                ->select('t_berita.*')
                ->join('t_berita_tag', 't_berita_tag.id_berita = t_berita.id_berita')
                ->where('t_berita_tag.id_tags', $tagData['id_tags'])
                ->orderBy('t_berita.created_at', 'DESC')
                ->findAll();

            // 3. Format Data (Looping untuk tambah kategori & tags lain)
            if (!empty($beritas)) {
                foreach ($beritas as &$b) {
                    // Kategori
                    $kats = $this->getKategoriByBerita($b['id_berita']);
                    $b['kategori']       = array_column($kats, 'kategori');
                    $b['kategori_ids']   = array_column($kats, 'id_kategori');
                    $b['kategori_slugs'] = array_column($kats, 'slug');

                    // Tags
                    $tags = $this->getTagsByBerita($b['id_berita']);
                    $b['tags']       = array_column($tags, 'nama_tag');
                    $b['tags_slugs'] = array_column($tags, 'slug');
                }
            }

            return $this->respond([
                'status'  => true,
                'message' => 'Berita berdasarkan tag: ' . $tagData['nama_tag'],
                'data'    => $beritas
            ]);

        } catch (\Exception $e) {
            return $this->failServerError($e->getMessage());
        }
    }
    // =================================================================
    // TAMPILKAN DETAIL BERITA (BY SLUG)
    // =================================================================
    public function show($slug = null)
    {
        try {
            if (empty($slug)) {
                return $this->failNotFound('Slug berita tidak boleh kosong.');
            }

            // 1. Cari Berita Reguler
            $berita = $this->model
                ->where('slug', $slug)
                ->where('trash', '0')
                ->first();

            // Fallback ID
            if (!$berita && is_numeric($slug)) {
                $berita = $this->model
                    ->where('id_berita', $slug)
                    ->where('trash', '0')
                    ->first();
            }

            // 2. Cari Berita Utama
            $isUtama = false;
            if (!$berita) {
                $berita = $this->utamaModel
                    ->where('slug', $slug)
                    ->where('trash', '0')
                    ->first();
                
                if (!$berita && is_numeric($slug)) {
                    $berita = $this->utamaModel
                        ->where('id_berita', $slug)
                        ->where('trash', '0')
                        ->first();
                }

                if ($berita) $isUtama = true;
            }

            if (!$berita) {
                return $this->failNotFound('Berita tidak ditemukan.');
            }

            $id = $berita['id_berita'];

            // 4. Enrich Data
            $kategoriBerita = $this->getKategoriByBerita($id);
            $berita['kategori']         = array_column($kategoriBerita, 'kategori');
            $berita['kategori_ids']     = array_column($kategoriBerita, 'id_kategori');
            $berita['kategori_slugs']   = array_column($kategoriBerita, 'slug');

            $tagsBerita = $this->getTagsByBerita($id);
            $berita['tags']             = array_column($tagsBerita, 'nama_tag');
            $berita['tags_slugs']       = array_column($tagsBerita, 'slug');
            $berita['tags_detail']      = $tagsBerita;

            // Hit Counter
            if ($this->canCountHit($id)) {
                if ($isUtama) {
                    $this->utamaModel->set('hit', 'hit + 1', false)->where('id_berita', $id)->update();
                } else {
                    $this->model->set('hit', 'hit + 1', false)->where('id_berita', $id)->update();
                }
                $berita['hit'] = (int)$berita['hit'] + 1;
            }

            // ✅ 2. GUNAKAN base_url() PADA GAMBAR UTAMA
            if (!empty($berita['feat_image'])) { 
                $berita['feat_image'] = base_url($berita['feat_image']); 
            }

            // Gallery
            $gallery = [];
            if (!empty($berita['additional_images'])) {
                $decoded = json_decode($berita['additional_images'], true);
                if (is_array($decoded)) {
                    foreach ($decoded as $item) {
                        $path = is_array($item) ? $item['path'] : $item;
                        $caption = is_array($item) ? ($item['caption'] ?? '') : '';
                        if (!empty($path)) {
                            // ✅ 3. GUNAKAN base_url() PADA GAMBAR GALLERY
                            // Ini akan memperbaiki masalah carousel
                            $gallery[] = [
                                'url'     => base_url($path), 
                                'caption' => $caption
                            ];
                        }
                    }
                }
            }
            $berita['additional_images'] = $gallery;

            // Berita Terkait
            $beritaTerkait = [];
            $getRelated = function($idTerkait) {
                if (!$idTerkait) return null;
                $related = $this->model->find($idTerkait);
                if ($related) {
                    return [
                        'id_berita'  => $related['id_berita'],
                        'judul'      => $related['judul'],
                        'slug'       => $related['slug'],
                        // ✅ 4. GUNAKAN base_url() PADA GAMBAR TERKAIT
                        'feat_image' => !empty($related['feat_image']) ? base_url($related['feat_image']) : null,
                        'created_at' => $related['created_at']
                    ];
                }
                return null;
            };

            if (!empty($berita['id_berita_terkait'])) {
                $res = $getRelated($berita['id_berita_terkait']);
                if ($res) $beritaTerkait[] = $res;
            }
            if (!empty($berita['id_berita_terkait2'])) {
                $res = $getRelated($berita['id_berita_terkait2']);
                if ($res) $beritaTerkait[] = $res;
            }
            
            $berita['berita_terkait'] = $beritaTerkait;

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