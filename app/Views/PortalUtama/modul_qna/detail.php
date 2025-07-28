<?= $this->extend('PortalUtama/layout/template'); ?>
<?= $this->section('content'); ?>


<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --hashtag-gradient: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        --card-hover-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        --border-radius: 20px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
        transition: var(--transition);
    }

    body {
        background: linear-gradient(360deg, #667eea 10%, #001f4f 90%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .bg-section-title {

        position: relative;
        overflow: hidden;
    }



    @keyframes float {
        0% {
            transform: translateX(0) translateY(0);
        }

        100% {
            transform: translateX(-50px) translateY(-50px);
        }
    }

    .container {
        margin-top: 1rem;
    }

    /* Alert Animations */
    .alert {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        animation: slideInDown 0.5s ease-out;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: var(--warning-gradient);
        color: white;
        border-left: 5px solid #00f2fe;
    }

    .alert-danger {
        background: var(--secondary-gradient);
        color: white;
        border-left: 5px solid #f5576c;
    }

    /* Header Section */
    .header-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: var(--primary-gradient);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 500;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .back-btn:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
    }

    .breadcrumb {
        background: none;
        padding: 0;
        margin: 1rem 0 0 0;
    }

    .breadcrumb-item a {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb-item.active {
        color: #764ba2;
        font-weight: 600;
    }

    .page-title {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 800;
        font-size: 2.5rem;
        margin: 1rem 0 0 0;
        text-align: center;
    }

    /* Question Card */
    .question-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: var(--transition);
    }

    .question-card:hover {
        box-shadow: var(--card-hover-shadow);
        transform: translateY(-5px);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: rgba(102, 126, 234, 0.05);
        border-radius: 15px;
        border-left: 4px solid #667eea;
    }

    .user-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #667eea;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .user-details h6 {
        margin: 0;
        font-weight: 600;
        color: #333;
    }

    .user-details small {
        color: #666;
        font-weight: 500;
    }

    .question-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1rem;
        line-height: 1.4;
    }

    .question-hashtags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .question-hashtag {
        padding: 0.25rem 0.75rem;
        background: var(--hashtag-gradient);
        color: white;
        text-decoration: none;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .question-hashtag:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .question-content {
        font-size: 1.1rem;
        line-height: 1.6;
        color: #444;
        margin-bottom: 1.5rem;
    }

    /* Enhanced Buttons */
    .btn {
        border-radius: 50px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: var(--transition);
        border: none;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transition: var(--transition);
        transform: translate(-50%, -50%);
    }

    .btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-primary {
        background: var(--primary-gradient);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
    }

    .btn-outline-primary {
        border: 2px solid #667eea;
        color: #667eea;
        background: transparent;
    }

    .btn-outline-primary:hover {
        background: var(--primary-gradient);
        border-color: transparent;
        color: white;
        transform: translateY(-2px);
    }

    .btn-danger {
        background: var(--secondary-gradient);
        box-shadow: 0 4px 15px rgba(245, 87, 108, 0.4);
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(245, 87, 108, 0.6);
    }

    .btn-success {
        background: var(--success-gradient);
        box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 172, 254, 0.6);
    }

    /* File Attachment */
    .file-attachment {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .file-attachment:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .preview-image {
        border-radius: 10px;
        transition: var(--transition);
    }

    .preview-image:hover {
        transform: scale(1.05);
    }

    /* Answers Section */
    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        transition: var(--transition);
    }

    .card:hover {
        box-shadow: var(--card-hover-shadow);
    }

    .card-header {
        border-bottom: 1px solid rgba(102, 126, 234, 0.2);
        padding: 1.5rem;
    }

    .badge {
        background: var(--primary-gradient);
        border-radius: 20px;
        padding: 0.5rem 1rem;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .dropdown-toggle {
        background: var(--primary-gradient);
        border: none;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .dropdown-toggle:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
    }

    .dropdown-menu {
        border: none;
        border-radius: 15px;
        box-shadow: var(--card-shadow);
        backdrop-filter: blur(20px);
        background: rgba(255, 255, 255, 0.95);
    }

    .dropdown-item {
        border-radius: 10px;
        margin: 0.25rem;
        transition: var(--transition);
    }

    .dropdown-item:hover {
        background: var(--primary-gradient);
        color: white;
        transform: translateX(5px);
    }

    .dropdown-item.active {
        background: var(--primary-gradient);
        color: white;
    }

    /* Answers Container */
    .answers-container {
        max-height: 800px;
        overflow-y: auto;
        overflow-x: hidden;
        scrollbar-width: thin;
        scrollbar-color: #667eea rgba(102, 126, 234, 0.2);
    }

    .answers-container::-webkit-scrollbar {
        width: 8px;
    }

    .answers-container::-webkit-scrollbar-track {
        background: rgba(102, 126, 234, 0.1);
        border-radius: 10px;
    }

    .answers-container::-webkit-scrollbar-thumb {
        background: var(--primary-gradient);
        border-radius: 10px;
    }

    .answers-container::-webkit-scrollbar-thumb:hover {
        background: #764ba2;
    }

    .border-bottom {
        border-bottom: 1px solid rgba(102, 126, 234, 0.1) !important;
        transition: var(--transition);
    }

    .border-bottom:hover {
        background: rgba(102, 126, 234, 0.02);
        transform: translateX(5px);
    }

    /* Form Styling */
    .form-control {
        border: 2px solid rgba(102, 126, 234, 0.2);
        border-radius: 15px;
        padding: 1rem;
        transition: var(--transition);
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        transform: translateY(-2px);
    }

    /* File Upload Area */
    .file-upload-area {
        border-radius: 15px;
        transition: var(--transition);
        cursor: pointer;
    }

    .file-upload-area:hover {
        border-color: #667eea !important;
        background: rgba(102, 126, 234, 0.05);
        transform: translateY(-2px);
    }

    .file-preview-item {
        border: none;
        border-radius: 15px;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .file-preview-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    /* Modal Styling */
    .modal-content {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        backdrop-filter: blur(20px);
        background: rgba(255, 255, 255, 0.95);
    }

    .modal-header {
        border-bottom: 1px solid rgba(102, 126, 234, 0.2);
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            margin-top: -50px;
            padding: 1rem;
        }

        .page-title {
            font-size: 2rem;
        }

        .question-card,
        .header-section {
            padding: 1.5rem;
        }

        .user-info {
            flex-direction: column;
            text-align: center;
        }

        .question-hashtags {
            justify-content: center;
        }
    }

    /* Loading Animation */
    .loading {
        position: relative;
        pointer-events: none;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top: 2px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        transform: translate(-50%, -50%);
    }

    @keyframes spin {
        0% {
            transform: translate(-50%, -50%) rotate(0deg);
        }

        100% {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }

    /* Hover Effects for Interactive Elements */
    .user-avatar:hover {
        transform: scale(1.1) rotate(5deg);
    }

    .question-card .btn:hover {
        transform: translateY(-3px) scale(1.05);
    }

    /* Enhanced Typography */
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-weight: 700;
        letter-spacing: -0.02em;
    }

    p {
        line-height: 1.6;
        color: #555;
    }

    /* Glassmorphism Effects */
    .glass {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    /* Micro-interactions */
    .clickable {
        cursor: pointer;
        user-select: none;
    }

    .clickable:active {
        transform: scale(0.98);
    }
</style>

<div class="bg-section-title"></div>
<form id="csrf-form" style="display: none;">
    <?= csrf_field() ?>
</form>
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

    <!-- Header Section -->
    <div class="header-section">
        <div class="breadcrumb-nav">
            <a href="<?= base_url('pertanyaan') ?>" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('pertanyaan') ?>">Pertanyaan</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= strlen($pertanyaan['judul']) > 30 ? substr($pertanyaan['judul'], 0, 30) . '...' : $pertanyaan['judul'] ?>
                    </li>
                </ol>
            </nav>
        </div>
        <h1 class="page-title">PERTANYAAN</h1>
    </div>

    <section>
        <!-- Card Pertanyaan -->
        <div class="question-card">
            <!-- Info Penanya -->
            <div class="user-info">
                <img class="user-avatar"
                    src="<?= ($penanya['avatar'] != '') ? $penanya['avatar'] : base_url('PortalUtama/img/users/default.png') ?>"
                    alt="Avatar">
                <div class="user-details">
                    <h6><?= esc($penanya['nama_lengkap']); ?></h6>
                    <small>Diperbarui pada <?= date("d M Y H:i", strtotime($pertanyaan['updated_at'])); ?></small>
                </div>
            </div>

            <!-- Konten Pertanyaan -->
            <h2 class="question-title"><?= esc($pertanyaan['judul']); ?></h2>
            <?php if (!empty($pertanyaan['hashtags'])): ?>
                <?php
                $hashtags = json_decode($pertanyaan['hashtags'], true);
                if (is_array($hashtags) && !empty($hashtags)):
                ?>
                    <div class="question-hashtags">
                        <?php foreach ($hashtags as $tag): ?>
                            <a href="#" class="question-hashtag">#<?= $tag ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <div class="question-content"><?= $pertanyaan['deskripsi']; ?></div>

            <!-- Tombol Report Like Button dan Jumlah Like Pertanyaan bersebelahan di ujung kanan-->
            <div class="d-flex justify-content-end">
                <button class="btn btn-outline-danger me-2" onclick="showReportPertanyaanModal(<?= $pertanyaan['id_pertanyaan'] ?>)">
                    <i class="fas fa-flag"></i> Laporkan
                </button>
                <button onclick="likePertanyaan(<?= $pertanyaan['id_pertanyaan'] ?>)"
                    class="btn btn-sm <?= ($pertanyaanlike['has_liked'] ?? false) ? 'btn-primary' : 'btn-outline-primary' ?>">
                    <i class="fas fa-thumbs-up"></i>
                    <span class="like-count-pertanyaan"><?= $pertanyaan['likes'] ?></span>
                </button>
            </div>

            <!-- Modal untuk gambar besar -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">Gambar Besar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img id="modalImage" src="" class="img-fluid" alt="Gambar Besar">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <a id="downloadLink" href="" class="btn btn-primary" download>Unduh Gambar</a>
                        </div>
                    </div>
                </div>
            </div>

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
            <div class="container d-flex justify-content-end mt-3">
                <a href="/pertanyaan/edit/<?= $pertanyaan['id_pertanyaan']; ?>" class="btn btn-primary me-1" style="width: 80px">Edit</a>
                <form name="actionDelete2_Pertanyaan<?= $pertanyaan['id_pertanyaan']; ?>" onclick="destroy2(<?= $pertanyaan['id_pertanyaan']; ?>,'Pertanyaan','<?= $pertanyaan['judul']; ?>')" action="/pertanyaan/<?= $pertanyaan['id_pertanyaan']; ?>" method="post">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="btn btn-danger" style="width: 80px">
                        Hapus
                    </button>
                </form>
            </div>
        </div>



        <!-- Daftar Jawaban dengan Scroll -->
        <div class="card py-3 my-4 shadow rounded-4 w-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    Semua Jawaban
                    <span class="badge bg-secondary ms-2"><?= count($jawaban) ?></span>
                </h5>

                <!-- Dropdown untuk mengurutkan jawaban -->
                <div class="col-md-6 text-end">
                    <div class="dropdown ms-auto">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= ($sort == 'most_liked') ? 'Like Terbanyak' : 'Terbaru' ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                            <li><a class="dropdown-item <?= ($sort == 'newest') ? 'active' : '' ?>"
                                    href="<?= base_url('pertanyaan/' . $pertanyaan['id_pertanyaan'] . '?sort=newest') ?>">Terbaru</a></li>
                            <li><a class="dropdown-item <?= ($sort == 'most_liked') ? 'active' : '' ?>"
                                    href="<?= base_url('pertanyaan/' . $pertanyaan['id_pertanyaan'] . '?sort=most_liked') ?>">Like Terbanyak</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Container dengan scroll untuk daftar jawaban -->
            <div class="answers-container">
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
                                                    <!-- <a href="/jawaban/edit/<?= $j['id_jawaban']; ?>"
                                                        class="btn btn-sm btn-outline-primary">Edit</a> -->
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
                                        <?php if (!empty($j['file_attachment'])) : ?>
                                            <?php
                                            $file_jawaban = $j['file_attachment'];
                                            $fileExt_jawaban = strtolower(pathinfo($file_jawaban, PATHINFO_EXTENSION));
                                            $isImage_jawaban = in_array($fileExt_jawaban, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                            $isPdf_jawaban = $fileExt_jawaban === 'pdf';
                                            ?>
                                            <div class="mt-4">
                                                <h6 class="fw-bold text-muted mb-3">
                                                    <i class="fas fa-paperclip me-2"></i>File Lampiran
                                                </h6>
                                                <div class="row g-3">
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="card file-attachment">
                                                            <div class="card-body p-3">
                                                                <?php if ($isImage_jawaban) : ?>
                                                                    <div class="text-center mb-2">
                                                                        <img src="<?= base_url('uploads/pertanyaan/' . $file_jawaban) ?>"
                                                                            class="img-thumbnail preview-image"
                                                                            style="max-height: 120px; cursor: pointer;"
                                                                            onclick="openImageModal('<?= base_url('uploads/pertanyaan/' . $file) ?>', '<?= esc($file_jawaban) ?>')">
                                                                    </div>
                                                                <?php elseif ($isPdf_jawaban) : ?>
                                                                    <div class="text-center mb-2">
                                                                        <i class="fas fa-file-pdf text-danger" style="font-size: 3rem;"></i>
                                                                    </div>
                                                                <?php else : ?>
                                                                    <div class="text-center mb-2">
                                                                        <i class="fas fa-file text-secondary" style="font-size: 3rem;"></i>
                                                                    </div>
                                                                <?php endif; ?>

                                                                <div class="text-center">
                                                                    <small class="text-muted d-block mb-2" title="<?= esc($file_jawaban) ?>">
                                                                        <?= strlen($file_jawaban) > 25 ? substr($file_jawaban, 0, 25) . '...' : $file_jawaban ?>
                                                                    </small>
                                                                </div>

                                                                <div class="d-flex gap-1 mt-2">
                                                                    <a href="<?= base_url('uploads/jawaban/' . $file_jawaban) ?>"
                                                                        class="btn btn-outline-primary btn-sm flex-fill"
                                                                        target="_blank">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="<?= base_url('jawaban/download/' . $j['file_attachment']) ?>"
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
                                        <!-- Report Button -->
                                        <?php if (isset($_SESSION['id']) && $_SESSION['id'] != $j['id_penjawab']): ?>
                                            <div class="text-end mt-3">
                                                <button class="btn btn-sm btn-outline-danger"
                                                    onclick="showReportJawabanModal(<?= $j['id_jawaban'] ?>)">
                                                    <i class="fas fa-flag"></i> Laporkan
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                        <!-- End Report Button -->


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
        </div>

        <!-- Form Jawaban -->
        <?php if (isset($_SESSION['id'])): ?>
            <div class="card p-4 my-2 shadow rounded-4 w-100">
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


<!-- Modal Report Pertanyaan -->
<div class="modal fade" id="PertanyaanreportModal" tabindex="-1" aria-labelledby="PertanyaanreportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="PertanyaanreportModalLabel">
                    <i class="fas fa-flag text-danger"></i> Laporkan Pertanyaan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="reportFormPertanyaan">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reportReason" class="form-label">Alasan Laporan</label>
                        <textarea class="form-control" id="reportReason" name="alasan" rows="4"
                            placeholder="Silakan berikan alasan mengapa Anda melaporkan pertanyaan ini..." required></textarea>
                        <div class="invalid-feedback">
                            Alasan laporan tidak boleh kosong.
                        </div>
                    </div>
                    <!-- Alert untuk menampilkan pesan -->
                    <div id="reportAlert" class="alert d-none" role="alert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-danger" id="submitReportBtn">
                        <i class="fas fa-flag"></i> Laporkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Report Jawaban -->
<div class="modal fade" id="JawabanreportModal" tabindex="-1" aria-labelledby="JawabanreportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="JawabanreportModalLabel">
                    <i class="fas fa-flag text-danger"></i> Laporkan Jawaban
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="reportFormJawaban">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reportReason" class="form-label">Alasan Laporan</label>
                        <textarea class="form-control" id="reportReasonjawaban" name="alasanjawaban" rows="4"
                            placeholder="Silakan berikan alasan mengapa Anda melaporkan pertanyaan ini..." required></textarea>
                        <div class="invalid-feedback">
                            Alasan laporan tidak boleh kosong.
                        </div>
                    </div>
                    <!-- Alert untuk menampilkan pesan -->
                    <div id="reportAlertjawaban" class="alert d-none" role="alert"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-danger" id="submitReportBtnjawaban">
                        <i class="fas fa-flag"></i> Laporkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

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

    function likePertanyaan(id_pertanyaan) {
        const btn = event.currentTarget;
        btn.disabled = true;

        fetch(`/pertanyaan/like-question/${id_pertanyaan}`, {
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
                    const likeCount = btn.querySelector('.like-count-pertanyaan');
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
            confirmButtonColor: '#dd3333',
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

<script>
    // Global variables
    let currentQuestionId = null;
    const PertanyaanreportModal = new bootstrap.Modal(document.getElementById('PertanyaanreportModal'));
    const reportFormPertanyaan = document.getElementById('reportFormPertanyaan');
    const reportAlert = document.getElementById('reportAlert');
    const submitBtn = document.getElementById('submitReportBtn');
    const reasonTextarea = document.getElementById('reportReason');

    // Function to show modal
    function showReportPertanyaanModal(questionId) {
        currentQuestionId = questionId;
        reportFormPertanyaan.reset();
        hideAlert();
        enableForm();
        PertanyaanreportModal.show();

        setTimeout(() => {
            reasonTextarea.focus();
        }, 300);
    }

    // Function to show alert
    function showAlert(message, type = 'info') {
        reportAlert.className = `alert alert-${type}`;
        reportAlert.textContent = message;
        reportAlert.classList.remove('d-none');
    }

    // Function to hide alert
    function hideAlert() {
        reportAlert.classList.add('d-none');
    }

    // Function to disable form during submission
    function disableForm() {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        reasonTextarea.disabled = true;
    }

    // Function to enable form
    function enableForm() {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-flag"></i> Laporkan';
        reasonTextarea.disabled = false;
    }

    // Handle form submission - gunakan FormData untuk kompatibilitas maksimal
    reportFormPertanyaan.addEventListener('submit', function(e) {
        e.preventDefault();

        const alasan = reasonTextarea.value.trim();
        if (!alasan) {
            showAlert('Alasan laporan tidak boleh kosong.', 'danger');
            return;
        }

        if (alasan.length < 5) {
            showAlert('Alasan laporan minimal 5 karakter.', 'danger');
            return;
        }

        if (!currentQuestionId) {
            showAlert('ID pertanyaan tidak valid.', 'danger');
            return;
        }

        disableForm();
        hideAlert();

        // Gunakan FormData untuk mengirim data
        const formData = new FormData();
        formData.append('alasan', alasan);

        fetch(`/pertanyaan/report/${currentQuestionId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                return response.text().then(text => {
                    console.log('Raw response:', text);

                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        throw new Error('Response bukan JSON valid: ' + text);
                    }
                });
            })
            .then(data => {
                console.log('Parsed data:', data);

                if (data.status === 'success') {
                    showAlert(data.message, 'success');

                    setTimeout(() => {
                        PertanyaanreportModal.hide();
                        window.location.reload();
                    }, 2000);
                } else {
                    showAlert(data.message || 'Terjadi kesalahan saat melaporkan pertanyaan.', 'danger');
                    enableForm();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Terjadi kesalahan: ' + error.message, 'danger');
                enableForm();
            });
    });

    // Reset form when modal is hidden
    document.getElementById('PertanyaanreportModal').addEventListener('hidden.bs.modal', function() {
        reportFormPertanyaan.reset();
        hideAlert();
        enableForm();
        currentQuestionId = null;
    });

    // Auto-resize textarea
    reasonTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    console.log('Report Modal System Loaded Successfully');
</script>

<script>
    // function to show report modal for jawaban
    let currentJawabanId = null;
    const JawabanreportModal = new bootstrap.Modal(document.getElementById('JawabanreportModal'));
    const reportFormJawaban = document.getElementById('reportFormJawaban');
    const reportAlertJawaban = document.getElementById('reportAlertjawaban');
    const submitBtnJawaban = document.getElementById('submitReportBtnjawaban');
    const reasonTextareaJawaban = document.getElementById('reportReasonjawaban');
    // Function to show modal
    function showReportJawabanModal(jawabanId) {
        currentJawabanId = jawabanId;
        reportFormJawaban.reset();
        hideAlertJawaban();
        enableFormJawaban();
        JawabanreportModal.show();

        setTimeout(() => {
            reasonTextareaJawaban.focus();
        }, 300);
    }
    // Function to show alert
    function showAlertJawaban(message, type = 'info') {
        reportAlertJawaban.className = `alert alert-${type}`;
        reportAlertJawaban.textContent = message;
        reportAlertJawaban.classList.remove('d-none');
    }
    // Function to hide alert
    function hideAlertJawaban() {
        reportAlertJawaban.classList.add('d-none');
    }
    // Function to disable form during submission
    function disableFormJawaban() {
        submitBtnJawaban.disabled = true;
        submitBtnJawaban.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        reasonTextareaJawaban.disabled = true;
    }
    // Function to enable form
    function enableFormJawaban() {
        submitBtnJawaban.disabled = false;
        submitBtnJawaban.innerHTML = '<i class="fas fa-flag"></i> Laporkan';
        reasonTextareaJawaban.disabled = false;
    }   
    // Handle form submission - gunakan FormData untuk kompatibilitas maksimal
    reportFormJawaban.addEventListener('submit', async (e) => {
        e.preventDefault();
        const alasanjawaban = reasonTextareaJawaban.value.trim();
        if (!alasanjawaban) {
            showAlertJawaban('Alasan laporan tidak boleh kosong.', 'danger');
            return;
        }
        disableFormJawaban();
        hideAlertJawaban();
        // Gunakan FormData untuk mengirim data
        const formData = new FormData();
        formData.append('alasanjawaban', alasanjawaban);
        formData.append('jawaban_id', currentJawabanId);
        // Kirim data ke server
        try {
            const response = await fetch(`/pertanyaan/report-jawaban/${currentJawabanId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();
            if (data.status === 'success') {
                showAlertJawaban(data.message, 'success');
                setTimeout(() => {
                    JawabanreportModal.hide();
                    window.location.reload();
                }, 2000);
            } else {
                showAlertJawaban(data.message || 'Terjadi kesalahan saat melaporkan jawaban.', 'danger');
                enableFormJawaban();
            }
        } catch (error) {
            console.error('Error:', error);
            showAlertJawaban('Terjadi kesalahan: ' + error.message, 'danger');
            enableFormJawaban();
        }
    });
    // Reset form when modal is hidden
    document.getElementById('JawabanreportModal').addEventListener('hidden.bs.modal', () => {
        reportFormJawaban.reset();
        hideAlertJawaban();
        enableFormJawaban();
        currentJawabanId = null;
    });
    // Auto-resize textarea
    reasonTextareaJawaban.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
</script>


<?= $this->include('PortalUtama/layout/sweetalert') ?>
<?= $this->endSection(); ?>