<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\IncomingRequest; // <--- Import Class ini
use App\Models\VisitorModel;

class VisitorFillter implements FilterInterface
{
    /**
     * Dijalankan SEBELUM controller dieksekusi.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Pastikan request yang masuk adalah IncomingRequest (Request HTTP biasa)
        // Ini mengatasi error "Undefined method getUserAgent"
        if (!$request instanceof IncomingRequest) {
            return;
        }

        // 2. Siapkan Model
        $visitorModel = new VisitorModel();
        
        $ip           = $request->getIPAddress();
        $agent        = $request->getUserAgent(); // Sekarang aman dipanggil
        $currentDate  = date('Y-m-d');
        $currentTime  = date('Y-m-d H:i:s');

        // 3. Cek apakah IP ini sudah terekam HARI INI?
        $exist = $visitorModel->where('ip_address', $ip)
                              ->where('access_date', $currentDate)
                              ->first();

        if ($exist) {
            // Update waktu aktif user (supaya statusnya online)
            $visitorModel->update($exist['id'], [
                'last_activity' => $currentTime
            ]);
        } else {
            // Pengunjung baru hari ini
            $visitorModel->insert([
                'ip_address'    => $ip,
                'user_agent'    => (string) $agent, // Cast ke string agar aman disimpan
                'access_date'   => $currentDate,
                'last_activity' => $currentTime
            ]);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}