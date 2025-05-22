<?php $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>
<!-- WRITE CONTENT HERE -->
<section class="section">
    <div class="card ">
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th class="col-3">Judul Pertanyaan</th>
                        <th class="col-3">Nama</th>
                        <th class="col-1">Jumlah Like</th>
                        <th class="col-3">Aksi</th>
                        <th class="col-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($pertanyaan)): ?>
                    <?php foreach ($pertanyaan as $row): ?>
                        <tr>
                            <td><?= esc($row['judul']) ?></td>
                            <td><?= esc($row['nama']) ?></td>
                            <td><?= esc($row['likes']) ?></td>
                            <td class="py-1">
                                <a href="/pertanyaan/<?= $row['id_pertanyaan']; ?>"><button  class="my-1 btn btn-success" style="width: 100px;"><i class="bi bi-eye-fill"></i> Lihat</button></a>
                                
                                <form action="/admin/qna/<?= $row['id_pertanyaan']; ?>" method="post" class="d-inline"
                                      name="actionDelete2_Pertanyaan<?= $row['id_pertanyaan']; ?>" onclick="destroy2(<?= $row['id_pertanyaan']; ?>,'Pertanyaan','<?= $row['nama']; ?>')">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <?= csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger ml-1 my-1" style="width: 100px;" data-bs-dismiss="modal">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                            <td>
                                <?php if ($a['status']==0) { ?>
                                    <a><button class="btn btn-warning disabled">
                                        <i class="bi bi-info-circle"></i> Belum Dijawab</button>
                                    </a>
                                <?php } else { ?>
                                    <a><button class="btn btn-success disabled">
                                        <i class="bi bi-check-circle"></i> Sudah Dijawab</button>
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                        
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Tidak ada data pertanyaan.</td>
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