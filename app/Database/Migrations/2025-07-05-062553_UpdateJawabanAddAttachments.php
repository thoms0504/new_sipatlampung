<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateJawabanAddAttachments extends Migration
{
    public function up()
    {
        // Tambahkan kolom untuk file attachment
        $fields = [
            'file_attachment' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'isi'
            ],
            'file_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'file_attachment'
            ],
            'file_size' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'after' => 'file_type'
            ]
        ];
        
        $this->forge->addColumn('jawaban', $fields);
    }

    public function down()
    {
        // Hapus kolom yang ditambahkan
        $this->forge->dropColumn('jawaban', ['file_attachment', 'file_type', 'file_size']);
    }
}
