<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStockHistoryTable extends Migration
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
            'barang_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'stock' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'aksi' => [
                'type'       => 'ENUM',
                'constraint' => ['ditambah', 'dikurangi'],
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('barang_id', 'barang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('stock_history');
    }

    public function down()
    {
        $this->forge->dropTable('stock_history');
    }
}
