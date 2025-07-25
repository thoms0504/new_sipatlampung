<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="shortcut icon" href="<?= base_url(); ?>/PortalUtama/img/logo_bps.png">

    <!-- CSS Style Tampilan -->
    <link rel="stylesheet" href="<?= base_url(); ?>/admin/css/main/app.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/admin/css/main/app-dark.css">

    <!-- CDN Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS Datatable -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.2.1/dist/umd/simple-datatables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@9.2.1/dist/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>/admin/css/pages/simple-datatables.css">

    <!-- MANUAL CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>/admin/css/main/styles.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/admin/css/main/skko.css">

    <!-- CSS FORM SELECT -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url(); ?>/admin/css/pages/select2.css">

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>

    <!-- FONT AWESOME -->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <!-- APEX CHART -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.1.0/chartjs-plugin-datalabels.min.js" integrity="sha512-Tfw6etYMUhL4RTki37niav99C6OHwMDB2iBT5S5piyHO+ltK2YX8Hjy9TXxhE1Gm/TmAV0uaykSpnHKFIAif/A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
        
    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- PARSLEY JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>

    <!-- DATATABLES -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <!-- FullCalendar CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css" rel="stylesheet">

    <!-- FullCalendar JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>

    <!-- SELECT2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        #test {
            color: red;
        }
        #test1 {
            color: red;
        }
    </style>
</head>

<body>
        <!-- NAVBAR -->
        <?= $this->include('Admin/layout/navbar'); ?>

        <!-- SIDEBAR MENU -->
        <?= $this->include('Admin/layout/sidebar'); ?>

        <div id="main">
            <div class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </div>

            <!-- CONTENT START HERE -->
            <div class="page-heading">
                <div style="margin-bottom: 3rem;"></div>
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3><?= str_replace(" | Ruwai Jurai", "", $title) ?></h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/admin/dasbor">Admin</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <?= str_replace(" | Ruwai Jurai", "", $title) ?>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->renderSection('content'); ?>
            <!-- END OF CONTENT -->
        </div>

        <!-- FOOTER -->
        <?= $this->include('Admin/layout/footer'); ?>
        <?= $this->include('Admin/layout/sweetalert'); ?>


    <!-- Script JS -->
    <script src="<?= base_url(); ?>/admin/js/bootstrap.js"></script>
    <script src="<?= base_url(); ?>/admin/js/app.js"></script>
    <!-- Script lainnya -->
</body>

</html>