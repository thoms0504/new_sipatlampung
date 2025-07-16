<?= $this->extend('PortalUtama/layout/template'); ?>
<?= $this->section('content'); ?>

<style>
    .profile-header {
        background: linear-gradient(135deg, #001f4f 0%, #001f4f 50%, #001f4f 100%);
        color: white;
        padding: 60px 0 40px 0;
        margin-bottom: 0;
        
    }

    .profile-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-top: -30px;
        position: relative;
        z-index: 10;
    }

    .profile-avatar-section {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        padding: 50px 30px;
        text-align: center;
        position: relative;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 6px solid white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        object-fit: cover;
        margin-bottom: 20px;
    }

    .profile-name {
        font-size: 24px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .profile-email {
        color: #7f8c8d;
        font-size: 16px;
        font-weight: 500;
    }

    .profile-info-section {
        padding: 50px 40px;
    }

    .profile-title {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 15px;
    }

    .profile-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 2px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        font-weight: 600;
        color: #34495e;
        margin-bottom: 8px;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control-modern {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 15px 20px;
        font-size: 16px;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
        color: #495057;
    }

    .form-control-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        background-color: white;
    }

    .btn-group-modern {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 30px;
    }

    .btn-modern {
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-secondary-modern {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        color: #2c3e50;
    }

    .btn-secondary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(168, 237, 234, 0.3);
        color: #2c3e50;
        text-decoration: none;
    }

    /* .page-container {
        
        min-height: 100vh;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        padding-bottom: 60px;
    } */

    .icon-edit::before {
        content: "✏️";
        margin-right: 5px;
    }

    .icon-lock::before {
        content: "🔒";
        margin-right: 5px;
    }

    @media (max-width: 768px) {
        .profile-card {
            margin: 20px 15px;
        }

        .profile-info-section {
            padding: 30px 20px;
        }

        .profile-avatar-section {
            padding: 30px 20px;
        }

        .btn-group-modern {
            justify-content: center;
        }

        .btn-modern {
            flex: 1;
            text-align: center;
            justify-content: center;
        }
    }
</style>

<div class="page-container">
    <div class="profile-header">
        <div class="container">
            <div class="section-title pad">
                <h1>Profil Saya</h1>
                <p class="lead mb-0">Kelola informasi profil Anda</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="profile-card">
            <div class="row no-gutters">
                <div class="col-lg-4">
                    <div class="profile-avatar-section">
                        <img class="profile-avatar" src="<?= ($user['avatar'] != '') ? $user['avatar'] : base_url('admin/img/users/default.png') ?>" alt="Profile Avatar">
                        <div class="profile-name"><?= $user['nama_lengkap'] ?></div>
                        <div class="profile-email"><?= $user['email'] ?></div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="profile-info-section">
                        <h2 class="profile-title">Informasi Profil</h2>

                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-modern" value="<?= $user['nama_lengkap'] ?>" disabled>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nama Pengguna</label>
                            <input type="text" class="form-control form-control-modern" value="<?= $user['username'] ?>" disabled>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" class="form-control form-control-modern" value="<?= $user['email'] ?>" disabled>
                        </div>

                        <div class="btn-group-modern">
                            <a href="/profil/edit" class="btn btn-modern btn-primary-modern">
                                <span class="icon-edit"></span>
                                Edit Profil
                            </a>
                            <a href="/profil/changepassword" class="btn btn-modern btn-secondary-modern">
                                <span class="icon-lock"></span>
                                Ubah Kata Sandi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Sweet Alert-->
<?= $this->include('PortalUtama/layout/sweetalert'); ?>
<?= $this->endSection('content'); ?>