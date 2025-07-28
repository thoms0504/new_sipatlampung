<?= $this->extend('PortalUtama/layout/template'); ?>
<?= $this->section('content'); ?>

<head>

    <style>
        :root {
            --primary-color: #001f4f;
            --secondary-color: #3b82f6;
            --accent-color: #60a5fa;
            --light-blue: #dbeafe;
            --dark-blue: #1e40af;
            --gradient-primary: linear-gradient(135deg, #001f4f 0%, #3b82f6 100%);
            --gradient-secondary: linear-gradient(135deg, #60a5fa 0%, #93c5fd 100%);
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --white: #ffffff;
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        /* Hero Section */
        .hero {
            background: var(--gradient-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.05)" points="0,0 1000,300 1000,1000 0,700"/></svg>');
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 1rem;
            line-height: 1.2;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .hero h2 {
            font-size: 1.5rem;
            color: var(--light-blue);
            margin-bottom: 2rem;
            font-weight: 400;
        }

        .btn-get-started {
            background: var(--white);
            color: var(--primary-color);
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .btn-get-started::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s ease;
        }

        .btn-get-started:hover::before {
            left: 100%;
        }

        .btn-get-started:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
            color: var(--primary-color);
        }

        .hero-image {
            position: relative;
            z-index: 2;
        }

        .hero-image img {
            width: 100%;
            height: auto;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.2));
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* Services Section */
        .services {
            padding: 5rem 0;
            background: var(--white);
            position: relative;
        }

        .services::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(180deg, var(--primary-color) 0%, transparent 100%);
        }

        .section-title {
            text-align: center;
            margin-bottom: 4rem;
            position: relative;
            z-index: 2;
        }

        .section-title h2 {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--gradient-secondary);
            border-radius: 2px;
        }

        .service-card {
            background: var(--white);
            border-radius: 20px;
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
            margin: 1rem 0;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .service-card:hover::before {
            opacity: 0.03;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
            border-color: var(--accent-color);
        }

        .service-card .card-content {
            position: relative;
            z-index: 2;
        }

        .service-card .service-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem;
            transition: all 0.3s ease;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.1));
        }

        .service-card:hover .service-icon {
            transform: scale(1.1);
            filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.2));
        }

        .service-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
            transition: color 0.3s ease;
        }

        .service-card p {
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .service-link {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .service-link:hover {
            color: var(--primary-color);
            transform: translateX(5px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero h2 {
                font-size: 1.2rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .service-card {
                padding: 2rem 1rem;
            }
        }

        /* Animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .scale-in {
            opacity: 0;
            transform: scale(0.8);
            transition: all 0.6s ease;
        }

        .scale-in.visible {
            opacity: 1;
            transform: scale(1);
        }
    </style>
</head>

<!-- Hero Section -->
<section id="hero" class="hero d-flex align-items-center">
    <div class="container pt-5">
        <div class="row align-items-center">
            <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1 hero-content fade-in" data-aos="fade-up" data-aos-delay="200">
                <h1>Ruang Warga Aspiratif Interaktif – Jaringan untuk Usulan, Rekomendasi, Aspirasi, dan Informasi</h1>
                <h2>Tersedia untuk Umum dan BPS Provinsi Lampung</h2>
                <div class="d-flex justify-content-center justify-content-lg-start">
                    <a href="#clients" class="btn-get-started scrollto">
                        <i class="fas fa-rocket me-2"></i>
                        Mulai Sekarang
                    </a>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img scale-in" data-aos="zoom-in" data-aos-delay="200">
                <!-- Menggunakan gambar asli atau SVG custom -->
                <img src="<?= base_url(); ?>/PortalUtama/img/beranda2.svg" class="img-fluid animated" alt="Ilustrasi Layanan Data">
            </div>
        </div>
    </div>
</section>

<main id="main">
    <!-- Services Section -->
    <section id="clients" class="services section-bg">
        <div class="container">
            <div class="row mt-5">
                <div class="section-title fade-in">
                    <h2>Layanan Data</h2>
                    <p class="lead">Akses mudah ke layanan data dan konsultasi untuk mendukung kebutuhan informasi Anda</p>
                </div>
            </div>
            <div class="row mb-5" data-aos="zoom-in">
                <div class="col-lg-6 col-md-6 d-flex align-items-stretch">
                    <div class="service-card scale-in w-100">
                        <div class="card-content">
                            <!-- Icon untuk Layanan Data -->
                            <div class="service-icon">
                                <svg width="120" height="120" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="60" cy="60" r="55" fill="#e0f2fe" stroke="#0284c7" stroke-width="2" />
                                    <circle cx="60" cy="40" r="15" fill="#0284c7" />
                                    <rect x="35" y="55" width="50" height="30" rx="5" fill="#0284c7" />
                                    <rect x="40" y="65" width="40" height="3" fill="#fff" opacity="0.8" />
                                    <rect x="40" y="72" width="30" height="3" fill="#fff" opacity="0.6" />
                                    <path d="M45 90 Q60 85 75 90" stroke="#0284c7" stroke-width="2" fill="none" />
                                    <circle cx="50" cy="92" r="2" fill="#0284c7" />
                                    <circle cx="70" cy="92" r="2" fill="#0284c7" />
                                </svg>
                            </div>
                            <h3>Layanan Data</h3>
                            <p>Konsultasi dan akses data statistik untuk mendukung penelitian, analisis, dan pengambilan keputusan berbasis data yang akurat.</p>
                            <a href="/chat" class="service-link">
                                Mulai Konsultasi
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 d-flex align-items-stretch">
                    <div class="service-card scale-in w-100">
                        <div class="card-content">
                            <!-- Icon untuk Forum Diskusi -->
                            <div class="service-icon">
                                <svg width="120" height="120" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="60" cy="60" r="55" fill="#fef3c7" stroke="#f59e0b" stroke-width="2" />
                                    <rect x="30" y="35" width="60" height="50" rx="5" fill="#f59e0b" />
                                    <rect x="35" y="40" width="50" height="3" fill="#fff" opacity="0.8" />
                                    <rect x="35" y="50" width="40" height="3" fill="#fff" opacity="0.6" />
                                    <rect x="35" y="60" width="35" height="3" fill="#fff" opacity="0.6" />
                                    <rect x="35" y="70" width="45" height="3" fill="#fff" opacity="0.6" />
                                    <circle cx="45" cy="95" r="3" fill="#f59e0b" />
                                    <circle cx="60" cy="95" r="3" fill="#f59e0b" />
                                    <circle cx="75" cy="95" r="3" fill="#f59e0b" />
                                    <path d="M40 95 Q60 90 80 95" stroke="#f59e0b" stroke-width="2" fill="none" />
                                </svg>
                            </div>
                            <h3>Forum Diskusi</h3>
                            <p>Platform tanya jawab dan diskusi untuk berbagi pengetahuan, bertukar informasi, dan mendapatkan solusi dari komunitas.</p>
                            <a href="/pertanyaan" class="service-link">
                                Bergabung Forum
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>





<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true
    });

    // Smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in, .scale-in').forEach(el => {
        observer.observe(el);
    });

    // Card hover effects
    document.querySelectorAll('.service-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-10px) scale(1.02)';
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Fungsi pencarian bookmark (dari kode asli)
    function searchBookmarks() {
        const searchInput = document.getElementById('search-input')?.value.toLowerCase();
        if (!searchInput) return;

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

        // Periksa kategori
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

    // Event listeners untuk pencarian
    document.querySelector('.search-btn')?.addEventListener('click', searchBookmarks);
    document.getElementById('search-input')?.addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            searchBookmarks();
        }
    });

    // DOMContentLoaded functions
    document.addEventListener('DOMContentLoaded', function() {
        // Bookmark container scrollbar logic
        const bookmarkContainers = document.querySelectorAll('.bookmark-container');
        bookmarkContainers.forEach(container => {
            const list = container.querySelector('.bookmark-list');
            const items = list?.querySelectorAll('li');
            if (items && items.length <= 5) {
                container.style.overflowY = 'visible';
            }
        });
    });
</script>

<?= $this->endSection('content'); ?>