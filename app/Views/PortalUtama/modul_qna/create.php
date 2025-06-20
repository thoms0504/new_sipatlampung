<?= $this->extend("PortalUtama/layout/template"); ?>
<?= $this->section('content'); ?>
<div class="bg-section-title"></div>
<section>
    <div class="section-title">
        <h2><?= str_replace(" | Sipat Lampung", "", $title) ?></h2>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-8 order-sm-12">
                
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Form dengan enctype untuk file upload -->
                <form action="/pertanyaan/save" method="POST" enctype="multipart/form-data" id="pertanyaan-form">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Pertanyaan <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?= (isset($validation) && $validation->hasError('judul')) ? 'is-invalid' : ''; ?>" 
                               id="judul" 
                               name="judul" 
                               value="<?= old('judul'); ?>" 
                               placeholder="Masukkan judul pertanyaan (minimal 10 karakter)"
                               required>
                        <?php if (isset($validation) && $validation->hasError('judul')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('judul'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-text">Minimal 10 karakter, maksimal 255 karakter</div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Pertanyaan <span class="text-danger">*</span></label>
                        <textarea class="form-control <?= (isset($validation) && $validation->hasError('deskripsi')) ? 'is-invalid' : ''; ?>" 
                                  id="deskripsi" 
                                  name="deskripsi" 
                                  rows="6" 
                                  placeholder="Jelaskan pertanyaan Anda secara detail (minimal 20 karakter)"
                                  required><?= old('deskripsi'); ?></textarea>
                        <?php if (isset($validation) && $validation->hasError('deskripsi')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('deskripsi'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-text">Minimal 20 karakter</div>
                    </div>

                    <!-- File Upload Section -->
                    <div class="mb-3">
                        <label for="file_attachment" class="form-label">Lampiran File <span class="text-muted">(Opsional)</span></label>
                        <input type="file" 
                               class="form-control <?= (isset($validation) && $validation->hasError('file_attachment')) ? 'is-invalid' : ''; ?>" 
                               id="file_attachment" 
                               name="file_attachment"
                               accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx">
                        <?php if (isset($validation) && $validation->hasError('file_attachment')): ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('file_attachment'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-text">
                            <small>
                                <strong>Format yang didukung:</strong> JPG, JPEG, PNG, GIF, PDF, DOC, DOCX, XLS, XLSX<br>
                                <strong>Ukuran maksimal:</strong> 10MB
                            </small>
                        </div>
                    </div>

                    <!-- Preview untuk file yang dipilih -->
                    <div class="mb-3" id="file-preview" style="display: none;">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">File yang dipilih:</h6>
                                <div id="file-info" class="d-flex align-items-center">
                                    <i class="fas fa-file me-2"></i>
                                    <div>
                                        <div id="file-name" class="fw-bold"></div>
                                        <div id="file-size" class="text-muted small"></div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger ms-auto" onclick="clearFileInput()">
                                        <i class="fas fa-times"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">
                            <span class="text-danger">*</span> Wajib diisi
                        </small>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">  
                        <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary" id="submit-btn">
                            <i class="fas fa-paper-plane me-1"></i> Kirim Pertanyaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript untuk preview file -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file_attachment');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const form = document.getElementById('pertanyaan-form');
    const submitBtn = document.getElementById('submit-btn');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            console.log('File selected:', {
                name: file.name,
                size: file.size,
                type: file.type
            });
            
            // Validasi ukuran file (5MB = 5242880 bytes)
            if (file.size > 5242880) {
                alert('Ukuran file terlalu besar! Maksimal 5MB.');
                clearFileInput();
                return;
            }
            
            // Validasi tipe file - menggunakan extension
            const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx'];
            const fileExtension = file.name.split('.').pop().toLowerCase();
            
            if (!allowedExtensions.includes(fileExtension)) {
                alert('Tipe file tidak didukung! Gunakan format: JPG, JPEG, PNG, GIF, PDF, DOC, DOCX, XLS, XLSX');
                clearFileInput();
                return;
            }
            
            // Tampilkan preview
            filePreview.style.display = 'block';
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            
            // Update icon berdasarkan tipe file
            const fileIcon = document.querySelector('#file-info i');
            if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                fileIcon.className = 'fas fa-image me-2 text-primary';
            } else if (fileExtension === 'pdf') {
                fileIcon.className = 'fas fa-file-pdf me-2 text-danger';
            } else if (['doc', 'docx'].includes(fileExtension)) {
                fileIcon.className = 'fas fa-file-word me-2 text-primary';
            } else if (['xls', 'xlsx'].includes(fileExtension)) {
                fileIcon.className = 'fas fa-file-excel me-2 text-success';
            } else {
                fileIcon.className = 'fas fa-file me-2 text-secondary';
            }
            
        } else {
            filePreview.style.display = 'none';
        }
    });

    // Form submission handler
    form.addEventListener('submit', function(e) {
        // Validasi form sebelum submit
        const judul = document.getElementById('judul').value;
        const deskripsi = document.getElementById('deskripsi').value;
        
        if (judul.length < 10) {
            alert('Judul pertanyaan minimal 10 karakter!');
            e.preventDefault();
            return false;
        }
        
        if (deskripsi.length < 20) {
            alert('Deskripsi pertanyaan minimal 20 karakter!');
            e.preventDefault();
            return false;
        }
        
        // Disable submit button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Mengirim...';
        
        // Log form data for debugging
        const formData = new FormData(form);
        console.log('Form submission data:');
        for (let [key, value] of formData.entries()) {
            if (value instanceof File) {
                console.log(key + ':', {
                    name: value.name,
                    size: value.size,
                    type: value.type
                });
            } else {
                console.log(key + ':', value);
            }
        }
    });

    // Handle form errors - re-enable submit button
    if (document.querySelector('.alert-danger')) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Kirim Pertanyaan';
    }
});

function clearFileInput() {
    document.getElementById('file_attachment').value = '';
    document.getElementById('file-preview').style.display = 'none';
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Reset form
document.querySelector('button[type="reset"]').addEventListener('click', function() {
    clearFileInput();
    // Re-enable submit button
    const submitBtn = document.getElementById('submit-btn');
    submitBtn.disabled = false;
    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Kirim Pertanyaan';
});
</script>

<?= $this->endSection(); ?>