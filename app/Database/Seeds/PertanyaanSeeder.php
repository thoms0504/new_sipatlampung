<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PertanyaanSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 20; $i++) {
            $data = [
                'id_penanya' => 3,
                'judul' => $faker->sentence(3),
                'deskripsi' => $faker->sentence(100),
                'status' => 0,
                'created_at' => Time::createFromTimestamp($faker->unixTime()),
                'updated_at' => Time::now()
            ];
            $this->db->table('pertanyaan')->insert($data);
        }
    }
}
