<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ZoomScheduleSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $timList = ['IPDS', 'Produksi', 'Distribusi', 'Sosial', 'Neraca', 'PPSSDS'];

        // Loop untuk membuat data dummy
        for ($i = 0; $i < 25; $i++) { // Ubah 100 sesuai jumlah data yang diinginkan
            $namaKegiatan = $faker->words(5, true); // 5 kata acak
            $tim = $timList[array_rand($timList)]; // Pilih tim secara acak
            $tanggal = $faker->dateTimeBetween('2025-01-01', 'now')->format('Y-m-d'); // Tanggal acak antara 1 Jan 2025 hingga hari ini
            $jamMulai = $this->generateRandomTime(); // Waktu acak dengan kelipatan 30 menit
            $durasiJam = $faker->numberBetween(0, 23); // Durasi jam kelipatan 1
            $durasiMenit = $faker->randomElement([0, 15, 30, 45]); // Durasi menit kelipatan 15

            // Insert data ke database
            $data = [
                'nama_kegiatan' => $namaKegiatan,
                'tim'           => $tim,
                'tanggal'       => $tanggal,
                'jam_mulai'     => $jamMulai,
                'durasi_jam'    => $durasiJam,
                'durasi_menit'  => $durasiMenit,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ];

            $this->db->table('zoom_schedules')->insert($data);
        }
    }

    /**
     * Generate waktu acak dengan kelipatan 30 menit.
     */
    private function generateRandomTime()
    {
        $hour = rand(0, 23); // Jam antara 0-23
        $minute = rand(0, 1) * 30; // Menit 0 atau 30
        return sprintf('%02d:%02d:00', $hour, $minute); // Format HH:MM:SS
    }
}
