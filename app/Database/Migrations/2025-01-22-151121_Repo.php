<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Repo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'tim' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'file' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'deskripsi' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'tgl_upload' => [
            'type' => 'DATETIME',
            'null' => true
]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('repo');
    }

    public function down()
    {
        $this->forge->dropTable('repo');
    }
}
