<?= $this->extend('PortalUtama/layout/template'); ?>
<?= $this->section('content'); ?>

<div class="bg-section-title"></div>
<div class="container">
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata("pesan")) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata("pesan"); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata("errors")) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php foreach (session()->getFlashdata("errors") as $error) : ?>
                <p class="mb-0"><?= $error ?></p>
            <?php endforeach; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <section>
        <div class="section-title">
            <h2><?= str_replace(" | Sipat Lampung", "", $title) ?></h2>
        </div>

        <!-- Card Pertanyaan -->
        <div class="card mt-3 shadow rounded-4 p-4">
            <!-- Info Penanya -->
            <div class="row ps-3 mb-3 align-items-center">
                <div class="col-auto">
                    <img class="rounded-circle"
                        src="<?= ($penanya['avatar'] != '') ? $penanya['avatar'] : base_url('admin/img/users/default.png') ?>"
                        style="height: 50px; width: 50px; object-fit: cover;">
                </div>
                <div class="col">
                    <p class="fw-bolder mb-0 fs-5"><?= esc($penanya['nama_lengkap']); ?></p>
                    <small class="text-muted">
                        Diperbarui pada <?= date("d M Y H:i", strtotime($pertanyaan['updated_at'])); ?>
                    </small>
                </div>
            </div>

            <!-- Konten Pertanyaan -->
            <h2 class="mb-3"><?= esc($pertanyaan['judul']); ?></h2>
            <div class="fs-6 pt-2"><?= $pertanyaan['deskripsi']; ?></div>

            <!-- File Lampiran Pertanyaan -->
            <?php if (!empty($pertanyaan['file_attachment'])) : ?>
                <?php
                $file = $pertanyaan['file_attachment'];
                $fileExt = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                $isPdf = $fileExt === 'pdf';
                ?>
                <div class="mt-4">
                    <h6 class="fw-bold text-muted mb-3">
                        <i class="fas fa-paperclip me-2"></i>File Lampiran
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-4">
                            <div class="card file-attachment">
                                <div class="card-body p-3">
                                    <?php if ($isImage) : ?>
                                        <div class="text-center mb-2">
                                            <img src="<?= base_url('uploads/pertanyaan/' . $file) ?>"
                                                class="img-thumbnail preview-image"
                                                style="max-height: 120px; cursor: pointer;"
                                                onclick="openImageModal('<?= base_url('uploads/pertanyaan/' . $file) ?>', '<?= esc($file) ?>')">
                                        </div>
                                    <?php elseif ($isPdf) : ?>
                                        <div class="text-center mb-2">
                                            <i class="fas fa-file-pdf text-danger" style="font-size: 3rem;"></i>
                                        </div>
                                    <?php else : ?>
                                        <div class="text-center mb-2">
                                            <i class="fas fa-file text-secondary" style="font-size: 3rem;"></i>
                                        </div>
                                    <?php endif; ?>

                                    <div class="text-center">
                                        <small class="text-muted d-block mb-2" title="<?= esc($file) ?>">
                                            <?= strlen($file) > 25 ? substr($file, 0, 25) . '...' : $file ?>
                                        </small>
                                    </div>

                                    <div class="d-flex gap-1 mt-2">
                                        <a href="<?= base_url('uploads/pertanyaan/' . $file) ?>"
                                            class="btn btn-outline-primary btn-sm flex-fill"
                                            target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('pertanyaan/download/' . $pertanyaan['id_pertanyaan']) ?>"
                                            class="btn btn-outline-success btn-sm flex-fill">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Tombol Edit & Hapus untuk pemilik pertanyaan -->
            <?php if (isset($_SESSION['id']) && $owner) : ?>
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="/pertanyaan/edit/<?= $pertanyaan['id_pertanyaan']; ?>"
                        class="btn btn-primary" style="width: 80px">Edit</a>
                    <form name="actionDelete2_Pertanyaan<?= $pertanyaan['id_pertanyaan']; ?>"
                        action="/pertanyaan/<?= $pertanyaan['id_pertanyaan']; ?>" method="post">
                        <input type="hidden" name="_method" value="DELETE">
                        <?= csrf_field() ?>
                        <button type="button"
                            onclick="confirmDelete(<?= $pertanyaan['id_pertanyaan']; ?>, 'Pertanyaan', '<?= esc($pertanyaan['judul']); ?>')"
                            class="btn btn-danger" style="width: 80px">Hapus</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <!-- Daftar Jawaban -->
        <div class="card py-3 my-4 shadow rounded-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    Semua Jawaban
                    <span class="badge bg-secondary ms-2"><?= count($jawaban) ?></span>
                </h5>

                <!-- Dropdown untuk mengurutkan jawaban -->
                <div class="col-md-6 text-right">
                    <div class="dropdown float-right">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="sortDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= ($sort == 'most_liked') ? 'Like Terbanyak' : 'Terbaru' ?>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="sortDropdown">
                            <a class="dropdown-item <?= ($sort == 'newest') ? 'active' : '' ?>"
                                href="<?= base_url('pertanyaan/' . $pertanyaan['id_pertanyaan'] . '?sort=newest') ?>">Terbaru</a>
                            <a class="dropdown-item <?= ($sort == 'most_liked') ? 'active' : '' ?>"
                                href="<?= base_url('pertanyaan/' . $pertanyaan['id_pertanyaan'] . '?sort=most_liked') ?>">Like Terbanyak</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (empty($jawaban)) : ?>
                <div class="card-body text-center py-5">
                    <i class="fas fa-comments text-muted mb-3" style="font-size: 3rem;"></i>
                    <h5 class="text-muted">Belum ada jawaban</h5>
                </div>
            <?php else : ?>
                <?php foreach ($jawaban as $j) : ?>
                    <div class="border-bottom">
                        <div class="px-4 pt-3 pb-2">
                            <div class="d-flex">
                                <img class="rounded-circle me-3"
                                    src="<?= ($j['avatar'] != '') ? $j['avatar'] : base_url('admin/img/users/default.png') ?>"
                                    style="height: 40px; width: 40px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <!-- Header Jawaban -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1"><?= esc($j['nama_lengkap']) ?></h6>
                                            <small class="text-muted">
                                                <?= date("d M Y H:i", strtotime($j['created_at'])); ?>
                                            </small>
                                        </div>
                                        <?php if (isset($_SESSION['id']) && $_SESSION['id'] == $j['id_penjawab']) : ?>
                                            <div class="btn-group">
                                                <a href="/jawaban/edit/<?= $j['id_jawaban']; ?>"
                                                    class="btn btn-sm btn-outline-primary">Edit</a>
                                                <form name="actionDelete2_Jawaban<?= $j['id_jawaban']; ?>"
                                                    action="/jawaban/<?= $j['id_jawaban']; ?>" method="post" class="d-inline">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <?= csrf_field() ?>
                                                    <button type="button"
                                                        onclick="confirmDelete(<?= $j['id_jawaban']; ?>, 'Jawaban', '<?= substr(strip_tags($j['isi']), 0, 30) . '...'; ?>')"
                                                        class="btn btn-sm btn-outline-danger">Hapus</button>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Isi Jawaban -->
                                    <div class="my-3"><?= $j['isi'] ?></div>

                                    <!-- File Lampiran Jawaban -->
                                    <?php if (!empty($j['files'])) : ?>
                                        <div class="mt-3">
                                            <small class="text-muted mb-2 d-block">
                                                <i class="fas fa-paperclip me-1"></i>File Lampiran
                                            </small>
                                            <div class="row g-2">
                                                <?php foreach ($j['files'] as $file) : ?>
                                                    <div class="col-md-4 col-lg-3">
                                                        <div class="card file-attachment-small">
                                                            <div class="card-body p-2">
                                                                <?php
                                                                $fileExt = strtolower(pathinfo($file['nama_file'], PATHINFO_EXTENSION));
                                                                $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                                ?>

                                                                <?php if ($isImage) : ?>
                                                                    <div class="text-center mb-1">
                                                                        <img src="<?= base_url('uploads/jawaban/' . $file['nama_file']) ?>"
                                                                            class="img-thumbnail preview-image-small"
                                                                            style="max-height: 60px; cursor: pointer;"
                                                                            onclick="openImageModal('<?= base_url('uploads/jawaban/' . $file['nama_file']) ?>', '<?= esc($file['nama_asli']) ?>')">
                                                                    </div>
                                                                <?php else : ?>
                                                                    <div class="text-center mb-1">
                                                                        <i class="fas fa-file text-secondary" style="font-size: 1.5rem;"></i>
                                                                    </div>
                                                                <?php endif; ?>

                                                                <div class="text-center">
                                                                    <small class="text-muted d-block" style="font-size: 0.7rem;" title="<?= esc($file['nama_asli']) ?>">
                                                                        <?= strlen($file['nama_asli']) > 15 ? substr($file['nama_asli'], 0, 15) . '...' : $file['nama_asli'] ?>
                                                                    </small>
                                                                </div>

                                                                <div class="d-flex gap-1 mt-1">
                                                                    <a href="<?= base_url('uploads/jawaban/' . $file['nama_file']) ?>"
                                                                        class="btn btn-outline-primary btn-sm flex-fill py-0"
                                                                        target="_blank" style="font-size: 0.7rem;">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="<?= base_url('jawaban/download/' . $file['id_file']) ?>"
                                                                        class="btn btn-outline-success btn-sm flex-fill py-0" style="font-size: 0.7rem;">
                                                                        <i class="fas fa-download"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Like Button dan Jumlah Like -->
                                    <div class="text-end mt-3">
                                        <button onclick="likeJawaban(<?= $j['id_jawaban'] ?>)"
                                            class="btn btn-sm <?= ($j['has_liked'] ?? false) ? 'btn-primary' : 'btn-outline-primary' ?>">
                                            <i class="fas fa-thumbs-up"></i>
                                            <span class="like-count"><?= $j['likes'] ?></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Form Jawaban -->
        <?php if (isset($_SESSION['id'])): ?>
            <div class="card p-4 my-2 shadow rounded-4">
                <form action="/pertanyaan/reply/<?= $pertanyaan['id_pertanyaan']; ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Tambahkan Jawaban</h4>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="togglePreview()">
                            Preview
                        </button>
                    </div>

                    <div id="editor-container">
                        <textarea class="form-control <?= ($validation->hasError('isi')) ? 'is-invalid' : ''; ?>"
                            id="isi" name="isi" rows="5" required><?= old('isi') ?></textarea>
                        <div class="invalid-feedback">
                            <?= $validation->getError('isi'); ?>
                        </div>
                    </div>

                    <div id="preview-container" class="d-none">
                        <div class="border rounded p-3 mb-3" id="preview-content"></div>
                    </div>

                    <!-- File Upload Section -->
                    <div class="mt-3">
                        <label class="form-label text-muted">
                            <i class="fas fa-paperclip me-1"></i>Lampiran File (Opsional)
                        </label>
                        <div class="file-upload-area border-2 border-dashed rounded p-3" id="fileUploadArea">
                            <div class="text-center text-muted">
                                <i class="fas fa-cloud-upload-alt mb-2" style="font-size: 2rem;"></i>
                                <p class="mb-2">Klik untuk memilih file atau drag & drop</p>
                                <small>Maksimal 5 file, ukuran masing-masing file maksimal 10MB</small>
                                <small class="d-block">Format yang didukung: JPG, PNG, PDF, DOC, DOCX, XLS, XLSX</small>
                            </div>
                            <input type="file" class="form-control d-none" id="fileInput" name="files[]" multiple
                                accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.xls,.xlsx">
                        </div>

                        <!-- Preview Files -->
                        <div id="filePreview" class="mt-3 d-none">
                            <label class="form-label text-muted">File yang akan diupload:</label>
                            <div id="fileList" class="row g-2"></div>
                        </div>

                        <?php if ($validation->hasError('files')) : ?>
                            <div class="text-danger small mt-1">
                                <?= $validation->getError('files'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Jawaban
                        </button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="card p-4 my-2 shadow rounded-4 text-center">
                <p class="mb-3">Silahkan login terlebih dahulu untuk memberikan jawaban</p>
                <a href="/masuk" class="btn btn-primary">Login untuk Menjawab</a>
            </div>
        <?php endif; ?>
    </section>
</div>

<!-- Modal untuk Preview Gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Preview Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Preview">
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    // File Upload Handler
    const fileUploadArea = document.getElementById('fileUploadArea');
    const fileInput = document.getElementById('fileInput');
    const filePreview = document.getElementById('filePreview');
    const fileList = document.getElementById('fileList');
    let selectedFiles = [];

    // Click to select files
    fileUploadArea.addEventListener('click', () => {
        fileInput.click();
    });

    // Drag and drop handlers
    fileUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        fileUploadArea.classList.add('border-primary', 'bg-light');
    });

    fileUploadArea.addEventListener('dragleave', (e) => {
        e.preventDefault();
        fileUploadArea.classList.remove('border-primary', 'bg-light');
    });

    fileUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        fileUploadArea.classList.remove('border-primary', 'bg-light');
        const files = Array.from(e.dataTransfer.files);
        handleFiles(files);
    });

    // File input change handler
    fileInput.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);
        handleFiles(files);
    });

    function handleFiles(files) {
        // Validasi jumlah file
        if (selectedFiles.length + files.length > 5) {
            alert('Maksimal 5 file yang dapat diupload');
            return;
        }

        // Validasi ukuran dan format file
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'application/pdf',
            'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];
        const maxSize = 10 * 1024 * 1024; // 10MB

        for (let file of files) {
            if (!allowedTypes.includes(file.type)) {
                alert(`Format file ${file.name} tidak didukung`);
                continue;
            }
            if (file.size > maxSize) {
                alert(`Ukuran file ${file.name} terlalu besar (maksimal 10MB)`);
                continue;
            }
            selectedFiles.push(file);
        }

        updateFilePreview();
    }

    function updateFilePreview() {
        if (selectedFiles.length === 0) {
            filePreview.classList.add('d-none');
            return;
        }

        filePreview.classList.remove('d-none');
        fileList.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'col-md-4 col-lg-3';

            const isImage = file.type.startsWith('image/');
            const icon = isImage ? 'fa-image' : (file.type.includes('pdf') ? 'fa-file-pdf' : 'fa-file');
            const iconColor = isImage ? 'text-primary' : (file.type.includes('pdf') ? 'text-danger' : 'text-secondary');

            fileItem.innerHTML = `
                <div class="card file-preview-item">
                    <div class="card-body p-2 text-center">
                        <div class="position-relative">
                            <i class="fas ${icon} ${iconColor} mb-2" style="font-size: 2rem;"></i>
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" 
                                    onclick="removeFile(${index})" style="transform: translate(50%, -50%);">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <small class="text-muted d-block" title="${file.name}">
                            ${file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name}
                        </small>
                        <small class="text-muted">
                            ${formatFileSize(file.size)}
                        </small>
                    </div>
                </div>
            `;

            fileList.appendChild(fileItem);
        });

        // Update file input
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
    }

    function removeFile(index) {
        selectedFiles.splice(index, 1);
        updateFilePreview();
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Modal Image Preview
    function openImageModal(src, title) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModalLabel').textContent = title;
        new bootstrap.Modal(document.getElementById('imageModal')).show();
    }

    // Existing functions
    function likeJawaban(id_jawaban) {
        const btn = event.currentTarget;
        btn.disabled = true;

        fetch(`/pertanyaan/like/${id_jawaban}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else if (response.status === 401) {
                    alert('Silahkan login terlebih dahulu');
                    window.location.href = '/masuk';
                    return Promise.reject('Not logged in');
                } else {
                    return Promise.reject('Error: ' + response.status);
                }
            })
            .then(data => {
                if (data.success) {
                    const likeCount = btn.querySelector('.like-count');
                    likeCount.textContent = data.likes;

                    if (data.liked) {
                        btn.classList.remove('btn-outline-primary');
                        btn.classList.add('btn-primary');
                    } else {
                        btn.classList.add('btn-outline-primary');
                        btn.classList.remove('btn-primary');
                    }
                } else {
                    alert(data.message || 'Terjadi kesalahan saat menyukai jawaban');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (error !== 'Not logged in') {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            })
            .finally(() => {
                btn.disabled = false;
            });
    }

    function confirmDelete(id, type, title) {
        Swal.fire({
            title: `Hapus ${type}?`,
            text: `Anda yakin ingin menghapus ${type.toLowerCase()} "${title}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector(`form[name="actionDelete2_${type}${id}"]`).submit();
            }
        });
    }

    function togglePreview() {
        const editorContainer = document.getElementById('editor-container');
        const previewContainer = document.getElementById('preview-container');
        const previewContent = document.getElementById('preview-content');
        const textarea = document.getElementById('isi');

        if (editorContainer.classList.contains('d-none')) {
            editorContainer.classList.remove('d-none');
            previewContainer.classList.add('d-none');
        } else {
            previewContent.innerHTML = textarea.value;
            editorContainer.classList.add('d-none');
            previewContainer.classList.remove('d-none');
        }
    }

    function sortAnswers(sort) {
        const url = new URL(window.location);
        url.searchParams.set('sort', sort);
        window.location = url;
    }
</script>

<style>
    .auto-resize {
        min-height: 100px;
        resize: vertical;
    }

    .card {
        border: none;
    }

    .btn-group .btn {
        border-radius: 4px;
        margin: 0 2px;
    }

    .dropdown-item.active {
        background-color: #0d6efd;
        color: white;
    }

    /* File Attachment Styles */
    .file-attachment {
        border: 1px solid #e0e0e0;
        transition: all 0.2s ease;
    }

    .file-attachment:hover {
        border-color: #0d6efd;
        box-shadow: 0 2px 8px rgba(13, 110, 253, 0.15);
    }

    .file-attachment-small {
        border: 1px solid #e0e0e0;
        font-size: 0.8rem;
    }

    .preview-image,
    .preview-image-small {
        transition: transform 0.2s ease;
    }

    .preview-image:hover,
    .preview-image-small:hover {
        transform: scale(1.05);
    }

    /* File Upload Area */
    .file-upload-area {
        cursor: pointer;
        transition: all 0.2s ease;
        min-height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-color: #dee2e6 !important;
    }

    .file-upload-area:hover {
        border-color: #0d6efd !important;
        background-color: #f8f9fa;
    }

    .file-upload-area.border-primary {
        border-color: #0d6efd !important;
    }

    /* File Preview Items */
    .file-preview-item {
        border: 1px solid #e0e0e0;
        height: 120px;
    }

    .file-preview-item .card-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {

        .file-attachment,
        .file-attachment-small {
            margin-bottom: 1rem;
        }

        .btn-group {
            flex-direction: column;
            gap: 0.25rem;
        }

        .btn-group .btn {
            margin: 0;
        }
    }

    /* Loading state for like button */
    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>

<?= $this->include('PortalUtama/layout/sweetalert') ?>
<?= $this->endSection(); ?>