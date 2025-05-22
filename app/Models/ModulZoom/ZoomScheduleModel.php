<?php

namespace App\Models\ModulZoom;

use CodeIgniter\Model;

class ZoomScheduleModel extends Model
{
    protected $table            = 'zoom_schedules';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['nama_kegiatan', 'tanggal', 'jam_mulai', 'durasi_jam', 'durasi_menit', 'tim'];

    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getEventsByDateRange($startDate, $endDate)
    {
        return $this->where('jam_mulai >=', $startDate . ' 00:00:00')
            ->where('jam_mulai <=', $endDate . ' 23:59:59')
            ->orderBy('jam_mulai', 'ASC')
            ->findAll();
    }

    // Calculate end time based on start time and duration
    public function calculateEndTime($event)
    {
        $startTime = strtotime($event['jam_mulai']);
        $durationInSeconds = ($event['durasi_jam'] * 3600) + ($event['durasi_menit'] * 60);
        return date('Y-m-d H:i:s', $startTime + $durationInSeconds);
    }

    // Get schedules by date range
    public function getSchedulesByDateRange($startDate, $endDate)
    {
        $schedules = $this->select('id, tim, nama_kegiatan, DATE(tanggal) as tanggal, jam_mulai, durasi_jam, durasi_menit')
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $endDate)
            ->orderBy('tanggal, jam_mulai', 'ASC')
            ->findAll();

        // Kelompokkan jadwal berdasarkan tanggal dan tim
        $groupedByDate = [];
        foreach ($schedules as $schedule) {
            $date = $schedule['tanggal'];
            if (!isset($groupedByDate[$date])) {
                $groupedByDate[$date] = [];
            }
            $groupedSchedules[$date][] = $schedule['tim'];
        }

        return [
            'schedules' => $schedules,
            'groupedByDate' => $groupedSchedules
        ];
    }

    public function getZoomFixtures($params = [])
    {
        $builder = $this->select('id, tim, nama_kegiatan, tanggal, jam_mulai, durasi_jam, durasi_menit, created_at, updated_at');
        
        // Filter berdasarkan rentang tanggal
        if (isset($params['startDate']) && isset($params['endDate'])) {
            $builder->where('tanggal >=', $params['startDate'])
                   ->where('tanggal <=', $params['endDate']);
        } elseif (isset($params['startDate'])) {
            $builder->where('tanggal >=', $params['startDate']);
        } elseif (isset($params['endDate'])) {
            $builder->where('tanggal <=', $params['endDate']);
        }
        
        // Filter berdasarkan tim
        if (isset($params['tim'])) {
            $builder->where('tim', $params['tim']);
        }
        
        // Urutan berdasarkan tanggal dan jam mulai
        $builder->orderBy('tanggal', 'ASC')
                ->orderBy('jam_mulai', 'ASC');
        
        // Batasi jumlah data jika diperlukan
        if (isset($params['limit'])) {
            if (isset($params['offset'])) {
                $builder->limit($params['limit'], $params['offset']);
            } else {
                $builder->limit($params['limit']);
            }
        }
        
        $fixtures = $builder->findAll();
        
        // Tambahkan waktu akhir untuk setiap jadwal
        foreach ($fixtures as &$fixture) {
            $fixture['jam_akhir'] = $this->calculateEndTime($fixture);
            
            // Format tanggal untuk tampilan
            $fixture['tanggal_formatted'] = date('d-m-Y', strtotime($fixture['tanggal']));
            $fixture['jam_mulai_formatted'] = date('H:i', strtotime($fixture['jam_mulai']));
            $fixture['jam_akhir_formatted'] = date('H:i', strtotime($fixture['jam_akhir']));
            
            // Tambahkan durasi total dalam menit
            $fixture['durasi_total_menit'] = ($fixture['durasi_jam'] * 60) + $fixture['durasi_menit'];
        }
        
        // Hitung statistik
        $stats = [
            'total' => count($fixtures),
            'tim_count' => count(array_unique(array_column($fixtures, 'tim'))),
            'upcoming' => 0,
            'past' => 0
        ];
        
        $now = date('Y-m-d H:i:s');
        foreach ($fixtures as $fixture) {
            if ($fixture['jam_mulai'] > $now) {
                $stats['upcoming']++;
            } else {
                $stats['past']++;
            }
        }
        
        // Kelompokkan jadwal berdasarkan tanggal
        $groupedByDate = [];
        foreach ($fixtures as $fixture) {
            $date = date('Y-m-d', strtotime($fixture['tanggal']));
            if (!isset($groupedByDate[$date])) {
                $groupedByDate[$date] = [];
            }
            $groupedByDate[$date][] = $fixture;
        }
        
        // Kelompokkan jadwal berdasarkan tim
        $groupedByTeam = [];
        foreach ($fixtures as $fixture) {
            $team = $fixture['tim'];
            if (!isset($groupedByTeam[$team])) {
                $groupedByTeam[$team] = [];
            }
            $groupedByTeam[$team][] = $fixture;
        }
        
        return [
            'fixtures' => $fixtures,
            'grouped_by_date' => $groupedByDate,
            'grouped_by_team' => $groupedByTeam,
            'stats' => $stats
        ];
    }
    
    /**
     * Mendapatkan fixture zoom yang akan datang dalam periode tertentu (hari)
     * 
     * @param int $days Jumlah hari ke depan
     * @param string $team Tim spesifik (opsional)
     * @return array Daftar fixtures yang akan datang
     */
    public function getUpcomingFixtures($days = 7, $team = null)
    {
        $today = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime('+' . $days . ' days'));
        
        $params = [
            'startDate' => $today,
            'endDate' => $endDate
        ];
        
        if ($team) {
            $params['tim'] = $team;
        }
        
        $data = $this->getZoomFixtures($params);
        
        // Filter hanya untuk meetings yang belum terjadi
        $now = date('Y-m-d H:i:s');
        $upcomingFixtures = array_filter($data['fixtures'], function($fixture) use ($now) {
            return $fixture['jam_mulai'] > $now;
        });
        
        // Urutkan kembali array setelah filtering
        $upcomingFixtures = array_values($upcomingFixtures);
        
        return [
            'fixtures' => $upcomingFixtures,
            'total' => count($upcomingFixtures),
            'period' => [
                'start' => $today,
                'end' => $endDate,
                'days' => $days
            ]
        ];
    }
    
    /**
     * Mendapatkan jadwal zoom hari ini
     * 
     * @param string $team Tim spesifik (opsional)
     * @return array Daftar fixtures hari ini
     */
    public function getTodayFixtures($team = null)
    {
        $today = date('Y-m-d');
        
        $params = [
            'startDate' => $today,
            'endDate' => $today
        ];
        
        if ($team) {
            $params['tim'] = $team;
        }
        
        $data = $this->getZoomFixtures($params);
        
        // Pisahkan jadwal yang sudah lewat dan yang akan datang
        $now = date('Y-m-d H:i:s');
        $upcomingToday = [];
        $pastToday = [];
        
        foreach ($data['fixtures'] as $fixture) {
            if ($fixture['jam_mulai'] > $now) {
                $upcomingToday[] = $fixture;
            } else {
                $pastToday[] = $fixture;
            }
        }
        
        return [
            'all_fixtures' => $data['fixtures'],
            'upcoming' => $upcomingToday,
            'past' => $pastToday,
            'total' => count($data['fixtures']),
            'upcoming_count' => count($upcomingToday),
            'past_count' => count($pastToday),
            'date' => $today
        ];
    }
}
