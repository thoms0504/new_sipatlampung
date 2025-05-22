<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jawaban extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jawaban' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_penjawab' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true,
            ],
            'id_pertanyaan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'isi' => [
                'type'       => 'TEXT',
            ],
            'likes' => [          // Menambahkan kolom likes
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
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
        $this->forge->addKey('id_jawaban', true);
        $this->forge->addKey(['id_pertanyaan', 'id_penjawab']); // Composite index
        $this->forge->addForeignKey('id_pertanyaan', 'pertanyaan', 'id_pertanyaan', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_penjawab', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jawaban');
    }

    public function down()
    {
        $this->forge->dropTable('jawaban');
    }
}
