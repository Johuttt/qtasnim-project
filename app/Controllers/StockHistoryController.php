<?php

namespace App\Controllers;

use App\Models\StockHistoryModel;
use App\Models\BarangModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class StockHistoryController extends ResourceController
{
    protected $modelName = 'App\Models\StockHistoryModel';
    protected $format = 'json';

    public function dashboard()
    {
        return view('pages/stock-history/dashboard');
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $model = new StockHistoryModel();
        $data = $model->getAllWithBarang();
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
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        return view('pages/stock-history/form');
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $model = new StockHistoryModel();
        $data = $this->request->getPost();

        $barangModel = new BarangModel();
        $barang = $barangModel->find($data['barang_id']);
        if (!$barang) {
            return $this->fail('Barang tidak ditemukan', 400);
        }

        if ($data['aksi'] === 'ditambah') {
            $barangModel->update($data['barang_id'], ['stock' => $barang['stock'] + $data['stock']]);
        } elseif ($data['aksi'] === 'dikurangi') {
            $newStock = $barang['stock'] - $data['stock'];
            if ($newStock < 0) {
                return $this->fail('Stock barang tidak boleh negatif', 400);
            }
            $barangModel->update($data['barang_id'], ['stock' => $newStock]);
        }
        
        if ($model->insert($data)) {
            return $this->respondCreated(['message' => 'Data riwayat stok berhasil disimpan', 'data' => $data]);
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
        //
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
        //
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
        //
    }
}
