<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    public function index()
    {
        return view('/pages/Dashboard');
    }

    public function options()
    {
        return $this->response
            ->setStatusCode(ResponseInterface::HTTP_OK)
            ->setHeader('Access-Control-Allow-Origin', 'http://localhost:5173')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
            ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    }
}