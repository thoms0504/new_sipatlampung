<?= $this->extend("PortalUtama/layout/template"); ?>
<?= $this->section('content'); ?>


<style>
    :root {
        --primary-blue: #2563eb;
        --secondary-blue: #1e40af;
        --light-blue: #dbeafe;
        --gradient-bg: linear-gradient(135deg, #001f4f 0%, #3b82f6 100%);
        --card-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --border-radius: 16px;
    }

    body {
        background: var(--gradient-bg);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .hero-section {
        background: var(--gradient-bg);
        padding: 80px 0 40px;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="rgba(255,255,255,0.1)"><polygon points="0,0 1000,0 1000,100 0,80"/></svg>');
        background-size: cover;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .hero-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 2rem;
    }

    .form-container {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        padding: 2.5rem;
        margin-top: -40px;
        position: relative;
        z-index: 3;
    }

    .form-header {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--light-blue);
    }

    .form-header h3 {
        color: var(--primary-blue);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .form-header p {
        color: #6b7280;
        margin: 0;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        color: var(--primary-blue);
        width: 20px;
    }

    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f9fafb;
    }

    .form-control:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background: white;
    }

    .form-control.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .form-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .invalid-feedback {
        font-size: 0.875rem;
        color: #ef4444;
        margin-top: 0.25rem;
    }

    .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        background: #f9fafb;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .file-upload-area:hover {
        border-color: var(--primary-blue);
        background: #f0f9ff;
    }

    .file-upload-area.dragover {
        border-color: var(--primary-blue);
        background: #f0f9ff;
        transform: scale(1.02);
    }

    .file-upload-icon {
        font-size: 3rem;
        color: var(--primary-blue);
        margin-bottom: 1rem;
    }

    .file-preview {
        background: #f0f9ff;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1rem;
    }

    .file-preview-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .file-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .file-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .btn {
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary {
        background: var(--gradient-bg);
        color: white;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.5);
    }

    .btn-outline-secondary {
        border: 2px solid #d1d5db;
        color: #6b7280;
        background: white;
    }

    .btn-outline-secondary:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }

    .btn-outline-danger {
        border: 1px solid #fecaca;
        color: #dc2626;
        background: white;
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
    }

    .alert {
        border-radius: 12px;
        border: none;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: #ecfdf5;
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    .alert-danger {
        background: #fef2f2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    .progress-bar {
        height: 6px;
        background: #e5e7eb;
        border-radius: 3px;
        overflow: hidden;
        margin-top: 1rem;
    }

    .progress-fill {
        height: 100%;
        background: var(--gradient-bg);
        transition: width 0.3s ease;
    }

    .character-count {
        font-size: 0.875rem;
        color: #6b7280;
        text-align: right;
        margin-top: 0.25rem;
    }

    .required-star {
        color: #ef4444;
        font-weight: bold;
    }

    .floating-elements {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    .floating-circle {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        animation: float 6s ease-in-out infinite;
    }

    .floating-circle:nth-child(1) {
        width: 80px;
        height: 80px;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .floating-circle:nth-child(2) {
        width: 60px;
        height: 60px;
        top: 60%;
        right: 15%;
        animation-delay: 2s;
    }

    .floating-circle:nth-child(3) {
        width: 100px;
        height: 100px;
        bottom: 20%;
        left: 20%;
        animation-delay: 4s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }

        .form-container {
            padding: 1.5rem;
            margin-top: -20px;
        }

        .hero-section {
            padding: 60px 0 20px;
        }
    }
</style>


<div class="bg-section-title"></div>
<section>
    <div class="floating-elements">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

    <div class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Ajukan Pertanyaan</h1>
                <p class="hero-subtitle">Sampaikan pertanyaan Anda kepada BPS Provinsi Lampung</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-8 order-sm-12">
                <div class="form-container">
                    <div class="form-header">
                        <h3><i class="fas fa-question-circle"></i> Form Pertanyaan</h3>
                        <p>Isi form di bawah ini untuk mengajukan pertanyaan Anda</p>
                    </div>

                    <!-- Success Alert -->
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;" id="success-alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <span id="success-message"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>

                    <!-- Error Alert -->
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;" id="error-alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <span id="error-message"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>

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
                            <a href="/pertanyaan" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            <button type="submit" class="btn btn-primary" id="submit-btn">
                                <i class="fas fa-paper-plane me-1"></i> Kirim Pertanyaan
                            </button>
                        </div>
                    </form>
                </div>


                <!-- Form dengan enctype untuk file upload -->
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