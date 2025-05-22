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

    .form-group input,
    .form-group select {
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
        <!-- Debug: Menampilkan path aktual -->
        <!-- <?= base_url('admin/zoom-monitoring/update/' . $schedule['id']); ?> -->

        <!-- Flash message area -->
        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger">
                <?php foreach (session('errors') as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h2 class="mb-4">Edit Jadwal Zoom</h2>
                        <!-- nama kegiatan -->
                        <form action="<?= site_url('admin/zoom-monitoring/update/' . $schedule['id']); ?>" method="post" id="updateZoomForm">
                            <?= csrf_field(); ?>

                            <!-- Nama Kegiatan -->
                            <div class="row mb-3">
                                <label for="nama_kegiatan" class="col-sm-2 col-form-label">Nama Kegiatan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control <?= session()->has('errors') && isset(session('errors')['nama_kegiatan']) ? 'is-invalid' : ''; ?>"
                                        id="nama_kegiatan" name="nama_kegiatan" autofocus
                                        value="<?= old('nama_kegiatan', $schedule['nama_kegiatan'] ?? ''); ?>">
                                    <?php if (session()->has('errors') && isset(session('errors')['nama_kegiatan'])): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors')['nama_kegiatan']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Tim -->
                            <div class="row mb-3">
                                <label for="tim" class="col-sm-2 col-form-label">Tim</label>
                                <div class="col-sm-10">
                                    <select class="form-select <?= session()->has('errors') && isset(session('errors')['tim']) ? 'is-invalid' : ''; ?>"
                                        id="tim" name="tim">
                                        <option value="">Pilih Tim...</option>
                                        <?php
                                        $teams = ['IPDS', 'Produksi', 'Distribusi', 'Sosial', 'Neraca', 'PPSSDS'];
                                        foreach ($teams as $team):
                                            $selected = old('tim', $schedule['tim'] ?? '') == $team ? 'selected' : '';
                                        ?>
                                            <option value="<?= $team ?>" <?= $selected ?>><?= $team ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (session()->has('errors') && isset(session('errors')['tim'])): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors')['tim']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Tanggal -->
                            <div class="row mb-3">
                                <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control <?= session()->has('errors') && isset(session('errors')['tanggal']) ? 'is-invalid' : ''; ?>"
                                        id="tanggal" name="tanggal"
                                        value="<?= old('tanggal', $schedule['tanggal'] ?? date('Y-m-d')); ?>">
                                    <?php if (session()->has('errors') && isset(session('errors')['tanggal'])): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors')['tanggal']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Jam Mulai -->
                            <div class="row mb-3">
                                <label for="jam_mulai" class="col-sm-2 col-form-label">Jam Mulai</label>
                                <div class="col-sm-10">
                                    <select class="form-select <?= session()->has('errors') && isset(session('errors')['jam_mulai']) ? 'is-invalid' : ''; ?>"
                                        id="jam_mulai" name="jam_mulai">
                                        <option value="">Pilih Jam...</option>
                                        <?php
                                        for ($i = 0; $i < 24; $i++):
                                            // For full hours (XX:00)
                                            $time = sprintf('%02d:00', $i);
                                            $selected = old('jam_mulai', $schedule['jam_mulai'] ?? '') == $time ? 'selected' : '';
                                        ?>
                                            <option value="<?= $time ?>" <?= $selected ?>><?= $time ?></option>
                                            <?php
                                            // For half hours (XX:30)
                                            $time = sprintf('%02d:30', $i);
                                            $selected = old('jam_mulai', $schedule['jam_mulai'] ?? '') == $time ? 'selected' : '';
                                            ?>
                                            <option value="<?= $time ?>" <?= $selected ?>><?= $time ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <?php if (session()->has('errors') && isset(session('errors')['jam_mulai'])): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors')['jam_mulai']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Durasi Jam -->
                            <div class="row mb-3">
                                <label for="durasi_jam" class="col-sm-2 col-form-label">Durasi (Jam)</label>
                                <div class="col-sm-10">
                                    <select class="form-select <?= session()->has('errors') && isset(session('errors')['durasi_jam']) ? 'is-invalid' : ''; ?>"
                                        id="durasi_jam" name="durasi_jam">
                                        <option value="">Pilih Jam...</option>
                                        <?php
                                        for ($i = 1; $i <= 12; $i++):
                                            $selected = old('durasi_jam', $schedule['durasi_jam'] ?? '') == $i ? 'selected' : '';
                                        ?>
                                            <option value="<?= $i ?>" <?= $selected ?>><?= $i ?> jam</option>
                                        <?php endfor; ?>
                                    </select>
                                    <?php if (session()->has('errors') && isset(session('errors')['durasi_jam'])): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors')['durasi_jam']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Durasi Menit -->
                            <div class="row mb-3">
                                <label for="durasi_menit" class="col-sm-2 col-form-label">Durasi (Menit)</label>
                                <div class="col-sm-10">
                                    <select class="form-select <?= session()->has('errors') && isset(session('errors')['durasi_menit']) ? 'is-invalid' : ''; ?>"
                                        id="durasi_menit" name="durasi_menit">
                                        <option value="0">0 menit</option>
                                        <?php
                                        $minutes = [15, 30, 45];
                                        foreach ($minutes as $minute):
                                            $selected = old('durasi_menit', $schedule['durasi_menit'] ?? 0) == $minute ? 'selected' : '';
                                        ?>
                                            <option value="<?= $minute ?>" <?= $selected ?>>
                                                <?= $minute ?> menit
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (session()->has('errors') && isset(session('errors')['durasi_menit'])): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors')['durasi_menit']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Pesan status -->
                            <?php if (session()->has('error')): ?>
                                <div class="alert alert-danger">
                                    <?= session('error'); ?>
                                </div>
                            <?php endif; ?>

                            <div class="row mt-4">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary" id="updateButton">Update</button>
                                    <a href="<?= base_url('admin/zoom-monitoring'); ?>" class="btn btn-secondary">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include JavaScript for Flatpickr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Form initialized');

            // Debug form action
            console.log('Form action:', document.querySelector('form').getAttribute('action'));

            // Debug form submission
            document.querySelector('form').addEventListener('submit', function(e) {
                console.log('Form submitted');
            });
        });

        // Add to the bottom of your edit.php view
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('updateZoomForm');
    
    if (form) {
        console.log('Form URL:', form.action);
        
        form.addEventListener('submit', function(e) {
            // Log submission
            console.log('Form is being submitted to:', this.action);
            console.log('Form method:', this.method);
            
            // Optional: Collect form data for debugging
            const formData = new FormData(this);
            const formValues = {};
            
            for (let [key, value] of formData.entries()) {
                formValues[key] = value;
            }
            
            console.log('Form data:', formValues);
            
            // Allow the form to submit normally
            return true;
        });
    } else {
        console.error('Form with ID "updateZoomForm" not found');
    }
});
    </script>

    <?php $this->endSection(); ?>