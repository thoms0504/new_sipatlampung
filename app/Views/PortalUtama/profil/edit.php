<?= $this->extend('PortalUtama/layout/template'); ?>
<?= $this->section('content'); ?>

<div class="bg-section-title"></div>
    <div class="section-title pad">
        <h2>Profil Saya</h2>
    </div>
       <div class="container shadow p rounded">
           <div class="row">
               <div class="col-md-5 border-right">
                   <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="<?=($user['avatar'] != '') ? $user['avatar'] : base_url('admin/img/users/default.png') ?>"><span class="font-weight-bold mt-2"><?= $user['nama_lengkap']?></span><span class="text-black-50"><?= $user['email']?></span><span> </span></div>
               </div>
               <div class="col-md-7 border-right">
                   <div class="p-3">
                       <div class="d-flex justify-content-between align-items-center mb-3">
                           <h4 class="text-right">Edit Profil</h4>
                       </div>
                       <form action="" method="post">
                           <?= csrf_field(); ?>
                           <div class="row mt-3">
                               <div class="col-md-12 mb-3">
                                   <label class="labels">Nama Lengkap</label>
                                   <input type="text" class="form-control <?= ($validation->hasError('nama_lengkap')) ? 'is-invalid' : ''; ?>" placeholder="Nama Lengkap" value="<?= (old('nama_lengkap')) ? old('nama_lengkap') : $user['nama_lengkap']; ?>" name="nama_lengkap">
                                   <div class="invalid-feedback">
                                       <?= $validation->getError('nama_lengkap'); ?>
                                   </div>
                               </div>
                               <div class="col-md-12 mb-3">
                                   <label class="labels">Nama Pengguna</label>
                                   <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" placeholder="Nama Pengguna" value="<?= (old('username')) ? old('username') : $user['username']; ?>" name="username">
                                   <div class="invalid-feedback">
                                       <?= $validation->getError('username'); ?>
                                   </div>
                               </div>
                           </div>
                           <button class="btn btn-primary profile-button" type="submit">Perbarui Profil</button>
                       </form>
                   </div>
               </div>

           </div>
       </div>
<br><br><br><br>


<!--Sweet Alert-->
<?= $this->include('PortalUtama/layout/sweetalert'); ?>
<?= $this->endSection('content'); ?>