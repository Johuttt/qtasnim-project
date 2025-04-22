<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $users_data = [
			[
				'username' => 'admin',
				'password' => 'admin12345',
				'nama' => 'admin',
				'npk' => 0,
				'id_divisi' => NULL,
				'divisi' => NULL,
				'id_departement' => NULL,
				'departement' => NULL,
				'id_section' => NULL,
				'section' => NULL,
				'id_sub_section' => NULL,
				'sub_section' => NULL,
				'kode_jabatan' => 0,
				'is_login' => 'false'
			],
			[
				'username' => 'operator',
				'password' => 'operator123',
				'nama' => 'operator',
				'npk' => 0,
				'id_divisi' => NULL,
				'divisi' => NULL,
				'id_departement' => NULL,
				'departement' => NULL,
				'id_section' => NULL,
				'section' => NULL,
				'id_sub_section' => NULL,
				'sub_section' => NULL,
				'kode_jabatan' => 0,
				'is_login' => 'false'
			],
		];

		foreach($users_data as $data){
			// insert semua data ke tabel
			$this->db->table('users')->insert($data);
		}
    }
}
