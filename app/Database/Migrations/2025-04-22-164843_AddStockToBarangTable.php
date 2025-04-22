<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStockToBarangTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('barang', [
            'stock' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
                'default'    => 0,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('barang', 'stock');
    }
}
