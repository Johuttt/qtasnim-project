<?php

namespace App\Models;

use CodeIgniter\Model;

class StockHistoryModel extends Model
{
    protected $table            = 'stock_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['barang_id', 'stock', 'aksi'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'barang_id' => 'required|is_natural_no_zero|is_not_unique[barang.id]',
        'stock'     => 'required|is_natural',
        'aksi'      => 'required|in_list[ditambah,dikurangi]',
    ];
    
    protected $validationMessages = [
        'barang_id' => [
            'required'          => 'Barang ID wajib diisi.',
            'is_natural_no_zero' => 'Barang ID harus berupa angka positif.',
            'is_not_unique'     => 'Barang ID tidak ditemukan.'
        ],
        'stock' => [
            'required'   => 'Stock wajib diisi.',
            'is_natural' => 'Stock harus berupa angka non-negatif.'
        ],
        'aksi' => [
            'required'  => 'Aksi wajib diisi.',
            'in_list'   => 'Aksi harus berupa "ditambah" atau "dikurangi".'
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

    /**
     * Relasi belongsTo ke BarangModel
     * @param int|null $barangId
     * @return array|null
     */
    public function belongsToBarang($barangId = null)
    {
        $barangModel = new BarangModel();
        return $barangModel->find($barangId ?? $this->barang_id);
    }

    /**
     * Mengambil semua stock_history dengan relasi ke barang (nested)
     * @return array
     */
    public function getAllWithBarang()
    {
        $stockHistory = $this->findAll();
        return array_map(function ($item) {
            $item['barang'] = $this->belongsToBarang($item['barang_id']);
            return $item;
        }, $stockHistory);
    }

    /**
     * Mengambil stock_history berdasarkan ID dengan relasi ke barang (nested)
     * @param int $id
     * @return array|null
     */
    public function getByIdWithBarang($id)
    {
        $item = $this->find($id);
        if ($item) {
            $item['barang'] = $this->belongsToBarang($item['barang_id']);
        }
        return $item;
    }
}
