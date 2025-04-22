<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\JenisBarangModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class BarangController extends ResourceController
{
    protected $modelName = 'App\Models\JenisBarangModel';
    protected $format = 'json';

    public function dashboard()
    {
        return view('pages/barang/dashboard');
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $model = new BarangModel();
        $data = $model->getAllWithJenisBarang();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $model = new BarangModel();
        $data = $model->getByIdWithJenisBarang($id);
        if ($data) {
            return $this->respond($data);
        }
        return $this->failNotFound('Barang tidak ditemukan');
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        return view('pages/barang/form');
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $model = new BarangModel();
        $data = $this->request->getPost();

        $jenisBarangModel = new JenisBarangModel();
        if (!$jenisBarangModel->find($data['jenis_barang_id'])) {
            return $this->fail('Jenis barang tidak ditemukan', 400);
        }

        if ($model->insert($data)) {
            return $this->respondCreated(['message' => 'Data berhasil disimpan', 'data' => $data]);
        }
        return $this->fail($model->errors());
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        return view('pages/barang/form');
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $model = new BarangModel();
        $data = $this->request->getPost();

        $jenisBarangModel = new JenisBarangModel();
        if (!$jenisBarangModel->find($data['jenis_barang_id'])) {
            return $this->fail('Jenis barang tidak ditemukan', 400);
        }

        if ($model->update($id, $data)) {
            return $this->respond(['message' => 'Data berhasil diperbarui', 'data' => $data]);
        }
        return $this->fail($model->errors());
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $model = new BarangModel();
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        }
        return $this->failNotFound('Barang tidak ditemukan');
    }
}
