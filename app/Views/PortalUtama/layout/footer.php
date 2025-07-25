<style>
    .footer-gradient {
        background: linear-gradient(135deg, #0d47a1 0%, #1565c0 50%, #1976d2 100%);
        position: relative;
        overflow: hidden;
    }

    .footer-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 200"><defs><linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:%23ffffff;stop-opacity:0.05"/><stop offset="100%" style="stop-color:%23ffffff;stop-opacity:0.01"/></linearGradient></defs><path d="M0,50 Q300,0 600,50 T1200,50 L1200,200 L0,200 Z" fill="url(%23grad)"/></svg>') no-repeat;
        background-size: cover;
        opacity: 0.1;
    }

    .footer-content {
        position: relative;
        z-index: 2;
    }

    .logo-section {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .logo-section img {
        width: 50px;
        height: 50px;
        margin-right: 15px;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
    }

    .app-title {
        font-size: 1.8rem;
        font-weight: 700;

        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .app-subtitle {
        font-size: 0.9rem;

        margin: 5px 0 0 0;
        line-height: 1.4;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        text-align: center;
        margin-bottom: 15px;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .service-link-footer {
        display: inline-block;
        color: #e3f2fd;
        text-decoration: none;
        padding: 8px 16px;
        margin: 4px 8px 4px 0;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .service-link-footer:hover {
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .contact-info-footer {
        color: #b3d9ff;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    .contact-info-footer li {
        list-style: none;
        margin-bottom: 5px;
        position: relative;
        padding-left: 20px;
    }

    .contact-info-footer li:before {
        content: "📍";
        position: absolute;
        left: 0;
        top: 0;
    }

    .contact-info-footer li:nth-child(2):before {
        content: "🏢";
    }

    .contact-info-footer li:nth-child(3):before {
        content: "📧";
    }

    .footer-bottom {
        background: rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(20px);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 30px;
        padding: 20px 0;
    }

    .copyright {
        color: #b3d9ff;
        font-size: 0.9rem;
        margin: 0;
    }

    .social-links {
        display: flex;
        gap: 15px;
        align-items: center;
        justify-content: end;
    }

    .social-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        color: #ffffff;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
    }

    .social-link:hover {
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    .whatsapp-float {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        text-decoration: none;
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.3);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .whatsapp-float:hover {
        background: linear-gradient(135deg, #128c7e 0%, #25d366 100%);
        transform: scale(1.1);
        box-shadow: 0 6px 30px rgba(37, 211, 102, 0.5);
        color: white;
    }

    .back-to-top {
        position: fixed;
        bottom: 20px;
        left: 20px;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #1976d2 0%, #0d47a1 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(13, 71, 161, 0.3);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .back-to-top:hover {
        background: linear-gradient(135deg, #0d47a1 0%, #1976d2 100%);
        transform: scale(1.1);
        box-shadow: 0 6px 25px rgba(13, 71, 161, 0.5);
        color: white;
    }

    @media (max-width: 768px) {
        .footer-content .row>div {
            margin-bottom: 30px;
        }

        .social-links {
            justify-content: center;
        }

        .app-title {
            font-size: 1.5rem;
        }

        .service-link-footer {
            display: block;
            margin: 8px 0;
        }
    }
</style>

<footer id="footer">
    <div class="container pt-5">
        <div class="containter text-white " style="background-color: #001f4f;">
            <div class="row" style="margin:0 auto;">
                <!-- footer kiri -->
                <div class="col">
                    <div class="logo-section">
                        <img class="float-left me-3" src="<?= base_url(); ?>/PortalUtama/img/logo_bps.png" alt="logo BPS"
                            style="width:70px; float:left">
                        <div>
                            <h3 class="app-title">Ruwai Jurai</h3>
                            <p class="app-subtitle">Aplikasi Penyimpanan dan Konsultasi Tanya Jawab<br>BPS Provinsi Lampung</p>
                        </div>
                    </div>
                </div>
                <!-- footer tengah -->
                <div class="col">
                    <h5 class="section-title">Layanan</h5>
                    <div>
                        <a href="/chat" class="service-link-footer">
                            <i class="bi bi-database me-2"></i>Layanan Data
                        </a>
                        <a href="/pertanyaan" class="service-link-footer">
                            <i class="bi bi-chat-square-dots me-2"></i>Forum Diskusi
                        </a>
                    </div>
                </div>
                <!-- footer kanann -->
                <div class="col-sm-4">
                    <h5 class="section-title">Hubungi Kami</h5>
                    <ul class="contact-info-footer p-0 m-0 ">
                        <li>BPS Provinsi Lampung</li>
                        <li>Jl. Basuki Rahmat No.54</li>
                        <li>Bandar Lampung, 13330</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="containter text-white mt-5" style="background-color: #001f4f;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="copyright">
                        &copy; Copyright <strong>IPDS BPS Provinsi Lampung</strong>.
                        <span class="divider">|</span> Made with Klanting
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="social-links">
                        <a href="https://facebook.com/bpsprovlampung" class="social-link" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://instagram.com/bpsprovlampung" class="social-link" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://threads.com/bpsprovlampung" class="social-link" title="Threads">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-threads" viewBox="0 0 16 16">
                                <path d="M6.321 6.016c-.27-.18-1.166-.802-1.166-.802.756-1.081 1.753-1.502 3.132-1.502.975 0 1.803.327 2.394.948s.928 1.509 1.005 2.644q.492.207.905.484c1.109.745 1.719 1.86 1.719 3.137 0 2.716-2.226 5.075-6.256 5.075C4.594 16 1 13.987 1 7.994 1 2.034 4.482 0 8.044 0 9.69 0 13.55.243 15 5.036l-1.36.353C12.516 1.974 10.163 1.43 8.006 1.43c-3.565 0-5.582 2.171-5.582 6.79 0 4.143 2.254 6.343 5.63 6.343 2.777 0 4.847-1.443 4.847-3.556 0-1.438-1.208-2.127-1.27-2.127-.236 1.234-.868 3.31-3.644 3.31-1.618 0-3.013-1.118-3.013-2.582 0-2.09 1.984-2.847 3.55-2.847.586 0 1.294.04 1.663.114 0-.637-.54-1.728-1.9-1.728-1.25 0-1.566.405-1.967.868ZM8.716 8.19c-2.04 0-2.304.87-2.304 1.416 0 .878 1.043 1.168 1.6 1.168 1.02 0 2.067-.282 2.232-2.423a6.2 6.2 0 0 0-1.528-.161" />
                            </svg>
                        </a>
                        <a href="https://x.com/bpsprovlampung" class="social-link" title="X">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 1200 1227">
                                <path d="M1070 0h-168L599 537 293 0H0l436 685L2 1227h168l434-485 310 485h293L764 768z" />
                            </svg>
                        </a>
                        <a href="https://www.youtube.com/bpsprovlampung" class="social-link" title="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer><!-- End Footer -->

<!-- Floating Action Buttons -->
<a href="https://wa.me/628117281800" target="_blank" class="whatsapp-float" title="Chat WhatsApp">
    <i class="bi bi-whatsapp"></i>
</a>

<a href="#" class="back-to-top" title="Back to Top">
    <i class="bi bi-arrow-up-short"></i>
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Smooth scroll for back to top
    document.querySelector('.back-to-top').addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>