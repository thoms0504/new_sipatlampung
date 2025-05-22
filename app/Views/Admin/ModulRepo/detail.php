<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
    <div class="container">
        <div class="row justify-content-around">
            <div class="card">
                <div class="card-body">
                    <div class="col">
                        <div class="row-2">
                            <h3><?= $repo['judul']; ?></h3>
                            <p>oleh <?= $repo['tim']; ?> pada <?= $repo['tgl_upload']; ?></p>
                            <a href="/admin/repo/edit/<?= $repo['slug']; ?>" class="btn btn-warning" style="width: 100px;">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="/admin/repo/<?= $repo['id']; ?>" method="post" class="d-inline"
                                  name="actionDelete2_Artikel<?= $repo['id']; ?>" onclick="destroy2(<?= $repo['id']; ?>,'Artikel','<?= $repo['judul']; ?>')">
                                <input type="hidden" name="_method" value="DELETE">
                                <?= csrf_field(); ?>
                                <button type="submit" class="btn btn-danger ml-1" style="width: 100px;" data-bs-dismiss="modal">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                        <div class="row-4 my-3">
                            <?php
                            $fileExtension = pathinfo($repo['file'], PATHINFO_EXTENSION);
                            // Pastikan path file sesuai dengan struktur folder Anda
                            $fileUrl = $this->minio->getFileUrl($repo['file']); 
                            
                            if (strtolower($fileExtension) === 'pdf') {
                                ?>
                                <div class="text-center mb-3">
                                    <img src="<?= base_url('PortalUtama/img/pdf-icon.png'); ?>" alt="PDF Icon" style="width: 100px;">
                                    <div class="mt-3">
                                        <iframe src="<?= $filePath ?>" width="100%" height="800px" style="border: 1px solid #ddd;"></iframe>
                                    </div>
                                </div>
                            <?php } elseif (in_array(strtolower($fileExtension), ['doc', 'docx'])) { ?>
                                <div class="text-center mb-3">
                                    <img src="<?= base_url('PortalUtama/img/word-icon.png'); ?>" alt="Word Icon" style="width: 100px;">
                                    <div class="mt-3">
                                        <a href="<?= $filePath ?>" class="btn btn-primary" download>
                                            <i class="bi bi-download"></i> Download Word Document
                                        </a>
                                    </div>
                                </div>
                            <?php } elseif (in_array(strtolower($fileExtension), ['xls', 'xlsx'])) { ?>
                                <div class="text-center mb-3">
                                    <img src="<?= base_url('PortalUtama/img/excel-icon.png'); ?>" alt="Excel Icon" style="width: 100px;">
                                    <div class="mt-3">
                                        <a href="<?= $filePath ?>" class="btn btn-primary" download>
                                            <i class="bi bi-download"></i> Download Excel Document
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row-6 text-justify">
                            <strong><label for="deskripsi" class="col-sm-2 col-form-label bold">Deskripsi: </label></strong>
                            <p><?= $repo['deskripsi']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Sweet Alert-->
<?= $this->include('admin/layout/sweetalert'); ?>
<?= $this->endSection(); ?>