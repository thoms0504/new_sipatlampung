<?= $this->extend('PortalUtama/layout/template'); ?>
<?= $this->section('content'); ?>

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

    /* Scroll Container untuk Daftar Jawaban */
    .answers-container {
        max-height: 600px;
        /* Bisa disesuaikan sesuai kebutuhan */
        overflow-y: auto;
        border-radius: 0 0 1rem 1rem;
        position: relative;
    }

    /* Custom Scrollbar untuk container jawaban */
    .answers-container::-webkit-scrollbar {
        width: 8px;
    }

    .answers-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .answers-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
        transition: background 0.3s ease;
    }

    .answers-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Untuk Firefox */
    .answers-container {
        scrollbar-width: thin;
        scrollbar-color: #c1c1c1 #f1f1f1;
    }

    /* Fade effect untuk menunjukkan ada lebih banyak konten */
    .answers-container::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 20px;
        background: linear-gradient(transparent, rgba(255, 255, 255, 0.8));
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .answers-container:not(:hover)::after {
        opacity: 1;
    }

    /* Responsive untuk mobile */
    @media (max-width: 768px) {
        .answers-container {
            max-height: 400px;
            /* Lebih kecil untuk mobile */
        }

        .answers-container::-webkit-scrollbar {
            width: 6px;
        }
    }

    /* Smooth scrolling behavior */
    .answers-container {
        scroll-behavior: smooth;
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

<style>
    :root {
        --primary-color: #667eea;
        --primary-dark: #5a6fd8;
        --secondary-color: #764ba2;
        --accent-color: #f093fb;
        --light-bg: #f8fafc;
        --white: #ffffff;
        --text-primary: #2d3748;
        --text-secondary: #718096;
        --border-color: #e2e8f0;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.05);
        --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    

    /* Header Section */
    .header-section {
        background: var(--white);
        border-radius: 20px;
        margin-top: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .header-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    }

    .breadcrumb-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .back-btn {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: var(--white);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .back-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: var(--white);
    }

    .breadcrumb {
        background: var(--light-bg);
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        margin: 0;
        border: 1px solid var(--border-color);
    }

    .breadcrumb-item+.breadcrumb-item::before {
        content: "→";
        color: var(--primary-color);
        font-weight: bold;
    }

    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb-item.active {
        color: var(--text-secondary);
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-align: center;
        margin-bottom: 0.5rem;
    }

    /* Question Card */
    .question-card {
        background: var(--white);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
        position: relative;
        overflow: hidden;
    }

    .question-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .user-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary-color);
        box-shadow: var(--shadow-sm);
    }

    .user-details h6 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .user-details small {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .question-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
        line-height: 1.3;
    }

    .question-content {
        font-size: 1.1rem;
        color: var(--text-secondary);
        line-height: 1.7;
        margin-bottom: 1.5rem;
    }

    /* File Attachment */
    .file-attachment-section {
        background: var(--light-bg);
        border-radius: 16px;
        padding: 1.5rem;
        margin: 1.5rem 0;
        border: 1px solid var(--border-color);
    }

    .file-attachment-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
    }

    .file-card {
        background: var(--white);
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        text-align: center;
    }

    .file-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-color);
    }

    .file-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .file-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .file-actions .btn {
        flex: 1;
        padding: 0.5rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: var(--white);
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    .file-actions .btn:hover {
        background: var(--primary-color);
        color: var(--white);
        border-color: var(--primary-color);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
        margin-top: 1.5rem;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: var(--white);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-danger-custom {
        background: linear-gradient(135deg, #e53e3e, #c53030);
        color: var(--white);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .btn-danger-custom:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Answers Section */
    .answers-section {
        background: var(--white);
        border-radius: 20px;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .answers-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: var(--white);
        padding: 1.5rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .answers-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }

    .answers-count {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .sort-dropdown {
        position: relative;
    }

    .sort-btn {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: var(--white);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .sort-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .answers-container {
        max-height: 600px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--primary-color) var(--light-bg);
    }

    .answers-container::-webkit-scrollbar {
        width: 8px;
    }

    .answers-container::-webkit-scrollbar-track {
        background: var(--light-bg);
    }

    .answers-container::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 4px;
    }

    .answer-item {
        padding: 2rem;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .answer-item:hover {
        background: var(--light-bg);
    }

    .answer-item:last-child {
        border-bottom: none;
    }

    .answer-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .answer-user {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .answer-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary-color);
    }

    .answer-user-info h6 {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .answer-user-info small {
        color: var(--text-secondary);
    }

    .answer-actions {
        display: flex;
        gap: 0.5rem;
    }

    .answer-actions .btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        border: 1px solid var(--border-color);
        background: var(--white);
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    .answer-actions .btn:hover {
        background: var(--primary-color);
        color: var(--white);
        border-color: var(--primary-color);
    }

    .answer-content {
        font-size: 1.1rem;
        color: var(--text-secondary);
        line-height: 1.7;
        margin-bottom: 1.5rem;
    }

    .like-section {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: 1rem;
    }

    .like-btn {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: var(--white);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .like-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .like-btn.liked {
        background: linear-gradient(135deg, var(--accent-color), var(--secondary-color));
    }

    /* Empty State */
    .empty-answers {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .empty-answers i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: var(--primary-color);
        opacity: 0.5;
    }

    .empty-answers h5 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    /* Answer Form */
    .answer-form {
        background: var(--white);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        margin-bottom: 2rem;
    }

    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .form-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .preview-btn {
        background: var(--light-bg);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .preview-btn:hover {
        background: var(--primary-color);
        color: var(--white);
        border-color: var(--primary-color);
    }

    .form-control {
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        resize: vertical;
        min-height: 120px;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .file-upload-area {
        background: var(--light-bg);
        border: 2px dashed var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1.5rem;
    }

    .file-upload-area:hover {
        border-color: var(--primary-color);
        background: rgba(102, 126, 234, 0.05);
    }

    .file-upload-icon {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .submit-btn {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: var(--white);
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
        margin-top: 1.5rem;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Login Prompt */
    .login-prompt {
        background: var(--white);
        border-radius: 20px;
        padding: 3rem;
        text-align: center;
        box-shadow: var(--shadow-lg);
        margin-bottom: 2rem;
    }

    .login-prompt h5 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
    }

    .login-prompt p {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .login-btn {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: var(--white);
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.1rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: var(--white);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }

        .header-section,
        .question-card,
        .answers-section,
        .answer-form,
        .login-prompt {
            padding: 1.5rem;
            border-radius: 16px;
        }

        .page-title {
            font-size: 2rem;
        }

        .question-title {
            font-size: 1.5rem;
        }

        .breadcrumb-nav {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .answers-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .answer-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .form-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .action-buttons {
            flex-direction: column;
        }

        .answer-actions {
            flex-direction: column;
        }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .question-card,
    .answers-section,
    .answer-form,
    .login-prompt {
        animation: fadeInUp 0.6s ease-out;
    }

    .answer-item {
        animation: fadeInUp 0.4s ease-out;
    }

    /* Hover Effects */
    .question-card:hover,
    .answer-form:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
    }

    /* Focus States */
    .btn:focus,
    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    /* Loading States */
    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .question-hashtags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 0.75rem;
    margin-bottom: 0.5rem;
  }

  .question-hashtag {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .question-hashtag:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    color: white;
  }
</style>


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
            
            <!-- Like Button dan Jumlah Like Pertanyaan-->
            <div class="text-end mt-3">
                <button onclick="likePertanyaan(<?= $pertanyaan['id_pertanyaan'] ?>)"
                    class="btn btn-sm <?= ($pertanyaanlike['has_liked'] ?? false) ? 'btn-primary' : 'btn-outline-primary' ?>">
                    <i class="fas fa-thumbs-up"></i>
                    <span class="like-count-pertanyaan"><?= $pertanyaan['likes'] ?></span>
                </button>
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


<?= $this->include('PortalUtama/layout/sweetalert') ?>
<?= $this->endSection(); ?>