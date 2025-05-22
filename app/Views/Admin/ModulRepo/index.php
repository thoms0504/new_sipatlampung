<?php $this->extend('Admin/layout/template'); ?>

<?= $this->section('content'); ?>
<!-- WRITE CONTENT HERE -->
<section class="section">
    <div class="card ">
        <div class="card-body">
            <a href="<?= base_url(); ?>admin/repo/create" class="btn btn-primary mb-3">Tambah</a>
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tim</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($repo as $r) : ?>
                        <tr>
                            <td><?= $r['judul']; ?></td>
                            <td><?= $r['tim']; ?></td>
                            <td><?= $r['kategori']; ?></td>
                            <td class="py-1">
                                <a href="/admin/repo/<?= $r['slug'] ?> "><button  class="my-1 btn btn-success" style="width: 100px;"><i class="bi bi-eye-fill"></i> Lihat</button></a>
                                <a href="/admin/repo/edit/<?= $r['slug']; ?>"><button class="my-1 btn btn-warning" style="width: 100px;"><i class="bi bi-pencil-square"></i> Edit</button></a>
                                <form action="/admin/repo/<?= $r['id']; ?>" method="post" class="d-inline" name="actionDelete2_Artikel<?= $r['id']; ?>" onclick="destroy2(<?= $r['id']; ?>,'File','<?= $r['judul']; ?>')">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <?= csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger ml-1 my-1" data-bs-dismiss="modal" style="width: 100px;">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!--Sweet Alert-->
<?= $this->include('Admin/layout/sweetalert'); ?>
<script src="<?= base_url(); ?>/admin/js/pages/simple-datatables.js"></script>

<!-- END OF CONTENT -->
<?php $this->endSection(); ?>