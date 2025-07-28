<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateReportPertanyaandanJawaban extends Migration
{
    public function up()
    {
        // Tambahkan kolom report_count ke tabel pertanyaan
        $fieldsPertanyaan = [
            'report_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'after' => 'updated_at'
            ]
        ];
        $this->forge->addColumn('pertanyaan', $fieldsPertanyaan);

        // Tambahkan kolom report_count ke tabel jawaban
        $fieldsJawaban = [
            'report_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'after' => 'updated_at'
            ]
        ];
        $this->forge->addColumn('jawaban', $fieldsJawaban);
    }

    public function down()
    {
        // Hapus kolom report_count dari tabel pertanyaan jika migrasi di-rollback
        $this->forge->dropColumn('pertanyaan', 'report_count');

        // Hapus kolom report_count dari tabel jawaban jika migrasi di-rollback
        $this->forge->dropColumn('jawaban', 'report_count');
    }
}
