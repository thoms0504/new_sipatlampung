<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModulZoom\ZoomScheduleModel;
use Config\Services;

class Zoom extends BaseController
{
    protected $zoomScheduleModel;

    public function __construct()
    {
        $this->zoomScheduleModel = new ZoomScheduleModel();
    }

    public function index()
    {
        $data['title'] = 'Jadwal Pemakaian Zoom';
        $data['active'] = 'zoom-monitoring';
        return view('Admin/ModulZoom/index', $data);
    }


    public function getMonthData()
    {
        $startDate = $this->request->getVar('start');
        $endDate = $this->request->getVar('end');
        log_message('debug', "getMonthData called with start: $startDate, end: $endDate");

        $result = $this->zoomScheduleModel->getSchedulesByDateRange($startDate, $endDate);
        $schedules = $result['schedules'];
        log_message('debug', 'Schedules retrieved: ' . json_encode($schedules));
        $groupedByDate = $result['groupedByDate'];

        // Process data for consistency
        $processedSchedules = [];
        foreach ($schedules as $schedule) {
            // Calculate end time
            $startTime = $schedule['jam_mulai'] ?? null;
            if ($startTime) {
                $durasi_jam = $schedule['durasi_jam'] ?? 0;
                $durasi_menit = $schedule['durasi_menit'] ?? 0;

                // Create datetime objects for start and end
                $start = new \DateTime($schedule['tanggal'] . ' ' . $startTime);
                $end = clone $start;
                $end->modify("+{$durasi_jam} hours +{$durasi_menit} minutes");

                $schedule['start'] = $start->format('Y-m-d H:i:s');
                $schedule['end'] = $end->format('Y-m-d H:i:s');
            } else {
                // If no start time, use the date for an all-day event
                $schedule['start'] = $schedule['tanggal'];
                $schedule['allDay'] = true;
            }

            // Add color based on team
            $schedule['color'] = $this->getColorForTeam($schedule['tim']);

            $processedSchedules[] = $schedule;
        }

        // Return JSON response with both regular schedules and date-team information
        return $this->response->setJSON([
            'schedules' => $processedSchedules,
            'dateTeams' => $groupedByDate
        ]);
    }

    public function getTeamsByDate()
    {
        $date = $this->request->getVar('date');

        if (!$date) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Date parameter is required'
            ]);
        }

        // Get events for this specific date
        $events = $this->zoomScheduleModel->select('id, tim, nama_kegiatan, tanggal, jam_mulai, durasi_jam, durasi_menit')
            ->where('DATE(tanggal)', $date)
            ->orderBy('jam_mulai', 'ASC')
            ->findAll();

        // Extract unique teams for this date
        $teams = [];
        foreach ($events as $event) {
            if (!empty($event['tim']) && !in_array($event['tim'], $teams)) {
                $teams[] = $event['tim'];
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'date' => $date,
            'teams' => $teams,
            'events' => $events
        ]);
    }

    private function getColorForTeam($tim)
    {
        $colors = [
            'IPDS' => '#FF5733',
            'Produksi' => '#33FF57',
            'Distribusi' => '#3357FF',
            'Sosial' => '#F033FF',
            'Neraca' => '#FF9033',
            'PPSSDS' => '#33FFF9'
        ];

        return isset($colors[$tim]) ? $colors[$tim] : '#CCCCCC';
    }

    public function create_zoom()
    {
        if ($this->request->getMethod() == 'POST') {
            // Validate form data
            $rules = [
                'nama_kegiatan' => 'required|min_length[3]',
                'tanggal'       => 'required|valid_date',
                'jam_mulai'     => 'required',
                'durasi_jam'    => 'required|numeric',
                'durasi_menit'  => 'permit_empty|numeric|less_than[60]',
                'tim'           => 'required'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'nama_kegiatan' => $this->request->getPost('nama_kegiatan'),
                'tanggal'       => $this->request->getPost('tanggal'),
                'jam_mulai'     => $this->request->getPost('jam_mulai'),
                'durasi_jam'    => $this->request->getPost('durasi_jam'),
                'durasi_menit'  => $this->request->getPost('durasi_menit') ?: 0,
                'tim'           => $this->request->getPost('tim')
            ];

            if ($this->zoomScheduleModel->insert($data)) {
                session()->setFlashdata('sukses', 'Jadwal Zoom berhasil ditambahkan');
                return redirect()->to('admin/zoom-monitoring');
            } else {
                session()->setFlashdata('gagal', 'Gagal Menambahkan Jadwal Zoom');
                return redirect()->back()->withInput()->with('errors', $this->zoomScheduleModel->errors());
            }
        }

        $data = [
            'title' => 'Tambah Pemakaian Zoom',
            'active' => 'buat_zoom',
            'validation' => Services::validation(),
        ];

        return view('Admin/ModulZoom/create', $data);
    }

    // Add a method to delete schedule if needed
    public function delete($id = null)
    {
        if ($id) {
            if ($this->zoomScheduleModel->delete($id)) {
                return redirect()->to('/zoom-monitoring')->with('message', 'Jadwal berhasil dihapus');
            }
        }
        return redirect()->to('/zoom-monitoring')->with('error', 'Gagal menghapus jadwal');
    }

    public function edit($id)
    {
        // Log untuk debugging
        log_message('debug', 'Edit method called for ID: ' . $id);

        // Cek keberadaan data terlebih dahulu
        $schedule = $this->zoomScheduleModel->find($id);
        if (!$schedule) {
            log_message('debug', 'Schedule with ID ' . $id . ' not found');
            return redirect()->to('/admin/zoom-monitoring')->with('error', 'Jadwal tidak ditemukan');
        }

        log_message('debug', 'Schedule data found: ' . json_encode($schedule));

        $data = [
            'title' => 'Edit Pemakaian Zoom',
            'active' => 'edit_zoom',
            'validation' => \Config\Services::validation(),
            'schedule' => $schedule
        ];

        return view('Admin/ModulZoom/edit', $data);
    }

    // Method untuk mengupdate jadwal zoom
    public function update($id = null)
    {
        // Debugging
        log_message('debug', '==== MULAI PROSES UPDATE JADWAL ZOOM ID: ' . $id . ' ====');

        // Redirect jika ID tidak ada
        if (!$id) {
            return redirect()->to('/admin/zoom-monitoring')->with('error', 'ID Jadwal tidak ditemukan');
        }

        // Cari data jadwal berdasarkan ID
        $schedule = $this->zoomScheduleModel->find($id);
        if (!$schedule) {
            return redirect()->to('/admin/zoom-monitoring')->with('error', 'Jadwal tidak ditemukan');
        }

        // Proses update jika ada request POST
        if ($this->request->getMethod() === 'POST') {
            log_message('debug', 'Processing POST request with data: ' . json_encode($this->request->getPost()));

            // Aturan validasi
            $rules = [
                'nama_kegiatan' => 'required|min_length[3]',
                'tanggal'       => 'required|valid_date',
                'jam_mulai'     => 'required',
                'durasi_jam'    => 'required|numeric',
                'durasi_menit'  => 'permit_empty|numeric|less_than[60]',
                'tim'           => 'required'
            ];

            // Jalankan validasi
            if (!$this->validate($rules)) {
                log_message('debug', 'Validation failed: ' . json_encode($this->validator->getErrors()));
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // Data yang akan diupdate
            $data = [
                'nama_kegiatan' => $this->request->getPost('nama_kegiatan'),
                'tanggal'       => $this->request->getPost('tanggal'),
                'jam_mulai'     => $this->request->getPost('jam_mulai'),
                'durasi_jam'    => (int)$this->request->getPost('durasi_jam'),
                'durasi_menit'  => (int)($this->request->getPost('durasi_menit') ?: 0),
                'tim'           => $this->request->getPost('tim'),
                'updated_at'    => date('Y-m-d H:i:s')
            ];

            log_message('debug', 'Attempting to update with data: ' . json_encode($data));

            try {
                // Update data langsung dengan save()
                $data['id'] = $id; // Pastikan ID dimasukkan ke data
                $result = $this->zoomScheduleModel->save($data);

                if ($result) {
                    // Redirect dengan metode standar CI4
                    session()->setFlashdata('sukses', 'Jadwal Zoom berhasil diperbarui');
                    return redirect()->to('/admin/zoom-monitoring');
                } else {
                    log_message('error', 'Update failed. Model errors: ' . json_encode($this->zoomScheduleModel->errors()));
                    return redirect()->back()->withInput()->with('error', 'Gagal mengupdate jadwal: ' . implode(', ', $this->zoomScheduleModel->errors()));
                }
            } catch (\Exception $e) {
                log_message('error', 'Exception during update: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
            }
        }

        // Jika bukan POST request, tampilkan form edit
        return view('Admin/ModulZoom/edit', [
            'schedule' => $schedule,
            'title' => 'Edit Pemakaian Zoom',
            'active' => 'edit_zoom',
            'validation' => \Config\Services::validation()
        ]);
    }

    public function hapusJadwalZoom($id = null)
    {
        // If no ID provided or invalid format, show error
        if ($id === null || !is_numeric($id)) {
            return redirect()->to(site_url('admin/zoom-monitoring'))
                ->with('error', 'ID Jadwal tidak valid.');
        }

        // Load the model (assuming it's called ZoomMonitoringModel)
        $model = new ZoomScheduleModel();

        // Check if record exists
        $schedule = $model->find($id);
        if (!$schedule) {
            return redirect()->to(site_url('admin/zoom-monitoring'))
                ->with('error', 'Jadwal tidak ditemukan.');
        }

        // Try to delete the record
        try {
            $model->delete($id);
            session()->setFlashdata('sukses', 'Jadwal Zoom berhasil dihapus.');
            return redirect()->to(site_url('admin/zoom-monitoring'));
        } catch (\Exception $e) {
            // Log the error for admin review
            log_message('error', 'Failed to delete zoom schedule: ' . $e->getMessage());
            session()->setFlashdata('gagal', 'Gagal menghapus jadwal. Silakan coba lagi.');
            return redirect()->to(site_url('admin/zoom-monitoring'));
        }
    }
}
