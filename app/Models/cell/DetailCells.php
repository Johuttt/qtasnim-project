<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailCells extends Model
{
    protected $table            = 'detail_cells';
    protected $primaryKey       = 'id_detail_cell';
    protected $useAutoIncrement = true;

    protected $allowedFields    = [
        'id_cell',
        'qr_battery',
        'ir',
        'cell',
        'volt',
        'check_qr'
    ];

    // Dates
    protected $useTimestamps = true;

    public function getData($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id_detail_cell' => $id])->first();
    }

    public function getOneData($id)
    {
        return $this->where(['id_cell' => $id, 'qr_battery' => NULL])->first();
    }

    public function getDataByIdCell($id)
    {
        return $this->where(['id_cell' => $id])->findAll();
    }

    public function shortDataIrMin($id_cell, $seri)
    {
        $data = $this->where('id_cell', $id_cell)
            ->orderBy('ir', 'asc')
            ->findAll();

        // Memisahkan array menjadi bagian-bagian yang lebih kecil dengan 16 data dalam setiap bagian
        $chunks = array_chunk($data, $seri);

        // Mengurutkan array genap berdasarkan 'ir' dari yang terbesar ke yang terkecil (descending)
        foreach ($chunks as $key => $chunk) {
            if (($key + 1) % 2 == 0) { // Jika index + 1 adalah genap
                usort($chunk, function ($a, $b) {
                    return $b['ir'] - $a['ir']; // Mengurutkan descending berdasarkan 'ir'
                });
                $chunks[$key] = array_reverse($chunk); // Membalik urutan setelah pengurutan descending
            }
        }

        return $chunks;
    }
}
