<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_barang', 'jenis_barang_id', 'stock'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
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
     * Relasi belongsTo ke JenisBarangModel
     * @param int|null $jenisBarangId
     * @return object|null
     */
    public function belongsToJenisBarang($jenisBarangId = null)
    {
        $jenisBarangModel = new JenisBarangModel();
        return $jenisBarangModel->find($jenisBarangId ?? $this->jenis_barang_id);
    }

    /**
     * Mengambil semua barang dengan relasi ke jenis_barang (nested)
     * @return array
     */
    public function getAllWithJenisBarang()
    {
        $barang = $this->findAll();
        return array_map(function ($item) {
            $item['jenis_barang'] = $this->belongsToJenisBarang($item['jenis_barang_id']);
            return $item;
        }, $barang);
    }

    /**
     * Mengambil barang berdasarkan ID dengan relasi ke jenis_barang (nested)
     * @param int $id
     * @return object|null
     */
    public function getByIdWithJenisBarang($id)
    {
        $item = $this->find($id);
        if ($item) {
            $item['jenis_barang'] = $this->belongsToJenisBarang($item['jenis_barang_id']);
        }
        return $item;
    }
}
