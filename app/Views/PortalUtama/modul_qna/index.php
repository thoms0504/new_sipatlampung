<?= $this->extend('PortalUtama/layout/template'); ?>
<?= $this->section('content'); ?>

<div class="bg-section-title"></div>
<section>
  <div class="section-title">
    <h2><?= str_replace(" | Sipat Lampung", "", $title) ?></h2>
  </div>

  <div class="container">

    <div class="row d-flex align-items-center flex-column">
      <div class="col-10">
        <?php
          if (session()->getFlashdata("pesan")) :
          ?>
            <div class="alert alert-success" role="alert">
              <?= session()->getFlashdata("pesan"); ?>
            </div>
        <?php endif; ?>
      </div>
      <div class="col-10 d-flex justify-content-end mb-3">
        <a href="pertanyaan/create" class='btn btn-primary'>Buat Pertanyaan</a>
      </div>
    </div>

    <div class="row d-flex align-items-center flex-column">
      <div class="col-10">
        <form action="" method="get" class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Cari Pertanyaan" aria-label="Search" name="keyword" value="<?= ($keyword) ? $keyword : ''; ?>">
            <button class="btn btn-primary" type="submit" name="submit">Cari</button>
        </form>
      </div>
    </div>

    <div class="mt-3 row d-flex align-items-center flex-column">
      <div class="col-10">
      <?php if ($pertanyaan == []) : ?>
        <h3 class="text-center">Tidak Ada Pertanyaan</h3>
      <?php else : ?>
        <?php foreach ($pertanyaan as $p) : ?>
          <div class="card mb-3">
            <div class="card-body" onclick="window.location='/pertanyaan/<?= $p['id_pertanyaan']; ?>'" style="cursor: pointer;">
              <h5 class="card-title"><?= $p['judul']; ?></h5>
              <p class="card-text"><?= word_limiter(str_replace('<br />',"",$p["deskripsi"]), 50)?></p>
            </div>
          </div>
        <?php endforeach; ?>
        
        <?= $pager->links('pertanyaan', 'artikel_pagination') ?>
        <?php endif ?>
      </div>
    </div>
  </div>
</section>

<?= $this->include('PortalUtama/layout/sweetalert') ?>
<?= $this->endSection(); ?>