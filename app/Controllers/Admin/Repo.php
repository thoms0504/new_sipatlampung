<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModulRepo\RepoModel;
use App\Config\MinIOUploader;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;


class Repo extends BaseController
{
    protected $repoModel;
    protected $minio;

    public function __construct() {
        $this->repoModel = new RepoModel();
        $this->minio = new MinIOUploader();
    }

    public function index()
    {
        $data = [
            'title' => 'Repository | Sipat Lampung',
            'repo' => $this->repoModel->orderBy("tgl_upload","deskripsi")->findAll(),
            'active' => 'semua_repo'
        ];
        return view('Admin/ModulRepo/index',$data);
    }

    public function create_repo(){
        $data = [
            'title' => 'Tambah Repo | Sipat Lampung',
            'validation' => Services::validation(),
            'active' => 'tambah_repo'
        ];
        return view('Admin/ModulRepo/create', $data);
    }

    public function edit($slug){
        $data = [
            'title' => 'Edit Repo | Sipat Lampung',
            'validation' => Services::validation(),
            'repo' => $this->repoModel->getFile($slug),
            'active' => 'edit_repo'
        ];
        return view('admin/modul_repo/edit', $data);
    }

    public function update($id)
    {
        $file_lama = $this->repoModel->getFile($this->request->getVar('slug'));

    // Validate the file
    if (!$this->validate([
        'file' => [
            'rules' => 'uploaded[file]|max_size[file,5120]|mime_in[file,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet]',
            'errors' => [
                'uploaded' => 'Pilih file terlebih dahulu',
                'max_size' => 'Ukuran file terlalu besar (maksimal 5MB)',
                'mime_in' => 'Format file tidak sesuai (hanya menerima PDF, Word, dan Excel)'
            ]
        ]
    ])) {
        return redirect()->to('admin/repo/edit/' . $file_lama['slug'])->withInput();
    }

    $filedokumen = $this->request->getFile('file');

    if ($filedokumen->getError() == UPLOAD_ERR_OK) {
        $namafile = $filedokumen->getRandomName();
        
        // Upload to MinIO
        $uploadResult = $this->minio->uploadFile(
            $filedokumen->getTempName(), 
            $namafile
        );

        if (!$uploadResult['success']) {
            session()->setFlashdata('gagal', 'Gagal mengunggah file: ' . $uploadResult['error']);
            return redirect()->to('admin/repo/edit/' . $file_lama['slug']);
        }

        // Delete old file from MinIO if it exists and is not the default
        if ($file_lama['file'] != 'test.pdf') {
            $this->minio->deleteFile($file_lama['file']);
        }
    } else {
        $namafile = $file_lama['file'];
    }

    $this->repoModel->save([
        'id' => $id,
        'judul' => $file_lama['judul'],
        'slug' => url_title($file_lama['judul'], '-', true),
        'tim' => $this->request->getVar('tim'),
        'kategori' => $this->request->getVar('kategori'),
        'tgl_upload' => date('Y-m-d H:i:s', strtotime($this->request->getVar('tgl_upload'))),
        'file' => $namafile,
        'deskripsi' => $this->request->getVar('deskripsi'),
    ]);

    session()->setFlashdata('sukses', 'Data berhasil diubah.');
    return redirect()->to('/admin/repo');
    }

    public function save(){
        // validasi input
        
        if(!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[repo.judul]',
                'errors' => [
                    'required ' => '{field} file harus diisi.',
                    'is_unique' => '{field} file sudah terdaftar.'
                ]
            ],
            'file' => [ // Ubah 'gambar' menjadi 'dokumen'
            'rules' => 'uploaded[file]|max_size[file,5120]|mime_in[file,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet]',
            'errors' => [
                'uploaded' => 'Pilih file terlebih dahulu',
                'max_size' => 'Ukuran file terlalu besar (maksimal 5MB)',
                'mime_in' => 'Format file tidak sesuai (hanya menerima PDF, Word, dan Excel)'
            ]
        ]
        ])){
            return redirect()->to('admin/repo/create')->withInput();
        }

        $filedokumen = $this->request->getFile('file');
        // apakah tidak ada gambar yang diupload
        if ($filedokumen->getError() == 4) {
            $filedokumen = 'test.pdf';
        } else {
            // generate nama sampul random
            $namafile = $filedokumen->getRandomName();
            // pindahkan file ke folder img
            // $filedokumen->move('PortalUtama/img/file', $namafile);
            $uploadResult = $this->minio->uploadFile(
                $filedokumen->getTempName(),
                $namafile
            );

            if (!$uploadResult['success']) {
                session()->setFlashdata('gagal', 'Gagal mengunggah file: ' . $uploadResult['error']);
                return redirect()->to('admin/repo/create');
            }
            if (!$uploadResult['success']) {
                // Log error 
                session()->setFlashdata('gagal', 'Gagal mengunggah file: ' . $uploadResult['error']);
                return redirect()->to('admin/repo/create');
            }
            
        }
        


        $this->repoModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => url_title($this->request->getVar('judul'), '-', true),
            'tim' => $this->request->getVar('tim'),
            'kategori' => $this->request->getVar('kategori'),
            'tgl_upload' => date('Y-m-d H:i:s', strtotime($this->request->getVar('tgl_upload'))),
            'file' => $namafile,
            'deskripsi' => $this->request->getVar('deskripsi'),
        ]);

        session()->setFlashdata('sukses', 'Data berhasil diubah.');
        return redirect()->to('/admin/repo');

    }

    public function delete($id)
    {
        $repo = $this->repoModel->find($id);
        
        if (!$repo) {
            session()->setFlashdata('gagal', 'Data tidak ditemukan.');
            return redirect()->to('/admin/repo');
        }

        $deleteResult = $this->minio->deleteFile($repo['file']);
        if ($deleteResult['success']) {
            $this->repoModel->delete($id);
            session()->setFlashdata('sukses', 'Data berhasil dihapus.');
        } else {
            session()->setFlashdata('gagal', 'Gagal menghapus file: ' . $deleteResult['error']);
        }
        
        return redirect()->to('/admin/repo');
    }

    public function detail($slug){
        $repo = $this->repoModel->getFile($slug);
    
        if (!$repo) {
            session()->setFlashdata('gagal', 'File tidak ditemukan.');
            return redirect()->to('/admin/repo');
        }

        // Retrieve file from MinIO
        $fileUrl = $this->minio->getFileUrl($repo['file']);

        $data = [
            'title' => 'Detail Repository | Sipat Lampung',
            'active' => 'repo',
            'repo' => $repo,
            'fileUrl' => $fileUrl
        ];

        return view('admin/modul_repo/detail', $data);
    }

    public function display($filename)
    {
        try {
            // Generate pre-signed URL for the file
            $fileUrl = $this->minio->getFileUrl($filename);
    
            if (!$fileUrl) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('File not found');
            }
    
            // Redirect to the pre-signed URL
            return redirect()->to($fileUrl);
        } catch (\Exception $e) {
            session()->setFlashdata('gagal', 'Gagal menampilkan file: ' . $e->getMessage());
            return redirect()->to('/admin/repo');
        }
    }
}
