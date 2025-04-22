<?php

namespace App\Models;

use CodeIgniter\Model;

class Cells extends Model
{
    protected $table            = 'cells';
    protected $primaryKey       = 'id_cell';
    protected $useAutoIncrement = true;

    protected $allowedFields    = [
        'id_detail_cell', 
        'battery_type', 
        'volt_battery', 
        'ah_battery', 
        'total_seri', 
        'total_pararel',
        'need_cell',
        'limit_cell'
    ];

    // Dates
    protected $useTimestamps = true;

    public function getData($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }

        return $this->where(['id_cell' => $id])->first();
    }
}
