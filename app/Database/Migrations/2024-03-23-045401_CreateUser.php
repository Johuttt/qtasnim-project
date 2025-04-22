<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUser extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'npk' => [
                'type' => 'INT',
                'null' => true,
            ],
            'is_login' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP'
            ]);

        // Membuat primary key
        $this->forge->addKey('id_user', true);

        // Membuat tabel users
        $this->forge->createTable('users', true);
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
