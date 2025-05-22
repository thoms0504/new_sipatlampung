<?php $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>

<!-- Dashboard Zoom Meetings -->
<h4>Ringkasan Pertemuan Zoom</h4>
<br>
<div class="row d-flex justify-content-center">
    <!-- Card 1 -->
    <div class="col-12 col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-3 col-lg-12 col-xxl-3 d-flex justify-content-start">
                        <div class="stats-icon purple mb-2">
                            <span><b><i class="bi bi-camera-video-fill"></i></b></span>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-9">
                        <h6 class="text-muted font-semibold">Jumlah Pertemuan Hari Ini</h6>
                        <h1 class="font-extrabold mb-0"><?= count($todayFixtures['all_fixtures']) ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Card 2 -->
    <div class="col-12 col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-3 col-lg-12 col-xxl-3 d-flex justify-content-start">
                        <div class="stats-icon green mb-2">
                            <span><b><i class="bi bi-calendar-check-fill"></i></b></span>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-9">
                        <h6 class="text-muted font-semibold">Pertemuan Mendatang Hari Ini</h6>
                        <h1 class="font-extrabold mb-0"><?= count($todayFixtures['upcoming']) ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Card 3 -->
    <div class="col-12 col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-3 col-lg-12 col-xxl-3 d-flex justify-content-start">
                        <div class="stats-icon red mb-2">
                            <span><b><i class="bi bi-calendar-range-fill"></i></b></span>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-9">
                        <h6 class="text-muted font-semibold">Pertemuan Dalam 7 Hari</h6>
                        <h1 class="font-extrabold mb-0"><?= $upcomingFixtures['total'] ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h4>Pertemuan Zoom Hari Ini</h4>
<br>
<?php if(count($todayFixtures['upcoming']) > 0): ?>
<div class="row d-flex justify-content-center">
    <?php foreach ($todayFixtures['upcoming'] as $fixture) : ?>
    <div class="col-12 col-lg-4 col-md-6 mb-4">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-12">
                        <h5 class="font-semibold"><?= $fixture['nama_kegiatan']; ?></h5>
                        <h6 class="font-extrabold mb-0">
                            <i class="bi bi-clock"></i> <?= $fixture['jam_mulai_formatted'] ?> - <?= $fixture['jam_akhir_formatted'] ?>
                        </h6>
                        <p class="font-semibold mt-2">
                            <span class="badge bg-primary"><?= $fixture['tim']; ?></span>
                        </p>
                        <p class="mt-2">
                            <i class="bi bi-hourglass-split"></i> Durasi: <?= $fixture['durasi_jam'] ?> jam <?= $fixture['durasi_menit'] ?> menit
                        </p>
                        <a href="/zoom/detail/<?= $fixture['id']; ?>" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="alert alert-info">
    <i class="bi bi-info-circle"></i> Tidak ada pertemuan Zoom yang dijadwalkan untuk hari ini.
</div>
<?php endif; ?>

<h4>Statistik Pertemuan Zoom</h4>
<br>
<!-- Statistik Pertemuan Zoom -->
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tren Pertemuan Zoom per Bulan</h4>
                <!-- Dropdown untuk memilih tahun -->
                <select id="tahunDropdownZoom" class="form-select">
                    <?php 
                    $currentYear = date('Y');
                    for($year = $currentYear; $year >= $currentYear - 2; $year--): ?>
                        <option value="<?= $year ?>" <?= ($year == $currentYear) ? 'selected' : '' ?>>
                            <?= $year ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="card-body">
                <canvas id="chart-tren-zoom"></canvas>
                <div class="my-4">
                    Bar chart di atas menunjukkan tren pertemuan Zoom setiap bulan pada tahun <span id="selected-year-zoom"><?= date('Y') ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Distribusi Pertemuan per Tim</h4>
            </div>
            <div class="card-body">
                <canvas id="chart-tim-zoom"></canvas>
                <div class="my-4">
                    Pie chart di atas menunjukkan distribusi pertemuan Zoom berdasarkan tim.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row d-flex justify-content-center">
    <!-- Card 1 -->
    <div class="col-12 col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-3 col-lg-12 col-xxl-3 d-flex justify-content-start">
                        <div class="stats-icon purple mb-2">
                            <span><b><i class="bi bi-calendar2-week"></i></b></span>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-9">
                        <h6 class="text-muted font-semibold">Total Pertemuan Bulan Ini</h6>
                        <h1 class="font-extrabold mb-0" id="total-bulan-ini">0</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-3 col-lg-12 col-xxl-3 d-flex justify-content-start">
                        <div class="stats-icon green mb-2">
                            <span><b><i class="bi bi-people-fill"></i></b></span>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-9">
                        <h6 class="text-muted font-semibold">Jumlah Tim Aktif</h6>
                        <h1 class="font-extrabold mb-0" id="tim-aktif">0</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-3 col-lg-12 col-xxl-3 d-flex justify-content-start">
                        <div class="stats-icon red mb-2">
                            <span><b><i class="bi bi-clock-history"></i></b></span>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-9">
                        <h6 class="text-muted font-semibold">Total Jam Pertemuan</h6>
                        <h1 class="font-extrabold mb-0" id="total-jam">0</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Kalender Mini -->
<h4>Kalender Pertemuan Zoom</h4>
<br>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Kalender Pertemuan Zoom - <?= date('F Y') ?></h4>
                <a href="/admin/zoom-monitoring" class="btn btn-primary">Lihat Kalender Lengkap</a>
            </div>
            <div class="card-body">
                <div id="calendar-zoom"></div>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Tim dan Statistik -->
<h4>Statistik Tim</h4>
<br>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Tim dan Jumlah Pertemuan</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-lg" id="table-tim">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tim</th>
                                <th>Jumlah Pertemuan</th>
                                <th>Mendatang</th>
                                <th>Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-tim-body">
                            <!-- Data tim akan dimuat melalui JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.css" rel="stylesheet">

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk memuat data statistik
    function loadStatistics() {
        fetch('/zoom/api/fixtures?start_date=<?= date('Y-m-01') ?>&end_date=<?= date('Y-m-t') ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update statistik card
                    document.getElementById('total-bulan-ini').textContent = data.data.stats.total;
                    document.getElementById('tim-aktif').textContent = data.data.stats.tim_count;
                    
                    // Hitung total jam pertemuan
                    let totalMinutes = 0;
                    data.data.fixtures.forEach(fixture => {
                        totalMinutes += (fixture.durasi_jam * 60) + fixture.durasi_menit;
                    });
                    const totalHours = Math.floor(totalMinutes / 60);
                    document.getElementById('total-jam').textContent = totalHours;
                    
                    // Load data tim
                    loadTeamData(data.data.grouped_by_team);
                }
            })
            .catch(error => console.error('Error loading statistics:', error));
    }
    
    // Fungsi untuk memuat data tim
    function loadTeamData(teamData) {
        const tableBody = document.getElementById('tabel-tim-body');
        tableBody.innerHTML = '';
        
        let counter = 1;
        for (const team in teamData) {
            const meetings = teamData[team];
            const now = new Date();
            
            // Hitung pertemuan mendatang dan selesai
            const upcoming = meetings.filter(m => new Date(m.jam_mulai) > now).length;
            const completed = meetings.length - upcoming;
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${counter}</td>
                <td>${team}</td>
                <td>${meetings.length}</td>
                <td>${upcoming}</td>
                <td>${completed}</td>
                <td>
                    <a href="/zoom/team/${encodeURIComponent(team)}" class="btn btn-sm btn-primary">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                </td>
            `;
            tableBody.appendChild(row);
            counter++;
        }
    }
    
    // Chart untuk tren pertemuan zoom
    const chartTrenZoom = new Chart(
        document.getElementById('chart-tren-zoom').getContext('2d'),
        {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Pertemuan',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: 'rgba(60, 60, 220, 0.6)',
                    borderColor: 'rgba(60, 60, 220, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Tren Pertemuan Zoom per Bulan'
                    }
                }
            }
        }
    );
    
    // Fungsi untuk memuat data chart tren zoom berdasarkan tahun
    function loadChartTrenZoom(year) {
        fetch(`/zoom/api/fixtures?start_date=${year}-01-01&end_date=${year}-12-31`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reset data
                    const monthlyCounts = Array(12).fill(0);
                    
                    // Hitung jumlah pertemuan per bulan
                    data.data.fixtures.forEach(fixture => {
                        const fixtureDate = new Date(fixture.tanggal);
                        const month = fixtureDate.getMonth(); // 0-based (0 = Jan)
                        monthlyCounts[month]++;
                    });
                    
                    // Update chart
                    chartTrenZoom.data.datasets[0].data = monthlyCounts;
                    chartTrenZoom.update();
                    
                    // Update teks tahun
                    document.getElementById('selected-year-zoom').textContent = year;
                }
            })
            .catch(error => console.error('Error loading chart data:', error));
    }
    
    // Event listener untuk dropdown tahun
    document.getElementById('tahunDropdownZoom').addEventListener('change', function() {
        loadChartTrenZoom(this.value);
    });
    
    // Chart untuk distribusi tim
    const chartTimZoom = new Chart(
        document.getElementById('chart-tim-zoom').getContext('2d'),
        {
            type: 'pie',
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(255, 99, 255, 0.7)',
                        'rgba(54, 162, 64, 0.7)',
                        'rgba(255, 206, 153, 0.7)',
                        'rgba(75, 192, 255, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 255, 1)',
                        'rgba(54, 162, 64, 1)',
                        'rgba(255, 206, 153, 1)',
                        'rgba(75, 192, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribusi Pertemuan Zoom per Tim'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        }
    );
    
    // Fungsi untuk memuat data chart tim
    function loadChartTimZoom() {
        fetch('/zoom/api/fixtures?start_date=<?= date('Y-01-01') ?>&end_date=<?= date('Y-12-31') ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const teamData = data.data.grouped_by_team;
                    const teams = Object.keys(teamData);
                    const counts = teams.map(team => teamData[team].length);
                    
                    // Update chart
                    chartTimZoom.data.labels = teams;
                    chartTimZoom.data.datasets[0].data = counts;
                    chartTimZoom.update();
                }
            })
            .catch(error => console.error('Error loading team chart data:', error));
    }
    
    // Inisialisasi Kalender
    const calendarEl = document.getElementById('calendar-zoom');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listWeek'
        },
        locale: 'id',
        events: '/zoom/fixtures/json',
        eventClick: function(info) {
            window.location.href = '/zoom/detail/' + info.event.id;
        },
        height: 'auto',
        contentHeight: 500
    });
    
    // Render kalender
    calendar.render();
    
    // Load data statistik
    loadStatistics();
    
    // Load data chart tren zoom untuk tahun ini
    loadChartTrenZoom(<?= date('Y') ?>);
    
    // Load data chart tim
    loadChartTimZoom();
});
</script>
<?= $this->endSection() ?>