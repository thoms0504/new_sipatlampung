<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class RepoSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i <50; $i++){
            $data = [
                'judul' => $faker->sentence(4),
                'slug' => $faker->slug(),
                'tim' => $faker->randomElement(['IPDS','Produksi','Distribusi','Sosial','Neraca','PPSSDS']),
                'kategori' => $faker->randomElement(['Pendidikan','Tanaman Pangan','Kesehatan','Sosial Kependudukan','Statistik Sektoral','Inflasi']),
                'file' => 'test.pdf',
                'deskripsi' => $faker->sentence(7),
                'tgl_upload' => Time::createFromTimestamp($faker->unixTime())
            ];
            $this->db->table('repo')->insert($data);
        }
    }
}
