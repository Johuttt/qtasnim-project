<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBarangTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'jenis_barang_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('jenis_barang_id', 'jenis_barang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('barang');
    }

    public function down()
    {
        $this->forge->dropTable('barang');
    }
}
