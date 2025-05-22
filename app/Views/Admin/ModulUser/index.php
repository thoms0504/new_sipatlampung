<?php $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
    <!-- WRITE CONTENT HERE -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#addUserModal">
                    Tambah Akun
                </button>
                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#imporModal">
                    Impor Akun
                </button>
                <table class="table table-striped" id="table1">
                    <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Login Via</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($user as $u) : ?>
                        <tr>
                            <td><?= $u['nama_lengkap']; ?></td>
                            <td><?= $u['email']; ?></td>
                            <td> <?= ($u['google_id'] != '') ? 'Google' : 'Manual' ?> </td>
                            <td class="py-1">
                                <button type="button" class="btn btn-success my-1" style="width: 100px;" data-bs-toggle="modal"
                                        data-bs-target="#modalUserDetail<?= $u['id']; ?>">
                                    <i class="bi bi-eye-fill"></i> Lihat
                                </button>
                                <form action="/admin/user/<?= $u['id']; ?>" method="post" class="d-inline"
                                      name="actionDelete2_Akun<?= $u['id']; ?>" onclick="destroy2(<?= $u['id']; ?>,'Akun','<?= $u['nama_lengkap']; ?>')">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <?= csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger ml-1 my-1" style="width: 100px;" data-bs-dismiss="modal">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                                <?php if ($u['is_active'] != 1) : ?>
                                    <form action="/admin/user/aktifkan/<?= $u['id']; ?>" method="post" class="d-inline" 
                                        name="actionStatus_aktifkan<?= $u['id']; ?>" onclick="active(<?= $u['id']; ?>,'aktifkan','<?= $u['nama_lengkap']; ?>')">
                                        <input type="hidden" name="_method" value="POST">
                                        <?= csrf_field(); ?>
                                        <button type="submit" class="btn btn-success ml-1 my-1" style="width: 150px;" data-bs-dismiss="modal">
                                            <i class="bi bi-check-lg"></i> Aktifkan
                                        </button>
                                    </form>
                                <?php else : ?>
                                    <form action="/admin/user/nonaktifkan/<?= $u['id']; ?>" method="post"
                                          class="d-inline"
                                        name="actionStatus_nonaktifkan<?= $u['id']; ?>" onclick="active(<?= $u['id']; ?>,'nonaktifkan','<?= $u['nama_lengkap']; ?>')">
                                        <input type="hidden" name="_method" value="POST">
                                        <?= csrf_field(); ?>
                                        <button type="submit" class="btn btn-danger ml-1 my-1" style="width: 150px;" data-bs-dismiss="modal">
                                            <i class="bi bi-x-lg"></i> Nonaktifkan
                                        </button>
                                    </form>
                                <?php endif ?>
                            </td>
                        </tr>
                        <!--View User Detail -->
                        <div class="modal fade" id="modalUserDetail<?= $u['id']; ?>" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                 role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">Detail Profil Penggua
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group row align-items-center">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label">Nama Lengkap</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="form-group has-icon-left">
                                                        <div class="position-relative">
                                                            <input type="text" id="name" class="form-control"
                                                                   name="name"
                                                                   value="<?= $u['nama_lengkap'] ?>" disabled>
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-person"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group row align-items-center">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label">Nama Pengguna</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="form-group has-icon-left">
                                                        <div class="position-relative">
                                                            <input type="text" id="username" class="form-control"
                                                                   name="username"
                                                                   value="<?= $u['username'] ?>" disabled>
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-person"></i>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group row align-items-center">
                                                <div class="col-sm-3">
                                                    <label class="col-form-label">Alamat Email</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="form-group has-icon-left">
                                                        <div class="position-relative">
                                                            <input type="email" id="email" class="form-control"
                                                                   name="email"
                                                                   value="<?= $u['email'] ?>" disabled>
                                                            <div class="form-control-icon">
                                                                <i class="bi bi-envelope"></i>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary ml-1"
                                                    data-bs-dismiss="modal">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Kembali</span>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!--Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
             role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Pengguna
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <?= csrf_field(); ?>
                        <div class="row mb-3">
                            <label for="nama_lengkap" class="col-sm-3 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-9">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input type="text"
                                               class="form-control <?= ($validation->hasError('nama_lengkap')) ? 'is-invalid' : ''; ?>"
                                               id="nama_lengkap" name="nama_lengkap" autofocus
                                               value="<?= old('nama_lengkap'); ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('nama_lengkap'); ?>
                                        </div>
                                        <div class="form-control-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="username" class="col-sm-3 col-form-label">Nama Pengguna</label>
                            <div class="col-sm-9">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input type="text"
                                               class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>"
                                               id="username" name="username" value="<?= old('username'); ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('username'); ?>
                                        </div>
                                        <div class="form-control-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">Alamat Email</label>
                            <div class="col-sm-9">
                                <div class="form-group has-icon-left">
                                    <div class="position-relative">
                                        <input type="email"
                                               class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>"
                                               id="email" name="email" value="<?= old('email'); ?>">
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('email'); ?>
                                        </div>
                                        <div class="form-control-icon">
                                            <i class="bi bi-envelope"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Kembali
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Tambah
                            </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>


    <!--Impor Modal -->
    <div class="modal fade text-left" id="imporModal" tabindex="-1" role="dialog" aria-labelledby="imporModal"
         aria-hidden="true" data-bs-backdrop="false">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">Impor Akun</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="<?= base_url(); ?>/admin/user/impor" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <? csrf_field(); ?>
                        <label for="fileImpor" class="form-label">Contoh File Excel</label>
                        <img src="<?= base_url('admin/img/impor.png'); ?>" class="img-fluid mb-2" alt="image">
                        <input class="form-control" type="file" name="fileImpor" id="fileImpor">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary ml-1" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Batal</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Impor</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Sweet Alert-->
<?= $this->include('admin/layout/sweetalert'); ?>
    <script src="<?= base_url(); ?>/admin/js/pages/simple-datatables.js"></script>

    <!-- END OF CONTENT -->
<?php $this->endSection(); ?>