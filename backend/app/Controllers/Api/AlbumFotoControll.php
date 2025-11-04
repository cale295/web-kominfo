<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

use App\Models\AlbumFotoModels;

class AlbumFotoControll extends ResourceController
{
    protected $modelName = AlbumFotoModels::class;
    protected $format = 'json';
    public function index()
    {
        return $this->respond($this->model->findAll());

    }

    //untuk show
    public function show($id = null)
    {
        $user = $this->model->find($id);

        if (!$user) {
            return $this->failNotFound('User tidak ditemukan');
        }

        return $this->respond($user);
    }

    public function create()
    {
        $json = $this->request->getBody();
        $data = json_decode($json, true) ?? [];

        if ($this->model->insert($data) === false) {
            return $this->fail($this->model->errors(), 400);
        }

        return $this->respondCreated($data, 'berhasil ditambahkan');

    }

    public function update($id = null)
    {
        $json = $this->request->getBody();
        $data = json_decode($json, true) ?? [];

        if (!$this->model->update($id, $data)) {
            return $this->fail($this->model->errors(), 400);
        }

        return $this->respondUpdated($data);
    }

    public function delete($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->failNotFound('User dengan id ' . $id . 'tidak ditemukan');
        }

        $this->model->delete($id);
        return $this->respondDeleted(['id' => $id, 'message' => 'berhasil dihapus']);
    }
}
