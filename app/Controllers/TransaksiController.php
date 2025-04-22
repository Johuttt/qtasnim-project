<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\BarangModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class TransaksiController extends ResourceController
{
    protected $modelName = 'App\Models\TransaksiModel';
    protected $format = 'json';

    public function dashboard()
    {
        return view('pages/transaksi/dashboard');
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $model = new TransaksiModel();
        $search = $this->request->getGet('search');
        $sortBy = $this->request->getGet('sort');
        $sortOrder = $this->request->getGet('order') ?? 'asc';

        $data = $model->getAllWithBarang($search, $sortBy, $sortOrder);
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
        $model = new TransaksiModel();
        $data = $model->getByIdWithBarang($id);
        if ($data) {
            return $this->respond($data);
        }
        return $this->failNotFound('Transaksi tidak ditemukan');
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        return view('pages/transaksi/form');
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $model = new TransaksiModel();
        $barangModel = new BarangModel();
        $data = $this->request->getPost();

        $barang = $barangModel->find($data['barang_id']);
        if (!$barang) {
            return $this->fail('Barang tidak ditemukan', 400);
        }
        if ($barang['stock'] < $data['jumlah_terjual']) {
            return $this->fail('Stock barang tidak mencukupi', 400);
        }

        $barangModel->update($data['barang_id'], ['stock' => $barang['stock'] - $data['jumlah_terjual']]);

        if ($model->insert($data)) {
            return $this->respondCreated(['message' => 'Data transaksi berhasil disimpan', 'data' => $data]);
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
        return view('pages/transaksi/form');
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
        $model = new TransaksiModel();
        $barangModel = new BarangModel();
        $data = $this->request->getPost();

        // Ambil data transaksi lama
        $transaksiLama = $model->find($id);
        if (!$transaksiLama) {
            return $this->failNotFound('Transaksi tidak ditemukan');
        }

        // Validasi barang_id baru
        $barangBaru = $barangModel->find($data['barang_id']);
        if (!$barangBaru) {
            return $this->fail('Barang tidak ditemukan', 400);
        }

        // Jika barang_id berubah
        if ($transaksiLama['barang_id'] != $data['barang_id']) {
            // Tambahkan jumlah terjual lama ke stock barang lama
            $barangLama = $barangModel->find($transaksiLama['barang_id']);
            if ($barangLama) {
                $barangModel->update($transaksiLama['barang_id'], [
                    'stock' => $barangLama['stock'] + $transaksiLama['jumlah_terjual']
                ]);
            }

            // Kurangi jumlah terjual baru dari stock barang baru
            if ($barangBaru['stock'] < $data['jumlah_terjual']) {
                return $this->fail('Stock barang baru tidak mencukupi', 400);
            }
            $barangModel->update($data['barang_id'], [
                'stock' => $barangBaru['stock'] - $data['jumlah_terjual']
            ]);
        } else {
            // Barang_id sama, sesuaikan stock berdasarkan perubahan jumlah terjual
            $stockSetelahBatal = $barangBaru['stock'] + $transaksiLama['jumlah_terjual'];
            $stockBaru = $stockSetelahBatal - $data['jumlah_terjual'];
            if ($stockBaru < 0) {
                return $this->fail('Stock barang tidak mencukupi', 400);
            }
            $barangModel->update($data['barang_id'], ['stock' => $stockBaru]);
        }

        // Perbarui transaksi
        if ($model->update($id, $data)) {
            return $this->respond(['message' => 'Data transaksi berhasil diperbarui', 'data' => $data]);
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
        $model = new TransaksiModel();
        $barangModel = new BarangModel();

        // Ambil data transaksi
        $transaksi = $model->find($id);
        if (!$transaksi) {
            return $this->failNotFound('Transaksi tidak ditemukan');
        }

        // Validasi barang_id
        $barang = $barangModel->find($transaksi['barang_id']);
        if (!$barang) {
            return $this->fail('Barang terkait tidak ditemukan', 400);
        }

        // Kembalikan jumlah terjual ke stock barang
        $barangModel->update($transaksi['barang_id'], [
            'stock' => $barang['stock'] + $transaksi['jumlah_terjual']
        ]);

        // Hapus transaksi
        if ($model->delete($id)) {
            return $this->respondDeleted(['id' => $id, 'message' => 'Data transaksi berhasil dihapus']);
        }

        return $this->fail('Gagal menghapus transaksi', 500);
    }

    public function compareJenisBarang()
    {
        $model = new TransaksiModel();
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        // Validasi format tanggal
        if ($startDate && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate)) {
            return $this->fail('Format tanggal mulai tidak valid. Gunakan YYYY-MM-DD.', 400);
        }
        if ($endDate && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $endDate)) {
            return $this->fail('Format tanggal selesai tidak valid. Gunakan YYYY-MM-DD.', 400);
        }

        $data = $model->getJenisBarangComparison($startDate, $endDate);

        if (empty($data)) {
            log_message('debug', 'No data found for compareJenisBarang. start_date: ' . ($startDate ?: 'null') . ', end_date: ' . ($endDate ?: 'null'));
            return $this->respond(['data' => [], 'message' => 'Tidak ada data transaksi untuk rentang waktu ini']);
        }

        // Tentukan terbanyak dan terendah
        $maxSold = max(array_column($data, 'total_terjual'));
        $minSold = min(array_column($data, 'total_terjual'));

        $data = array_map(function($item) use ($maxSold, $minSold) {
            $item['status'] = null;
            if ($item['total_terjual'] == $maxSold && $maxSold > 0) {
                $item['status'] = 'Terbanyak';
            } elseif ($item['total_terjual'] == $minSold && $minSold >= 0) {
                $item['status'] = 'Terendah';
            }
            return $item;
        }, $data);

        return $this->respond(['data' => $data, 'message' => 'Data perbandingan jenis barang berhasil diambil']);
    }
}
