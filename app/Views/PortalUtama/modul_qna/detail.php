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

                                    <!-- Like Button dan Jumlah Like -->
                                    <div class="text-end">
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
                <form action="/pertanyaan/reply/<?= $pertanyaan['id_pertanyaan']; ?>" method="POST">
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

<!-- JavaScript -->
<script>
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
                credentials: 'same-origin' // Menambahkan cookie sesi ke request
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else if (response.status === 401) {
                    // Kalau status 401 (Unauthorized), berarti belum login
                    alert('Silahkan login terlebih dahulu');
                    window.location.href = '/masuk';
                    return Promise.reject('Not logged in');
                } else {
                    return Promise.reject('Error: ' + response.status);
                }
            })
            .then(data => {
                if (data.success) {
                    // Update UI tanpa reload halaman
                    const likeCount = btn.querySelector('.like-count');
                    likeCount.textContent = data.likes;

                    // Toggle class untuk mengubah tampilan tombol
                    if (data.liked) {
                        btn.classList.remove('btn-outline-primary');
                        btn.classList.add('btn-primary');
                    } else {
                        btn.classList.add('btn-outline-primary');
                        btn.classList.remove('btn-primary');
                    }
                } else {
                    // Tangani pesan error dari server jika ada
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

    /* Style tambahan untuk dropdown pengurutan */
    .dropdown-item.active {
        background-color: #0d6efd;
        color: white;
    }
</style>

<?= $this->include('PortalUtama/layout/sweetalert') ?>
<?= $this->endSection(); ?>