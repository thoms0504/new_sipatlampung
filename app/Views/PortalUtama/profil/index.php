<?= $this->extend('PortalUtama/layout/template'); ?>
<?= $this->section('content'); ?>
<div class="bg-section-title"></div>
<div class="section-title pad">
    <h2>Profil Saya</h2>
</div>
<div class="container shadow p rounded">
    <div class="row">
        <div class="col-md-5 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle mt-5" width="150px" src="<?= ($user['avatar'] != '') ? $user['avatar'] : base_url('admin/img/users/default.png') ?>">
                <span class="font-weight-bold mt-2">
                    <?= $user['nama_lengkap'] ?>
                </span>
                <span class="text-black-50"><?= $user['email'] ?>
                </span>
                <span> 
                </span>
            </div>
        </div>
        <div class="col-md-7 border-right">
            <div class="p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profil Saya</h4>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 mb-3"><label class="labels">Nama Lengkap</label><input type="text" class="form-control" placeholder="Nama Lengkap" value="<?= $user['nama_lengkap'] ?>" name="nama_lengkap" disabled></div>
                    <div class="col-md-12 mb-3"><label class="labels">Nama Pengguna</label><input type="text" class="form-control" placeholder="Nama Pengguna" value="<?= $user['username'] ?>" name="username" disabled></div>
                    <div class="col-md-12 mb-3"><label class="labels">Alamat Email</label><input type="text" class="form-control" placeholder="Alamat Email" value="<?= $user['email'] ?>" name="email" disabled></div>
                </div>

                <a href="/profil/edit" class="btn btn-primary profile-button mt-2">Edit Profil</a>
                <a href="/profil/changepassword" class="btn btn-primary profile-button mt-2 mr-2">Ubah Kata Sandi</a>

            </div>
        </div>
    </div>
</div>
<br><br><br><br>
<!--Sweet Alert-->
<?= $this->include('PortalUtama/layout/sweetalert'); ?>
<?= $this->endSection('content'); ?>