<?php $this->extend('Admin/layout/template'); ?>
<?= $this->section('content'); ?>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-container {
            max-width: 400px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group .flatpickr-input {
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h2 class="mb-4">Tambah</h2>
                        <!-- nama kegiatan -->
                        <form action="<?= base_url(); ?>admin/zoom-monitoring/create_zoom" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="row mb-3">
                                <label for="nama_kegiatan" class="col-sm-2 col-form-label">Nama Kegiatan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control <?= ($validation->hasError('nama_kegiatan')) ? 'is-invalid' : ''; ?>"
                                           id="nama_kegiatan" name="nama_kegiatan" autofocus value="<?= old('nama_kegiatan'); ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama_kegiatan'); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- tim -->
                            <div class="row mb-3">
                                <label for="tim" class="col-sm-2 col-form-label">Tim</label>
                                <div class="col-sm-10">
                                    <select class="form-select <?= ($validation->hasError('tim')) ? 'is-invalid' : ''; ?>" 
                                            id="tim" name="tim" required>
                                        <option value="">Pilih Tim...</option>
                                        <option value="IPDS" <?= (old('tim') == 'IPDS') ? 'selected' : ''; ?>>IPDS</option>
                                        <option value="Produksi" <?= (old('tim') == 'Produksi') ? 'selected' : ''; ?>>Produksi</option>
                                        <option value="Distribusi" <?= (old('tim') == 'Distribusi') ? 'selected' : ''; ?>>Distribusi</option>
                                        <option value="Sosial" <?= (old('tim') == 'Sosial') ? 'selected' : ''; ?>>Sosial</option>
                                        <option value="Neraca" <?= (old('tim') == 'Neraca') ? 'selected' : ''; ?>>Neraca</option>
                                        <option value="PPSSDS" <?= (old('tim') == 'PPSSDS') ? 'selected' : ''; ?>>PPSSDS</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('tim'); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- kapan -->
                            <div class="row mb-3">
                                <label for="tim" class="col-sm-2 col-form-label">Tanggal</label>
                                <div class="col-sm-10">
                                    <input type="date" class="flatpickr-input <?= ($validation->hasError('tanggal')) ? 'is-invalid' : ''; ?>"
                                           id="tanggal" name="tanggal" autofocus value="<?= old('tanggal') ?? $_GET['date'] ?? date('Y-m-d') ?>" required>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('tanggal'); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- jam berapa -->
                            <div class="row mb-3">
                                <label for="tim" class="col-sm-2 col-form-label">Jam Mulai</label>
                                <div class="col-sm-10">
                                    <select class="form-select <?= ($validation->hasError('jam_mulai')) ? 'is-invalid' : ''; ?>" 
                                            id="jam_mulai" name="jam_mulai" required>
                                        <option value="">Pilih Jam...</option>
                                        <?php for ($i = 0; $i < 24; $i++): ?>
                                            <option value="<?= sprintf('%02d:00', $i) ?>" <?= (old('jam_mulai') == sprintf('%02d:00', $i)) ? 'selected' : ''; ?>><?= sprintf('%02d:00', $i) ?></option>
                                            <option value="<?= sprintf('%02d:30', $i) ?>" <?= (old('jam_mulai') == sprintf('%02d:30', $i)) ? 'selected' : ''; ?>><?= sprintf('%02d:30', $i) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jam_mulai'); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Durasi Jam -->
                            <div class="row mb-3">
                                <label for="tim" class="col-sm-2 col-form-label">Durasi (Jam)</label>
                                <div class="col-sm-10">
                                    <select class="form-select <?= ($validation->hasError('durasi_jam')) ? 'is-invalid' : ''; ?>" 
                                            id="durasi_jam" name="durasi_jam" required>
                                        <option value="">Pilih Jam...</option>
                                        <?php for ($i = 1; $i <= 12; $i++): ?>
                                            <option value="<?= $i ?>" <?= (old('durasi_jam') == $i) ? 'selected' : ''; ?>><?= $i ?> jam</option>
                                        <?php endfor; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('durasi_jam'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="tim" class="col-sm-2 col-form-label">Durasi (Menit)</label>
                                <div class="col-sm-10">
                                    <select class="form-select <?= ($validation->hasError('duration_minute')) ? 'is-invalid' : ''; ?>" 
                                            id="duration_minute" name="duration_minute" required>
                                        <option value="">Pilih Menit...</option>
                                        <?php 
                                            $minutes = [0, 15, 30, 45]; 
                                            foreach ($minutes as $minute): 
                                        ?>
                                            <option value="<?= $minute ?>" <?= (old('duration_minute') == $minute) ? 'selected' : ''; ?>>
                                                <?= $minute ?> menit
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('duration_minute'); ?>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include JavaScript for Flatpickr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <!-- <script>
        // Initialize Flatpickr for date input
        flatpickr("#date", {
            dateFormat: "Y-m-d", // Format tanggal
            minDate: "2025-01-01", // Tanggal minimal
            defaultDate: "2025-01-01", // Tanggal default
        });
    </script> -->

<?php $this->endSection(); ?>