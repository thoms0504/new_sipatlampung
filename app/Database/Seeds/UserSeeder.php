<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'nama_lengkap' => 'Admin',
                'email' => 'admin@localhost.test',
                'role' => 'admin',
                'is_active' => 1
            ], [
                'username' => 'operator',
                'password' => password_hash('operator', PASSWORD_DEFAULT),
                'nama_lengkap' => 'Operator',
                'email' => '0perator@localhost.test',
                'role' => 'operator',
                'is_active' => 1
            ],
            [
                'username' => 'user',
                'password' => password_hash('user', PASSWORD_DEFAULT),
                'nama_lengkap' => 'User',
                'email' => 'user@localhost.test',
                'role' => 'user',
                'is_active' => 1
            ]
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
