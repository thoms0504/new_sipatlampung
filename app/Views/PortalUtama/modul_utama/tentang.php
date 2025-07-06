<?= $this->extend('PortalUtama/layout/template'); ?>
<?= $this->section('content'); ?>

<style>
  :root {
    --primary-blue: #001f4f;
    --secondary-blue: #3b82f6;
    --light-blue: #dbeafe;
    --accent-blue: #60a5fa;
    --text-dark: #1f2937;
    --text-light: #6b7280;
    --white: #ffffff;
    --gradient-bg: linear-gradient(135deg, #001f4f 0%, #3b82f6 100%);
  }




  .section-title {
    text-align: center;
    margin-bottom: 4rem;
    position: relative;
  }

  .section-title h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-blue);
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
    background: var(--gradient-bg);
    border-radius: 2px;
  }

  .contact {
    padding: 80px 0;
    background: transparent;
  }

  .contact-card {
    background: var(--white);
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 2rem;
    border: 1px solid rgba(59, 130, 246, 0.1);
  }

  .contact-info {
    padding: 3rem;
    background: linear-gradient(135deg, var(--white) 0%, #f8fafc 100%);
  }

  .contact-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 2.5rem;
    padding: 1.5rem;
    background: var(--white);
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border-left: 4px solid var(--secondary-blue);
  }

  .contact-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
  }

  .contact-item i {
    font-size: 1.8rem;
    color: var(--secondary-blue);
    margin-right: 1.5rem;
    margin-top: 0.2rem;
    min-width: 40px;
  }

  .contact-item h4 {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--primary-blue);
    margin-bottom: 0.5rem;
  }

  .contact-item p {
    color: var(--text-light);
    margin: 0;
    font-size: 1rem;
  }

  .contact-item a {
    color: var(--secondary-blue);
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .contact-item a:hover {
    color: var(--primary-blue);
  }

  .map-container {
    margin-top: 2rem;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  }

  .map-container iframe {
    width: 100%;
    height: 350px;
    border: none;
    transition: transform 0.3s ease;
  }

  .contact-form-section {
    padding: 3rem;
    background: var(--gradient-bg);
    color: var(--white);
  }

  .contact-form-section h4 {
    font-size: 1.8rem;
    font-weight: 600;
    margin-bottom: 1rem;
  }

  .contact-details {
    margin-bottom: 2rem;
  }

  .contact-details div {
    margin-bottom: 0.5rem;
    opacity: 0.9;
  }

  .social-media {
    margin-top: 2rem;
  }

  .social-media h4 {
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
  }

  .social-links {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
  }

  .social-links a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: var(--white);
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
  }

  .social-links a:hover {
    background: var(--white);
    color: var(--primary-blue);
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
  }

  .social-links a i,
  .social-links a svg {
    font-size: 1.2rem;
  }

  .stats-section {
    background: var(--white);
    padding: 2rem;
    border-radius: 15px;
    margin-top: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
  }

  .stat-item {
    text-align: center;
    padding: 1rem;
  }

  .stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--secondary-blue);
    display: block;
  }

  .stat-label {
    font-size: 0.9rem;
    color: var(--text-light);
    margin-top: 0.5rem;
  }

  .floating-elements {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    overflow: hidden;
  }

  .floating-circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(59, 130, 246, 0.1);
    animation: float 6s ease-in-out infinite;
  }

  .floating-circle:nth-child(1) {
    width: 80px;
    height: 80px;
    top: 10%;
    left: 10%;
    animation-delay: 0s;
  }

  .floating-circle:nth-child(2) {
    width: 60px;
    height: 60px;
    top: 20%;
    right: 10%;
    animation-delay: 2s;
  }

  .floating-circle:nth-child(3) {
    width: 100px;
    height: 100px;
    bottom: 20%;
    left: 20%;
    animation-delay: 4s;
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

  @media (max-width: 768px) {
    .section-title h2 {
      font-size: 2rem;
    }

    .contact-info,
    .contact-form-section {
      padding: 2rem;
    }

    .contact-item {
      flex-direction: column;
      text-align: center;
    }

    .contact-item i {
      margin-right: 0;
      margin-bottom: 1rem;
    }

    .social-links {
      justify-content: center;
    }
  }
</style>

<div class="bg-section-title">
  <div class="floating-elements">
    <div class="floating-circle"></div>
    <div class="floating-circle"></div>
    <div class="floating-circle"></div>
  </div>
</div>



<section id="contact" class="contact">
  <div class="container" data-aos="fade-up">
    <div class="section-title">
      <h2>BPS Provinsi Lampung</h2>
      <p class="lead text-muted">Badan Pusat Statistik Provinsi Lampung siap melayani kebutuhan data dan informasi statistik Anda</p>
    </div>

    <div class="row">
      <div class="col-lg-7 col-md-12">
        <div class="contact-card">
          <div class="contact-info">
            <div class="contact-item" data-aos="fade-up" data-aos-delay="100">
              <i class="bi bi-geo-alt"></i>
              <div>
                <h4>Alamat</h4>
                <p>Jl. Basuki Rahmat No. 54 Bandar Lampung, Indonesia</p>
              </div>
            </div>

            <div class="contact-item" data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-envelope"></i>
              <div>
                <h4>Email</h4>
                <p><a href="mailto:bps1800@bps.go.id">bps1800@bps.go.id</a></p>
              </div>
            </div>

            <div class="contact-item" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-whatsapp"></i>
              <div>
                <h4>Kontak</h4>
                <p><a href="https://wa.me/6281172818000">08117281800</a></p>
              </div>
            </div>

            <div class="map-container" data-aos="fade-up" data-aos-delay="400">
              <iframe src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=The Central Statistics Agency of Lampung Province&amp;t=&amp;z=16&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
              </iframe>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-5 col-md-12">
        <div class="contact-card">
          <div class="contact-form-section">
            <h4>Hubungi Kami</h4>
            <div class="contact-details">
              <div><strong>BPS Provinsi Lampung</strong></div>
              <div>Jl. Basuki Rahmat No.54</div>
              <div>Bandar Lampung, 35122</div>
              <div>Indonesia</div>
            </div>

            <div class="social-media">
              <h4>Sosial Media</h4>
              <div class="social-links">
                <a href="https://facebook.com/bpsprovlampung" title="Facebook" target="_blank">
                  <i class="bi bi-facebook"></i>
                </a>
                <a href="https://instagram.com/bpsprovlampung" title="Instagram" target="_blank">
                  <i class="bi bi-instagram"></i>
                </a>
                <a href="https://threads.com/bpsprovlampung" title="Threads" target="_blank">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M6.321 6.016c-.27-.18-1.166-.802-1.166-.802.756-1.081 1.753-1.502 3.132-1.502.975 0 1.803.327 2.394.948s.928 1.509 1.005 2.644q.492.207.905.484c1.109.745 1.719 1.86 1.719 3.137 0 2.716-2.226 5.075-6.256 5.075C4.594 16 1 13.987 1 7.994 1 2.034 4.482 0 8.044 0 9.69 0 13.55.243 15 5.036l-1.36.353C12.516 1.974 10.163 1.43 8.006 1.43c-3.565 0-5.582 2.171-5.582 6.79 0 4.143 2.254 6.343 5.63 6.343 2.777 0 4.847-1.443 4.847-3.556 0-1.438-1.208-2.127-1.27-2.127-.236 1.234-.868 3.31-3.644 3.31-1.618 0-3.013-1.118-3.013-2.582 0-2.09 1.984-2.847 3.55-2.847.586 0 1.294.04 1.663.114 0-.637-.54-1.728-1.9-1.728-1.25 0-1.566.405-1.967.868ZM8.716 8.19c-2.04 0-2.304.87-2.304 1.416 0 .878 1.043 1.168 1.6 1.168 1.02 0 2.067-.282 2.232-2.423a6.2 6.2 0 0 0-1.528-.161" />
                  </svg>
                </a>
                <a href="https://x.com/bpsprovlampung" title="X (formerly Twitter)" target="_blank">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 1200 1227">
                    <path d="M1070 0h-168L599 537 293 0H0l436 685L2 1227h168l434-485 310 485h293L764 768z" />
                  </svg>
                </a>
                <a href="https://www.youtube.com/bpsprovlampung" title="YouTube" target="_blank">
                  <i class="bi bi-youtube"></i>
                </a>
              </div>
            </div>

            <div class="mt-4">
              <h5>Jam Operasional</h5>
              <div class="mb-2">
                <small>Senin - Jumat: 08:00 - 16:00 WIB</small>
              </div>
              <div>
                <small>Sabtu - Minggu: Tutup</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- End Contact Section -->
<?= $this->endSection('content'); ?>