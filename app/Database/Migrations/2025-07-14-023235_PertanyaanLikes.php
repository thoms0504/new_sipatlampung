<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PertanyaanLikes extends Migration
{
    public function up()
    {
        // Definisikan struktur tabel
        $this->forge->addField([
            'id_like' => [
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
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Tambahkan primary key
        $this->forge->addPrimaryKey('id_like');

        // Tambahkan foreign key ke tabel `pertanyaan`
        $this->forge->addForeignKey('id_pertanyaan', 'pertanyaan', 'id_pertanyaan', 'CASCADE', 'CASCADE');

        // Tambahkan foreign key ke tabel `users`
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');

        // Buat tabel
        $this->forge->createTable('pertanyaan_likes');
    }

    public function down()
    {
        // Hapus tabel jika migrasi di-rollback
        $this->forge->dropTable('pertanyaan_likes');
    }
}
