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
                           <h4 class="text-right">Ubah Kata Sandi</h4>
                       </div>
                       <form action="" method="post">
                           <?= csrf_field(); ?>
                           <div class="row mt-3">
                               <div class="col-md-12 mb-3">
                                   <label class="labels">Kata Sandi Lama</label>
                                   <input type="password" class="form-control <?= ($validation->hasError('old_password')) ? 'is-invalid' : ''; ?>" placeholder="Kata Sandi Lama" name="old_password">
                                   <div class="invalid-feedback">
                                       <?= $validation->getError('old_password'); ?>
                                   </div>
                               </div>
                               <div class="col-md-12 mb-3">
                                   <label class="labels">Kata Sandi Baru</label>
                                   <input type="password" class="form-control <?= ($validation->hasError('new_password')) ? 'is-invalid' : ''; ?>" placeholder="Kata Sandi Baru" name="new_password">
                                   <div class="invalid-feedback">
                                       <?= $validation->getError('new_password'); ?>
                                   </div>
                               </div>
                               <div class="col-md-12 mb-3">
                                   <label class="labels">Konfirmasi Kata Sandi</label>
                                   <input type="password" class="form-control <?= ($validation->hasError('confirm_password')) ? 'is-invalid' : ''; ?>" placeholder="Konfirmasi Kata Sandi" name="confirm_password">
                                   <div class="invalid-feedback">
                                       <?= $validation->getError('confirm_password'); ?>
                                   </div>
                               </div>
                           </div>
                           <button class="btn btn-primary profile-button" type="submit">Ubah Kata Sandi</button>
                       </form>
                   </div>
               </div>

           </div>
       </div>
<br><br><br><br>
    <!--Sweet Alert-->
<?= $this->include('PortalUtama/layout/sweetalert'); ?>
<?= $this->endSection('content'); ?>