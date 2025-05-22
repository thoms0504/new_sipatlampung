<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url(); ?>/admin/css/main/app.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/admin/css/pages/auth.css">
    <link rel="shortcut icon" href="<?= base_url(); ?>/PortalUtama/img/logo_bps.png">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    
    <style>
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #ddd;
        }
        .divider:not(:empty)::before {
            margin-right: .25em;
        }
        .divider:not(:empty)::after {
            margin-left: .25em;
        }
        .google-login-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            color: #757575;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px 15px;
            width: 100%;
        }
        .google-login-btn img {
            margin-right: 10px;
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>
<div class="login-page">
        <div id="auth" class="container">
            <div class="mf">
                <div class="d-flex align-items-center">
                    <a href="/">
                        <img src="<?= base_url(); ?>/PortalUtama/img/logo_bps.png" class="img-fluid float-start" alt="">
                    </a>
                    <h1 class="auth-title ps-2">Masuk</h1>
                </div>
                <div id="auth-left">
                    <form action="" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group position-relative has-icon-left mb-3">
                            <input type="text" id="username" name="username" 
                                class="form-control form-control-lg" 
                                placeholder="Nama Pengguna atau Email" required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-3">
                            <input type="password" id="password" name="password" 
                                class="form-control form-control-lg" 
                                placeholder="Kata Sandi" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-check form-check d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" id="rememberMe" value="1" name="rememberMe">
                            <label class="form-check-label" for="rememberMe">
                                Ingat Saya
                            </label>
                            <!-- <a href="#" class="ms-auto text-muted">Lupa Kata Sandi?</a> -->
                        </div>
                        <div class="form-group position-relative has-icon-left mb-3">
                            <input type="submit" class="btn btn-biru btn-block shadow mt-3" name="submit" value="Masuk">
                        </div>

                        <div class="divider">atau</div>
                    </form>
                    <a class="btn-google btn btn-with btn-block shadow mt-4" href="/googlelogin" onmousedown="return false">
                        <img class="" src="<?= base_url(); ?>/PortalUtama/img/logoGoogle.png" alt="Logo Google" width="20px">
                        <span class="ms-1">Masuk dengan Google</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!--Sweet Alert Script-->
    <script>
    function destroy() {
        event.preventDefault();
        var form = document.forms['actionDelete'];
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Anda tidak dapat mengembalikkan data yang telah dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        })
    }

    function destroy2(id,tipe,nama) {
        event.preventDefault();
        var form = document.forms['actionDelete2_'+tipe+id];
        Swal.fire({
            title: 'Apakah anda yakin?',
            html: tipe+' '+nama+' akan dihapus'+'<br>'+'Anda tidak dapat mengembalikkan data yang telah dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        })
    }

    function active(id,tipe,nama) {
        event.preventDefault();
        var form = document.forms['actionStatus_'+tipe+id];
        Swal.fire({
            title: 'Apakah anda yakin?',
            html: 'Akun '+nama+' akan di'+tipe,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: tipe.charAt(0).toUpperCase() + tipe.slice(1),
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        })
    }

    $(document).ready(function () {
        <?php if (session()->getFlashdata('sukses')) { ?>
        Swal.fire(
            {
                title: 'Sukses',
                text: '<?= session()->getFlashdata('sukses'); ?>',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
            }
        )
        <?php } else if (session()->getFlashdata('gagal')) { ?>
        Swal.fire(
            {
                title: 'Gagal',
                text: '<?= session()->getFlashdata('gagal'); ?>',
                icon: 'error',
                showConfirmButton: false,
                timer: 1500
            }
        )
        <?php } ?>
    });
</script>
</body>
</html>