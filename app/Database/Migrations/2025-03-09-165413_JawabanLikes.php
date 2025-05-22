<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JawabanLikes extends Migration
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
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Tambahkan primary key
        $this->forge->addPrimaryKey('id_like');

        // Tambahkan foreign key ke tabel `jawaban`
        $this->forge->addForeignKey('id_jawaban', 'jawaban', 'id_jawaban', 'CASCADE', 'CASCADE');

        // Tambahkan foreign key ke tabel `users`
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');

        // Buat tabel
        $this->forge->createTable('jawaban_likes');
    }

    public function down()
    {
        // Hapus tabel jika migrasi di-rollback
        $this->forge->dropTable('jawaban_likes');
    }
}
