<?php $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script>

    <!-- WRITE CONTENT HERE -->
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <form action="<?= base_url(); ?>/admin/repo/save" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="row mb-3">
                                <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : ''; ?>"
                                           id="judul" name="judul" autofocus value="<?= old('judul'); ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('judul'); ?>
                                    </div>
                                </div>
                            </div>
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
                            <div class="row mb-3">
                                <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                                <div class="col-sm-10">
                                    <select class="form-select <?= ($validation->hasError('kategori')) ? 'is-invalid' : ''; ?>" 
                                            id="kategori" name="kategori" required>
                                        <option value="">Pilih Kategori...</option>
                                        <option value="Pendidikan" <?= (old('kategori') == 'Pendidikan') ? 'selected' : ''; ?>>Pendidikan</option>
                                        <option value="Tanaman Pangan" <?= (old('kategori') == 'Tanaman Pangan') ? 'selected' : ''; ?>>Tanaman Pangan</option>
                                        <option value="Kesehatan" <?= (old('kategori') == 'Kesehatan') ? 'selected' : ''; ?>>Kesehatan</option>
                                        <option value="Sosial Kependudukan" <?= (old('kategori') == 'Sosial Kependudukan') ? 'selected' : ''; ?>>Sosial Kependudukan</option>
                                        <option value="Statistik Sektoral" <?= (old('kategori') == 'Statistik Sektoral') ? 'selected' : ''; ?>>Statistik Sektoral</option>
                                        <option value="Inflasi" <?= (old('kategori') == 'Inflasi') ? 'selected' : ''; ?>>Inflasi</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('kategori'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control <?= ($validation->hasError('deskripsi')) ? 'is-invalid' : ''; ?>" 
                                            id="deskripsi" name="deskripsi" rows="4"><?= old('deskripsi'); ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('deskripsi'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="tgl_upload" class="col-sm-2 col-form-label">Tanggal Upload</label>
                                <div class="col-sm-10">
                                    <input type="datetime-local" class="form-control" id="tgl_upload" name="tgl_upload" 
                                        value="<?= date('Y-m-d\TH:i:s'); ?>" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="file" class="col-sm-2 col-form-label">File</label>
                                <div class="col-sm-2">
                                    <img src="<?= base_url(); ?>/PortalUtama/img/file/default.png" alt=""
                                         class="img-thumbnail img-preview">
                                </div>
                                <div class="col-sm-8">
                                    <input class="form-control <?= ($validation->hasError('file')) ? 'is-invalid' : ''; ?>"
                                           type="file" id="file" name="file" 
                                           accept=".pdf,.doc,.docx,.xls,.xlsx">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('file'); ?>
                                    </div>
                                    <small class="text-muted">File yang diperbolehkan: PDF, Word, Excel. Maksimal ukuran: 2MB</small>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF CONTENT -->

    <script>

        ClassicEditor
            .create(document.querySelector('#deskripsi'))
            .catch(error => {
                console.error(error);
            });


        const fileInput = document.querySelector('#file');
        const imgPreview = document.querySelector('.img-preview');

        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                // Jika file adalah PDF, tampilkan ikon PDF
                if (file.type === 'application/pdf') {
                    imgPreview.src = '<?= base_url(); ?>/PortalUtama/img/file/pdf-icon.png';
                }
                // Jika file adalah Word
                else if (file.type === 'application/msword' || file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                    imgPreview.src = '<?= base_url(); ?>/PortalUtama/img/file/word-icon.png';
                }
                // Jika file adalah Excel
                else if (file.type === 'application/vnd.ms-excel' || file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                    imgPreview.src = '<?= base_url(); ?>/PortalUtama/img/file/excel-icon.png';
                }
            }
        });

         // Update waktu real-time setiap detik
    function updateDateTime() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            
            // Format datetime-local value
            const formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
            document.getElementById('tgl_upload').value = formattedDateTime;
        }

        // Update saat pertama kali halaman dimuat
        updateDateTime();
        
        // Update setiap detik
        setInterval(updateDateTime, 1000);
        </script>

<?php $this->endSection(); ?>