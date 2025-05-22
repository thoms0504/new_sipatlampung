<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZoomSchedule extends Migration
{
    public function up()
    {
        // Membuat struktur tabel
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_kegiatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'jam_mulai' => [
                'type' => 'TIME',
            ],
            'durasi_jam' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'durasi_menit' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'tim' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
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

        // Menambahkan primary key
        $this->forge->addKey('id', true);

        // Membuat tabel
        $this->forge->createTable('zoom_schedules');
    }

    public function down()
    {
        // Menghapus tabel jika migration di-rollback
        $this->forge->dropTable('zoom_schedules');
    }
}
