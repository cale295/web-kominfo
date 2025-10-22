<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Cek apakah user sudah login
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Jika role dibatasi
        if ($arguments && !in_array($session->get('role'), $arguments)) {
            // Redirect ke dashboard kalau role tidak sesuai
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak!');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu isi
    }
}
