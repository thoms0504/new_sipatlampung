<?= $this->extend('PortalUtama/layout/template'); ?>
<?= $this->section('content'); ?>

<style>
  .hero-section {
    background: linear-gradient(135deg, #001f4f 0%, #001f4f 50%, #001f4f 100%);
    min-height: 400px;
    display: flex;
    align-items: center;
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
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 200"><path d="M0,50 Q250,150 500,50 T1000,50 V200 H0 Z" fill="rgba(255,255,255,0.1)"/></svg>');
    background-size: cover;
    background-position: bottom;
  }

  .hero-content {
    position: relative;
    z-index: 2;
  }

  .hero-title {
    font-size: 3rem;
    font-weight: 700;
    color: white;
    margin-bottom: 1rem;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  .hero-subtitle {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2rem;
  }

  .search-section {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    margin-top: -50px;
    position: relative;
    z-index: 3;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  }

  .search-input {
    border: 2px solid #e5e7eb;
    border-radius: 15px;
    padding: 1rem 1.5rem;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    background: white;
  }

  .search-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    outline: none;
  }

  .btn-primary-custom {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    border: none;
    border-radius: 15px;
    padding: 1rem 2rem;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
  }

  .btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    color: white;
  }

  .btn-create {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    border-radius: 15px;
    padding: 0.8rem 2rem;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
  }

  .btn-create:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    color: white;
  }

  .question-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid rgba(59, 130, 246, 0.1);
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }

  .question-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #1e40af);
    transform: scaleX(0);
    transition: transform 0.3s ease;
  }

  .question-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 50px rgba(59, 130, 246, 0.15);
  }

  .question-card:hover::before {
    transform: scaleX(1);
  }

  .question-title {
    font-size: 1.4rem;
    font-weight: 600;
    color: #1e40af;
    margin-bottom: 1rem;
    line-height: 1.4;
  }

  .question-content {
    color: #6b7280;
    font-size: 1rem;
    line-height: 1.6;
  }

  .alert-success-custom {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    border-radius: 15px;
    color: white;
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.2);
  }

  .no-questions {
    text-align: center;
    padding: 4rem 2rem;
    color: #6b7280;
  }

  .no-questions h3 {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: #9ca3af;
  }

  .content-section {
    padding: 2rem 0;
  }

  .icon-search {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
  }

  .search-container {
    position: relative;
  }

  /* Hashtag Styles */
  .hashtag-sidebar {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(59, 130, 246, 0.1);
    position: sticky;
    top: 20px;
  }

  .hashtag-sidebar h5 {
    color: #1e40af;
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1.1rem;
  }

  .hashtag-list {
    max-height: 400px;
    overflow-y: auto;
  }

  .hashtag-item {
    display: flex;
    justify-content: between;
    align-items: center;
    padding: 0.5rem 0.75rem;
    margin-bottom: 0.5rem;
    background: #f8fafc;
    border-radius: 12px;
    transition: all 0.3s ease;
    cursor: pointer;
    text-decoration: none;
    color: #374151;
    border: 1px solid transparent;
  }

  .hashtag-item:hover {
    background: #e0f2fe;
    border-color: #3b82f6;
    color: #1e40af;
    transform: translateX(5px);
  }

  .hashtag-item.active {
    background: #3b82f6;
    color: white;
  }

  .hashtag-item.active:hover {
    background: #1e40af;
    color: white;
  }

  .hashtag-name {
    flex: 1;
    font-size: 0.9rem;
  }

  .hashtag-count {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
    padding: 0.2rem 0.6rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-left: 0.5rem;
  }

  .active .hashtag-count {
    background: rgba(255, 255, 255, 0.2);
    color: white;
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

  .filter-reset {
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 12px;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    margin-bottom: 1rem;
  }

  .filter-reset:hover {
    background: #dc2626;
    transform: translateY(-1px);
    color: white;
  }

  @media (max-width: 768px) {
    .hashtag-sidebar {
      margin-bottom: 2rem;
      position: static;
    }

    .hashtag-list {
      max-height: 200px;
    }
  }
</style>

<!-- Hero Section -->
<div class="hero-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 hero-content">
        <h1 class="hero-title"><?= str_replace(" | Ruwai Jurai", "", $title) ?></h1>
        <p class="hero-subtitle">Temukan jawaban untuk pertanyaan Anda atau bagikan pengetahuan dengan komunitas</p>
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="container content-section">
  <!-- Search Section -->
  <div class="search-section">
    <div class="row">
      <div class="col-12">
        <?php if (session()->getFlashdata("pesan")) : ?>
          <div class="alert alert-success-custom" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata("pesan"); ?>
          </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="mb-0" style="color: #1e40af; font-weight: 600;">Jelajahi Pertanyaan</h4>
          <a href="pertanyaan/create" class="btn-create">
            <i class="fas fa-plus me-2"></i>Buat Pertanyaan
          </a>
        </div>

        <form action="" method="get" class="d-flex gap-3">
          <div class="search-container flex-grow-1">
            <input class="form-control search-input" type="search" placeholder="Cari pertanyaan yang Anda butuhkan..." aria-label="Search" name="keyword" value="<?= ($keyword) ? $keyword : ''; ?>">
            <i class="fas fa-search icon-search"></i>
          </div>
          <?php if ($selectedTag): ?>
            <input type="hidden" name="tag" value="<?= $selectedTag ?>">
          <?php endif; ?>
          <button class="btn-primary-custom" type="submit" name="submit">
            <i class="fas fa-search me-2"></i>Cari
          </button>
        </form>

        <!-- Filter Status -->
        <?php if ($selectedTag || $keyword): ?>
          <div class="mt-3">
            <?php if ($selectedTag): ?>
              <span class="badge bg-primary me-2">Filter: #<?= $selectedTag ?></span>
            <?php endif; ?>
            <?php if ($keyword): ?>
              <span class="badge bg-secondary me-2">Pencarian: "<?= $keyword ?>"</span>
            <?php endif; ?>
            <a href="/pertanyaan" class="filter-reset">
              <i class="fas fa-times me-1"></i>Reset Filter
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Questions and Sidebar Section -->
  <div class="mt-5">
    <div class="row">
      <!-- Main Content -->
      <div class="col-lg-8">
        <?php if (empty($pertanyaan)) : ?>
          <div class="no-questions">
            <i class="fas fa-question-circle" style="font-size: 4rem; color: #d1d5db; margin-bottom: 2rem;"></i>
            <h3>Belum Ada Pertanyaan</h3>
            <p>Jadilah yang pertama untuk mengajukan pertanyaan!</p>
            <a href="pertanyaan/create" class="btn-primary-custom mt-3">
              <i class="fas fa-plus me-2"></i>Buat Pertanyaan Pertama
            </a>
          </div>
        <?php else : ?>
          <?php foreach ($pertanyaan as $p) : ?>
            <div class="question-card" onclick="window.location='/pertanyaan/<?= $p['id_pertanyaan']; ?>'">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <h5 class="question-title mb-0"><?= $p['judul']; ?></h5>
              </div>

              <!-- Display hashtags for this question -->
              <?php if (!empty($p['hashtags'])): ?>
                <?php
                $hashtags = json_decode($p['hashtags'], true);
                if (is_array($hashtags) && !empty($hashtags)):
                ?>
                  <div class="question-hashtags">
                    <?php foreach ($hashtags as $tag): ?>
                      <a href="/pertanyaan?tag=<?= urlencode($tag) ?>" class="question-hashtag" onclick="event.stopPropagation();">
                        #<?= $tag ?>
                      </a>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>

              <p class="question-content"><?= word_limiter(str_replace('<br />', "", $p["deskripsi"]), 50) ?></p>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <span style="color: #6b7280; font-size: 0.9rem;">
                  <i class="fas fa-clock me-1"></i>
                  Baca selengkapnya
                </span>
                <div class="d-flex align-items-center gap-3">
                  <div class="d-flex align-items-center" style="background: rgba(239, 68, 68, 0.1); padding: 0.3rem 0.8rem; border-radius: 12px;">
                    <i class="fas fa-heart" style="color: #ef4444; margin-right: 0.4rem;"></i>
                    <span style="color: #ef4444; font-weight: 600; font-size: 0.9rem;">
                      <?= $p['likes'] ?? 0 ?>
                    </span>
                  </div>
                  <i class="fas fa-arrow-right" style="color: #3b82f6;"></i>
                </div>
              </div>
            </div>
          <?php endforeach; ?>

          <div class="d-flex justify-content-center mt-4">
            <?= $pager->links('pertanyaan', 'artikel_pagination') ?>
          </div>
        <?php endif ?>
      </div>

      <!-- Hashtag Sidebar -->
      <div class="col-lg-4">
        <div class="hashtag-sidebar">
          <h5><i class="fas fa-hashtag me-2"></i>Tag Populer</h5>

          <?php if (!empty($allHashtags)): ?>
            <div class="hashtag-list">
              <?php foreach ($allHashtags as $tag => $count): ?>
                <a href="/pertanyaan?tag=<?= urlencode($tag) ?>"
                  class="hashtag-item <?= ($selectedTag === $tag) ? 'active' : '' ?>">
                  <span class="hashtag-name">#<?= $tag ?></span>
                  <span class="hashtag-count"><?= $count ?></span>
                </a>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p class="text-muted small">Belum ada hashtag yang tersedia</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->include('PortalUtama/layout/sweetalert') ?>
<?= $this->endSection(); ?>