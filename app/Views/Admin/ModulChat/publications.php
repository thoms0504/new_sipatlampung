<?php
// =====================================
// File: app/Views/admin/chat/publications.php
?>
<?= $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">PDF Publications</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/chat') ?>">Chat</a></li>
                        <li class="breadcrumb-item active">Publications</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Manage PDF Publications</h3>
                            <div class="card-tools">
                                <a href="<?= base_url('admin/chat/upload-publication') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Upload New PDF
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="publicationsTable">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>File Size</th>
                                            <th>Uploaded By</th>
                                            <th>Status</th>
                                            <th>Upload Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($publications)): ?>
                                            <?php foreach ($publications as $pub): ?>
                                                <tr>
                                                    <td>
                                                        <strong><?= esc($pub['title']) ?></strong>
                                                        <?php if (!empty($pub['description'])): ?>
                                                            <br><small class="text-muted"><?= esc(substr($pub['description'], 0, 100)) ?>...</small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= esc($pub['category']) ?: 'Uncategorized' ?></td>
                                                    <td><?= number_format($pub['file_size'] / 1024, 2) ?> KB</td>
                                                    <td><?= esc($pub['uploaded_by_name']) ?></td>
                                                    <td>
                                                        <?php if ($pub['is_active']): ?>
                                                            <span class="badge badge-success">Active</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-danger">Inactive</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= date('d M Y', strtotime($pub['created_at'])) ?></td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                Actions
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="<?= base_url('uploads/publications/' . $pub['file_name']) ?>" target="_blank">
                                                                    <i class="fas fa-eye"></i> View PDF
                                                                </a>
                                                                <a class="dropdown-item" href="<?= base_url('admin/chat/edit-publication/' . $pub['id']) ?>">
                                                                    <i class="fas fa-edit"></i> Edit
                                                                </a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item text-danger" href="<?= base_url('admin/chat/delete-publication/' . $pub['id']) ?>" 
                                                                   onclick="return confirm('Are you sure you want to delete this publication?')">
                                                                    <i class="fas fa-trash"></i> Delete
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No publications found</td>
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

<script>
$(document).ready(function() {
    $('#publicationsTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": true,
        "info": true,
        "paging": true
    });
});
</script>

<?= $this->endSection(); ?>
