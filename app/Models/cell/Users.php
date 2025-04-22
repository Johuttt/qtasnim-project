<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;

    protected $allowedFields    = [
        'username', 
        'password', 
        'nama', 
        'level'
    ];

    // Dates
    protected $useTimestamps = true;

    public function cek_login($username, $password)
    {
        $query = $this->query('SELECT * FROM users WHERE username = \''.$username.'\' AND password = \''.$password.'\'');

        return $query->getRowArray();
    }
}
