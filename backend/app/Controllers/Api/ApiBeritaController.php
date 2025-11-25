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

    // ================================
    // TAMPILKAN SEMUA AGENDA (API)
    // ================================
public function index()
{
    $tagmodes = $this->tagmodel
    ->orderBy('created_at', 'DESC')
    ->findAll();


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
        ->orderBy('created_at', 'DESC')
        ->findAll();

    return $this->respond([
        'status'  => true,
        'message' => 'Data berita berhasil diambil.',
        'data'    => [
            'utama'  => $beritautama,
            'berita' => $beritas,
            'kategori' => $kategories,
            'tag' => $tagmodes
        ]
    ]);
}


   // =================================================================
    // TAMPILKAN DETAIL BERITA (SHOW)
    // =================================================================
    // ==========================================================
    // ANTI SPAM HIT (IP + CACHE)
    // ==========================================================
    private function canCountHit($id_berita)
    {
        // Ambil IP User
        $ip = $this->request->getIPAddress();
        
        // Buat kunci unik: IP + ID Berita
        $cacheKey = "hit_lock_" . md5($ip) . "_" . $id_berita;

        $cache = \Config\Services::cache();

        // Cek apakah IP ini sudah nge-hit berita ini dalam waktu dekat?
        if ($cache->get($cacheKey)) {
            // Jika ada di cache, berarti SPAM/Refresh -> Jangan hitung
            return false;
        }

        // Jika belum, simpan ke cache selama 1 JAM (3600 detik)
        // Artinya 1 IP hanya bisa menambah 1 hit per jam per berita
        $cache->save($cacheKey, true, 3600);
        
        return true;
    }

    // ==========================================================
    // DETAIL BERITA (SHOW)
    // ==========================================================
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
            // 4. UPDATE HIT + ANTI SPAM
            // ======================================================
            
            // Cek apakah boleh nambah hit? (Lolos filter IP)
            if ($this->canCountHit($id)) {
                
                // Tentukan model mana yang dipakai update
                if ($isUtama) {
                    $this->utamaModel->set('hit', 'hit + 1', false)
                        ->where('id_berita', $id)
                        ->update();
                } else {
                    $this->model->set('hit', 'hit + 1', false)
                        ->where('id_berita', $id)
                        ->update();
                }

                // Update angka di response agar user melihat angka terbaru
                $berita['hit'] = (int)$berita['hit'] + 1;
            }

            // ======================================================
            // 5. FORMAT DATA (Gambar & JSON)
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

            // 6. Response
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
