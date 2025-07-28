<!-- ======= Header ======= -->
<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">
        <img src="<?= base_url(); ?>/PortalUtama/img/logo_bps.png" alt="logo stis">
        <h1 class="logo me-auto"><a href="<?= base_url(); ?>">Ruwai Jurai</a></h1>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto <?= ($active == 'beranda') ? 'active' : ''; ?>" href="/">Beranda</a>
                </li>
                <li class="dropdown"><a class="<?= ($active == 'layanan') ? 'active' : ''; ?>" href="#"><span>Pelayanan</span>
                        <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a class="<?= ($active == 'chat') ? 'active' : ''; ?>" href="/chat">Layanan Data</a>
                        </li>
                        <!-- Forum Diskusi dengan Sub-menu Branch -->
                        <li class="dropdown submenu"><a href="#"><span>Forum Diskusi</span> <i class="bi bi-chevron-right"></i></a>
                            <ul>
                                <li><a class="<?= ($active == '`qna`') ? 'active' : ''; ?>" href="/pertanyaan">Daftar Pertanyaan</a></li>
                                <li><a class="<?= ($active == 'qna_saya') ? 'active' : ''; ?>" href="/pertanyaan-saya/">Pertanyaan saya</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a class="<?= ($active == 'tentang') ? 'active' : ''; ?>" href="/tentang">Tentang Kami</a></li>
                
                <!-- Jika Belum Masuk -->
                <?php if (!isset((session()->get())['username'])) : ?>
                    <li><a class="getstarted scrollto <?= ($active == 'beranda') ? 'active' : ''; ?>" href="/masuk">Masuk</a>
                    </li>
                    <!-- Jika Sudah Masuk -->
                <?php elseif ((session()->get())['username']) : ?>
                    <li class="dropdown"><a href="#"><span><i class="bi bi-person-circle fs-6"></i> <?= (session()->get())['nama_lengkap']; ?></span>
                            <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <!-- Jika Sudah Masuk namun Admin -->
                            <?php if ((session()->get())['role'] != 'user') : ?>
                                <li><a class="dropdown-item" href="/admin/dasbor"><i class="bi bi-window-sidebar"></i>
                                        Dashboard</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="/profil"><i class="bi bi-person-square"></i> Profil
                                    Saya</a></li>
                            <!-- Notifikasi -->
                            <!-- <li><a class="dropdown-item" href="/notifikasi"><i class="bi bi-bell"></i> Notifikasi
                                    <span class="badge bg-danger"><?= (session()->get())['notifikasi'] ?? 0; ?></span></a>
                            </li> -->
                            <li>
                                <a class="dropdown-item d-flex" href="" onclick="mKeluar()">
                                    <span><i class="bi bi-box-arrow-right"></i></span>
                                    <span style="padding-left: 0.5rem;">Keluar</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>

</header><!-- End Header -->

<!-- Modal untuk notifikasi -->
<div class="modal fade" id="notifikasiModal" tabindex="-1" aria-labelledby="notifikasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notifikasiModalLabel">Notifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Konten notifikasi akan dimuat di sini -->
                <div id="notifikasiContent"></div>
            </div>
        </div>
    </div>
</div>

<!-- CSS untuk submenu dropdown -->
<style>
/* Style untuk submenu dropdown */
.navbar .dropdown ul .dropdown.submenu {
    position: relative;
}

.navbar .dropdown ul .dropdown.submenu > a:after {
    content: "\f285";
    font-family: bootstrap-icons;
    position: absolute;
    right: 15px;
}

.navbar .dropdown ul .dropdown.submenu:hover > ul,
.navbar .dropdown ul .dropdown.submenu.show > ul {
    opacity: 1;
    top: 0;
    left: 100%;
    visibility: visible;
}

.navbar .dropdown ul .dropdown.submenu ul {
    margin: 0;
    padding: 10px 0;
    background: #fff;
    box-shadow: 0px 0px 30px rgba(127, 137, 161, 0.25);
    position: absolute;
    top: 0;
    left: 100%;
    visibility: hidden;
    opacity: 0;
    transition: 0.3s;
    border-radius: 4px;
    z-index: 99;
    min-width: 200px;
}

.navbar .dropdown ul .dropdown.submenu ul li {
    min-width: 200px;
}

.navbar .dropdown ul .dropdown.submenu ul a {
    padding: 10px 20px;
    font-size: 14px;
    text-transform: none;
    color: #2c4964;
    transition: 0.3s;
    display: block;
}

.navbar .dropdown ul .dropdown.submenu ul a:hover,
.navbar .dropdown ul .dropdown.submenu ul .active,
.navbar .dropdown ul .dropdown.submenu ul a:hover,
.navbar .dropdown ul .dropdown.submenu ul li:hover > a {
    color: #106eea;
}

/* Responsive untuk mobile */
@media (max-width: 991px) {
    .navbar .dropdown ul .dropdown.submenu ul {
        position: static;
        visibility: visible;
        opacity: 1;
        left: 0;
        box-shadow: none;
        background: #f8f9fa;
        margin-left: 20px;
        border-left: 2px solid #106eea;
    }
    
    .navbar .dropdown ul .dropdown.submenu > a:after {
        content: "\f282";
    }
    
    .navbar .dropdown ul .dropdown.submenu.show > a:after {
        content: "\f229";
    }
}
</style>

<!-- JavaScript untuk handling submenu -->
<script>
// Handle submenu dropdown pada mobile
document.addEventListener('DOMContentLoaded', function() {
    const submenuItems = document.querySelectorAll('.dropdown.submenu > a');
    
    submenuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            if (window.innerWidth <= 991) {
                e.preventDefault();
                const parent = this.parentElement;
                parent.classList.toggle('show');
            }
        });
    });
});

function mKeluar() {
    event.preventDefault();
    Swal.fire({
        title: 'Apakah Anda ingin keluar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Keluar',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/keluar";
        }
    })
}
</script>