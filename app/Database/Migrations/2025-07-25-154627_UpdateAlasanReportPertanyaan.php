<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateAlasanReportPertanyaan extends Migration
{
    public function up()
    {
        // Membuat tabel baru untuk alasan report pertanyaan
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_pertanyaan' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'alasan' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_pertanyaan', 'pertanyaan', 'id_pertanyaan', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('alasan_report_pertanyaan');
    }

    public function down()
    {
        // Menghapus tabel alasan report pertanyaan 
        $this->forge->dropTable('alasan_report_pertanyaan', true);
    }
}
