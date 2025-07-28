<?php $this->extend('Admin/layout/template'); ?>
<?= $this->section('content'); ?>

<style>
    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    .hover-effect:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    }

    .btn-outline-primary:hover {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }
</style>


<!-- WRITE CONTENT HERE -->
<section class="section">
    <div class="card ">
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th class="col-3">Judul Pertanyaan</th>
                        <th class="col-2">Nama</th>
                        <th class="col-1">Like Pertanyaan</th>
                        <th class="col-1">Like Jawaban</th>
                        <th class="col-1">Report</th>
                        <th class="col-2">Aksi</th>
                        <th class="col-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($pertanyaan)): ?>
                    <?php foreach ($pertanyaan as $row): ?>
                        <tr>
                            <td>
                                <div class="fw-bold text-primary" style="font-size: 0.95rem;">
                                    <i class="bi bi-question-circle me-2"></i>
                                    <?= esc($row['judul']) ?>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    
                                    <span class="fw-medium"><?= esc($row['nama']) ?></span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info rounded-pill px-3 py-2" style="font-size: 0.85rem;">
                                    <i class="bi bi-heart-fill me-1"></i>
                                    <?= esc($row['like_pertanyaan']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2" style="font-size: 0.85rem;">
                                    <i class="bi bi-hand-thumbs-up-fill me-1"></i>
                                    <?= esc($row['likes_jawaban']) ?>
                                </span>
                            </td>
                            <!-- Cell berwarna merah jika report_count lebih dari 0 -->
                            <td class="text-center">
                                <?php if ($row['report_count'] >= 1): ?>
                                    <span class="badge bg-danger rounded-pill shadow-sm px-3 py-2" 
                                          style="font-size: 0.85rem; animation: pulse 2s infinite;">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        <?= esc($row['report_count']) ?> Report
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-success rounded-pill px-3 py-2" style="font-size: 0.85rem;">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Aman
                                    </span>
                                <?php endif; ?>
                            </td>
                            
                            <td class="py-1">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="/pertanyaan/<?= $row['id_pertanyaan']; ?>" class="text-decoration-none">
                                        <button class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm hover-effect" 
                                                style="transition: all 0.3s ease;">
                                            <i class="bi bi-eye-fill me-1"></i> Lihat
                                        </button>
                                    </a>
                                    
                                    <form action="/admin/qna/<?= $row['id_pertanyaan']; ?>" method="post" class="d-inline"
                                          name="actionDelete2_Pertanyaan<?= $row['id_pertanyaan']; ?>" 
                                          onclick="destroy2(<?= $row['id_pertanyaan']; ?>,'Pertanyaan','<?= $row['nama']; ?>')">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <?= csrf_field(); ?>
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm hover-effect" 
                                                data-bs-dismiss="modal" style="transition: all 0.3s ease;">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <?php if ($row['status']==0) { ?>
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2 shadow-sm" 
                                          style="font-size: 0.85rem;">
                                        <i class="bi bi-clock me-1"></i> Belum Dijawab
                                    </span>
                                <?php } else { ?>
                                    <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm" 
                                          style="font-size: 0.85rem;">
                                        <i class="bi bi-check-circle-fill me-1"></i> Sudah Dijawab
                                    </span>
                                <?php } ?>
                            </td>
                        </tr>
                        
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Tidak ada data pertanyaan.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!--Sweet Alert-->
<?= $this->include('admin/layout/sweetalert'); ?>
<script src="<?= base_url(); ?>/admin/js/pages/simple-datatables.js"></script>

<!-- END OF CONTENT -->
<?php $this->endSection(); ?>