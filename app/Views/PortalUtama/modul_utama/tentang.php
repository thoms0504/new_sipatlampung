<?= $this->extend('PortalUtama/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="bg-section-title pad"></div>
<section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>BPS Provinsi Lampung</h2>
        </div>

        <div class="row">

          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Alamat</h4>
                <p>Jl. Basuki Rahmat No. 54 Bandar Lampung, Indonesia</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email</h4>
                <p>https://mailto:bps1800@bps.go.id</p>
              </div>

              <div class="phone">
                <i class="bi bi-whatsapp"></i>
                <h4>Kontak</h4>
                <p>08117281800</p>
              </div>
              <iframe src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=The Central Statistics Agency of Lampung Province&amp;t=&amp;z=16&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" width="100%" height="410px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

          </div>

          <div class="col-lg-4 mt-5 mt-lg-0 d-flex align-items-stretch">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="row">            
                <h4>Hubungi Kami</h4>
                <div>BPS Provinsi Lampung</div>
                <div>Jl. Basuki Rahmat No.54</div>
                <div>Bandar Lampung, 13330</div><br><br>
        
                <h4>Sosial Media</h4> 
                <div class="social-media mt-3">
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="tiktok"><i class="bi bi-tiktok"></i></a>
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="youtube"><i class="bi bi-youtube"></i></a>
                </div>
              </div>
        </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->
<?= $this->endSection('content'); ?>