<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Definisikan Headers
        header('Access-Control-Allow-Origin: http://localhost:5173');
        header('Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Credentials: true'); // Penting jika pakai cookies/auth

        // 2. Tangani Preflight Request (OPTIONS)
        // Gunakan strtoupper() atau getMethod(true) untuk memastikan huruf besar
        $method = $request->getMethod(true); 
        
        if ($method === 'OPTIONS') {
            header('HTTP/1.1 200 OK');
            die(); // Gunakan die() agar CI4 berhenti di sini dan tidak lanjut ke Controller
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Opsional: Tambahkan header lagi di sini untuk memastikan respon normal juga punya header CORS
        // Ini berguna jika header() di 'before' tertimpa oleh proses lain
        // $response->setHeader('Access-Control-Allow-Origin', 'http://localhost:5173');
        // $response->setHeader('Access-Control-Allow-Headers', 'X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization');
        // $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        // $response->setHeader('Access-Control-Allow-Credentials', 'true');
        
        return $response;
    }
}