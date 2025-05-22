<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script>
<div class="container">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col">
          <form action="/admin/repo/update/<?= $repo['id']; ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <input type="hidden" name="slug" value="<?= $repo['slug']; ?>">
            <input type="hidden" name="fileLama" value="<?= $repo['file']; ?>">
            <div class="row mb-3">
              <label for="judul" class="col-sm-2 col-form-label">Judul</label>
              <div class="col-sm-10">
                <input type="text" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : ''; ?>" id="judul" name="judul" autofocus value="<?= (old('judul')) ? old('judul') : $repo['judul']; ?>">
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
                        <option value="IPDS" <?= (old('tim') ? old('tim') : $repo['tim']) == 'IPDS' ? 'selected' : ''; ?>>IPDS</option>
                        <option value="Produksi" <?= (old('tim') ? old('tim') : $repo['tim']) == 'Produksi' ? 'selected' : ''; ?>>Produksi</option>
                        <option value="Distribusi" <?= (old('tim') ? old('tim') : $repo['tim']) == 'Distribusi' ? 'selected' : ''; ?>>Distribusi</option>
                        <option value="Sosial" <?= (old('tim') ? old('tim') : $repo['tim']) == 'Sosial' ? 'selected' : ''; ?>>Sosial</option>
                        <option value="Neraca" <?= (old('tim') ? old('tim') : $repo['tim']) == 'Neraca' ? 'selected' : ''; ?>>Neraca</option>
                        <option value="PPSSDS" <?= (old('tim') ? old('tim') : $repo['tim']) == 'PPSSDS' ? 'selected' : ''; ?>>PPSSDS</option>
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
                        <option value="Pendidikan" <?= (old('kategori') ? old('kategori') : $repo['kategori']) == 'Pendidikan' ? 'selected' : ''; ?>>Pendidikan</option>
                        <option value="Tanaman Pangan" <?= (old('kategori') ? old('kategori') : $repo['kategori']) == 'Tanaman Pangan' ? 'selected' : ''; ?>>Tanaman Pangan</option>
                        <option value="Kesehatan" <?= (old('kategori') ? old('kategori') : $repo['kategori']) == 'Kesehatan' ? 'selected' : ''; ?>>Kesehatan</option>
                        <option value="Sosial Kependudukan" <?= (old('kategori') ? old('kategori') : $repo['kategori']) == 'Sosial Kependudukan' ? 'selected' : ''; ?>>Sosial Kependudukan</option>
                        <option value="Statistik Sektoral" <?= (old('kategori') ? old('kategori') : $repo['kategori']) == 'Statistik Sektoral' ? 'selected' : ''; ?>>Statistik Sektoral</option>
                        <option value="Inflasi" <?= (old('kategori') ? old('kategori') : $repo['kategori']) == 'Inflasi' ? 'selected' : ''; ?>>Inflasi</option>
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
                            id="deskripsi" name="deskripsi" rows="4"><?= (old('deskripsi')) ? old('deskripsi') : $repo['deskripsi']; ?></textarea>
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
                <div class="col-sm-10">
                    <div class="mb-3">
                        <p class="mb-2">File Saat Ini:</p>
                        <?php
                        // $fileExtension = pathinfo($repo['file'], PATHINFO_EXTENSION);
                        // if (strtolower($fileExtension) === 'pdf') {
                        //     echo '<img src="' . base_url('PortalUtama/img/file/pdf-icon.png') . '" alt="PDF Icon" style="width: 50px;">';
                        // } elseif (in_array(strtolower($fileExtension), ['doc', 'docx'])) {
                        //     echo '<img src="' . base_url('PortalUtama/img/file/word-icon.png') . '" alt="Word Icon" style="width: 50px;">';
                        // } elseif (in_array(strtolower($fileExtension), ['xls', 'xlsx'])) {
                        //     echo '<img src="' . base_url('PortalUtama/img/file/excel-icon.png') . '" alt="Excel Icon" style="width: 50px;">';
                        // }
                        // ?>
                        <div class="row-4 my-3">
                            <?php
                            $fileExtension = pathinfo($repo['file'], PATHINFO_EXTENSION);
                            // Pastikan path file sesuai dengan struktur folder Anda
                            $filePath = base_url('PortalUtama/img/file/' . $repo['file']); 
                            
                            if (strtolower($fileExtension) === 'pdf') {
                                ?>
                                <div class="text-center mb-3">
                                    <div class="mt-3">
                                        <iframe src="<?= $filePath ?>" width="100%" height="800px" style="border: 1px solid #ddd;"></iframe>
                                    </div>
                                </div>
                            <?php } elseif (in_array(strtolower($fileExtension), ['doc', 'docx'])) { ?>
                                <div class="text-center mb-3">
                                    <div class="mt-3">
                                        <a href="<?= $filePath ?>" class="btn btn-primary" download>
                                            <i class="bi bi-download"></i> Download Word Document
                                        </a>
                                    </div>
                                </div>
                            <?php } elseif (in_array(strtolower($fileExtension), ['xls', 'xlsx'])) { ?>
                                <div class="text-center mb-3">
                                    <div class="mt-3">
                                        <a href="<?= $filePath ?>" class="btn btn-primary" download>
                                            <i class="bi bi-download"></i> Download Excel Document
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <strong><span class="ms-2"><?= $repo['judul']; ?></span></strong>
                    </div>
                    <div>
                        <p class="mb-2">Upload File Baru (Optional):</p>
                        <input class="form-control <?= ($validation->hasError('file')) ? 'is-invalid' : ''; ?>" 
                            type="file" id="file" name="file" 
                            accept=".pdf,.doc,.docx,.xls,.xlsx">
                        <div class="invalid-feedback">
                            <?= $validation->getError('file'); ?>
                        </div>
                        <small class="text-muted">File yang diperbolehkan: PDF, Word, Excel. Maksimal ukuran: 2MB</small>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Ubah</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    ClassicEditor
            .create(document.querySelector('#deskripsi'))
            .catch(error => {
                console.error(error);
            });
    
            const fileInput = document.querySelector('#file');
    const previewContainer = document.querySelector('.preview-container');

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const fileName = file.name;
            let iconSrc = '';

            if (file.type === 'application/pdf') {
                iconSrc = '<?= base_url(); ?>/PortalUtama/img/file/pdf-icon.png';
            } else if (file.type === 'application/msword' || file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                iconSrc = '<?= base_url(); ?>/PortalUtama/img/file/word-icon.png';
            } else if (file.type === 'application/vnd.ms-excel' || file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                iconSrc = '<?= base_url(); ?>/PortalUtama/img/file/excel-icon.png';
            }

            // Update preview jika diperlukan
            if (iconSrc) {
                const previewImg = document.createElement('img');
                previewImg.src = iconSrc;
                previewImg.style.width = '50px';
                previewImg.style.marginTop = '10px';
                
                // Hapus preview sebelumnya jika ada
                const existingPreview = document.querySelector('.file-preview');
                if (existingPreview) {
                    existingPreview.remove();
                }

                const previewDiv = document.createElement('div');
                previewDiv.className = 'file-preview mt-2';
                previewDiv.appendChild(previewImg);
                previewDiv.innerHTML += `<span class="ms-2">File baru: ${fileName}</span>`;
                
                fileInput.parentNode.appendChild(previewDiv);
            }
        }
    });
</script>
<script>

<?= $this->endSection('content'); ?>