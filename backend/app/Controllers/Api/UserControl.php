<?php

namespace App\Controllers\Api;
use CodeIgniter\RESTful\ResourceController;
//untuk mengambil data
use App\Models\UserModel;
class UserControl extends ResourceController
{

    protected $modelName = UserModel::class;
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
