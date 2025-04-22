<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'nama','npk'];

    public function getUserByUsername($userId)
    {
        return $this->where('id_user', $userId)->first();
    }
    public function getUser()
    {
        return $this->findAll(); 
    }

    public function TotalUser(){
        return $this->db->table('users')->countAllResults();
    }

    public function getUserById($userId){
        return $this->where('id_user', $userId)
        ->orderBy('updated_at', 'DESC')
        ->first();}


}
