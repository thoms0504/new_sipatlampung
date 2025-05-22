<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pertanyaan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pertanyaan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_penanya' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type'       => 'TEXT'
            ],
            'status' => [
                'type' => 'INT',
                'constraint' => 1
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
        $this->forge->addKey('id_pertanyaan', true);
        $this->forge->addKey('id_penanya'); // Menambahkan index
        $this->forge->addForeignKey('id_penanya', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pertanyaan');
    }

    public function down()
    {
        $this->forge->dropTable('pertanyaan');
    }
}
