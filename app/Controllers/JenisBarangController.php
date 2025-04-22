<?php

namespace App\Controllers;

use App\Models\JenisBarangModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class JenisBarangController extends ResourceController
{

    protected $modelName = 'App\Models\JenisBarangModel';
    protected $format = 'json';

    public function dashboard()
    {
        return view('pages/jenis-barang/dashboard');
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $model = new JenisBarangModel();
        $data = $model->findAll();
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
        $model = new JenisBarangModel();
        $data = $model->find($id);
        if ($data) {
            return $this->respond($data);
        }
        return $this->failNotFound('Jenis barang tidak ditemukan');
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        return view('pages/jenis-barang/form');
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $model = new JenisBarangModel();
        $data = $this->request->getPost();

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
        return view('pages/jenis-barang/form');
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
        $model = new JenisBarangModel();
        $data = $this->request->getPost();

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
        $model = new JenisBarangModel();
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        }
        return $this->failNotFound('Jenis barang tidak ditemukan');
    }
}
