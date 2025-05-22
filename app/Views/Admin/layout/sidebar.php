
<!-- SIDEBAR MENU -->
<div id="sidebar" class="active">
    <div class="sidebar-wrapper active" style="margin-top: 3rem;">
        <div class="sidebar-menu">
            <ul class="menu">
                <!-- dasbor -->
                <li class="sidebar-item <?= ($active == 'dasbor') ? 'active' : ''; ?>">
                    <a href="<?= base_url(); ?>admin/dasbor" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dasbor</span>
                    </a>
                </li>
                <!-- repository -->
                <li class="sidebar-item has-sub <?= ($active == 'semua_repo' || $active == 'tambah_repo') ? 'active' : ''; ?>">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-hdd-rack-fill"></i>
                            <span>Repository</span>
                        </a>
                        <ul class="submenu <?= ($active == 'semua_repo' || $active == 'tambah_repo') ? 'active' : ''; ?>">
                            <li class="submenu-item <?= ($active == 'semua_repo') ? 'active' : ''; ?>">
                                <a href="<?= base_url(); ?>/admin/repo">Tabel Repository</a>
                            </li>
                            <li class="submenu-item<?= ($active == 'tambah_repo') ? 'active' : ''; ?> ">
                                <a href="<?= base_url(); ?>/admin/repo/create">Tambah Repository</a>
                            </li>
                        </ul>
                </li>
                <!-- QnA -->
                <li class="sidebar-item has-sub <?= ($active == 'daftarQnA' || $active == 'jawabQnA') ? 'active' : ''; ?>">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-chat-right-text-fill"></i>
                        <span>QnA</span>
                    </a>
                    <ul class="submenu <?= ($active == 'daftarQnA' || $active == 'jawabQnA') ? 'active' : ''; ?>">
                        <li class="submenu-item <?= ($active == 'daftarQnA') ? 'active' : ''; ?>">
                            <a href="<?= base_url(); ?>admin/qna/">Daftar Pertanyaan</a>
                        </li>
                    </ul>
                </li>
                
                <!-- chatbot -->
                <li class="sidebar-item has-sub <?= ($active == 'chatbot' || $active == 'kb' || $active == 'importwa') ? 'active' : ''; ?>">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-chat-dots-fill"></i>
                        <span>Chatbot</span>
                    </a>
                    <ul class="submenu <?= ($active == 'chatbot' || $active == 'kb' || $active == 'importwa') ? 'active' : ''; ?>">
                        <li class="submenu-item <?= ($active == 'chatbot') ? 'active' : ''; ?>">
                            <a href="<?= base_url(); ?>admin/chatbot/">Chatbot</a>
                        </li>
                        <li class="submenu-item <?= ($active == 'kb') ? 'active' : ''; ?>">
                            <a href="<?= base_url(); ?>admin/chatbot/knowledge-base">Knowledge Base</a>
                        </li>
                        <li class="submenu-item <?= ($active == 'importwa') ? 'active' : ''; ?>">
                            <a href="<?= base_url(); ?>admin/chatbot/import-wa">Import WhatsApp</a>
                        </li>
                    </ul>
                </li>
                <!-- zoom -->
                <li class="sidebar-item has-sub <?= ($active == 'buat_zoom' || $active == 'zoom-monitoring') ? 'active' : ''; ?>">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-camera-video-fill"></i>
                            <span>Zoom</span>
                        </a>
                        <ul class="submenu <?= ($active == 'buat_zoom' || $active == 'zoom-monitoring' || $active == 'edit_zoom' || $active == 'dasbor-zoom') ? 'active' : ''; ?>">
                            <li class=" submenu-item <?= ($active == 'dasbor_zoom') ? 'active' : ''; ?>">
                                <a href="<?= base_url(); ?>admin/zoom-monitoring/dasbor">Dasbor Zoom</a>
                            </li>
                            <li class="submenu-item <?= ($active == 'buat_zoom') ? 'active' : ''; ?>">
                                <a href="<?= base_url(); ?>admin/zoom-monitoring/create_zoom">Membuat Pemakaian Zoom</a>
                            </li>
                            <li class="submenu-item<?= ($active == 'zoom-monitoring') ? 'active' : ''; ?> ">
                                <a href="<?= base_url(); ?>admin/zoom-monitoring/">Jadwal Pemakaian Zoom</a>
                            </li>
                        </ul>
                </li>
                <!-- END OF MENU UTAMA -->
                <?php if (session('role') == 'admin') : ?>
                    <!-- Administrator -->
                    <li class="sidebar-title">ADMINISTRATOR</li>
                    <li class="sidebar-item  <?= ($active == 'semua_pengguna') ? 'active' : ''; ?>">
                        <a href="<?= base_url(); ?>admin/user" class='sidebar-link'>
                            <i class="bi bi-people-fill"></i>
                            <span>Pengguna</span>
                        </a>
                    </li>
                <?php endif ?>

                <!-- END OF MODUL SKKO -->


                <div style="margin-bottom: 150px;"></div>
            </ul>
        </div>
    </div>
</div>
<!-- END OF SIDEBAR MENU -->