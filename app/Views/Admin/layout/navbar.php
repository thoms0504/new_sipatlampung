<header class="navbar-fixed fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="/" class="logo d-flex align-items-center">
            <img src="<?= base_url(); ?>/admin/img/logo.png" alt="" style="height: 2.5rem;">
            <span class="d-none d-lg-block" style="font-weight: bolder; padding-left: 0.5rem;">Ruwai Jurai</span>
        </a>

        <div style="padding-left: 0.5rem;">
            <div class="theme-toggle d-flex gap-2  align-items-center" style="margin-top: 0.15rem;">
                <!-- SUN ICON FOR CHANGE THEME TO LIGHT -->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                    <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                        <g transform="translate(-210 -1)">
                            <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                            <circle cx="220.5" cy="11.5" r="4"></circle>
                            <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                            </path>
                        </g>
                    </g>
                </svg>
                <!-- END OF SUN ICON FOR CHANGE THEME TO LIGHT -->

                <!-- TOOGLE THEME -->
                <div class="form-check form-switch fs-6" style="margin-left: 0.5rem;">
                    <input class="form-check-input  me-0" type="checkbox" id="toggle-dark">
                    <label class="form-check-label"></label>
                </div>
                <!-- END OF TOOGLE THEME -->

                <!-- MOON ICON FOR CHANGE THEME TO DARK -->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                    </path>
                </svg>
                <!-- END OF MOON ICON FOR CHANGE THEME TO DARK -->
            </div>
        </div>
        <a href="#" class="burger-btn d-block d-xl-none" style="padding-left: 0.5rem;">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </div><!-- End Logo -->
    <div class="ms-auto">
        <ul class="d-flex align-items-center" style="height: 0.5rem; list-style-type: none;">
            <li class="nav-item dropdown pe-3" style="height: 0.5rem;">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="/admin/img/users/default.png" alt="Foto Profil" class="rounded-circle" style="height: 25px;">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?= isset((session()->get())['nama_lengkap']) ? session()->get()['nama_lengkap'] : ""; ?></span>
                </a><!-- End Profile Image Icon -->
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

                    <li>
                        <a class="dropdown-item d-flex" href="/">
                            <span><i class="bi bi-house"></i></span>
                            <span style="padding-left: 0.5rem;">Beranda</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex" href="/profil">
                            <span><i class="bi bi-person"></i></span>
                            <span style="padding-left: 0.5rem;">Profil Saya</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex" href="" onclick="mKeluar()">
                            <span><i class="bi bi-box-arrow-right"></i></span>
                            <span style="padding-left: 0.5rem;">Keluar</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</header>
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