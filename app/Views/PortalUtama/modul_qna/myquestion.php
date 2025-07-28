<?= $this->extend('PortalUtama/layout/template'); ?>
<?= $this->section('content'); ?>

<style>
    .hero-section {
        margin-top: auto;
        background: linear-gradient(135deg, #001f4f 0%, #001f4f 100%);
        padding: 4rem 0 2rem 0;
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
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }
    
    .hero-content {
        margin-top: 4rem;
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
    }
    
    .hero-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 2rem;
    }
    
    .main-container {
        margin-top: -1rem;
        position: relative;
        z-index: 3;
    }
    
    .card-modern {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border: none;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    /* .card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.15);
    } */
    
    .card-header-modern {
        background: linear-gradient(135deg, #001f4f 0%, #2a5298 100%);
        color: white;
        padding: 2rem;
        border: none;
        position: relative;
    }
    
    .card-header-modern::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: white;
        border-radius: 2px;
        opacity: 0.3;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 15px;
        text-align: center;
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: scale(1.05);
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    
    
    
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-answered {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
    }
    
    .status-pending {
        background: linear-gradient(135deg, #ff6b6b 0%, #ffa726 100%);
        color: white;
    }
    
    .btn-modern {
        border: none;
        border-radius: 10px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        margin: 0 0.2rem;
    }
    
    .btn-view {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #4caf50 0%, #66bb6a 100%);
        color: white;
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #f44336 0%, #ef5350 100%);
        color: white;
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-state-icon {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 1rem;
    }
    
    .empty-state-title {
        font-size: 1.5rem;
        color: #666;
        margin-bottom: 0.5rem;
    }
    
    .empty-state-text {
        color: #999;
    }
    
    .question-title {
        font-weight: 600;
        color: #333;
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .question-desc {
        color: #666;
        max-width: 350px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .floating-add-btn {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 1.5rem;
        box-shadow: 0 10px 30px rgba(30, 60, 114, 0.4);
        transition: all 0.3s ease;
        z-index: 1000;
    }
    
    .floating-add-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 15px 40px rgba(30, 60, 114, 0.6);
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }
        
        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
        }
        
        .btn-modern {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
            margin: 0.1rem;
        }
    }
</style>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">💬 Pertanyaan Saya</h1>
            <p class="hero-subtitle">Kelola dan pantau semua pertanyaan Anda dengan mudah</p>
        </div>
    </div>
</div>

<!-- Main Container -->
<div class="container main-container">
    <div class="row">
        <div class="col-12">
            <!-- Statistics Cards -->
            <div class="stats-grid mb-4">
                <?php 
                $total_pertanyaan = count($pertanyaan);
                $terjawab = 0;
                $belum_terjawab = 0;
                foreach($pertanyaan as $item) {
                    if($item['status'] == '1') $terjawab++;
                    else $belum_terjawab++;
                }
                ?>
                <div class="stat-card">
                    <div class="stat-number"><?= $total_pertanyaan ?></div>
                    <div class="stat-label">Total Pertanyaan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $terjawab ?></div>
                    <div class="stat-label">Sudah Terjawab</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $belum_terjawab ?></div>
                    <div class="stat-label">Belum Terjawab</div>
                </div>
            </div>
            
            <!-- Main Card -->
            <div class="card card-modern">
                <div class="card-header-modern">
                    <h3 class="mb-0">📋 Daftar Pertanyaan Saya</h3>
                </div>
                <div class="card-body p-0">
                    <?php if (count($pertanyaan) > 0) : ?>
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th class="col-3">Judul Pertanyaan</th>
                                        <th class="col-3">Deskripsi</th>
                                        <th class="col-2">Status</th>
                                        <th class="col-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pertanyaan as $index => $item) : ?>
                                        <tr>
                                            <td>
                                                <div class="fw-bold text-primary d-flex align-items-center" 
                                                     style="font-size: 0.95rem;" 
                                                     title="<?= htmlspecialchars($item['judul']); ?>">
                                                    <i class="bi bi-question-circle me-2"></i>
                                                    <span class="text-truncate"><?= esc($item['judul']); ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-muted" 
                                                     style="font-size: 0.9rem; max-height: 60px; overflow: hidden;" 
                                                     title="<?= htmlspecialchars($item['deskripsi']); ?>">
                                                    <i class="bi bi-file-text me-1"></i>
                                                    <span class="text-truncate d-inline-block" style="max-width: 200px;">
                                                        <?= esc($item['deskripsi']); ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($item['status'] == '0') : ?>
                                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2 shadow-sm" 
                                                          style="font-size: 0.85rem;">
                                                        <i class="bi bi-clock me-1"></i>
                                                        Belum Terjawab
                                                    </span>
                                                <?php else : ?>
                                                    <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm" 
                                                          style="font-size: 0.85rem;">
                                                        <i class="bi bi-check-circle-fill me-1"></i>
                                                        Sudah Terjawab
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2 justify-content-center flex-wrap">
                                                    <a href="/pertanyaan/<?= $item['id_pertanyaan']; ?>" 
                                                       class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm hover-effect text-decoration-none" 
                                                       title="Lihat Detail"
                                                       style="transition: all 0.3s ease;">
                                                        <i class="bi bi-eye-fill me-1"></i> Lihat
                                                    </a>
                                                    <a href="/pertanyaan/edit/<?= $item['id_pertanyaan']; ?>" 
                                                       class="btn btn-outline-warning btn-sm rounded-pill px-3 shadow-sm hover-effect text-decoration-none" 
                                                       title="Edit Pertanyaan"
                                                       style="transition: all 0.3s ease;">
                                                        <i class="bi bi-pencil-fill me-1"></i> Edit
                                                    </a>
                                                    <a href="/pertanyaan/hapus/<?= $item['id_pertanyaan']; ?>" 
                                                       class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm hover-effect text-decoration-none" 
                                                       onclick="destroy2(<?= $item['id_pertanyaan']; ?>,'Pertanyaan','<?= session()->get('nama'); ?>')"
                                                       title="Hapus Pertanyaan"
                                                       style="transition: all 0.3s ease;">
                                                        <i class="bi bi-trash me-1"></i> Hapus
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">❓</div>
                            <h4 class="empty-state-title">Belum Ada Pertanyaan</h4>
                            <p class="empty-state-text">
                                Anda belum memiliki pertanyaan. Mulai dengan mengajukan pertanyaan pertama Anda!
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Add Button -->
<button class="floating-add-btn" onclick="window.location.href='/pertanyaan/tambah'" title="Tambah Pertanyaan Baru">
    ➕
</button>

<br><br><br>

<!--Sweet Alert-->
<?= $this->include('PortalUtama/layout/sweetalert'); ?>

<script>
// Add smooth scrolling and enhanced interactions
document.addEventListener('DOMContentLoaded', function() {
    
    
    // Add click ripple effect to buttons
    const buttons = document.querySelectorAll('.btn-modern');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});
</script>

<style>
/* Ripple effect */
.btn-modern {
    position: relative;
    overflow: hidden;
}

.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.4);
    transform: scale(0);
    animation: ripple-animation 0.6s linear;
    pointer-events: none;
}

@keyframes ripple-animation {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
</style>

<!-- sweetalert -->
<?= $this->include('PortalUtama/layout/sweetalert'); ?>
<?= $this->endSection('content'); ?>