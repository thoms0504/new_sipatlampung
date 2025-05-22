<?= $this->extend('PortalUtama/layout/template'); ?>
<?= $this->section('content'); ?>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">

  <div class="container pt-5">
    <div class="row">
      <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
        <h1>Aplikasi Layanan Data dan Internal</h1>
        <h2>Tersedia untuk Umum dan BPS Provinsi Lampung</h2>
        <div class="d-flex justify-content-center justify-content-lg-start">
          <!-- <a href="/masuk" class="btn-get-started scrollto">Masuk</a> -->
          <a href="#clients" class="btn-get-started scrollto">Mulai</a>
        </div>
      </div>
      <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
        <img src="<?= base_url(); ?>/PortalUtama/img/beranda.svg" class="img-fluid animated" alt="">
      </div>
    </div>
  </div>

</section><!-- End Hero -->

<main id="main">

  <!-- ======= Clients Section ======= -->
  <section id="clients" class="clients section-bg">
    <div class="container">
      <div class="row mt-5">
        <div class="section-title">
          <h2>Layanan Data</h2>
        </div>
      </div>
      <div class="row mb-5" data-aos="zoom-in">
        <div class="col-lg-6 col-md-6 col-6 d-flex align-items-center justify-content-center">
          <a href="/chat" class="d-inline-block">
            <img src="<?= base_url(); ?>/PortalUtama/img/IkonKonsultasi.png" alt="Konsultasi Online" style="width:150px;height:auto;">
            <figcaption><strong>Konsultasi Data</strong></figcaption>
          </a>
        </div>
        <div class="col-lg-6 col-md-6 col-6 d-flex align-items-center justify-content-center">
          <a href="/pertanyaan" class="d-inline-block">
            <img src="<?= base_url(); ?>/PortalUtama/img/IkonQna.png" alt="QnA" style="width:150px;height:auto;">
            <figcaption><strong>Tanya Jawab</strong></figcaption>
          </a>
        </div>
      </div>
    </div>
  </section>
  <!-- End Cliens Section -->
  <section id="clients" class="clients section-bg">
        <div class="container">
            <div class="row mt-5">
                <div class="section-title">
                    <h2>Layanan Internal BPS Provinsi Lampung</h2>
                </div>     
            </div>
            
            <div class="search-box">
                <input type="text" id="search-input" placeholder="Cari Layanan...">
                <button class="search-btn">Cari</button>
            </div>
            
            <div class="category-container">
                <!-- Kategori Umum -->
                <div class="category category-umum">
                    <div class="category-header">Umum</div>
                    <div class="bookmark-container">
                        <ul class="bookmark-list">
                        <li>
                            <a href="https://ppid.bps.go.id/?mfd=1800" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-info-circle"></i></span>
                            <span>Pejabat Pengelola Informasi dan Dokumentasi (PPID)</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://bps.go.id" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-chart-line"></i></span>
                            <span>Badan Pusat Statistik</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://lampung.bps.go.id" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-map-marked-alt"></i></span>
                            <span>Badan Pusat Statistik Provinsi Lampung</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://jdih.bps.go.id" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-balance-scale"></i></span>
                            <span>Jaringan Dokumentasi Informasi Hukum (JDIH)</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://klasifikasi.web.bps.go.id" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-book"></i></span>
                            <span>Kamus Pembakuan Statistik (Klasifikasi)</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://jafung.bps.go.id/main" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-user-tie"></i></span>
                            <span>Sistem Informasi Jabatan Fungsional (Jafung)</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://sibaku.bps.go.id/sibaku" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-clipboard-check"></i></span>
                            <span>Sistem Pembakuan Statistik (Sibaku)</span>
                            </a>
                        </li>
                        </ul>
                    </div>
                </div>

                <!-- Kategori Administrasi -->
                <div class="category category-administrasi">
                    <div class="category-header">Administrasi</div>
                    <div class="bookmark-container">
                        <ul class="bookmark-list">
                            <li>
                                <a href="https://backoffice.bps.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-user-tie"></i></span>
                                    <span>Backoffice BPS</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://lampung.web.bps.go.id/getuk" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-id-card"></i></span>
                                    <span>Getuk BPS Provinsi Lampung</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://halosis.bps.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-users-cog"></i></span>
                                    <span>Layanan Ticketing IT BPS (Halosis)</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://mania.bps.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-database"></i></span>
                                    <span>Manajemen Inventaris Aset TI (Mania)</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://risiko.web.bps.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-user-plus"></i></span>
                                    <span>Manajemen Risiko Terus Menerus (MARI TEMEN)</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://sites.google.com/view/portalpengadaanbps/pokja" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-file-alt"></i></span>
                                    <span>Portal Pengadaan BPS Pokja</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://lampung.web.bps.go.id/sapanadia" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-id-card"></i></span>
                                    <span>SAPANADIA BPS Provinsi Lampung</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://sirup.lkpp.go.id/loginctr/index" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-id-card"></i></span>
                                    <span>SIRUP LKPP</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://srikandi.arsip.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-id-card"></i></span>
                                    <span>Sistem Informasi Kearsipan Dinamis Terintegrasi (Srikandi LAN)</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://webapps.bps.go.id/daftarhadir/" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-user-plus"></i></span>
                                    <span>Sistem Informasi Pengelolaan Daftar Hadir</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://sites.google.com/view/program-can-2025" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-file-alt"></i></span>
                                    <span>Program CAN Lampung 2025</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Kategori Diseminasi -->
                <div class="category category-diseminasi">
                    <div class="category-header">Diseminasi</div>
                    <div class="bookmark-container">
                        <ul class="bookmark-list">
                        <li>
                            <a href="https://perpustakaan.bps.go.id/apps" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-book-reader"></i></span>
                            <span>Dashboard Perpustakaan BPS</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://lampung.archieve.bps.go.id" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-cogs"></i></span>
                            <span>Backend Website BPS Provinsi Lampung</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/628117281800" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fab fa-whatsapp"></i></span>
                            <span>Layanan TALITA Chat WhatsApp</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://linktr.ee/KARISSA2023" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-book"></i></span>
                            <span>Pedoman KARISSA</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://linktr.ee/pedomanpublikasi2023" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-file-alt"></i></span>
                            <span>Pedoman Pembuatan Publikasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://pst.bps.go.id" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-hands-helping"></i></span>
                            <span>Pelayanan Statistik Terpadu (PST)</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://perpustakaan.bps.go.id/opac" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-books"></i></span>
                            <span>Perpustakaan</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://sbe.bps.go.id/silastik" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-server"></i></span>
                            <span>Silastik Backend (SPBE)</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://silastik.bps.go.id" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-chart-network"></i></span>
                            <span>Sistem Informasi Layanan Statistik (SILASTIK)</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://simdasi.bps.go.id" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-database"></i></span>
                            <span>Sistem Informasi Manajemen Data Statistik Terintegrasi (Simdasi)</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://silastik.bps.go.id" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-sitemap"></i></span>
                            <span>Sistem Informasi Rujukan Statistik (Sirusa)</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://karissa.web.bps.go.id" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-newspaper"></i></span>
                            <span>Sistem Kelola Berita Resmi Statistik (BRS)</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://linktr.ee/KARISSA2025" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-bullhorn"></i></span>
                            <span>Sosialisasi KARISSA</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://webdash.bps.go.id/home" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-tachometer-alt"></i></span>
                            <span>Web Dash</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://portalpublikasi.bps.go.id/" class="bookmark-link" target="_blank">
                            <span class="bookmark-icon"><i class="fas fa-file-pdf"></i></span>
                            <span>Web Portal Publikasi BPS</span>
                            </a>
                        </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Kategori Layanan Publik -->
                <div class="category category-kepegawaian">
                    <div class="category-header">Kepegawaian</div>
                    <div class="bookmark-container">
                        <ul class="bookmark-list">
                            <li>
                                <a href="https://lapor.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-bullhorn"></i></span>
                                    <span>LAPOR!</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://mail.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-envelope"></i></span>
                                    <span>Email Pemerintah</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://sipp.menpan.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-tasks"></i></span>
                                    <span>SIPP</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://ppid.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-info-circle"></i></span>
                                    <span>PPID</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://jdih.gov.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-gavel"></i></span>
                                    <span>JDIH</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://lpse.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-shopping-cart"></i></span>
                                    <span>LPSE</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
  <!-- akhir artikel -->

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .section-title h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #2c3e50;
            position: relative;
            padding-bottom: 15px;
        }
        
        .section-title h2:after {
            content: '';
            position: absolute;
            display: block;
            width: 50px;
            height: 3px;
            background: #3498db;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .search-box {
            margin: 20px 0;
            display: flex;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            background-color: white;
        }
        
        #search-input {
            flex: 1;
            padding: 12px 20px;
            border: none;
            outline: none;
            font-size: 1rem;
        }
        
        .search-btn {
            background-color:rgba(9, 37, 85, 0.9);
            color: white;
            border: none;
            padding: 0 20px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        
        .search-btn:hover {
            background-color: #0d62c9;
        }
        
        .category-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }
        
        .category {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            overflow: hidden;
            flex: 1 1 300px;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
        }
        
        .category:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .category-header {
            padding: 15px;
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
        }
        
        .category-umum .category-header {
            background-color: #4285f4;
        }
        
        .category-administrasi .category-header {
            background-color: #0f9d58;
        }
        
        .category-diseminasi .category-header {
            background-color: #f4b400;
        }
        
        .category-layanan .category-header {
            background-color: #db4437;
        }
        
        .bookmark-container {
            max-height: 300px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #3498db #f1f1f1;
        }
        
        /* Scrollbar styling for webkit browsers */
        .bookmark-container::-webkit-scrollbar {
            width: 6px;
        }
        
        .bookmark-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .bookmark-container::-webkit-scrollbar-thumb {
            background: rgba(9, 37, 85, 0.9);
            border-radius: 10px;
        }
        
        .bookmark-container::-webkit-scrollbar-thumb:hover {
            background: rgba(9, 37, 85, 0.9);
        }
        
        .bookmark-list {
            padding: 15px;
            list-style-type: none;
            text-align: left;
        }
        
        .bookmark-list li {
            margin-bottom: 12px;
            border-bottom: 1px solid #eee;
            padding-bottom: 12px;
        }
        
        .bookmark-list li:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }
        
        .bookmark-item {
            margin-bottom: 12px;
            border-bottom: 1px solid #eee;
            padding-bottom: 12px;
        }
        
        .bookmark-item:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }
        
        .bookmark-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #1a73e8;
            font-weight: 500;
            padding: 8px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        
        .bookmark-link:hover {
            background-color: #f1f5fe;
        }
        
        .bookmark-icon {
            margin-right: 15px;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a73e8;
            font-size: 16px;
        }
        
        footer {
            text-align: center;
            padding: 20px;
            background-color: #2c3e50;
            color: white;
            margin-top: 30px;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .category-container {
                flex-direction: column;
            }
            
            .search-box {
                flex-direction: column;
                border-radius: 8px;
            }
            
            .search-btn {
                padding: 10px;
                border-radius: 0 0 8px 8px;
            }
        }
    </style>

    <script>
        // Fungsi pencarian bookmark
        document.querySelector('.search-btn').addEventListener('click', searchBookmarks);
        document.getElementById('search-input').addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                searchBookmarks();
            }
        });
        
        function searchBookmarks() {
            const searchInput = document.getElementById('search-input').value.toLowerCase();
            const bookmarkItems = document.querySelectorAll('.bookmark-link');
            
            bookmarkItems.forEach(item => {
                const bookmarkText = item.textContent.toLowerCase();
                const listItem = item.closest('li');
                
                if (bookmarkText.includes(searchInput)) {
                    listItem.style.display = 'block';
                } else {
                    listItem.style.display = 'none';
                }
            });
            
            // Periksa apakah semua item dalam kategori tersembunyi
            const categories = document.querySelectorAll('.category');
            categories.forEach(category => {
                const visibleItems = category.querySelectorAll('li[style="display: block"]').length;
                const hiddenItems = category.querySelectorAll('li[style="display: none"]').length;
                const totalItems = category.querySelectorAll('li').length;
                
                if (hiddenItems === totalItems) {
                    category.style.display = 'none';
                } else {
                    category.style.display = 'flex';
                }
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Memeriksa tinggi konten untuk menampilkan scrollbar jika dibutuhkan
            const bookmarkContainers = document.querySelectorAll('.bookmark-container');
            
            bookmarkContainers.forEach(container => {
                const list = container.querySelector('.bookmark-list');
                const items = list.querySelectorAll('li');
                
                // Jika jumlah bookmark kurang dari atau sama dengan 5, hilangkan scrollbar
                if (items.length <= 5) {
                    container.style.overflowY = 'visible';
                }
            });
        });
    </script>
<?= $this->endSection('content'); ?>