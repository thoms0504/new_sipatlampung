<!-- ======= Header ======= -->
<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">
        <img src="<?= base_url(); ?>/PortalUtama/img/logo_bps.png" alt="logo stis">
        <h1 class="logo me-auto"><a href="<?= base_url(); ?>">Ruwai Jurai</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto <?= ($active == 'beranda') ? 'active' : ''; ?>" href="/">Beranda</a>
                </li>
                <li class="dropdown"><a class="<?= ($active == 'layanan') ? 'active' : ''; ?>" href="#"><span>Pelayanan</span>
                        <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a class="<?= ($active == 'chat') ? 'active' : ''; ?>" href="/chat">Layanan Data</a>
                        </li>
                        <li><a class="<?= ($active == 'qna') ? 'active' : ''; ?>" href="/pertanyaan">Forum Diskusi</a>
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

<script>
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