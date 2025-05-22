<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Internal BPS Provinsi Lampung</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .section-title h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #2c3e50;
            position: relative;
            padding-bottom: 15px;
        }
        
        .section-title h2:after {
            content: '';
            position: absolute;
            display: block;
            width: 50px;
            height: 3px;
            background: #3498db;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .search-box {
            margin: 20px 0;
            display: flex;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            background-color: white;
        }
        
        #search-input {
            flex: 1;
            padding: 12px 20px;
            border: none;
            outline: none;
            font-size: 1rem;
        }
        
        .search-btn {
            background-color: #1a73e8;
            color: white;
            border: none;
            padding: 0 20px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        
        .search-btn:hover {
            background-color: #0d62c9;
        }
        
        .category-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }
        
        .category {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            overflow: hidden;
            flex: 1 1 300px;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
        }
        
        .category:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .category-header {
            padding: 15px;
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
        }
        
        .category-umum .category-header {
            background-color: #4285f4;
        }
        
        .category-kepegawaian .category-header {
            background-color: #0f9d58;
        }
        
        .category-keuangan .category-header {
            background-color: #f4b400;
        }
        
        .category-layanan .category-header {
            background-color: #db4437;
        }
        
        .bookmark-container {
            max-height: 300px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #3498db #f1f1f1;
        }
        
        /* Scrollbar styling for webkit browsers */
        .bookmark-container::-webkit-scrollbar {
            width: 6px;
        }
        
        .bookmark-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .bookmark-container::-webkit-scrollbar-thumb {
            background: #3498db;
            border-radius: 10px;
        }
        
        .bookmark-container::-webkit-scrollbar-thumb:hover {
            background: #2980b9;
        }
        
        .bookmark-list {
            padding: 15px;
            list-style-type: none;
        }
        
        .bookmark-list li {
            margin-bottom: 12px;
            border-bottom: 1px solid #eee;
            padding-bottom: 12px;
        }
        
        .bookmark-list li:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }
        
        .bookmark-item {
            margin-bottom: 12px;
            border-bottom: 1px solid #eee;
            padding-bottom: 12px;
        }
        
        .bookmark-item:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }
        
        .bookmark-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #1a73e8;
            font-weight: 500;
            padding: 8px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        
        .bookmark-link:hover {
            background-color: #f1f5fe;
        }
        
        .bookmark-icon {
            margin-right: 15px;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a73e8;
            font-size: 16px;
        }
        
        footer {
            text-align: center;
            padding: 20px;
            background-color: #2c3e50;
            color: white;
            margin-top: 30px;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .category-container {
                flex-direction: column;
            }
            
            .search-box {
                flex-direction: column;
                border-radius: 8px;
            }
            
            .search-btn {
                padding: 10px;
                border-radius: 0 0 8px 8px;
            }
        }
    </style>
</head>
<body>
    <section id="clients" class="clients section-bg">
        <div class="container">
            <div class="row mt-5">
                <div class="section-title">
                    <h2>Layanan Internal BPS Provinsi Lampung</h2>
                </div>     
            </div>
            
            <div class="search-box">
                <input type="text" id="search-input" placeholder="Cari Layanan...">
                <button class="search-btn">Cari</button>
            </div>
            
            <div class="category-container">
                <!-- Kategori Umum -->
                <div class="category category-umum">
                    <div class="category-header">Umum</div>
                    <div class="bookmark-container">
                        <ul class="bookmark-list">
                            <li>
                                <a href="https://bps.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-chart-bar"></i></span>
                                    <span>Badan Pusat Statistik</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://lampung.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-landmark"></i></span>
                                    <span>Portal Prov. Lampung</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://menpan.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-building-government"></i></span>
                                    <span>Kementerian PAN-RB</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://indonesia.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-globe-asia"></i></span>
                                    <span>Portal Nasional Indonesia</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://kominfo.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-broadcast-tower"></i></span>
                                    <span>Kementerian Kominfo</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.ekon.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-chart-line"></i></span>
                                    <span>Kemenko Perekonomian</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Kategori Kepegawaian -->
                <div class="category category-kepegawaian">
                    <div class="category-header">Kepegawaian</div>
                    <div class="bookmark-container">
                        <ul class="bookmark-list">
                            <li>
                                <a href="https://aaa.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-user-tie"></i></span>
                                    <span>Portal AAA</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://dlmfldf.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-id-card"></i></span>
                                    <span>Portal DLMFLDF</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://bkn.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-users-cog"></i></span>
                                    <span>Badan Kepegawaian Negara</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://siasn.bkn.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-database"></i></span>
                                    <span>SIASN BKN</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://sscasn.bkn.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-user-plus"></i></span>
                                    <span>Portal SSCASN</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://sapk.bkn.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-file-alt"></i></span>
                                    <span>SAPK BKN</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Kategori Keuangan -->
                <div class="category category-keuangan">
                    <div class="category-header">Keuangan</div>
                    <div class="bookmark-container">
                        <ul class="bookmark-list">
                            <li>
                                <a href="https://kemenkeu.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-money-bill-wave"></i></span>
                                    <span>Kementerian Keuangan</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://e-rekon-lk.kemenkeu.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-balance-scale"></i></span>
                                    <span>E-Rekon</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://span.kemenkeu.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-university"></i></span>
                                    <span>SPAN</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://djkn.kemenkeu.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-building"></i></span>
                                    <span>Dirjen Kekayaan Negara</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://djpb.kemenkeu.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-coins"></i></span>
                                    <span>Dirjen Perbendaharaan</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://djp.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                                    <span>Dirjen Pajak</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Kategori Layanan Publik -->
                <div class="category category-layanan">
                    <div class="category-header">Layanan Publik</div>
                    <div class="bookmark-container">
                        <ul class="bookmark-list">
                            <li>
                                <a href="https://lapor.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-bullhorn"></i></span>
                                    <span>LAPOR!</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://mail.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-envelope"></i></span>
                                    <span>Email Pemerintah</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://sipp.menpan.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-tasks"></i></span>
                                    <span>SIPP</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://ppid.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-info-circle"></i></span>
                                    <span>PPID</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://jdih.gov.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-gavel"></i></span>
                                    <span>JDIH</span>
                                </a>
                            </li>
                            <li>
                                <a href="https://lpse.go.id" class="bookmark-link" target="_blank">
                                    <span class="bookmark-icon"><i class="fas fa-shopping-cart"></i></span>
                                    <span>LPSE</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <footer>
        &copy; 2025 Layanan Internal BPS Provinsi Lampung | Dibuat untuk memudahkan akses informasi penting
    </footer>

    <script>
        // Fungsi pencarian bookmark
        document.querySelector('.search-btn').addEventListener('click', searchBookmarks);
        document.getElementById('search-input').addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                searchBookmarks();
            }
        });
        
        function searchBookmarks() {
            const searchInput = document.getElementById('search-input').value.toLowerCase();
            const bookmarkItems = document.querySelectorAll('.bookmark-link');
            
            bookmarkItems.forEach(item => {
                const bookmarkText = item.textContent.toLowerCase();
                const listItem = item.closest('li');
                
                if (bookmarkText.includes(searchInput)) {
                    listItem.style.display = 'block';
                } else {
                    listItem.style.display = 'none';
                }
            });
            
            // Periksa apakah semua item dalam kategori tersembunyi
            const categories = document.querySelectorAll('.category');
            categories.forEach(category => {
                const visibleItems = category.querySelectorAll('li[style="display: block"]').length;
                const hiddenItems = category.querySelectorAll('li[style="display: none"]').length;
                const totalItems = category.querySelectorAll('li').length;
                
                if (hiddenItems === totalItems) {
                    category.style.display = 'none';
                } else {
                    category.style.display = 'flex';
                }
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Memeriksa tinggi konten untuk menampilkan scrollbar jika dibutuhkan
            const bookmarkContainers = document.querySelectorAll('.bookmark-container');
            
            bookmarkContainers.forEach(container => {
                const list = container.querySelector('.bookmark-list');
                const items = list.querySelectorAll('li');
                
                // Jika jumlah bookmark kurang dari atau sama dengan 5, hilangkan scrollbar
                if (items.length <= 5) {
                    container.style.overflowY = 'visible';
                }
            });
        });
    </script>
</body>
</html>