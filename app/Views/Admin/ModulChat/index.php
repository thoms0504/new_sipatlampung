<?php
// File: app/Views/admin/chat/index.php
?>
<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chat Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Chat Management</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Stats Cards -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $total_sessions ?></h3>
                            <p>Total Sessions</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-chatbubbles"></i>
                        </div>
                        <a href="<?= base_url('admin/chat/sessions') ?>" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $total_messages ?></h3>
                            <p>Total Messages</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-chatbox"></i>
                        </div>
                        <a href="<?= base_url('admin/chat/sessions') ?>" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $active_sessions ?></h3>
                            <p>Active Sessions</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?= base_url('admin/chat/sessions') ?>" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $total_publications ?></h3>
                            <p>PDF Publications</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-document"></i>
                        </div>
                        <a href="<?= base_url('admin/chat/publications') ?>" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Quick Actions</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="<?= base_url('admin/chat/sessions') ?>" class="btn btn-primary btn-block">
                                        <i class="fas fa-comments"></i> View All Sessions
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="<?= base_url('admin/chat/publications') ?>" class="btn btn-success btn-block">
                                        <i class="fas fa-file-pdf"></i> Manage Publications
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="<?= base_url('admin/chat/upload-publication') ?>" class="btn btn-warning btn-block">
                                        <i class="fas fa-upload"></i> Upload PDF
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="<?= base_url('admin/chat/analytics') ?>" class="btn btn-info btn-block">
                                        <i class="fas fa-chart-bar"></i> View Analytics
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Sessions -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Chat Sessions</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Session Title</th>
                                            <th>Status</th>
                                            <th>Last Activity</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($recent_sessions)): ?>
                                            <?php foreach ($recent_sessions as $session): ?>
                                                <tr>
                                                    <td><?= esc($session['nama_lengkap']) ?></td>
                                                    <td><?= esc($session['session_title']) ?></td>
                                                    <td>
                                                        <?php if ($session['status'] == 'active'): ?>
                                                            <span class="badge badge-success">Active</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-secondary">Inactive</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= date('d M Y, H:i', strtotime($session['updated_at'])) ?></td>
                                                    <td>
                                                        <a href="<?= base_url('admin/chat/view-session/' . $session['id']) ?>" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No chat sessions found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>
