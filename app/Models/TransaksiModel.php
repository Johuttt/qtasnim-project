<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['barang_id', 'jumlah_terjual'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'barang_id'      => 'required|is_natural_no_zero|is_not_unique[barang.id]',
        'jumlah_terjual' => 'required|is_natural_no_zero',
    ];
    protected $validationMessages = [
        'barang_id' => [
            'required'          => 'Barang ID wajib diisi.',
            'is_natural_no_zero' => 'Barang ID harus berupa angka positif.',
            'is_not_unique'     => 'Barang ID tidak ditemukan.',
        ],
        'jumlah_terjual' => [
            'required'          => 'Jumlah terjual wajib diisi.',
            'is_natural_no_zero' => 'Jumlah terjual harus berupa angka positif.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAllWithBarang($search = null, $sortBy = null, $sortOrder = 'asc')
    {
        $builder = $this->select('transaksi.*, barang.nama_barang, barang.jenis_barang_id, barang.stock as barang_stock, jenis_barang.nama_jenis_barang')
                       ->join('barang', 'barang.id = transaksi.barang_id', 'left')
                       ->join('jenis_barang', 'jenis_barang.id = barang.jenis_barang_id', 'left');

        // Pencarian berdasarkan nama_barang
        if ($search) {
            $builder->like('barang.nama_barang', $search);
        }

        // Pengurutan
        if ($sortBy) {
            $validSortColumns = ['nama_barang' => 'barang.nama_barang', 'created_at' => 'transaksi.created_at'];
            $sortColumn = isset($validSortColumns[$sortBy]) ? $validSortColumns[$sortBy] : 'transaksi.created_at';
            $sortOrder = ($sortOrder === 'desc') ? 'desc' : 'asc';
            $builder->orderBy($sortColumn, $sortOrder);
        } else {
            $builder->orderBy('transaksi.created_at', 'desc');
        }

        $data = $builder->findAll();

        // Format data untuk struktur nested
        return array_map(function($item) {
            $barang = [
                'id' => $item['barang_id'],
                'nama_barang' => $item['nama_barang'],
                'jenis_barang_id' => $item['jenis_barang_id'],
                'stock' => $item['barang_stock'],
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
                'jenis_barang' => [
                    'id' => $item['jenis_barang_id'],
                    'nama_jenis_barang' => $item['nama_jenis_barang']
                ]
            ];
            unset($item['nama_barang'], $item['jenis_barang_id'], $item['barang_stock'], $item['nama_jenis_barang']);
            $item['barang'] = $barang;
            return $item;
        }, $data);
    }

    /**
     * Mengambil transaksi berdasarkan ID dengan relasi ke barang dan jenis barang (nested)
     * @param int $id
     * @return array|null
     */
    public function getByIdWithBarang($id)
    {
        $builder = $this->select('transaksi.*, barang.nama_barang, barang.jenis_barang_id, barang.stock as barang_stock, jenis_barang.nama_jenis_barang')
                       ->join('barang', 'barang.id = transaksi.barang_id', 'left')
                       ->join('jenis_barang', 'jenis_barang.id = barang.jenis_barang_id', 'left')
                       ->where('transaksi.id', $id);

        $item = $builder->first();

        if ($item) {
            $barang = [
                'id' => $item['barang_id'],
                'nama_barang' => $item['nama_barang'],
                'jenis_barang_id' => $item['jenis_barang_id'],
                'stock' => $item['barang_stock'],
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
                'jenis_barang' => [
                    'id' => $item['jenis_barang_id'],
                    'nama_jenis_barang' => $item['nama_jenis_barang']
                ]
            ];
            unset($item['nama_barang'], $item['jenis_barang_id'], $item['barang_stock'], $item['nama_jenis_barang']);
            $item['barang'] = $barang;
        }

        return $item;
    }

    /**
     * Mengambil perbandingan jenis barang berdasarkan total jumlah terjual
     * Mendukung filter rentang waktu
     * @param string|null $startDate Format: YYYY-MM-DD
     * @param string|null $endDate Format: YYYY-MM-DD
     * @return array
     */
    public function getJenisBarangComparison($startDate = null, $endDate = null)
{
    $builder = $this->db->table('jenis_barang')
                       ->select('jenis_barang.id, jenis_barang.nama_jenis_barang, COALESCE(SUM(transaksi.jumlah_terjual), 0) as total_terjual')
                       ->join('barang', 'barang.jenis_barang_id = jenis_barang.id', 'left');

    // Gabungkan kondisi tanggal ke dalam ON clause untuk transaksi
    $onClause = 'transaksi.barang_id = barang.id';
    if ($startDate && $endDate) {
        $onClause .= " AND transaksi.created_at >= '{$startDate} 00:00:00' AND transaksi.created_at <= '{$endDate} 23:59:59'";
    }
    $builder->join('transaksi', $onClause, 'left');

    $builder->groupBy('jenis_barang.id, jenis_barang.nama_jenis_barang')
            ->orderBy('total_terjual', 'desc');

    return $builder->get()->getResultArray();
}

}
