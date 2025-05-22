<?php $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>

<!-- Pertanyaan -->
<h4>Ringkasan Seputar Pertanyaan dan </h4>
<br>
<div class="row d-flex justify-content-center">
    <!-- Card 1 -->
    <div class="col-12 col-lg-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-3 col-lg-12 col-xxl-3 d-flex justify-content-start">
                        <div class="stats-icon purple mb-2">
                            <span><b><i class="bi bi-newspaper"></i></b></span>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-9">
                        <h6 class="text-muted font-semibold">Jumlah Pertanyaan Bulan ini</h6>
                        <h1 class="font-extrabold mb-0"><?= $jumlah_pertanyaan_bulan_ini ?></h1>
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
                            <span><b><i class="bi bi-chat-left-quote-fill"></i></b></span>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-9">
                        <h6 class="text-muted font-semibold">Pertanyaan belum Dijawab</h6>
                        <h1 class="font-extrabold mb-0"><?= $jumlah_pertanyaan_belum_dijawab ?></h1>
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
                            <span><b><i class="bi bi-question-circle-fill"></i></b></span>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-9">
                        <h6 class="text-muted font-semibold">Jumlah Pertanyaan Tahun ini</h6>
                        <h1 class="font-extrabold mb-0"><?= $jumlah_pertanyaan_tahun_ini ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h4>Pertanyaan Terbaru</h4>
<br>
<div class="row d-flex justify-content-center">
    <?php foreach ($pertanyaan_terbaru as $pt) : ?>
    <div class="col-12 col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-12">
                        <h5 class="font-semibold"><?= $pt['nama_lengkap']; ?></h5>
                        <h6 class="font-extrabold mb-0"><?= date("d M Y", strtotime($pt['created_at'])) ?></h6>
                        <p class="font-semibold"><?= substr($pt['judul'], 0, 100);
                                            if (strlen($pt['judul']) >= 100) {
                                                echo "...";
                                            } ?></p>
                        <p class="mt-3"><?= substr($pt['deskripsi'], 0, 100);
                                            if (strlen($pt['deskripsi']) >= 100) {
                                                echo "...";
                                            } ?></p>
                        <a href="/pertanyaan/<?= $pt['id_pertanyaan']; ?>" class="btn btn-primary">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<h4>Statistik Pertanyaan dan Jawaban</h4>
<br>
<!-- View Tren Pertanyaan per bulan pada tahun X -->
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tren Pertanyaan setiap Bulan pada Tahun</h4>
                <!-- Dropdown untuk memilih tahun -->
                <select id="tahunDropdown" class="form-select">
                    <?php foreach ($daftarTahunpertanyaan as $tahun) : ?>
                        <option value="<?= $tahun['tahun'] ?>" <?= ($tahun['tahun'] == $tahunDefaultP) ? 'selected' : '' ?>>
                            <?= $tahun['tahun'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="card-body">
                <canvas id="chart-tren-pertanyaan"></canvas>
                <div class="my-4">
                    Bar chart di atas merupakan tren pertanyaan setiap bulan pada tahun <span id="selected-year"><?= $tahunDefaultP ?></span>
                </div>
                <!-- Debug info area -->
                <div id="debug-info" class="mt-3 p-3 bg-light" style="display: none;">
                    <h5>Debug Information</h5>
                    <div id="debug-request">Request data: </div>
                    <div id="debug-response">Response data: </div>
                </div>
                <!-- <button id="toggle-debug" class="btn btn-sm btn-secondary mt-2">Show Debug Info</button> -->
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tren Jawaban setiap Bulan pada Tahun</h4>
                <!-- Dropdown untuk memilih tahun -->
                <select id="tahunDropdown" class="form-select">
                    <?php foreach ($daftarTahunjawaban as $tahun) : ?>
                        <option value="<?= $tahun['tahun'] ?>" <?= ($tahun['tahun'] == $tahunDefaultJ) ? 'selected' : '' ?>>
                            <?= $tahun['tahun'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="card-body">
                <canvas id="chart-tren-jawaban"></canvas>
                <div class="my-4">
                    Bar chart di atas merupakan tren jawaban setiap bulan pada tahun <span id="selected-year"><?= $tahunDefaultJ ?></span>
                </div>
                <!-- Debug info area -->
                <div id="debug-info" class="mt-3 p-3 bg-light" style="display: none;">
                    <h5>Debug Information</h5>
                    <div id="debug-request">Request data: </div>
                    <div id="debug-response">Response data: </div>
                </div>
                <!-- <button id="toggle-debug" class="btn btn-sm btn-secondary mt-2">Show Debug Info</button> -->
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
                            <span><b><i class="bi bi-question-lg"></i></b></span>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-9">
                        <h6 class="text-muted font-semibold">Jumlah Pertanyaan</h6>
                        <h1 class="font-extrabold mb-0"><?= $jumlahpertanyaanAOT ?></h1>
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
                            <span><b><i class="bi bi-chat-dots-fill"></i></b></span>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-9">
                        <h6 class="text-muted font-semibold">Jumlah Jawaban </h6>
                        <h1 class="font-extrabold mb-0"><?= $jumlahJawabanAOT ?></h1>
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
                            <span><b><i class="bi bi-star-fill"></i></b></span>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-9">
                        <h6 class="text-muted font-semibold">Jumlah Likes </h6>
                        <h1 class="font-extrabold mb-0"><?= $total_likes ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- wordcloud -->
<h4>Wordcloud</h4>
<br>
<div class="row">
    <div class="card col-12 col-lg-6">
        <div class="card-header text-center">
            <h4 class="card-title">Visualisasi Kata Kunci dari Judul Pertanyaan</h4>
        </div>
        <div class="card-body">
            <div id="word-cloud-jp" style="border: 1px solid #ddd;"></div>
            <div class="my-4 text-center">
                Visualisasi di atas menampilkan kata-kata yang paling sering muncul dalam judul pertanyaan. Ukuran kata menunjukkan tingkat frekuensi kemunculannya.
            </div>
        </div>
    </div>

    <div class="card col-12 col-lg-6">
        <div class="card-header text-center">
            <h4 class="card-title">Visualisasi Kata Kunci dari Deskripsi Pertanyaan</h4>
        </div>
        <div class="card-body">
            <div id="word-cloud" style="width: 100%; height: 500px; border: 1px solid #ddd;"></div>
            <div class="my-4 text-center">
                Visualisasi di atas menampilkan kata-kata yang paling sering muncul dalam deskripsi pertanyaan. Ukuran kata menunjukkan tingkat frekuensi kemunculannya.
            </div>
        </div>
    </div>
</div>

<!-- Alamat -->
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 d-flex align-items-stretch">
                            <div class="info">
                                <h4>Alamat</h4>
                                <span>BPS Provinsi Lampung</span>
                                <p>JL. Basuki Rahmat No. 54, Bandar Lampung, Lampung</p>
                                <p>Indonesia, xxxxxx</p>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-4">
                            <div class="googlemaps">
                                <iframe src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=The Central Statistics Agency of Lampung Province&amp;t=&amp;z=16&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" width="100%" height="410px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script paling sederhana dengan jQuery -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.16.0/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3-cloud/1.2.5/d3.layout.cloud.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Debug toggle
    

    var ctx = document.getElementById('chart-tren-pertanyaan').getContext('2d');
    var chartTrenPertanyaan;

    // Data awal untuk grafik
    var dataTrenPertanyaan = <?= json_encode($trenPertanyaan) ?>;
    
    // Debug initial data
    document.getElementById('debug-response').innerHTML = 'Initial data: ' + JSON.stringify(dataTrenPertanyaan);

    // Fungsi untuk membuat grafik
    function createChart(labels, data) {
        if (chartTrenPertanyaan) {
            chartTrenPertanyaan.destroy(); // Hancurkan grafik sebelumnya jika ada
        }

        chartTrenPertanyaan = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels, // Label bulan (Januari-Desember)
                datasets: [{
                    label: 'Jumlah Pertanyaan',
                    data: data, // Data jumlah pertanyaan
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                animation: {
                    duration: 1000 // Animate changes more visibly
                }
            }
        });
    }

    // Buat grafik pertama kali
    if (dataTrenPertanyaan && dataTrenPertanyaan.labels && dataTrenPertanyaan.data) {
        createChart(dataTrenPertanyaan.labels, dataTrenPertanyaan.data);
    } else {
        console.error('Format data awal tidak valid:', dataTrenPertanyaan);
        document.getElementById('debug-response').innerHTML += '<br>ERROR: Format data awal tidak valid!';
    }

    // Event saat dropdown tahun berubah
    document.getElementById('tahunDropdown').addEventListener('change', function() {
        var tahun = this.value;
        console.log('Tahun yang dipilih:', tahun);
        
        // Update UI untuk tahun yang dipilih
        document.getElementById('selected-year').textContent = tahun;
        
        // URL lengkap dengan base_url
        var requestUrl = '<?= site_url('admin/dasbor/getDataTrenPertanyaan') ?>';
        document.getElementById('debug-request').innerHTML = 'Request URL: ' + requestUrl + '<br>Tahun: ' + tahun;
        
        // Gunakan jQuery AJAX jika tersedia (lebih kompatibel dengan CI)
        if (typeof $ !== 'undefined') {
            $.ajax({
                url: requestUrl,
                method: 'POST',
                data: {
                    tahun: tahun
                },
                dataType: 'json',
                beforeSend: function() {
                    console.log('Mengirim request AJAX ke: ' + requestUrl);
                },
                success: function(data) {
                    console.log('Data yang diterima:', data);
                    document.getElementById('debug-response').innerHTML = 'Response: ' + JSON.stringify(data);
                    
                    if (data && data.labels && data.data) {
                        // Update chart dengan data baru
                        createChart(data.labels, data.data);
                    } else {
                        console.error('Format data tidak valid:', data);
                        document.getElementById('debug-response').innerHTML += '<br>ERROR: Format data tidak valid!';
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    document.getElementById('debug-response').innerHTML = 'AJAX Error: ' + status + ' - ' + error + 
                                                                        '<br>Response Text: ' + xhr.responseText;
                }
            });
        } else {
            // Fallback ke Fetch API jika jQuery tidak tersedia
            var formData = new FormData();
            formData.append('tahun', tahun);
            
            // CSRF for CodeIgniter 4 if needed
            <?php if (function_exists('csrf_token') && function_exists('csrf_hash')): ?>
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            <?php endif; ?>
            
            fetch(requestUrl, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log('Data yang diterima:', data);
                document.getElementById('debug-response').innerHTML = 'Response: ' + JSON.stringify(data);
                
                if (data && data.labels && data.data) {
                    createChart(data.labels, data.data);
                } else {
                    console.error('Format data tidak valid:', data);
                    document.getElementById('debug-response').innerHTML += '<br>ERROR: Format data tidak valid!';
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                document.getElementById('debug-response').innerHTML = 'Fetch Error: ' + error.message;
            });
        }
    });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Debug toggle
        
    
        var ctx = document.getElementById('chart-tren-jawaban').getContext('2d');
        var chartTrenjawaban;
    
        // Data awal untuk grafik
        var dataTrenjawaban = <?= json_encode($trenjawaban) ?>;
        
        // Debug initial data
        document.getElementById('debug-response').innerHTML = 'Initial data: ' + JSON.stringify(dataTrenjawaban);
    
        // Fungsi untuk membuat grafik
        function createChart(labels, data) {
            if (chartTrenjawaban) {
                chartTrenjawaban.destroy(); // Hancurkan grafik sebelumnya jika ada
            }
    
            chartTrenjawaban = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels, // Label bulan (Januari-Desember)
                    datasets: [{
                        label: 'Jumlah jawaban',
                        data: data, // Data jumlah jawaban
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    animation: {
                        duration: 1000 // Animate changes more visibly
                    }
                }
            });
        }
    
        // Buat grafik pertama kali
        if (dataTrenjawaban && dataTrenjawaban.labels && dataTrenjawaban.data) {
            createChart(dataTrenjawaban.labels, dataTrenjawaban.data);
        } else {
            console.error('Format data awal tidak valid:', dataTrenjawaban);
            document.getElementById('debug-response').innerHTML += '<br>ERROR: Format data awal tidak valid!';
        }
    
        // Event saat dropdown tahun berubah
        document.getElementById('tahunDropdown').addEventListener('change', function() {
            var tahun = this.value;
            console.log('Tahun yang dipilih:', tahun);
            
            // Update UI untuk tahun yang dipilih
            document.getElementById('selected-year').textContent = tahun;
            
            // URL lengkap dengan base_url
            var requestUrl = '<?= site_url('admin/dasbor/getDataTrenjawaban') ?>';
            document.getElementById('debug-request').innerHTML = 'Request URL: ' + requestUrl + '<br>Tahun: ' + tahun;
            
            // Gunakan jQuery AJAX jika tersedia (lebih kompatibel dengan CI)
            if (typeof $ !== 'undefined') {
                $.ajax({
                    url: requestUrl,
                    method: 'POST',
                    data: {
                        tahun: tahun
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        console.log('Mengirim request AJAX ke: ' + requestUrl);
                    },
                    success: function(data) {
                        console.log('Data yang diterima:', data);
                        document.getElementById('debug-response').innerHTML = 'Response: ' + JSON.stringify(data);
                        
                        if (data && data.labels && data.data) {
                            // Update chart dengan data baru
                            createChart(data.labels, data.data);
                        } else {
                            console.error('Format data tidak valid:', data);
                            document.getElementById('debug-response').innerHTML += '<br>ERROR: Format data tidak valid!';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        document.getElementById('debug-response').innerHTML = 'AJAX Error: ' + status + ' - ' + error + 
                                                                            '<br>Response Text: ' + xhr.responseText;
                    }
                });
            } else {
                // Fallback ke Fetch API jika jQuery tidak tersedia
                var formData = new FormData();
                formData.append('tahun', tahun);
                
                // CSRF for CodeIgniter 4 if needed
                <?php if (function_exists('csrf_token') && function_exists('csrf_hash')): ?>
                formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
                <?php endif; ?>
                
                fetch(requestUrl, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data yang diterima:', data);
                    document.getElementById('debug-response').innerHTML = 'Response: ' + JSON.stringify(data);
                    
                    if (data && data.labels && data.data) {
                        createChart(data.labels, data.data);
                    } else {
                        console.error('Format data tidak valid:', data);
                        document.getElementById('debug-response').innerHTML += '<br>ERROR: Format data tidak valid!';
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    document.getElementById('debug-response').innerHTML = 'Fetch Error: ' + error.message;
                });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Data judul dari controller
        const text = '<?= $all_textJP ?>';
        
        // Fungsi untuk menghitung frekuensi kata
        function getWordFrequency(text) {
            // Pastikan text tidak kosong
            if (!text || text.trim() === '') {
                console.error('Tidak ada teks untuk diproses');
                return [];
            }
            
            // Menghapus karakter khusus dan mengubah ke huruf kecil
            const cleanText = text.toLowerCase().replace(/[^\w\s]/g, '');
            
            // Memisahkan teks menjadi kata-kata
            const words = cleanText.split(/\s+/);
            
            // Daftar stopwords dalam Bahasa Indonesia yang lebih lengkap
            const stopwords = [
                'yang', 'dari', 'dan', 'di', 'ke', 'untuk', 'pada', 'dengan', 
                'ini', 'itu', 'atau', 'juga', 'saya', 'kamu', 'dia', 'mereka',
                'kami', 'kita', 'akan', 'sudah', 'telah', 'sedang', 'adalah', 
                'dalam', 'bisa', 'ada', 'tidak', 'oleh', 'jika', 'maka', 'nya',
                'karena', 'tentang', 'secara', 'dapat', 'apakah', 'sebagai',
                'bagaimana', 'dimana', 'kapan', 'siapa', 'ketika', 'tersebut',
                'terdapat', 'per', 'menjadi', 'seperti', 'agar', 'bahwa', 'kepada'
            ];
            
            // Menghitung frekuensi kata
            const wordFreq = {};
            words.forEach(word => {
                // Hanya memproses kata yang panjangnya > 2 karakter dan bukan stopword
                if (word.length > 2 && !stopwords.includes(word)) {
                    wordFreq[word] = (wordFreq[word] || 0) + 1;
                }
            });
            
            // Mengkonversi objek menjadi array untuk d3-cloud
            // Hanya ambil maksimal 100 kata teratas untuk performa yang lebih baik
            return Object.keys(wordFreq)
                .map(word => ({
                    text: word,
                    size: Math.min(wordFreq[word] * 5 + 10, 60) // Batasi ukuran maksimum font
                }))
                .sort((a, b) => b.size - a.size) // Urutkan berdasarkan frekuensi
                .slice(0, 100); // Batasi jumlah kata untuk tampilan yang lebih baik
        }
        
        // Membuat word cloud dengan D3.js
        function createWordCloud(words) {
            // Jika tidak ada kata yang diproses, tampilkan pesan
            if (words.length === 0) {
                document.getElementById('word-cloud-jp').innerHTML = '<div class="alert alert-warning">Tidak ada data yang cukup untuk membuat word cloud</div>';
                return;
            }
            
            // Ukuran wadah
            const width = document.getElementById('word-cloud-jp').offsetWidth;
            const height = 500;
            
            // Bersihkan elemen sebelum menambahkan grafik baru
            d3.select('#word-cloud-jp').html('');
            
            // Buat layout untuk word cloud
            const layout = d3.layout.cloud()
                .size([width, height])
                .words(words)
                .padding(5)
                .rotate(() => (Math.random() < 0.5 ? 0 : 90)) // Hanya 0° atau 90° untuk keterbacaan
                .fontSize(d => d.size)
                .on('end', draw);
            
            // Mulai menghitung layout
            layout.start();
            
            // Fungsi untuk menggambar word cloud
            function draw(words) {
                // Skema warna yang menarik
                const colors = d3.schemeCategory10;
                
                // Buat SVG untuk word cloud
                const svg = d3.select('#word-cloud-jp').append('svg')
                    .attr('width', width)
                    .attr('height', height)
                    .append('g')
                    .attr('transform', `translate(${width / 2},${height / 2})`);
                    
                // Tambahkan elemen teks untuk setiap kata
                svg.selectAll('text')
                    .data(words)
                    .enter().append('text')
                    .style('font-size', d => `${d.size}px`)
                    .style('font-family', '"Nunito", sans-serif')
                    .style('font-weight', d => d.size > 30 ? 'bold' : 'normal')
                    .style('fill', (d, i) => colors[i % colors.length])
                    .attr('text-anchor', 'middle')
                    .attr('transform', d => `translate(${d.x},${d.y})rotate(${d.rotate})`)
                    .text(d => d.text)
                    .on('mouseover', function() {
                        // Efek hover
                        d3.select(this)
                            .transition()
                            .duration(200)
                            .style('font-size', d => `${d.size * 1.2}px`)
                            .style('cursor', 'pointer');
                    })
                    .on('mouseout', function() {
                        // Kembalikan ke ukuran semula setelah hover
                        d3.select(this)
                            .transition()
                            .duration(200)
                            .style('font-size', d => `${d.size}px`);
                    });
            }
        }
        
        // Fungsi untuk menangani perubahan ukuran window
        let resizeTimeout;
        function handleResize() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                const wordFrequency = getWordFrequency(text);
                createWordCloud(wordFrequency);
            }, 300);
        }
        
        // Inisialisasi word cloud
        try {
            const wordFrequency = getWordFrequency(text);
            createWordCloud(wordFrequency);
            
            // Perbarui word cloud ketika ukuran window berubah
            window.addEventListener('resize', handleResize);
        } catch (error) {
            console.error('Error membuat word cloud:', error);
            document.getElementById('word-cloud-jp').innerHTML = 
                `<div class="alert alert-danger">Terjadi kesalahan saat membuat word cloud: ${error.message}</div>`;
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Data judul dari controller
        const text = '<?= $all_text ?>';
        
        // Fungsi untuk menghitung frekuensi kata
        function getWordFrequency(text) {
            // Pastikan text tidak kosong
            if (!text || text.trim() === '') {
                console.error('Tidak ada teks untuk diproses');
                return [];
            }
            
            // Menghapus karakter khusus dan mengubah ke huruf kecil
            const cleanText = text.toLowerCase().replace(/[^\w\s]/g, '');
            
            // Memisahkan teks menjadi kata-kata
            const words = cleanText.split(/\s+/);
            
            // Daftar stopwords dalam Bahasa Indonesia yang lebih lengkap
            const stopwords = [
                'yang', 'dari', 'dan', 'di', 'ke', 'untuk', 'pada', 'dengan', 
                'ini', 'itu', 'atau', 'juga', 'saya', 'kamu', 'dia', 'mereka',
                'kami', 'kita', 'akan', 'sudah', 'telah', 'sedang', 'adalah', 
                'dalam', 'bisa', 'ada', 'tidak', 'oleh', 'jika', 'maka', 'nya',
                'karena', 'tentang', 'secara', 'dapat', 'apakah', 'sebagai',
                'bagaimana', 'dimana', 'kapan', 'siapa', 'ketika', 'tersebut',
                'terdapat', 'per', 'menjadi', 'seperti', 'agar', 'bahwa', 'kepada'
            ];
            
            // Menghitung frekuensi kata
            const wordFreq = {};
            words.forEach(word => {
                // Hanya memproses kata yang panjangnya > 2 karakter dan bukan stopword
                if (word.length > 2 && !stopwords.includes(word)) {
                    wordFreq[word] = (wordFreq[word] || 0) + 1;
                }
            });
            
            // Mengkonversi objek menjadi array untuk d3-cloud
            // Hanya ambil maksimal 100 kata teratas untuk performa yang lebih baik
            return Object.keys(wordFreq)
                .map(word => ({
                    text: word,
                    size: Math.min(wordFreq[word] * 5 + 10, 60) // Batasi ukuran maksimum font
                }))
                .sort((a, b) => b.size - a.size) // Urutkan berdasarkan frekuensi
                .slice(0, 100); // Batasi jumlah kata untuk tampilan yang lebih baik
        }
        
        // Membuat word cloud dengan D3.js
        function createWordCloud(words) {
            // Jika tidak ada kata yang diproses, tampilkan pesan
            if (words.length === 0) {
                document.getElementById('word-cloud').innerHTML = '<div class="alert alert-warning">Tidak ada data yang cukup untuk membuat word cloud</div>';
                return;
            }
            
            // Ukuran wadah
            const width = document.getElementById('word-cloud').offsetWidth;
            const height = 500;
            
            // Bersihkan elemen sebelum menambahkan grafik baru
            d3.select('#word-cloud').html('');
            
            // Buat layout untuk word cloud
            const layout = d3.layout.cloud()
                .size([width, height])
                .words(words)
                .padding(5)
                .rotate(() => (Math.random() < 0.5 ? 0 : 90)) // Hanya 0° atau 90° untuk keterbacaan
                .fontSize(d => d.size)
                .on('end', draw);
            
            // Mulai menghitung layout
            layout.start();
            
            // Fungsi untuk menggambar word cloud
            function draw(words) {
                // Skema warna yang menarik
                const colors = d3.schemeCategory10;
                
                // Buat SVG untuk word cloud
                const svg = d3.select('#word-cloud').append('svg')
                    .attr('width', width)
                    .attr('height', height)
                    .append('g')
                    .attr('transform', `translate(${width / 2},${height / 2})`);
                    
                // Tambahkan elemen teks untuk setiap kata
                svg.selectAll('text')
                    .data(words)
                    .enter().append('text')
                    .style('font-size', d => `${d.size}px`)
                    .style('font-family', '"Nunito", sans-serif')
                    .style('font-weight', d => d.size > 30 ? 'bold' : 'normal')
                    .style('fill', (d, i) => colors[i % colors.length])
                    .attr('text-anchor', 'middle')
                    .attr('transform', d => `translate(${d.x},${d.y})rotate(${d.rotate})`)
                    .text(d => d.text)
                    .on('mouseover', function() {
                        // Efek hover
                        d3.select(this)
                            .transition()
                            .duration(200)
                            .style('font-size', d => `${d.size * 1.2}px`)
                            .style('cursor', 'pointer');
                    })
                    .on('mouseout', function() {
                        // Kembalikan ke ukuran semula setelah hover
                        d3.select(this)
                            .transition()
                            .duration(200)
                            .style('font-size', d => `${d.size}px`);
                    });
            }
        }
        
        // Fungsi untuk menangani perubahan ukuran window
        let resizeTimeout;
        function handleResize() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                const wordFrequency = getWordFrequency(text);
                createWordCloud(wordFrequency);
            }, 300);
        }
        
        // Inisialisasi word cloud
        try {
            const wordFrequency = getWordFrequency(text);
            createWordCloud(wordFrequency);
            
            // Perbarui word cloud ketika ukuran window berubah
            window.addEventListener('resize', handleResize);
        } catch (error) {
            console.error('Error membuat word cloud:', error);
            document.getElementById('word-cloud').innerHTML = 
                `<div class="alert alert-danger">Terjadi kesalahan saat membuat word cloud: ${error.message}</div>`;
        }
    });
    
</script>
<?php $this->endSection(); ?>