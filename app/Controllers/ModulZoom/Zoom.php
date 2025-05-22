<?php

namespace App\Controllers\ModulZoom;

use App\Controllers\BaseController;
use App\Models\ModulZoom\ZoomScheduleModel;
use CodeIgniter\HTTP\ResponseInterface;

class Zoom extends BaseController
{
    protected $zoomModel;
    
    public function __construct()
    {
        $this->zoomModel = new ZoomScheduleModel();
    }
    
    /**
     * Halaman dashboard utama zoom
     */
    public function index()
    {
        $todayFixtures = $this->zoomModel->getTodayFixtures();
        $upcomingFixtures = $this->zoomModel->getUpcomingFixtures(7);
        
        $data = [
            'title' => 'Dashboard Zoom Meetings',
            'active' => 'dasbor_zoom',
            'todayFixtures' => $todayFixtures,
            'upcomingFixtures' => $upcomingFixtures,
        ];
        
        return view('Admin/ModulZoom/dasbor', $data);
    }
    
    /**
     * Menampilkan kalender pertemuan zoom
     */
    
    
    /**
     * Menampilkan kalender pertemuan zoom untuk bulan tertentu
     */
    
    /**
     * Mendapatkan data fixtures untuk ditampilkan sebagai JSON (untuk keperluan AJAX)
     */
    public function getFixturesJson()
    {
        $request = $this->request;
        
        $startDate = $request->getGet('start_date') ?? date('Y-m-d');
        $endDate = $request->getGet('end_date') ?? date('Y-m-d', strtotime('+30 days'));
        $team = $request->getGet('team') ?? null;
        
        $params = [
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
        
        if ($team) {
            $params['tim'] = $team;
        }
        
        $fixtures = $this->zoomModel->getZoomFixtures($params);
        
        // Format data untuk calendar event (jika diperlukan untuk library seperti FullCalendar)
        $calendarEvents = [];
        foreach ($fixtures['fixtures'] as $fixture) {
            $calendarEvents[] = [
                'id' => $fixture['id'],
                'title' => $fixture['nama_kegiatan'] . ' (' . $fixture['tim'] . ')',
                'start' => $fixture['jam_mulai'],
                'end' => $fixture['jam_akhir'],
                'team' => $fixture['tim'],
                'description' => 'Durasi: ' . $fixture['durasi_jam'] . ' jam ' . $fixture['durasi_menit'] . ' menit'
            ];
        }
        
        return $this->response->setJSON([
            'success' => true,
            'events' => $calendarEvents,
            'fixtures' => $fixtures['fixtures'],
            'stats' => $fixtures['stats']
        ]);
    }
    
    /**
     * Menampilkan halaman detail pertemuan zoom
     */
    
    
    /**
     * Menampilkan halaman daftar pertemuan berdasarkan tim
     */
    public function listByTeam($team = null)
    {
        $request = $this->request;
        
        if ($team === null) {
            $team = $request->getGet('team');
        }
        
        if (empty($team)) {
            return redirect()->to('zoom')->with('error', 'Tim tidak ditemukan');
        }
        
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime('+30 days'));
        
        $fixtures = $this->zoomModel->getZoomFixtures([
            'startDate' => $startDate,
            'endDate' => $endDate,
            'tim' => $team
        ]);
        
        $data = [
            'title' => 'Pertemuan Tim: ' . $team,
            'fixtures' => $fixtures,
            'team' => $team,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
        
        return view('modul_zoom/team_fixtures', $data);
    }
    
    /**
     * Halaman untuk menampilkan pertemuan hari ini
     */
    public function today()
    {
        $todayFixtures = $this->zoomModel->getTodayFixtures();
        
        $data = [
            'title' => 'Pertemuan Zoom Hari Ini (' . date('d-m-Y') . ')',
            'fixtures' => $todayFixtures
        ];
        
        return view('modul_zoom/today', $data);
    }
    
    /**
     * Halaman untuk menampilkan pertemuan yang akan datang
     */
    public function upcoming($days = 7)
    {
        $request = $this->request;
        $days = $request->getGet('days') ?? $days;
        $team = $request->getGet('team') ?? null;
        
        // Validasi input
        $days = (int) $days;
        if ($days <= 0 || $days > 90) {
            $days = 7; // Default 7 hari jika input tidak valid
        }
        
        $upcomingFixtures = $this->zoomModel->getUpcomingFixtures($days, $team);
        
        $data = [
            'title' => 'Pertemuan Zoom Yang Akan Datang',
            'fixtures' => $upcomingFixtures,
            'days' => $days,
            'team' => $team
        ];
        
        return view('modul_zoom/upcoming', $data);
    }
    
    /**
     * Mendapatkan statistik pertemuan zoom (untuk dashboard admin)
     */
    public function stats()
    {
        // Statistik bulan ini
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-t');
        
        $monthlyFixtures = $this->zoomModel->getZoomFixtures([
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
        
        // Statistik tahun ini
        $yearStart = date('Y-01-01');
        $yearEnd = date('Y-12-31');
        
        $yearlyFixtures = $this->zoomModel->getZoomFixtures([
            'startDate' => $yearStart,
            'endDate' => $yearEnd
        ]);
        
        // Mendapatkan semua tim
        $allTeams = [];
        foreach ($yearlyFixtures['fixtures'] as $fixture) {
            $allTeams[$fixture['tim']] = true;
        }
        $allTeams = array_keys($allTeams);
        
        // Statistik per tim
        $teamStats = [];
        foreach ($allTeams as $team) {
            $teamFixtures = $this->zoomModel->getZoomFixtures([
                'startDate' => $yearStart,
                'endDate' => $yearEnd,
                'tim' => $team
            ]);
            
            $teamStats[$team] = [
                'total' => count($teamFixtures['fixtures']),
                'upcoming' => $teamFixtures['stats']['upcoming'],
                'past' => $teamFixtures['stats']['past']
            ];
        }
        
        $data = [
            'title' => 'Statistik Pertemuan Zoom',
            'monthlyStats' => $monthlyFixtures['stats'],
            'yearlyStats' => $yearlyFixtures['stats'],
            'teamStats' => $teamStats,
            'currentMonth' => date('F Y'),
            'currentYear' => date('Y')
        ];
        
        return view('modul_zoom/stats', $data);
    }
    
    /**
     * API untuk mendapatkan daftar fixture berdasarkan range tanggal
     */
    public function apiGetFixturesByDateRange()
    {
        $request = $this->request;
        
        // Validasi input
        $rules = [
            'start_date' => 'required|valid_date[Y-m-d]',
            'end_date' => 'required|valid_date[Y-m-d]'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }
        
        $startDate = $request->getGet('start_date');
        $endDate = $request->getGet('end_date');
        $team = $request->getGet('team') ?? null;
        
        $params = [
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
        
        if ($team) {
            $params['tim'] = $team;
        }
        
        $fixtures = $this->zoomModel->getZoomFixtures($params);
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $fixtures
        ]);
    }
}
