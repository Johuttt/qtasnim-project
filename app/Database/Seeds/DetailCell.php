<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DetailCell extends Seeder
{
    public function run()
    {
        $users_data = [];
        // Melakukan looping untuk membuat entri dengan nama A01 sampai D30
        for ($letter = 'A'; $letter <= 'Z'; $letter++) {
            for ($i = 1; $i <= 30 && count($users_data) < 80; $i++) {
                $ir = 123 + $i; // Penambahan nilai ir sebesar 1 setiap loop
                $volt = 1 + (2 * $i); // Penambahan nilai volt sebesar 2 setiap loop
                $cell_data = [
                    'id_cell' => 1,
                    'cell'  => $letter . sprintf('%02d', $i),
                    'qr_battery'  => 'asd2w32',
                    'ir' => $ir,
                    'volt' => $volt,
                    'check_qr' => NULL
                ];
                // Menyimpan entri pada tabel 'DetailCells'
                $users_data[] = $cell_data;
            }
        }

        foreach ($users_data as $data) {
            // insert semua data ke tabel
            $this->db->table('detail_cells')->insert($data);
        }
    }
}
