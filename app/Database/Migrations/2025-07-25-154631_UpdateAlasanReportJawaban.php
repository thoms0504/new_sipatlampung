<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateAlasanReportJawaban extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_jawaban' => [
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
        $this->forge->addForeignKey('id_jawaban', 'jawaban', 'id_jawaban', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('alasan_report_jawaban', true);
    }

    public function down()
    {
        // Hapus tabel alasan_report_jawaban jika migrasi di-rollback
        $this->forge->dropTable('alasan_report_jawaban', true);
    }
}
