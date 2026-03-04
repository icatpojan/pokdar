<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Pokdar Kamtibmas</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        /* Sidebar Styling Overhaul */
        #cms-pills-tab .nav-link {
            border-radius: 12px;
            padding: 14px 20px;
            color: #4b5563;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            position: relative;
            overflow: hidden;
            background: transparent;
            margin-bottom: 8px !important;
        }
        
        #cms-pills-tab .nav-link::after {
            display: none !important; /* Remove yellow underline from style.css */
        }

        #cms-pills-tab .nav-link:hover {
            background: #f3f4f6;
            color: #1f2937;
        }

        #cms-pills-tab .nav-link.active {
            background: #ffffff !important;
            color: #111827 !important;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-color: #e5e7eb;
        }

        #cms-pills-tab .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--accent);
        }

        #cms-pills-tab .nav-link i {
            width: 20px;
            transition: transform 0.2s ease;
        }

        #cms-pills-tab .nav-link.active i {
            transform: scale(1.1);
        }

        /* Top Nav Tabs */
        #adminTabs .nav-link {
            border: none;
            color: #6b7280;
            font-weight: 600;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }

        #adminTabs .nav-link.active {
            color: #111827;
            border-bottom-color: var(--accent);
            background: transparent;
        }
        
        /* Form Overhaul */
        .cms-card {
            border: 1px solid rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }
        .cms-card:hover { rotate: 0.2deg; }

        /* Smooth Content Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cms-animate-content {
            animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Mobile Optimization */
        @media (max-width: 991.98px) {
            .display-5 { font-size: 2.2rem; }
            .fs-5 { font-size: 1rem !important; }
            .mobile-text-center { text-align: center !important; }
            .mobile-justify-center { justify-content: center !important; }
            
            /* Hide the actual admin navs (top) on mobile */
            #adminTabs, #cms-pills-tab { display: none !important; }

            .mobile-menu-selector {
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                background: #f3f4f6;
                padding: 12px 20px;
                border-radius: 50px;
                cursor: pointer;
                transition: all 0.2s ease;
                border: 1px solid #e5e7eb;
                margin: 10px 0;
            }

            .mobile-menu-selector:active {
                background: #e5e7eb;
                transform: scale(0.98);
            }

            .mobile-menu-label {
                font-weight: 700;
                color: #111827;
                font-size: 0.9rem;
            }

            .mobile-menu-icon {
                color: var(--accent);
                font-size: 0.8rem;
            }

            /* Premium Action Sheet Style */
            .offcanvas-bottom {
                height: auto !important;
                max-height: 80vh;
                border-top-left-radius: 24px;
                border-top-right-radius: 24px;
                border-top: none;
                box-shadow: 0 -10px 25px rgba(0,0,0,0.1);
            }

            .offcanvas-header {
                padding: 24px 24px 12px;
            }

            .offcanvas-body {
                padding: 12px 24px 34px;
            }

            .mobile-nav-list {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .mobile-nav-item {
                display: flex;
                align-items: center;
                gap: 15px;
                padding: 14px 18px;
                border-radius: 16px;
                color: #4b5563;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.2s;
                border: 1px solid transparent;
            }

            .mobile-nav-item i {
                width: 20px;
                text-align: center;
                font-size: 1.1rem;
            }

            .mobile-nav-item:active {
                background: #f9fafb;
                color: #111827;
                border-color: #f3f4f6;
            }

            .mobile-nav-item.active {
                background: #111827;
                color: #fff;
            }

            .mobile-nav-item.active i {
                color: var(--accent);
            }

            .action-sheet-handle {
                width: 40px;
                height: 4px;
                background: #e5e7eb;
                border-radius: 2px;
                margin: -8px auto 16px;
            }
            
            /* Compact CMS Mobile Typography */
            .cms-section-title { 
                font-size: 1.25rem !important; 
                line-height: 1.4 !important;
                margin-bottom: 4px !important;
            }
            .cms-section-subtitle { 
                font-size: 0.75rem !important; 
                opacity: 0.65;
                font-weight: 500;
                line-height: 1.5 !important;
            }
            .cms-list-title { 
                font-size: 1.05rem !important; 
                line-height: 1.4 !important;
                display: flex !important;
                align-items: flex-start !important;
                gap: 12px !important;
                color: #111827 !important;
            }
            .cms-list-title .bg-accent {
                margin-top: 8px;
                flex-shrink: 0;
            }
            .btn-compact-mobile { 
                padding: 10px 24px !important; 
                font-size: 0.85rem !important;
                border-radius: 14px !important;
                background: #111827 !important;
                border: none !important;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
                color: #fff !important;
            }
            .btn-add-compact {
                width: 44px !important;
                height: 44px !important;
                padding: 0 !important;
                display: flex !important;
                align-items: center;
                justify-content: center;
                border-radius: 14px !important;
                box-shadow: 0 6px 20px rgba(0,0,0,0.12) !important;
                flex-shrink: 0;
                background: #111827 !important;
                border: none !important;
            }
            .btn-add-compact span, .btn-add-compact i { display: none !important; }
            .btn-add-compact::after {
                content: '\f067';
                font-family: 'Font Awesome 6 Free';
                font-weight: 900;
                font-size: 1rem;
                color: white;
            }
            
            .cms-premium-form .card {
                padding: 1.25rem !important;
                border-radius: 20px !important;
            }
            
            .cms-header-spacer { 
                margin-bottom: 1.75rem !important; 
                padding-bottom: 1.75rem !important; 
                border-bottom: 1px solid #f3f4f6 !important;
            }

            /* Mobile Fixed Bottom Navigation */
            .mobile-bottom-nav {
                display: none;
                position: fixed;
                bottom: 20px;
                left: 20px;
                right: 20px;
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
                border: 1px solid rgba(255, 255, 255, 0.3);
                border-radius: 24px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
                z-index: 1030;
                padding: 10px 15px;
            }

            @media (max-width: 991.98px) {
                .mobile-bottom-nav {
                    display: flex;
                    justify-content: space-around;
                    align-items: center;
                }
                
                body {
                    padding-bottom: 100px !important;
                }
            }

            .mobile-bottom-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 5px;
                color: #9ca3af;
                text-decoration: none;
                font-size: 0.65rem;
                font-weight: 600;
                transition: all 0.2s;
                flex: 1;
            }

            .mobile-bottom-item i {
                font-size: 1.35rem;
                transition: all 0.2s;
            }

            .mobile-bottom-item.active {
                color: #111827;
            }

            .mobile-bottom-item.active i {
                color: var(--accent);
                transform: translateY(-3px);
            }

            /* Compact Dashboard Header Mobile */
            @media (max-width: 767.98px) {
                .dashboard-header-row {
                    margin-bottom: 25px !important;
                }
                .dashboard-main-title {
                    /* color: black !important; */
                    font-size: 1.75rem !important;
                    margin-bottom: 8px !important;
                }
                .dashboard-subtitle {
                    font-size: 0.85rem !important;
                    line-height: 1.5;
                }
                .stats-card-compact {
                    padding: 12px 20px !important;
                    max-width: none !important;
                    width: auto !important;
                    display: flex !important;
                    flex-direction: row !important;
                    align-items: center !important;
                    justify-content: center !important;
                    gap: 15px !important;
                    border-radius: 16px !important;
                }
                .stats-count {
                    font-size: 1.5rem !important;
                    margin-bottom: 0 !important;
                }
                .stats-label {
                    font-size: 0.75rem !important;
                    text-align: left;
                }
            }

            .navbar-brand img { height: 32px !important; }
            .logo-text span.main-title { font-size: 0.85rem !important; }
            .logo-text span.sub-title { font-size: 0.6rem !important; }
        }

        /* Premium Toast Styling */
        .toast-container {
            position: fixed;
            top: 25px;
            right: 25px;
            z-index: 9999;
        }

        .custom-toast {
            background: #ffffff;
            color: #1f2937;
            padding: 16px 24px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 15px;
            min-width: 320px;
            max-width: 450px;
            border-left: 5px solid #10b981;
            transform: translateX(120%);
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            opacity: 0;
        }

        .custom-toast.show {
            transform: translateX(0);
            opacity: 1;
        }

        .custom-toast.error { border-left-color: #ef4444; }
        .custom-toast.warning { border-left-color: #f59e0b; }
        .custom-toast.info { border-left-color: #3b82f6; }

        .custom-toast-icon {
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .custom-toast-content {
            flex-grow: 1;
        }

        .custom-toast-title {
            font-weight: 700;
            font-size: 0.95rem;
            display: block;
            margin-bottom: 2px;
        }

        .custom-toast-message {
            font-size: 0.85rem;
            color: #6b7280;
            line-height: 1.4;
        }

        .custom-toast-close {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 4px;
            transition: color 0.2s;
        }

        .custom-toast-close:hover { color: #4b5563; }

        /* Premium Photo Upload Styling */
        .photo-upload-wrapper {
            position: relative;
            display: inline-block;
            padding: 8px;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 1px solid #f1f5f9;
        }
        .photo-upload-wrapper:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
        }
        .photo-preview-img {
            width: 130px;
            height: 170px;
            object-fit: cover;
            border-radius: 18px;
            background-color: #f8fafc;
            display: block;
        }
        .photo-upload-btn {
            position: absolute;
            bottom: -5px;
            right: -5px;
            width: 42px;
            height: 42px;
            background: #111827;
            color: #fff;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
            transition: all 0.2s ease;
            border: 3px solid #fff;
        }
        .photo-upload-btn:hover {
            background: #000;
            transform: scale(1.1);
        }
        .photo-upload-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Premium CMS Table Styles */
        .cms-table-container {
            border-radius: 16px;
            overflow-x: auto;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            /* Custom Scrollbar for premium feel */
            scrollbar-width: thin;
            scrollbar-color: #d1d5db transparent;
        }

        .cms-table-container::-webkit-scrollbar {
            height: 6px;
        }
        .cms-table-container::-webkit-scrollbar-track {
            background: transparent;
        }
        .cms-table-container::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 20px;
        }

        .cms-table {
            width: 100%;
            min-width: 800px; /* Prevent squishing */
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 0;
        }

        .cms-table thead th {
            background: #f9fafb;
            padding: 16px 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #4b5563;
            border-bottom: 1px solid #e5e7eb;
        }

        .cms-table tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.2s;
        }

        .cms-table tbody tr:last-child td {
            border-bottom: none;
        }

        .cms-table tbody tr:hover td {
            background: #f9fafb;
        }

        .cms-thumb {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            object-fit: cover;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
        }

        .cms-action-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: all 0.2s;
            border: none;
            background: #f3f4f6;
            color: #4b5563;
        }

        @media (max-width: 768px) {
            .cms-add-btn {
                padding: 6px 14px !important;
                font-size: 0.75rem !important;
            }
            .cms-add-btn i {
                font-size: 0.75rem !important;
                margin-right: 4px !important;
            }
        }


        .cms-action-btn:hover {
            background: #e5e7eb;
            color: #1f2937;
            transform: translateY(-2px);
        }

        .cms-action-btn.edit:hover {
            background: #eff6ff;
            color: #2563eb;
        }

        .cms-action-btn.delete:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        .cms-premium-modal .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .cms-premium-modal .modal-header {
            border-bottom: 1px solid #f3f4f6;
            padding: 24px 32px;
        }
    </style>
</head>
<body class="" style="background-color: #dbeafe;">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
                <img src="assets/image.png" alt="Logo Polri" style="height: 40px;">
                <div class="logo-text d-flex flex-column">
                    <span class="main-title text-dark fw-bold" style="font-size: 1rem; letter-spacing: 0.5px;">ADMIN PANEL</span>
                    <span class="sub-title" style="color: #1e3a8a; font-size: 0.7rem;">Pokdar Kamtibmas Bhayangkara</span>
                </div>
            </a>
            <button class="navbar-toggler border-0 shadow-none d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAdminMenu">
                <i class="fas fa-bars text-dark"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-lg-3 align-items-center">
                    <li class="nav-item"><a class="nav-link text-dark fw-medium opacity-75" href="index.php">Beranda</a></li>
                    <li class="nav-item">
                        <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-bold">Keluar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex flex-column min-vh-100">
        <main class="flex-grow-1 py-5">
        <div class="container">
            <!-- Header Section -->
            <div class="row align-items-center mb-5 animate-up dashboard-header-row">
                <div class="col-lg-7 mb-4 mb-lg-0 mobile-text-center">
                    <h1 class="fw-bold display-5 dashboard-main-title">Dashboard Pengelola</h1>
                    <p class="text-muted fs-5 mb-0 dashboard-subtitle">Selamat datang kembali! Kelola database anggota dan publikasi konten.</p>
                </div>
                <div class="col-lg-5 text-center">
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-end">
                        <?php
                            $dataFile = 'data/pendaftaran.json';
                            $data = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];
                            $total = is_array($data) ? count($data) : 0;
                        ?>
                        <div class="card bg-dark text-white border-0 shadow-sm rounded-4 text-center p-3 w-100 stats-card-compact" style="max-width: 200px;">
                            <span class="fs-2 mb-1 stats-count" id="active-member-count"><?php echo $total; ?></span>
                            <span class="small opacity-75 stats-label">Total Anggota Aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Section -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden animate-up delay-1">
                <div class="card-header bg-white p-0">
                    <ul class="nav nav-tabs border-0" id="adminTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-3 px-4" id="cms-tab" data-bs-toggle="tab" data-bs-target="#cms" type="button" role="tab" onclick="loadCMS('hero')">Manajemen Konten</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active py-3 px-4" id="pendaftaran-tab" data-bs-toggle="tab" data-bs-target="#pendaftaran" type="button" role="tab">Database Anggota</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-3 px-4 text-danger" id="trash-tab" data-bs-toggle="tab" data-bs-target="#trash-section" type="button" role="tab" onclick="loadTrash()"><i class="fas fa-door-open me-2"></i>Anggota Keluar</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4 bg-white">
                    <div class="tab-content" id="adminTabsContent">
                        
                        <!-- Tab Manajemen Konten -->
                        <div class="tab-pane fade" id="cms" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-lg-3">
                                    <div class="d-lg-none mb-3">
                                        <div class="mobile-menu-selector" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCmsMenu">
                                            <span class="mobile-menu-label" id="active-cms-pill-label">Hero Section</span>
                                            <i class="fas fa-chevron-down mobile-menu-icon"></i>
                                        </div>
                                    </div>
                                    <div class="nav nav-pills" id="cms-pills-tab" role="tablist">
                                        <button class="nav-link active text-start" data-bs-toggle="pill" onclick="loadCMS('hero')"><i class="fas fa-rocket me-2 me-lg-3 text-accent"></i> Hero Section</button>
                                        <button class="nav-link text-start" data-bs-toggle="pill" onclick="loadCMS('news')"><i class="fas fa-newspaper me-2 me-lg-3 text-accent"></i> Berita & Artikel</button>
                                        <button class="nav-link text-start" data-bs-toggle="pill" onclick="loadCMS('tentang')"><i class="fas fa-info-circle me-2 me-lg-3 text-accent"></i> Tentang Kami</button>
                                        <!-- <button class="nav-link text-start" data-bs-toggle="pill" onclick="loadCMS('sejarah')"><i class="fas fa-history me-2 me-lg-3 text-accent"></i> Sejarah & Timeline</button> -->
                                        <button class="nav-link text-start" data-bs-toggle="pill" onclick="loadCMS('structure')"><i class="fas fa-users me-2 me-lg-3 text-accent"></i> Struktur Organisasi</button>
                                        <button class="nav-link text-start" data-bs-toggle="pill" onclick="loadCMS('kegiatan')"><i class="fas fa-camera-retro me-2 me-lg-3 text-accent"></i> Galeri Kegiatan</button>
                                        <button class="nav-link text-start" data-bs-toggle="pill" onclick="loadCMS('faq')"><i class="fas fa-question-circle me-2 me-lg-3 text-accent"></i> Tanya Jawab (FAQ)</button>
                                        <button class="nav-link text-start" data-bs-toggle="pill" onclick="loadCMS('jadwal_kegiatan')"><i class="fas fa-calendar-alt me-2 me-lg-3 text-accent"></i> Jadwal Agenda</button>
                                        <button class="nav-link text-start" data-bs-toggle="pill" onclick="loadCMS('contact')"><i class="fas fa-address-book me-2 me-lg-3 text-accent"></i> Kontak & Media</button>
                                        <button class="nav-link text-start" data-bs-toggle="pill" onclick="loadCMS('stats')"><i class="fas fa-chart-bar me-2 me-lg-3 text-accent"></i> Statistik Utama</button>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div id="cms-editor-container" class="border rounded-4 p-4 bg-light shadow-sm">
                                        <!-- Loaded via JS -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Database Anggota -->
                        <div class="tab-pane fade show active" id="pendaftaran" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold mb-0 d-none d-lg-block">Daftar Pendaftar</h5>
                                <button class="btn btn-dark rounded-3 px-4 py-2 fw-bold shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                                    <i class="fas fa-user-plus"></i> Tambah Anggota
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle border-0">
                                    <thead class="table-light">
                                        <tr class="small text-uppercase fw-bold text-muted">
                                            <th class="border-0 d-none d-md-table-cell">No Anggota</th>
                                            <th class="border-0">Nama Lengkap</th>
                                            <th class="border-0 d-none d-sm-table-cell">L/P</th>
                                            <th class="border-0 d-none d-md-table-cell">Sektor</th>
                                            <th class="border-0 d-none d-lg-table-cell">Status</th>
                                            <th class="border-0 text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="member-table-body" class="border-top-0">
                                        <?php if ($total > 0): ?>
                                            <?php foreach (array_reverse($data) as $row): ?>
                                                <?php $isKhusus = ($row['member_type'] ?? '') === 'Khusus'; ?>
                                                <tr>
                                                    <td class="d-none d-md-table-cell"><code class="bg-light p-1 rounded"><?php echo htmlspecialchars($row['no_anggota'] ?: $row['reg_number']); ?></code></td>
                                                    <td>
                                                        <div class="fw-bold text-uppercase"><?php echo htmlspecialchars($row['full_name']); ?></div>
                                                        <div class="d-md-none small text-muted"><?php echo htmlspecialchars($row['no_anggota'] ?: $row['reg_number']); ?></div>
                                                    </td>
                                                    <td class="d-none d-sm-table-cell"><span class="badge bg-light text-dark"><?php echo htmlspecialchars($row['gender'] === 'Laki-laki' ? 'L' : 'P'); ?></span></td>
                                                    <td class="small d-none d-md-table-cell">Sektor <?php echo htmlspecialchars($row['sector']); ?> - Sub <?php echo htmlspecialchars($row['subsector']); ?></td>
                                                    <td class="d-none d-lg-table-cell">
                                                        <?php 
                                                            $status = $row['status'] ?? 'Pending';
                                                            $badgeClass = 'bg-warning-subtle text-warning';
                                                            if($status === 'Approved') $badgeClass = 'bg-success-subtle text-success';
                                                            if($status === 'Rejected') $badgeClass = 'bg-danger-subtle text-danger';
                                                            // Penilaian
                                                            $pen = $row['penilaian'] ?? null;
                                                            $penBadge = '';
                                                            if($pen && isset($pen['total'])) {
                                                                $pt = $pen['total'];
                                                                $pBg = '#e2e8f0'; $pColor = '#64748b';
                                                                if($pt >= 14)     { $pBg = '#0d9488'; $pColor = '#fff'; }
                                                                elseif($pt >= 11) { $pBg = '#d1fae5'; $pColor = '#065f46'; }
                                                                elseif($pt >= 6)  { $pBg = '#dbeafe'; $pColor = '#1e40af'; }
                                                                elseif($pt >= 1)  { $pBg = '#fef3c7'; $pColor = '#92400e'; }
                                                                $pLabel = $pt >= 14 ? 'Sangat Baik' : ($pt >= 11 ? 'Baik' : ($pt >= 6 ? 'Cukup Baik' : 'Perlu Pembinaan'));
                                                                $penBadge = '<span class="badge px-2 py-1" style="background:'.$pBg.';color:'.$pColor.';font-size:11px;"><i class="fas fa-clipboard-check me-1"></i>'.$pt.'/15 '.$pLabel.'</span>';
                                                            }
                                                        ?>
                                                        <div class="d-flex flex-column gap-1 align-items-start">
                                                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                                                <span class="badge <?php echo $badgeClass; ?> border px-2"><?php echo $status; ?></span>
                                                                <?php if($isKhusus): ?><span class="badge bg-warning text-dark px-2"><i class="fas fa-star me-1"></i>Khusus</span><?php endif; ?>
                                                            </div>
                                                            <?php if($penBadge): ?><?php echo $penBadge; ?><?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex gap-1 justify-content-end">
                                                            <button class="btn btn-sm btn-outline-primary rounded-3" title="Review"
                                                                    data-bs-toggle="modal" data-bs-target="#detailModal"
                                                                    data-reg="<?php echo htmlspecialchars($row['reg_number']); ?>"
                                                                    data-name="<?php echo htmlspecialchars($row['full_name']); ?>"
                                                                    data-gender="<?php echo htmlspecialchars($row['gender']); ?>"
                                                                    data-sector="<?php echo htmlspecialchars($row['sector']); ?>"
                                                                    data-subsector="<?php echo htmlspecialchars($row['subsector']); ?>"
                                                                    data-date="<?php echo date('d F Y, H:i', strtotime($row['timestamp'])); ?>"
                                                                    data-address="<?php echo htmlspecialchars($row['address']); ?>"
                                                                    data-status="<?php echo htmlspecialchars($row['status'] ?? 'Pending'); ?>"
                                                                    data-file="<?php echo htmlspecialchars($row['file_path'] ?? ''); ?>">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-secondary rounded-3" title="Print Kartu Anggota" onclick="printMemberCard('<?php echo htmlspecialchars($row['reg_number']); ?>')">
                                                                <i class="fas fa-print"></i>
                                                            </button>
                                                            <?php if($status === 'Approved'): ?>
                                                            <button class="btn btn-sm rounded-3 <?php echo $isKhusus ? 'btn-warning' : 'btn-outline-warning'; ?>" title="<?php echo $isKhusus ? 'Edit Rekomendasi' : 'Rekomendasikan sebagai Anggota Khusus'; ?>" onclick="openRekomendasiModal('<?php echo htmlspecialchars($row['reg_number']); ?>', '<?php echo htmlspecialchars($row['full_name']); ?>', '<?php echo htmlspecialchars(addslashes($row['rekomendasi_alasan'] ?? '')); ?>')">
                                                                <i class="fas fa-star"></i>
                                                            </button>
                                                            <?php endif; ?>
                                                            <?php if($status === 'Approved'): ?>
                                                            <button class="btn btn-sm btn-outline-info rounded-3" title="Penilaian Anggota" onclick="openPenilaianModal('<?php echo htmlspecialchars($row['reg_number']); ?>', '<?php echo htmlspecialchars($row['full_name']); ?>', '<?php echo htmlspecialchars($row['position'] ?? ''); ?>')">
                                                                <i class="fas fa-clipboard-check"></i>
                                                            </button>
                                                            <?php endif; ?>
                                                            <button class="btn btn-sm btn-outline-danger rounded-3" title="Keluarkan Anggota" onclick="moveToTrash('<?php echo $row['reg_number']; ?>')">
                                                                <i class="fas fa-sign-out-alt"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-5 text-muted">Belum ada data pendaftar.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab Anggota Keluar -->
                        <div class="tab-pane fade" id="trash-section" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h4 class="fw-bold mb-1">Anggota Keluar</h4>
                                    <p class="text-muted small mb-0">Daftar anggota yang telah dikeluarkan. Anda dapat memulihkan atau menghapus permanen.</p>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle border-0">
                                    <thead class="table-light">
                                        <tr class="small text-uppercase fw-bold text-muted">
                                            <th class="border-0 d-none d-md-table-cell">Reg Number</th>
                                            <th class="border-0">Nama Lengkap</th>
                                            <th class="border-0 d-none d-sm-table-cell">L/P</th>
                                            <th class="border-0 d-none d-md-table-cell">Sektor</th>
                                            <th class="border-0 text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="trash-table-body" class="border-top-0">
                                        <!-- Trash data will load here -->
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <div class="spinner-border spinner-border-sm me-2"></div> Memuat arsip...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Detail Modal (Split View XL) -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-white border-bottom py-3 px-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-accent p-2 rounded-3 text-white">
                            <i class="fas fa-user-check fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Review Pendaftaran Anggota</h5>
                            <div class="d-flex align-items-center mt-1">
                                <small class="text-muted me-3" id="m-reg-display">REG-000</small>
                                <div class="border-start ps-3" id="m-status-badge">
                                    <!-- Status badge populated by JS -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <!-- Left: PDF Viewer (becomes order-2 on mobile) -->
                        <div class="col-lg-8 bg-light border-end order-2 order-lg-1" style="min-height: 600px;">
                            <div id="pdf-viewer-container" class="h-100 d-flex flex-column">
                                <iframe id="m-pdf-viewer" src="" class="w-100 flex-grow-1 border-0" style="min-height: 600px;"></iframe>
                                <div id="no-pdf-message" class="flex-grow-1 d-none align-items-center justify-content-center text-center p-5">
                                    <div class="text-muted">
                                        <i class="fas fa-file-invoice fs-1 mb-3 d-block opacity-25"></i>
                                        <p class="mb-0 fw-bold">Tidak ada berkas terlampir</p>
                                        <small>Anggota ini tidak mengunggah dokumen pendaftaran.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right: Data Controls (becomes order-1 on mobile) -->
                        <div class="col-lg-4 p-4 order-1 order-lg-2">
                            <form id="editMemberForm">
                                <input type="hidden" name="reg_number" id="m-reg-val">
                                <input type="hidden" name="status" id="m-status-val">

                                <div class="section-badge mb-3">Data Calon Anggota</div>

                                <div class="text-center mb-4">
                                    <div class="photo-upload-wrapper">
                                        <img id="m-photo-preview" src="assets/img/avatar-placeholder.png" class="photo-preview-img">
                                        <label for="m-photo" class="photo-upload-btn">
                                            <i class="fas fa-camera fa-sm"></i>
                                        </label>
                                        <input type="file" name="photo" id="m-photo" class="d-none" accept="image/*" onchange="previewImage(this, 'm-photo-preview')">
                                    </div>
                                    <div class="photo-upload-label">Pas Foto Anggota</div>
                                </div>
                                
                                <div class="row g-3 mb-3">
                                    <div class="col-12">
                                        <label class="small fw-bold text-muted mb-1">NAMA LENGKAP</label>
                                        <input type="text" name="full_name" id="m-name" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2 fw-bold" required>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">TEMPAT LAHIR</label>
                                        <input type="text" name="birth_place" id="m-birth-place" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2">
                                    </div>
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">TANGGAL LAHIR</label>
                                        <input type="date" name="birth_date" id="m-birth-date" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2">
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">JENIS KELAMIN</label>
                                        <select name="gender" id="m-gender" class="form-select bg-light border-0 rounded-3 fs-6 px-3 py-2">
                                            <option value="Laki-laki">L</option>
                                            <option value="Perempuan">P</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">PENDIDIKAN</label>
                                        <select name="education" id="m-education" class="form-select bg-light border-0 rounded-3 fs-6 px-3 py-2">
                                            <option value="SD">SD</option>
                                            <option value="SMP">SMP</option>
                                            <option value="SMA">SMA</option>
                                            <option value="S1">S1</option>
                                            <option value="S2">S2</option>
                                            <option value="S3">S3</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">PEKERJAAN</label>
                                        <select name="occupation" id="m-occupation" class="form-select bg-light border-0 rounded-3 fs-6 px-3 py-2">
                                            <option value="PNS">PNS</option>
                                            <option value="PENSIUN">PENSIUN</option>
                                            <option value="KARYAWAN SWASTA">KARYAWAN SWASTA</option>
                                            <option value="SECURITY">SECURITY</option>
                                            <option value="WIRASWASTA">WIRASWASTA</option>
                                            <option value="IRT">IRT</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">NIK</label>
                                        <input type="text" name="nik" id="m-nik" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2">
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-12">
                                        <label class="small fw-bold text-muted mb-1">HP</label>
                                        <input type="text" name="phone" id="m-phone" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2">
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">KECAMATAN</label>
                                        <select name="sector" id="m-sector" class="form-select bg-light border-0 rounded-3 fs-6 px-3 py-2" onchange="updateKelurahanDropdown(this.value)">
                                            <!-- Options will be populated by JS -->
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">KELURAHAN</label>
                                        <select name="subsector" id="m-subsector" class="form-select bg-light border-0 rounded-3 fs-6 px-3 py-2" onchange="updateMemberId()">
                                            <!-- Options will be populated by JS -->
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small fw-bold text-muted mb-1">ALAMAT LENGKAP</label>
                                    <textarea name="address" id="m-address" class="form-control bg-light border-0 rounded-3 fs-6 px-3" rows="2"></textarea>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-12">
                                        <label class="small fw-bold text-muted mb-1">NO ANGGOTA</label>
                                        <input type="text" name="no_anggota" id="m-id-number" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2 fw-bold" placeholder="Otomatis..." readonly>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">JABATAN</label>
                                        <input type="text" name="position" id="m-position" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2">
                                    </div>
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">KODE PANGGIL</label>
                                        <input type="text" name="call_code" id="m-call-code" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small fw-bold text-muted mb-1 text-uppercase">LAMPIRAN DOKUMEN (PDF/ZIP)</label>
                                    <div id="m-file-status" class="bg-light p-2 rounded-3 mb-2 small"></div>
                                    <input type="file" name="reg_file" id="m-reg-file" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2">
                                </div>

                                <div class="section-badge mb-3 d-none">REKOMENDASI CETAK KARTU</div>
                                <div class="mb-4 d-none">
                                    <textarea name="card_recommendation" id="m-card-recommendation" class="form-control bg-light border-0 rounded-4 p-3" rows="3"></textarea>
                                </div>

                                <div class="d-grid gap-2 pt-3 border-top">
                                    <button type="submit" class="btn btn-primary rounded-pill py-2 fw-bold text-uppercase" style="background-color: #4472c4; border: none;">
                                        SIMPAN
                                    </button>
                                    <div class="row gx-2">
                                        <div class="col-6">
                                            <button type="button" onclick="setMemberStatus('Approved')" class="btn btn-success w-100 rounded-3 py-2 fw-bold small">
                                                <i class="fas fa-check-circle me-1"></i> Approve
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button type="button" onclick="setMemberStatus('Rejected')" class="btn btn-outline-danger w-100 rounded-3 py-2 fw-bold small">
                                                <i class="fas fa-times-circle me-1"></i> Tolak
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="js/script.js"></script>
    <script>
        // Custom Premium Toast System
        function showToast(message, type = 'success', title = '') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `custom-toast ${type}`;
            
            if (!title) {
                if (type === 'success') title = 'Berhasil';
                else if (type === 'error') title = 'Terjadi Kesalahan';
                else if (type === 'warning') title = 'Peringatan';
                else title = 'Informasi';
            }

            const icons = {
                success: 'fa-check-circle text-success',
                error: 'fa-exclamation-circle text-danger',
                warning: 'fa-exclamation-triangle text-warning',
                info: 'fa-info-circle text-info'
            };

            toast.innerHTML = `
                <div class="custom-toast-icon">
                    <i class="fas ${icons[type] || icons.info}"></i>
                </div>
                <div class="custom-toast-content">
                    <span class="custom-toast-title">${title}</span>
                    <p class="custom-toast-message mb-0">${message}</p>
                </div>
                <button class="custom-toast-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;

            container.appendChild(toast);
            
            // Force reflow for animation
            toast.offsetHeight;
            toast.classList.add('show');

            // Auto remove
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 500);
            }, 2000);
        }

        // Global Data for Dropdowns
        let polsekData = [];
        let kelurahanData = [];
        let allMembersData = [];

        async function loadDropdownData() {
            try {
                const [polsekRes, kelurahanRes, membersRes] = await Promise.all([
                    fetch('data/polsek.json'),
                    fetch('data/kelurahan.json'),
                    fetch('data/pendaftaran.json?v=' + Date.now())
                ]);
                polsekData = await polsekRes.json();
                kelurahanData = await kelurahanRes.json();
                allMembersData = await membersRes.json();
                
                populatePolsekDropdown();
            } catch (err) {
                console.error('Gagal memuat data:', err);
            }
        }

        function populatePolsekDropdown() {
            const selects = [document.getElementById('m-sector'), document.getElementById('a-sector')];
            selects.forEach(select => {
                if(!select) return;
                select.innerHTML = '<option value="">Pilih Kecamatan</option>';
                polsekData.forEach(p => {
                    const opt = document.createElement('option');
                    opt.value = p.id;
                    opt.textContent = p.nama;
                    select.appendChild(opt);
                });
            });
        }

        function updateKelurahanDropdown(polsekId, selectedKeluarahan = '') {
            const select = document.getElementById('m-subsector');
            if(!select) return;
            select.innerHTML = '<option value="">Pilih Kelurahan</option>';
            
            const filtered = kelurahanData.filter(k => k.polsek_id === polsekId);
            filtered.forEach(k => {
                const opt = document.createElement('option');
                opt.value = k.kode;
                opt.textContent = k.nama;
                if(k.kode === selectedKeluarahan) opt.selected = true;
                select.appendChild(opt);
            });
            
            if (!selectedKeluarahan) {
                updateMemberId();
            }
        }

        function updateKelurahanDropdownAdd(polsekId) {
            const select = document.getElementById('a-subsector');
            if(!select) return;
            select.innerHTML = '<option value="">Pilih Kelurahan</option>';
            
            const filtered = kelurahanData.filter(k => k.polsek_id === polsekId);
            filtered.forEach(k => {
                const opt = document.createElement('option');
                opt.value = k.kode;
                opt.textContent = k.nama;
                select.appendChild(opt);
            });
            updateMemberIdAdd();
        }

        function updateMemberId() {
            const polsekId = document.getElementById('m-sector').value;
            const kelurahanKode = document.getElementById('m-subsector').value;
            const idInput = document.getElementById('m-id-number');
            
            if(polsekId && kelurahanKode) {
                const pObj = polsekData.find(p => p.id === polsekId);
                const polsekKode = pObj ? pObj.kode : '';
                
                // Sequence based on total registered members + 1
                const nextSeq = (allMembersData.length + 1).toString().padStart(4, '0');
                if(idInput) idInput.value = `0741-${polsekKode}${kelurahanKode}-${nextSeq}`;
            } else {
                if(idInput) idInput.value = '';
            }
        }

        function updateMemberIdAdd() {
            const polsekId = document.getElementById('a-sector').value;
            const kelurahanKode = document.getElementById('a-subsector').value;
            const idInput = document.querySelector('#addMemberForm [name="no_anggota"]');
            
            if(polsekId && kelurahanKode) {
                const pObj = polsekData.find(p => p.id === polsekId);
                const polsekKode = pObj ? pObj.kode : '';
                
                // Sequence based on total registered members + 1
                const nextSeq = (allMembersData.length + 1).toString().padStart(4, '0');
                if(idInput) idInput.value = `0741-${polsekKode}${kelurahanKode}-${nextSeq}`;
            } else {
                if(idInput) idInput.value = '';
            }
        }

        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Initialize dropdown data
        loadDropdownData();

        // Helper functions for safe DOM updates
        const setVal = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.value = val || '';
        };
        const setHTML = (id, html) => {
            const el = document.getElementById(id);
            if (el) el.innerHTML = html || '';
        };
        const setSrc = (id, src) => {
            const el = document.getElementById(id);
            if (el) el.src = src || '';
        };

        // Modal Population for Edit
        const detailModal = document.getElementById('detailModal');
        if (detailModal) {
            detailModal.addEventListener('show.bs.modal', async (event) => {
                const btn = event.relatedTarget;
                const regNum = btn.getAttribute('data-reg');
                
                // Reset form first
                const form = document.getElementById('editMemberForm');
                if (form) form.reset();
                
                // Reload data to ensure sequence is accurate
                await loadDropdownData();
                
                const member = allMembersData.find(m => m.reg_number === regNum);

                if(member) {
                    setVal('m-name', member.full_name);
                    const regDisplay = document.getElementById('m-reg-display');
                    if (regDisplay) regDisplay.textContent = member.reg_number;
                    
                    setVal('m-reg-val', member.reg_number);
                    setVal('m-gender', (member.gender === 'Perempuan' ? 'Perempuan' : 'Laki-laki'));
                    setVal('m-birth-place', member.birth_place);
                    setVal('m-birth-date', member.birth_date);
                    setVal('m-education', member.education || 'SMA');
                    setVal('m-occupation', member.occupation || 'WIRASWASTA');
                    setVal('m-nik', member.nik);
                    setVal('m-phone', member.phone);
                    setVal('m-address', member.address);
                    setVal('m-position', member.position);
                    setVal('m-call-code', member.call_code);
                    setVal('m-card-recommendation', member.card_recommendation);
                    setVal('m-status-val', member.status || 'Pending');
                    
                    // Profile Photo Preview
                    const photoPath = member.photo_path || member.profile_path; // Support both naming variants if user edited manually
                    const photoPreview = document.getElementById('m-photo-preview');
                    if (photoPreview) {
                        if (photoPath && photoPath !== 'N/A' && photoPath !== '') {
                            photoPreview.src = photoPath.replace(/\\/g, '/') + '?v=' + Date.now();
                        } else {
                            photoPreview.src = 'assets/img/avatar-placeholder.png';
                        }
                    }
                    
                    // Dropdowns
                    let polsekId = member.sector;
                    // If member.sector is a code (legacy), find the matching unique ID
                    const matchingPolseks = polsekData.filter(p => p.kode === member.sector);
                    if (matchingPolseks.length > 1) {
                        // Ambiguous code (01, 02, 04), use kelurahan code to find the correct Polsek ID
                        const correctK = kelurahanData.find(k => k.polsek_id.startsWith(member.sector) && k.kode === member.subsector);
                        if (correctK) polsekId = correctK.polsek_id;
                    } else if (matchingPolseks.length === 1) {
                        polsekId = matchingPolseks[0].id;
                    }
                    
                    setVal('m-sector', polsekId);
                    updateKelurahanDropdown(polsekId || '', member.subsector || '');
                    
                    // ID Number logic
                    if (member.no_anggota) {
                        setVal('m-id-number', member.no_anggota);
                    } else if (member.sector && member.subsector) {
                        updateMemberId();
                    }

                    // Metadata display
                    setVal('m-date', btn.getAttribute('data-date'));
                    
                    // Status Badge update
                    const status = member.status || 'Pending';
                    let badgeClass = 'bg-warning-subtle text-warning';
                    if(status === 'Approved') badgeClass = 'bg-success-subtle text-success';
                    if(status === 'Rejected') badgeClass = 'bg-danger-subtle text-danger';
                    setHTML('m-status-badge', `<span class="badge ${badgeClass} border fw-bold w-100 py-2">${status}</span>`);

                    const filePath = member.file_path;
                    const pdfViewer = document.getElementById('m-pdf-viewer');
                    const noPdfMessage = document.getElementById('no-pdf-message');
                    
                    if (pdfViewer && noPdfMessage) {
                        if (filePath && filePath !== 'N/A' && filePath !== '') {
                            const cleanPath = filePath.replace(/\\/g, '/');
                            pdfViewer.src = cleanPath + '#view=FitH&scrollbar=0&toolbar=0';
                            pdfViewer.classList.remove('d-none');
                            noPdfMessage.classList.remove('d-flex');
                            noPdfMessage.classList.add('d-none');
                        } else {
                            pdfViewer.src = 'about:blank';
                            pdfViewer.classList.add('d-none');
                            noPdfMessage.classList.remove('d-none');
                            noPdfMessage.classList.add('d-flex');
                        }
                    }
                }
            });

            // Form Submit for Update Member
            document.getElementById('editMemberForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(e.target);
                const submitBtn = e.target.querySelector('button[type="submit"]');
                
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';

                try {
                    const resp = await fetch('update_member.php', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await resp.json();
                    if (result.status === 'success') {
                        // Success Feedback
                        bootstrap.Modal.getInstance(document.getElementById('detailModal')).hide();
                        await loadMembers();
                        showToast('Data anggota berhasil diperbarui!', 'success');
                    } else {
                        showToast(result.message, 'error');
                    }
                } catch (err) {
                    showToast('Gagal menghubungi server', 'error');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save me-2 text-accent"></i> Simpan Data Saja';
                }
            });
        }

        async function setMemberStatus(status) {
            const regNumber = document.getElementById('m-reg-val').value;
            const formData = new FormData(document.getElementById('editMemberForm'));
            formData.set('status', status);

            try {
                const resp = await fetch('update_member.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await resp.json();
                if (result.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('detailModal')).hide();
                    await loadMembers();
                    showToast(`Pendaftaran Berhasil ${status === 'Approved' ? 'Disetujui' : 'Ditolak'}!`, 'success');
                } else {
                    showToast(result.message, 'error');
                }
            } catch (err) {
                showToast('Gagal menghubungi server', 'error');
            }
        }

        async function loadMembers() {
            const tableBody = document.getElementById('member-table-body');
            try {
                const resp = await fetch('data/pendaftaran.json?v=' + Date.now());
                const data = await resp.json();
                allMembersData = data; // Keep global data in sync
                
                // Update counter
                const counterEl = document.getElementById('active-member-count');
                if(counterEl) counterEl.innerText = data.length;
                
                if (data.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-5 text-muted">Belum ada data pendaftar.</td></tr>';
                    return;
                }

                let html = '';
                // data is array, reverse to show newest first
                [...data].reverse().forEach(row => {
                    const date = new Date(row.timestamp);
                    const longDate = date.toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) + ', ' +
                                    date.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'});

                    const status = row.status || 'Pending';
                    let statusBadge = `<span class="badge bg-warning-subtle text-warning border px-2">Pending</span>`;
                    if(status === 'Approved') statusBadge = `<span class="badge bg-success-subtle text-success border px-2">Approved</span>`;
                    if(status === 'Rejected') statusBadge = `<span class="badge bg-danger-subtle text-danger border px-2">Rejected</span>`;

                    // Lookup names for better display
                    const pObj = polsekData.find(p => p.id === row.sector || p.kode === row.sector);
                    const kObj = kelurahanData.find(k => (k.polsek_id === row.sector || k.polsek_id.startsWith(row.sector)) && k.kode === row.subsector);
                    const sectorName = pObj ? pObj.nama : (row.sector || '-');
                    const subsectorName = kObj ? kObj.nama : (row.subsector || '-');

                    const isKhusus = (row.member_type || '') === 'Khusus';
                    const isApproved = status === 'Approved';
                    const khususBadge = isKhusus ? `<span class="badge bg-warning text-dark small px-2 py-1"><i class="fas fa-star me-1"></i>Anggota Khusus</span>` : '';
                    // Penilaian badge
                    let penilaianBadge = '';
                    if (row.penilaian && row.penilaian.total !== undefined) {
                        const pt = row.penilaian.total;
                        let pColor = '#64748b', pBg = '#e2e8f0';
                        if (pt >= 14)     { pBg = '#0d9488'; pColor = '#fff'; }
                        else if (pt >= 11){ pBg = '#d1fae5'; pColor = '#065f46'; }
                        else if (pt >= 6) { pBg = '#dbeafe'; pColor = '#1e40af'; }
                        else if (pt >= 1) { pBg = '#fef3c7'; pColor = '#92400e'; }
                        const pLabel = pt >= 14 ? 'Sangat Baik' : pt >= 11 ? 'Baik' : pt >= 6 ? 'Cukup Baik' : 'Perlu Pembinaan';
                        penilaianBadge = `<span class="badge px-2 py-1" style="background:${pBg};color:${pColor};font-size:11px;" title="Penilaian: Loyalitas ${row.penilaian.loyalitas||0}, Keaktifan ${row.penilaian.keaktifan||0}, Anggota Terbanyak ${row.penilaian.anggota_terbanyak||0}"><i class="fas fa-clipboard-check me-1"></i>${pt}/15 ${pLabel}</span>`;
                    }
                    // Rekomendasi button only for Approved members
                    let rekBtn = '';
                    let penilaianBtn = '';
                    if (isApproved) {
                        const safeAlasan = (row.rekomendasi_alasan || '').replace(/'/g, "\\'" ).replace(/\n/g, '\\n');
                        const safeName = row.full_name.replace(/'/g, "\\'");
                        rekBtn = isKhusus
                            ? `<button class="btn btn-sm btn-warning rounded-3" title="Edit Rekomendasi Anggota Khusus" onclick="openRekomendasiModal('${row.reg_number}', '${safeName}', '${safeAlasan}')"><i class="fas fa-star"></i></button>`
                            : `<button class="btn btn-sm btn-outline-warning rounded-3" title="Rekomendasikan sebagai Anggota Khusus" onclick="openRekomendasiModal('${row.reg_number}', '${safeName}', '')"><i class="fas fa-star"></i></button>`;
                        penilaianBtn = `<button class="btn btn-sm btn-outline-info rounded-3" title="Penilaian Anggota" onclick="openPenilaianModal('${row.reg_number}', '${safeName}', '${(row.position || '').replace(/'/g,"\\'")}')"><i class="fas fa-clipboard-check"></i></button>`;
                    }

                    html += `
                        <tr>
                            <td class="d-none d-md-table-cell"><code class="bg-light p-1 rounded">${row.no_anggota || row.reg_number}</code></td>
                            <td>
                                <div class="fw-bold text-uppercase">${row.full_name}</div>
                                <div class="d-md-none small text-muted">${row.no_anggota || row.reg_number}</div>
                            </td>
                            <td class="d-none d-sm-table-cell"><span class="badge bg-light text-dark">${row.gender === 'Laki-laki' ? 'L' : (row.gender === 'Perempuan' ? 'P' : '-')}</span></td>
                            <td class="small d-none d-md-table-cell text-uppercase">
                                <div class="fw-bold">${sectorName}</div>
                                <div class="text-muted small">${subsectorName}</div>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <div class="d-flex flex-column gap-1 align-items-start">
                                    <div class="d-flex flex-wrap gap-1">
                                        ${statusBadge}
                                        ${khususBadge}
                                    </div>
                                    ${penilaianBadge}
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="d-flex gap-1 justify-content-end">
                                    <button class="btn btn-sm btn-outline-primary rounded-3" title="Review"
                                            data-bs-toggle="modal" data-bs-target="#detailModal"
                                            data-reg="${row.reg_number}"
                                            data-name="${row.full_name}"
                                            data-gender="${row.gender}"
                                            data-sector="${row.sector}"
                                            data-subsector="${row.subsector}"
                                            data-date="${longDate}"
                                            data-address="${row.address}"
                                            data-status="${status}"
                                            data-file="${row.file_path || ''}">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary rounded-3" title="Print Kartu Anggota" onclick="printMemberCard('${row.reg_number}')">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    ${rekBtn}
                                    ${penilaianBtn}
                                    <button class="btn btn-sm btn-outline-danger rounded-3" title="Keluarkan Anggota" onclick="moveToTrash('${row.reg_number}')">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                });
                tableBody.innerHTML = html;
            } catch (err) {
                console.error('Gagal memuat ulang data anggota:', err);
            }
        }

        function openRekomendasiModal(regNumber, memberName, existingAlasan = '') {
            document.getElementById('rek-reg-number').value = regNumber;
            document.getElementById('rek-member-name').textContent = memberName.toUpperCase();
            // Pre-fill existing reason if already Anggota Khusus
            const alasanField = document.getElementById('rek-alasan');
            alasanField.value = existingAlasan ? existingAlasan.replace(/\\n/g, '\n') : '';

            // Update modal subtitle based on whether already khusus
            const subtitle = document.querySelector('#rekomendasiModal .modal-header small');
            if (subtitle) {
                subtitle.textContent = existingAlasan
                    ? 'Edit alasan rekomendasi Anggota Khusus'
                    : 'Jadikan anggota biasa sebagai Anggota Khusus';
            }
            const modal = new bootstrap.Modal(document.getElementById('rekomendasiModal'));
            modal.show();

        }

        async function saveRekomendasi() {
            const reg = document.getElementById('rek-reg-number').value;
            const alasan = document.getElementById('rek-alasan').value.trim();
            if (!alasan) {
                document.getElementById('rek-alasan').classList.add('is-invalid');
                document.getElementById('rek-alasan').focus();
                return;
            }
            document.getElementById('rek-alasan').classList.remove('is-invalid');

            try {
                const formData = new FormData();
                formData.append('reg_number', reg);
                formData.append('member_type', 'Khusus');
                formData.append('rekomendasi_alasan', alasan);

                const resp = await fetch('update_member.php', { method: 'POST', body: formData });
                const result = await resp.json();

                bootstrap.Modal.getInstance(document.getElementById('rekomendasiModal')).hide();

                if (result.status === 'success') {
                    showToast('Anggota berhasil dijadikan Anggota Khusus!', 'success', 'Rekomendasi Berhasil');
                    await loadMembers();
                } else {
                    showToast(result.message || 'Gagal menyimpan rekomendasi.', 'error', 'Gagal');
                }
            } catch (err) {
                showToast('Gagal menghubungi server.', 'error');
            }
        }

        function printMemberCard(reg) {
            const member = allMembersData.find(m => m.reg_number === reg);
            if (!member) {
                showToast('Data anggota tidak ditemukan.', 'error');
                return;
            }

            const pObj = polsekData.find(p => p.id === member.sector || p.kode === member.sector);
            const kObj = kelurahanData.find(k => (k.polsek_id === member.sector || k.polsek_id.startsWith(member.sector + '-')) && k.kode === member.subsector);
            const sectorName = pObj ? pObj.nama : (member.sector || '-');
            const subsectorName = kObj ? kObj.nama : (member.subsector || '-');
            const isKhusus = (member.member_type || '') === 'Khusus';
            const baseUrl = window.location.href.replace('admin.php', '').replace(/\?.*$/, '');
            const photoSrc = member.photo_path || member.profile_path || 'assets/img/avatar-placeholder.png';
            const fullPhotoSrc = baseUrl + photoSrc.replace(/\\/g, '/');

            // ── Two card designs ──────────────────────────────────
            const cardBg = isKhusus
                ? 'linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%)'
                : 'linear-gradient(135deg, #1e3a5f 0%, #0d2137 100%)';

            const accentColor = isKhusus ? '#f59e0b' : 'rgba(255,255,255,0.25)';

            const specialTopStrip = isKhusus
                ? `<div style="background:linear-gradient(90deg,#f59e0b,#d97706);height:5px;margin:-14px -14px 10px -14px;"></div>`
                : '';

            const memberTypeLabel = isKhusus
                ? `<div style="display:inline-flex;align-items:center;gap:4px;background:#f59e0b;color:#111;font-size:7px;font-weight:700;padding:2px 8px;border-radius:4px;letter-spacing:0.5px;margin:3px 0;">
                       ★ ANGGOTA KHUSUS
                   </div>`
                : `<div style="font-size:6.5px;color:rgba(255,255,255,0.5);letter-spacing:0.5px;margin:3px 0;">ANGGOTA BIASA</div>`;

            const idBg = isKhusus
                ? 'linear-gradient(90deg,rgba(245,158,11,0.2),rgba(245,158,11,0.05))'
                : 'rgba(255,255,255,0.1)';
            const idBorder = isKhusus ? 'border: 1px solid rgba(245,158,11,0.4)' : '';

            const cardHTML = `<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>Kartu Anggota - ${member.full_name || ''}</title>
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');
                * { margin:0; padding:0; box-sizing:border-box; }
                body { font-family:'Inter',Arial,sans-serif; background:#e8ecf0; display:flex; flex-direction:column; justify-content:center; align-items:center; min-height:100vh; gap:10px; }
                .card-wrap { width:85.6mm; }
                .card { width:85.6mm; min-height:54mm; background:${cardBg}; border-radius:12px; padding:14px; color:white; display:flex; gap:12px; box-shadow:0 10px 40px rgba(0,0,0,0.4); position:relative; overflow:hidden; }
                .card::before { content:''; position:absolute; top:-30px; right:-30px; width:120px; height:120px; background:${accentColor}; border-radius:50%; opacity:0.12; }
                .card::after { content:''; position:absolute; bottom:-40px; left:30px; width:160px; height:160px; background:${accentColor}; border-radius:50%; opacity:0.07; }
                .photo { width:68px; height:80px; border-radius:8px; object-fit:cover; border:2px solid ${isKhusus ? '#f59e0b' : 'rgba(255,255,255,0.3)'}; flex-shrink:0; position:relative; z-index:1; }
                .info { flex:1; display:flex; flex-direction:column; justify-content:space-between; position:relative; z-index:1; }
                .org { font-size:6px; text-transform:uppercase; letter-spacing:1.5px; opacity:0.6; }
                .org-name { font-size:9px; font-weight:700; }
                .divider { height:1px; background:${isKhusus ? 'rgba(245,158,11,0.5)' : 'rgba(255,255,255,0.2)'}; margin:5px 0; }
                .name { font-size:11.5px; font-weight:900; text-transform:uppercase; line-height:1.2; }
                .field-label { font-size:6px; opacity:0.55; text-transform:uppercase; letter-spacing:0.6px; margin-top:4px; }
                .field-value { font-size:8px; font-weight:600; }
                .id-box { font-size:8px; font-weight:700; font-family:'Courier New',monospace; background:${idBg}; ${idBorder}; padding:3px 8px; border-radius:5px; letter-spacing:1px; display:inline-block; margin-top:2px; }
                @media print {
                    body { background:white; }
                    .no-print { display:none; }
                }
            </style></head><body>
            <div class="card-wrap">
                <div class="card">
                    ${specialTopStrip}
                    <img class="photo" src="${fullPhotoSrc}" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2268%22 height=%2280%22><rect fill=%22%23334155%22 width=%2268%22 height=%2280%22 rx=%228%22/><circle fill=%22%2364748b%22 cx=%2234%22 cy=%2228%22 r=%2212%22/><ellipse fill=%22%2364748b%22 cx=%2234%22 cy=%2270%22 rx=%2220%22 ry=%2212%22/></svg>'">
                    <div class="info">
                        <div>
                            <div class="org">Pokdar Kamtibmas</div>
                            <div class="org-name">Kota Tangerang Selatan</div>
                            <div class="divider"></div>
                            <div class="name">${(member.full_name || '-').toUpperCase()}</div>
                            ${memberTypeLabel}
                        </div>
                        <div>
                            <div class="field-label">NIK</div>
                            <div class="field-value">${member.nik || '-'}</div>
                            <div class="field-label">Sektor / Kelurahan</div>
                            <div class="field-value">${sectorName} / ${subsectorName}</div>
                            ${member.position ? `<div class="field-label">Jabatan</div><div class="field-value">${member.position}</div>` : ''}
                        </div>
                        <div class="id-box">${member.no_anggota || member.reg_number}</div>
                    </div>
                </div>
            </div>
            <script>window.onload = function() { window.print(); }<\/script>
            </body></html>`;

            const printWin = window.open('', '_blank', 'width=420,height=320');
            if (printWin) {
                printWin.document.write(cardHTML);
                printWin.document.close();
            } else {
                showToast('Pop-up diblokir browser. Izinkan pop-up untuk mencetak kartu.', 'warning');
            }
        }
        // ── Penilaian Anggota ─────────────────────────────────
        function openPenilaianModal(regNumber, memberName, jabatan) {
            const member = allMembersData.find(m => m.reg_number === regNumber);
            document.getElementById('pen-reg-number').value = regNumber;
            document.getElementById('pen-member-name').textContent = memberName.toUpperCase();
            document.getElementById('pen-member-jabatan').textContent = jabatan || '—';

            // Sektor name
            const pObj = polsekData.find(p => p.id === (member?.sector) || p.kode === (member?.sector));
            document.getElementById('pen-member-sektor').textContent = pObj ? pObj.nama : (member?.sector || '—');

            // Reset / restore ratings
            document.querySelectorAll('.pen-rating-btn').forEach(btn => {
                btn.style.background = '#e2e8f0';
                btn.style.color = '#64748b';
                btn.style.transform = '';
            });
            const existing = member?.penilaian || {};
            ['loyalitas', 'keaktifan', 'anggota_terbanyak'].forEach(group => {
                const saved = existing[group];
                if (saved) {
                    document.querySelectorAll(`.pen-rating-btn[data-group="${group}"]`).forEach(btn => {
                        if (parseInt(btn.dataset.val) <= saved) {
                            applyRatingActive(btn);
                        }
                    });
                }
            });
            document.getElementById('pen-komentar').value = existing.komentar || '';
            updatePenilaianTotal();

            const modal = new bootstrap.Modal(document.getElementById('penilaianModal'));
            modal.show();
        }

        function applyRatingActive(btn) {
            btn.style.background = '#0d9488';
            btn.style.color = '#fff';
            btn.style.transform = 'scale(1.08)';
        }

        function updatePenilaianTotal() {
            const groups = ['loyalitas', 'keaktifan', 'anggota_terbanyak'];
            let total = 0;
            groups.forEach(group => {
                // Find highest selected
                const selected = [...document.querySelectorAll(`.pen-rating-btn[data-group="${group}"]`)]
                    .filter(b => b.style.background === 'rgb(13, 148, 136)' || b.style.background === '#0d9488');
                if (selected.length) total += Math.max(...selected.map(b => parseInt(b.dataset.val)));
            });
            document.getElementById('pen-total').textContent = total;
            const lbl = document.getElementById('pen-total-label');
            if (total === 0)    { lbl.textContent = 'Belum dinilai'; lbl.style.cssText = 'background:#e2e8f0;color:#64748b;font-size:12px;'; }
            else if (total <= 5)  { lbl.textContent = 'Perlu Pembinaan'; lbl.style.cssText = 'background:#fef3c7;color:#92400e;font-size:12px;'; }
            else if (total <= 10) { lbl.textContent = 'Cukup Baik'; lbl.style.cssText = 'background:#dbeafe;color:#1e40af;font-size:12px;'; }
            else if (total <= 13) { lbl.textContent = 'Baik'; lbl.style.cssText = 'background:#d1fae5;color:#065f46;font-size:12px;'; }
            else                  { lbl.textContent = 'Sangat Baik'; lbl.style.cssText = 'background:#0d9488;color:#fff;font-size:12px;'; }
        }

        // Rating button click handler (delegated)
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.pen-rating-btn');
            if (!btn) return;
            const group = btn.dataset.group;
            const val = parseInt(btn.dataset.val);
            // Fill up-to clicked, unfill above
            document.querySelectorAll(`.pen-rating-btn[data-group="${group}"]`).forEach(b => {
                if (parseInt(b.dataset.val) <= val) {
                    applyRatingActive(b);
                } else {
                    b.style.background = '#e2e8f0';
                    b.style.color = '#64748b';
                    b.style.transform = '';
                }
            });
            updatePenilaianTotal();
        });

        async function savePenilaian() {
            const reg = document.getElementById('pen-reg-number').value;
            const getVal = (group) => {
                const selected = [...document.querySelectorAll(`.pen-rating-btn[data-group="${group}"]`)]
                    .filter(b => b.style.background === 'rgb(13, 148, 136)' || b.style.background === '#0d9488');
                return selected.length ? Math.max(...selected.map(b => parseInt(b.dataset.val))) : 0;
            };
            const loyalitas = getVal('loyalitas');
            const keaktifan = getVal('keaktifan');
            const anggota_terbanyak = getVal('anggota_terbanyak');
            const total = loyalitas + keaktifan + anggota_terbanyak;
            const komentar = document.getElementById('pen-komentar').value.trim();

            if (loyalitas === 0 && keaktifan === 0 && anggota_terbanyak === 0) {
                showToast('Isi minimal satu kriteria penilaian.', 'warning');
                return;
            }
            const formData = new FormData();
            formData.append('reg_number', reg);
            formData.append('penilaian', JSON.stringify({ loyalitas, keaktifan, anggota_terbanyak, total, komentar, tanggal: new Date().toISOString().slice(0,10) }));
            try {
                const btn = document.getElementById('pen-save-btn');
                btn.disabled = true;
                const resp = await fetch('update_member.php', { method: 'POST', body: formData });
                const result = await resp.json();
                if (result.status === 'success') {
                    showToast('Penilaian anggota berhasil disimpan!', 'success');
                    bootstrap.Modal.getInstance(document.getElementById('penilaianModal')).hide();
                    await loadMembers();
                } else {
                    showToast(result.message || 'Gagal menyimpan penilaian.', 'error');
                }
            } catch (err) {
                showToast('Gagal menghubungi server.', 'error');
            } finally {
                document.getElementById('pen-save-btn').disabled = false;
            }
        }

        async function moveToTrash(reg) {
            if(!confirm('Keluarkan anggota ini dari daftar?')) return;
            try {
                const resp = await fetch('delete.php?reg=' + encodeURIComponent(reg) + '&ajax=1');
                const result = await resp.json();
                if(result.status === 'success') {
                    await loadMembers();
                } else {
                    showToast(result.message, 'error', 'Gagal Menghapus');
                }
            } catch (err) {
                showToast('Gagal menghubungi server', 'error');
            }
        }


        async function loadTrash() {
            const tableBody = document.getElementById('trash-table-body');
            try {
                const resp = await fetch('data/sampah.json?v=' + Date.now());
                const data = await resp.json();
                
                if (data.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="5" class="text-center py-5 text-muted">Belum ada data di arsip sampah.</td></tr>';
                    return;
                }

                let html = '';
                [...data].reverse().forEach(row => {
                    html += `
                        <tr>
                            <td class="d-none d-md-table-cell"><code class="bg-light p-1 rounded">${row.no_anggota || row.reg_number}</code></td>
                            <td>
                                <div class="fw-bold">${row.full_name}</div>
                                <div class="d-md-none small text-muted">${row.no_anggota || row.reg_number}</div>
                            </td>
                            <td class="d-none d-sm-table-cell"><span class="badge bg-light text-dark">${row.gender === 'Laki-laki' ? 'L' : (row.gender === 'Perempuan' ? 'P' : '-')}</span></td>
                            <td class="small d-none d-md-table-cell">Sektor ${row.sector}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm rounded-pill shadow-sm">
                                    <button onclick="restoreMember('${row.reg_number}')" class="btn btn-success px-2 px-sm-3">Pulihkan</button>
                                    <button onclick="permanentDelete('${row.reg_number}')" class="btn btn-outline-danger px-2 px-sm-3">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    `;
                });
                tableBody.innerHTML = html;
            } catch (err) {
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center py-5 text-danger">Gagal memuat data sampah.</td></tr>';
            }
        }

        async function restoreMember(reg) {
            const formData = new FormData();
            formData.append('action', 'restore');
            formData.append('reg_number', reg);

            try {
                const resp = await fetch('manage_trash.php', { method: 'POST', body: formData });
                const result = await resp.json();
                if(result.status === 'success') {
                    await loadTrash();
                    await loadMembers();
                    showToast('Anggota berhasil dipulihkan!', 'success');
                }
            } catch (err) { showToast('Gagal menghubungi server', 'error'); }
        }

        async function permanentDelete(reg) {
            if(!confirm('⚠️ PERINGATAN: Data akan dihapus permanen dan tidak bisa dikembalikan. Lanjutkan?')) return;
            
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('reg_number', reg);

            try {
                const resp = await fetch('manage_trash.php', { method: 'POST', body: formData });
                const result = await resp.json();
                if(result.status === 'success') {
                    await loadTrash();
                    showToast('Data telah dihapus secara permanen.', 'info', 'Terhapus');
                }
            } catch (err) { showToast('Gagal menghubungi server', 'error'); }
        }

        // All logic unified in loadCMS for premium UX

        const labelMap = {
            'badge': 'Label Kecil (Badge)',
            'welcome_text': 'Teks Selamat Datang',
            'title_primary': 'Judul Utama',
            'lead_text': 'Teks Penjelasan',
            'video_link': 'Link Video YouTube',
            'number': 'Angka Statistik',
            'label': 'Label Keterangan',
            'icon': 'Ikon (FontAwesome)',
            'title': 'Judul',
            'description': 'Deskripsi/Ringkasan',
            'image': 'Path Gambar',
            'images': 'Galeri Gambar',
            'question': 'Pertanyaan FAQ',
            'answer': 'Jawaban FAQ',
            'address': 'Alamat Lengkap',
            'map_address': 'Link Google Maps',
            'footer_address': 'Alamat di Footer',
            'phone': 'Nomor WhatsApp (628...)',
            'phone_display': 'Format Nomor Tampilan',
            'email': 'Email Kontak',
            'social': 'Media Sosial',
            'platform': 'Nama Platform',
            'partners': 'Logo Partner/Mitra',
            'name': 'Nama Personel/Instansi',
            'footer_title': 'Judul Footer Khusus',
            'position': 'Jabatan/Posisi',
            'tag': 'Kategori/Tag',
            'items': 'Daftar Item',
            'mobile': 'Konten Mobile',
            'full': 'Konten Lengkap',
            'skep': 'Nomor SKEP/Dokumen',
            // Section Labels
            'hero': 'Hero Section',
            'stats': 'Statistik Utama',
            'tentang': 'Tentang Kami',
            'sejarah': 'Sejarah & Timeline',
            'structure': 'Struktur Organisasi',
            'news': 'Berita & Pengumuman',
            'kegiatan': 'Galeri Kegiatan',
            'faq': 'Tanya Jawab (FAQ)',
            'contact': 'Kontak & Media',
            'jadwal_kegiatan': 'Jadwal Agenda Kegiatan'
        };

        function getLabel(key) {
            return labelMap[key] || key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        }

        async function saveContent(type, data) {
            const formData = new FormData();
            formData.append('type', type);
            formData.append('data', JSON.stringify(data));
            
            try {
                const resp = await fetch('update_content.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await resp.json();
                if (result.status === 'success') {
                    showToast(`Data ${type} berhasil diperbarui!`, 'success');
                } else {
                    showToast(result.message, 'error', 'Gagal Menyimpan');
                }
                return result;
            } catch (err) {
                showToast('Terjadi kesalahan koneksi', 'error');
                console.error(err);
            }
        }

        // Global function for mobile tab switching
        window.switchAdminTab = function(tabId, label, icon, element) {
            const tabTrigger = document.getElementById(tabId);
            if (tabTrigger) {
                bootstrap.Tab.getOrCreateInstance(tabTrigger).show();
                
                // Update active state in offcanvas menu
                const mobileMenu = document.getElementById('offcanvasAdminMenu');
                mobileMenu.querySelectorAll('.mobile-nav-item').forEach(item => {
                    if (item.getAttribute('onclick')?.includes(tabId)) item.classList.add('active');
                    else item.classList.remove('active');
                });
                
                // Update active state in fixed bottom nav
                const bottomNav = document.querySelector('.mobile-bottom-nav');
                if (bottomNav) {
                    bottomNav.querySelectorAll('.mobile-bottom-item').forEach(item => {
                        if (item.getAttribute('onclick')?.includes(tabId)) item.classList.add('active');
                        else item.classList.remove('active');
                    });
                }
                
                const offcanvasInstance = bootstrap.Offcanvas.getInstance(mobileMenu);
                if (offcanvasInstance) offcanvasInstance.hide();
            }
        };

        async function loadCMS(type) {
            const container = document.getElementById('cms-editor-container');
            container.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-accent mb-3" role="status"></div>
                    <p class="text-muted">Mengambil data ${type}...</p>
                </div>
            `;

            try {
                const resp = await fetch(`data/${type}.json?v=${Date.now()}`);
                const data = await resp.json();

                // Mobile Sync
                const activePill = document.querySelector('#cms-pills-tab [onclick*="loadCMS(\''+type+'\')"]');
                if (activePill) {
                    const pills = document.querySelectorAll('#cms-pills-tab .nav-link');
                    pills.forEach(p => p.classList.remove('active'));
                    activePill.classList.add('active');
                    if (document.getElementById('active-cms-pill-label')) {
                        document.getElementById('active-cms-pill-label').innerText = activePill.innerText.trim();
                    }
                }

                // Populate Mobile CMS Menu if empty
                const mobileCmsNav = document.getElementById('mobile-cms-nav-list');
                if (mobileCmsNav && mobileCmsNav.children.length === 0) {
                    const pills = document.querySelectorAll('#cms-pills-tab .nav-link');
                    pills.forEach(pill => {
                        const icon = pill.querySelector('i').cloneNode(true);
                        const text = pill.innerText.trim();
                        const onclickStr = pill.getAttribute('onclick');
                        
                        const item = document.createElement('a');
                        item.href = '#';
                        item.className = 'mobile-nav-item' + (pill.classList.contains('active') ? ' active' : '');
                        item.innerHTML = '';
                        item.appendChild(icon);
                        item.innerHTML += ' ' + text;
                        item.onclick = (e) => {
                            e.preventDefault();
                            eval(onclickStr);
                            const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasCmsMenu'));
                            if (offcanvas) offcanvas.hide();
                        };
                        mobileCmsNav.appendChild(item);
                    });
                } else if (mobileCmsNav) {
                    // Update active state in mobile menu
                    mobileCmsNav.querySelectorAll('.mobile-nav-item').forEach(item => {
                        if (item.innerText.trim() === activePill?.innerText.trim()) item.classList.add('active');
                        else item.classList.remove('active');
                    });
                }
                
                // ── Special CRUD: Jadwal Agenda Kegiatan ───────────
                if (type === 'jadwal_kegiatan') {
                    window._jadwalData = Array.isArray(data) ? data : [];
                    
                    // Ensureodal exists in body to avoid clipping
                    if (!document.getElementById('jadwalAgendaModal')) {
                        const mDiv = document.createElement('div');
                        mDiv.innerHTML = `
                            <div class="modal fade" id="jadwalAgendaModal" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
                                        <div class="modal-header border-0 text-white px-4 pt-4 pb-3" style="background:linear-gradient(135deg,#0d9488,#0f766e);">
                                            <div>
                                                <h5 class="modal-title fw-bold mb-0" id="jadwalModalLabel"><i class="fas fa-calendar-plus me-2"></i>Tambah Agenda</h5>
                                                <small class="opacity-75" id="jadwal-modal-subtitle">Isi detail agenda kegiatan baru</small>
                                            </div>
                                            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body px-4 pb-2 pt-3">
                                            <input type="hidden" id="jadwal-edit-index" value="-1">
                                            <div class="row g-3">
                                                <div class="col-12 col-sm-6">
                                                    <label class="form-label fw-semibold small">Hari / Tanggal <span class="text-danger">*</span></label>
                                                    <input type="text" id="jadwal-f-haritgl" class="form-control rounded-3" placeholder="cth: Sabtu, 15 Maret 2026">
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <label class="form-label fw-semibold small">Jam</label>
                                                    <input type="text" id="jadwal-f-jam" class="form-control rounded-3" placeholder="cth: 08:00 - 12:00 WIB">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold small">Keterangan / Judul Kegiatan <span class="text-danger">*</span></label>
                                                    <input type="text" id="jadwal-f-keterangan" class="form-control rounded-3" placeholder="Nama kegiatan...">
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <label class="form-label fw-semibold small">Tempat</label>
                                                    <input type="text" id="jadwal-f-tempat" class="form-control rounded-3" placeholder="Lokasi kegiatan">
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <label class="form-label fw-semibold small">Contact Person (CP)</label>
                                                    <input type="text" id="jadwal-f-cp" class="form-control rounded-3" placeholder="Nama (No HP)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 px-4 pb-4 pt-2 gap-2">
                                            <button type="button" class="btn btn-outline-secondary rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="button" class="btn fw-bold rounded-3 text-white px-4" style="background:linear-gradient(135deg,#0d9488,#0f766e);" onclick="window._submitJadwalForm()">
                                                <i class="fas fa-check me-2"></i><span id="jadwal-btn-label">Tambah Agenda</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        document.body.appendChild(mDiv.firstElementChild);
                    }

                    window._renderJadwal = function() {
                        const c = document.getElementById('cms-editor-container');
                        const events = window._jadwalData;
                        c.innerHTML = `
                        <div class="cms-animate-content">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h2 class="fw-bold mb-0 text-dark" style="letter-spacing:-0.02em">Jadwal Agenda Kegiatan</h2>
                                    <p class="text-muted mb-0 small">Kelola dan perbarui daftar agenda kegiatan yang tampil di halaman utama.</p>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm" onclick="window._saveJadwal()">
                                        <i class="fas fa-save me-2"></i>Simpan
                                    </button>
                                    <button class="btn rounded-pill px-4 fw-bold shadow-sm text-white" style="background:linear-gradient(135deg,#0d9488,#0f766e);" onclick="window._openJadwalModal()">
                                        <i class="fas fa-plus me-2"></i>Tambah Agenda
                                    </button>
                                </div>
                            </div>

                            <!-- Event Cards -->
                            <div class="row g-3" id="jadwal-cards-container">
                                ${events.length === 0 ? `<div class="col-12 text-center text-muted py-5"><i class="fas fa-calendar-times fa-2x mb-2 d-block opacity-50"></i>Belum ada agenda. Klik "Tambah Agenda" untuk mulai.</div>` :
                                events.map((ev, i) => `
                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="border rounded-4 p-3 h-100 shadow-sm" style="border-color:#e2e8f0!important;background:#fff; transition: all 0.3s ease;">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge rounded-pill px-3 py-2 fw-semibold" style="background:#f1f5f9;color:#475569;font-size:11px;">
                                                <i class="far fa-calendar-alt me-1 text-accent"></i>${ev.hari_tgl || '—'}
                                            </span>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-sm btn-outline-primary rounded-3 border-0 bg-light" style="padding:6px 10px;" onclick="window._editJadwal(${i})" title="Edit"><i class="fas fa-edit" style="font-size:12px;"></i></button>
                                                <button class="btn btn-sm btn-outline-danger rounded-3 border-0 bg-light-danger" style="padding:6px 10px; color:#ef4444;" onclick="window._deleteJadwal(${i})" title="Hapus"><i class="fas fa-trash-alt" style="font-size:12px;"></i></button>
                                            </div>
                                        </div>
                                        <h6 class="fw-bold mb-3 lh-sm" style="font-size:14px; min-height: 2.4em;">${ev.keterangan || '—'}</h6>
                                        <div class="d-flex flex-column gap-2" style="font-size:12px;color:#64748b;">
                                            <div class="d-flex align-items-center gap-2"><i class="far fa-clock text-accent" style="width:16px;"></i><span>${ev.jam || '—'}</span></div>
                                            <div class="d-flex align-items-center gap-2"><i class="fas fa-map-marker-alt text-accent" style="width:16px;"></i><span>${ev.tempat || '—'}</span></div>
                                            <div class="d-flex align-items-center gap-2"><i class="fas fa-id-badge text-accent" style="width:16px;"></i><span>CP: ${ev.cp || '—'}</span></div>
                                        </div>
                                    </div>
                                </div>`).join('')}
                            </div>
                        </div>`;
                    };

                    window._saveJadwal = async function() {
                        const result = await saveContent('jadwal_kegiatan', window._jadwalData);
                        if (result && result.status === 'success') showToast('Jadwal agenda berhasil disimpan!', 'success');
                    };
                    window._deleteJadwal = function(i) {
                        if (!confirm('Hapus agenda ini?')) return;
                        window._jadwalData.splice(i, 1);
                        window._renderJadwal();
                    };
                    window._openJadwalModal = function() {
                        const m = document.getElementById('jadwalAgendaModal');
                        if (!m) return;
                        m.querySelector('#jadwal-edit-index').value = -1;
                        ['jadwal-f-haritgl','jadwal-f-jam','jadwal-f-keterangan','jadwal-f-tempat','jadwal-f-cp'].forEach(id => m.querySelector('#'+id).value = '');
                        m.querySelector('#jadwalModalLabel').innerHTML = '<i class="fas fa-calendar-plus me-2"></i>Tambah Agenda';
                        m.querySelector('#jadwal-modal-subtitle').textContent = 'Isi detail agenda kegiatan baru';
                        m.querySelector('#jadwal-btn-label').textContent = 'Tambah Agenda';
                        bootstrap.Modal.getOrCreateInstance(m).show();
                    };
                    window._editJadwal = function(i) {
                        const m = document.getElementById('jadwalAgendaModal');
                        if (!m) return;
                        const ev = window._jadwalData[i];
                        m.querySelector('#jadwal-edit-index').value = i;
                        m.querySelector('#jadwal-f-haritgl').value = ev.hari_tgl || '';
                        m.querySelector('#jadwal-f-jam').value = ev.jam || '';
                        m.querySelector('#jadwal-f-keterangan').value = ev.keterangan || '';
                        m.querySelector('#jadwal-f-tempat').value = ev.tempat || '';
                        m.querySelector('#jadwal-f-cp').value = ev.cp || '';
                        m.querySelector('#jadwalModalLabel').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Agenda';
                        m.querySelector('#jadwal-modal-subtitle').textContent = 'Ubah detail agenda kegiatan';
                        m.querySelector('#jadwal-btn-label').textContent = 'Simpan Perubahan';
                        bootstrap.Modal.getOrCreateInstance(m).show();
                    };
                    window._submitJadwalForm = function() {
                        const m = document.getElementById('jadwalAgendaModal');
                        const hari_tgl = m.querySelector('#jadwal-f-haritgl').value.trim();
                        const jam = m.querySelector('#jadwal-f-jam').value.trim();
                        const keterangan = m.querySelector('#jadwal-f-keterangan').value.trim();
                        const tempat = m.querySelector('#jadwal-f-tempat').value.trim();
                        const cp = m.querySelector('#jadwal-f-cp').value.trim();
                        if (!hari_tgl || !keterangan) { showToast('Hari/Tanggal dan Keterangan wajib diisi.', 'warning'); return; }
                        const idx = parseInt(m.querySelector('#jadwal-edit-index').value);
                        const item = { hari_tgl, jam, keterangan, tempat, cp };
                        if (idx >= 0) { window._jadwalData[idx] = item; }
                        else { window._jadwalData.push(item); }
                        bootstrap.Modal.getInstance(m)?.hide();
                        window._renderJadwal();
                    };
                    window._renderJadwal();
                    return;
                }
                // ── END: Jadwal special case ───────────────────────

                let html = `
                    <div class="cms-animate-content">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-4 mb-4 cms-header-spacer">
                            <div class="pe-sm-5">
                                <h2 class="fw-bold mb-0 text-dark cms-section-title" style="letter-spacing: -0.02em;">Manajemen ${getLabel(type)}</h2>
                                <p class="text-muted mb-0 cms-section-subtitle">Oksigenasi dan kelola konten bagian ini dengan efisien.</p>
                            </div>
                            <div class="d-flex w-100 w-sm-auto">
                                <button class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm py-2 px-sm-4 btn-compact-mobile" onclick="saveCMS('${type}')">
                                    <i class="fas fa-save me-2"></i> Simpan <span class="d-none d-sm-inline">Perubahan</span>
                                </button>
                            </div>
                        </div>
                        <form id="cms-form-${type}" class="cms-premium-form">
                `;

                function renderRecursive(obj, currentKey, path = []) {
                    let fieldsHtml = "";
                    
                    // Special case: if this object contains children that are mostly objects/arrays,
                    // let's see if we can render some of them as a group table for better consistency
                    const keys = Object.keys(obj).filter(k => !['buttons', 'id', 'class', 'icon'].includes(k));
                    const childObjects = keys.filter(k => typeof obj[k] === 'object' && obj[k] !== null && !Array.isArray(obj[k]));
                    
                    // If we have multiple child objects that look like "Person" records, group them
                    if (childObjects.length > 1) {
                        const firstChild = obj[childObjects[0]];
                        if (firstChild && typeof firstChild === 'object' && (firstChild.name || firstChild.position)) {
                            // Group these into a table!
                            fieldsHtml += `
                                    <div class="mb-5 pb-4 border-bottom border-light">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 gap-sm-3 mb-0 h5 cms-list-title">
                                                <div class="bg-accent rounded-pill d-none d-sm-block" style="width:12px; height:6px;"></div>
                                                Daftar ${getLabel(currentKey)}
                                            </label>
                                        </div>
                                    <div class="cms-table-container">
                                        <table class="cms-table">
                                            <thead>
                                                <tr>
                                                    <th>Posisi</th>
                                                    <th>Nama</th>
                                                    <th>Foto</th>
                                                    <th class="text-end">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${childObjects.map(k => {
                                                    const item = obj[k];
                                                    const itemPath = [...path, k].join('.');
                                                    const val = item.name || "";
                                                    const pos = item.position || getLabel(k);
                                                    const img = item.image || "assets/user.png";
                                                    return `
                                                        <tr>
                                                            <td><div class="fw-bold">${pos}</div></td>
                                                            <td><div class="text-truncate" style="max-width: 250px;">${val}</div></td>
                                                            <td><img src="${img}?v=${Date.now()}" class="cms-thumb shadow-sm"></td>
                                                            <td class="text-end">
                                                                <button type="button" class="cms-action-btn edit" onclick="editCmsItem('${type}', '${itemPath}', null)" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    `;
                                                }).join('')}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            `;
                            // Remove processed keys from normal loop
                            keys.forEach(k => { if (childObjects.includes(k)) delete keys[keys.indexOf(k)]; });
                        }
                    }

                    for (const key of keys) {
                        if (!key) continue;
                        const label = getLabel(key);
                        const val = obj[key];
                        const fullPath = [...path, key];
                        const dataPath = fullPath.join('.');

                        if (Array.isArray(val)) {
                            const isObjectArray = val.length > 0 && typeof val[0] === 'object';
                            fieldsHtml += `
                                <div class="mb-5 pb-4 border-bottom border-light">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 gap-sm-3 mb-0 h5 cms-list-title">
                                            <div class="bg-accent rounded-pill d-none d-sm-block" style="width:12px; height:6px;"></div>
                                            ${label}
                                        </label>
                                        <button class="btn btn-dark btn-sm rounded-pill px-4 fw-bold shadow-sm cms-add-btn btn-add-compact" type="button" onclick="addItem(event, '${type}', '${dataPath}')">
                                            <i class="fas fa-plus me-1"></i> <span>Tambah Item</span>
                                        </button>
                                    </div>
                                    ${isObjectArray ? (() => {
                                        let visibleKeys = Object.keys(val[0]).filter(k => {
                                            const v = val[0][k];
                                            return k !== 'id' && k !== 'is_list' && (typeof v !== 'object' || v === null);
                                        });

                                        // Apply filters per content type for a cleaner list view
                                        if (type === 'faq') visibleKeys = ['question'];
                                        else if (type === 'news') visibleKeys = ['tag', 'title', 'image'];
                                        else if (type === 'stats') visibleKeys = ['title', 'value', 'icon'];
                                        else if (type === 'tentang') visibleKeys = ['title', 'icon'];
                                        else if (type === 'contact') visibleKeys = ['label', 'value', 'icon'];

                                        return `
                                        <div class="cms-table-container">
                                            <table class="cms-table">
                                                <thead>
                                                    <tr>
                                                        ${visibleKeys.map(k => `<th>${getLabel(k)}</th>`).join('')}
                                                        <th class="text-end">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ${val.map((item, i) => `
                                                        <tr>
                                                            ${visibleKeys.map(k => {
                                                                const value = item[k] || '';
                                                                const isItemImage = (k.toLowerCase().includes('image') || (value || "").toString().includes('assets/'));
                                                                const isIcon = k === 'icon';
                                                                return `
                                                                    <td>
                                                                        ${isItemImage ? `<img src="${value}?v=${Date.now()}" class="cms-thumb shadow-sm">` : 
                                                                        (isIcon ? `<div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;"><i class="${value} text-dark"></i></div>` :
                                                                        `<div class="text-truncate" style="max-width: 200px;">${value}</div>`)}
                                                                    </td>
                                                                `;
                                                            }).join('')}
                                                            <td class="text-end">
                                                                <div class="d-flex justify-content-end gap-2">
                                                                    <button type="button" class="cms-action-btn edit" onclick="editCmsItem('${type}', '${dataPath}', ${i})" title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                    <button type="button" class="cms-action-btn delete" onclick="removeItem(event, '${type}', '${dataPath}', ${i})" title="Hapus">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    `).join('')}
                                                </tbody>
                                            </table>
                                        </div>`;
                                    })() : (() => {
                                        const isAllImages = val.length > 0 && val.every(item => !item || item.toString().includes('assets/') || item.toString().includes('uploads/')) && val.some(item => item && (item.toString().includes('assets/') || item.toString().includes('uploads/')));
                                        return `
                                        <div id="array-container-${dataPath.replace(/\./g, '-')}" class="row g-3">
                                            ${val.map((item, i) => {
                                                const isActualImage = item && (item.toString().includes('assets/') || item.toString().includes('uploads/'));
                                                if (isAllImages) {
                                                    return `
                                                    <div class="col-6 col-md-3 col-lg-2" id="item-${dataPath.replace(/\./g, '-')}-${i}">
                                                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white h-100 position-relative">
                                                            <div class="position-absolute top-0 end-0 p-2 d-flex gap-1 z-2">
                                                                <button type="button" class="btn btn-light btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" style="width:28px; height:28px;" onclick="this.nextElementSibling.click()" title="Ganti">
                                                                    <i class="fas fa-camera small"></i>
                                                                </button>
                                                                <input type="file" class="d-none" accept="image/*" onchange="handleCMSImageUpload(this, '${type}', '${dataPath}', ${i})">
                                                                <button type="button" class="btn btn-danger btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" style="width:28px; height:28px;" onclick="removeItem(event, '${type}', '${dataPath}', ${i})" title="Hapus">
                                                                    <i class="fas fa-times small"></i>
                                                                </button>
                                                            </div>
                                                            <div class="ratio ratio-1x1 bg-light d-flex align-items-center justify-content-center">
                                                                ${isActualImage ? 
                                                                    `<img src="${item}?v=${Date.now()}" class="object-fit-contain p-3 w-100 h-100">` : 
                                                                    `<div class="text-muted small text-center p-2"><i class="fas fa-image fa-2x mb-2 d-block opacity-25"></i>Pilih Gambar</div>`
                                                                }
                                                            </div>
                                                            <input type="hidden" data-path="${dataPath}" data-index="${i}" value="${item}">
                                                        </div>
                                                    </div>`;
                                                }
                                                const isImage = (item.toString().includes('assets/') || item.toString().includes('uploads/'));
                                                return `
                                                <div class="col-md-6" id="item-${dataPath.replace(/\./g, '-')}-${i}">
                                                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex align-items-center gap-3 cms-card">
                                                        ${isImage ? `
                                                            <div class="rounded-3 overflow-hidden border shadow-sm" style="width: 60px; height: 45px; flex-shrink: 0;">
                                                                <img src="${item}?v=${Date.now()}" class="w-100 h-100 object-fit-cover">
                                                            </div>
                                                        ` : ''}
                                                        <div class="flex-grow-1">
                                                            <input type="text" class="form-control border-0 bg-light rounded-pill px-3" 
                                                                   data-path="${dataPath}" data-index="${i}" 
                                                                   value="${item.toString().replace(/"/g, '&quot;')}">
                                                        </div>
                                                        <div class="d-flex gap-1">
                                                            ${isImage ? `
                                                                <button type="button" class="btn btn-link text-dark p-1 shadow-none" onclick="this.nextElementSibling.click()">
                                                                    <i class="fas fa-upload"></i>
                                                                </button>
                                                                <input type="file" class="d-none" accept="image/*" onchange="handleCMSImageUpload(this, '${type}', '${dataPath}', ${i})">
                                                            ` : ''}
                                                            <button type="button" class="btn btn-link text-danger p-1 text-decoration-none shadow-none" onclick="removeItem(event, '${type}', '${dataPath}', ${i})">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>`;
                                            }).join('')}
                                        </div>`;
                                    })()}
                                </div>
                            `;
                        } else if (typeof val === 'object' && val !== null) {
                            fieldsHtml += `
                                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white border-top border-4 border-accent">
                                    <label class="form-label fw-bold text-dark mb-3 text-uppercase small" style="letter-spacing: 1px;">${label}</label>
                                    <div class="row g-3">
                                        ${renderRecursive(val, key, fullPath)}
                                    </div>
                                </div>
                            `;
                        } else {
                            const isRich = key.includes('content') || key.includes('description') || key.includes('text') || key.includes('answer') || key.includes('question') || key.includes('address');
                            const isLarge = isRich || (val || "").toString().length > 100;
                            const colClass = path.length > 0 ? "col-md-6" : "col-12";
                            fieldsHtml += `
                                <div class="${colClass} mb-4">
                                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                                        <label class="form-label fw-bold text-muted small text-uppercase mb-2" style="letter-spacing: 0.5px;">${label}</label>
                                        ${(key.toLowerCase().includes('image') || (val || "").toString().includes('assets/')) ? `
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="rounded-4 overflow-hidden border bg-light shadow-sm" style="width: 100px; height: 75px;">
                                                    <img src="${val}?v=${Date.now()}" class="w-100 h-100 object-fit-cover">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control mb-2 border-0 bg-light rounded-pill px-3 fs-6" data-path="${dataPath}" value="${(val || "").toString().replace(/"/g, '&quot;')}">
                                                    <button type="button" class="btn btn-sm btn-outline-dark rounded-pill px-3" onclick="this.nextElementSibling.click()">
                                                        <i class="fas fa-upload me-1"></i> Ganti Gambar
                                                    </button>
                                                    <input type="file" class="d-none" accept="image/*" onchange="handleCMSImageUpload(this, '${type}', '${dataPath}')">
                                                </div>
                                            </div>
                                        ` : (isLarge ? 
                                            `<textarea class="form-control border-0 bg-light rounded-4 p-3 fs-6 ${isRich ? 'summernote' : ''}" data-path="${dataPath}" data-is-rich="${isRich}" rows="4">${val}</textarea>` :
                                            `<input type="text" class="form-control form-control-lg border-0 bg-light rounded-pill px-4 fs-6" data-path="${dataPath}" value="${(val || "").toString().replace(/"/g, '&quot;')}">`
                                        )}
                                    </div>
                                </div>
                            `;
                        }
                    }
                    return fieldsHtml;
                }

                if (Array.isArray(data)) {
                    const isObjectArray = data.length > 0 && typeof data[0] === 'object';
                    html += `
                        <div class="mb-5">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 gap-sm-3 mb-0 h5 cms-list-title">
                                    <div class="bg-accent rounded-pill d-none d-sm-block" style="width:12px; height:6px;"></div>
                                    Daftar ${getLabel(type)}
                                </label>
                                <button class="btn btn-dark btn-sm rounded-pill px-4 fw-bold shadow-sm cms-add-btn btn-add-compact" type="button" onclick="addItem(event, '${type}', '')">
                                    <i class="fas fa-plus me-1"></i> <span>Tambah Item</span>
                                </button>
                            </div>
                            ${isObjectArray ? (() => {
                                let visibleKeys = Object.keys(data[0]).filter(k => {
                                    const v = data[0][k];
                                    return k !== 'id' && k !== 'is_list' && (typeof v !== 'object' || v === null);
                                });

                                // Apply filters per content type for a cleaner list view
                                if (type === 'faq') visibleKeys = ['question'];
                                else if (type === 'news') visibleKeys = ['tag', 'title', 'image'];
                                else if (type === 'stats') visibleKeys = ['title', 'value', 'icon'];
                                else if (type === 'tentang') visibleKeys = ['title', 'icon'];
                                else if (type === 'contact') visibleKeys = ['label', 'value', 'icon'];
                                else if (type === 'jadwal_kegiatan') visibleKeys = ['hari_tgl', 'keterangan', 'jam'];
                                return `
                                <div class="cms-table-container">
                                    <table class="cms-table">
                                        <thead>
                                            <tr>
                                                ${visibleKeys.map(k => `<th>${getLabel(k)}</th>`).join('')}
                                                <th class="text-end">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${data.map((item, i) => `
                                                <tr>
                                                    ${visibleKeys.map(k => {
                                                        const value = item[k] || '';
                                                        const isImage = (k.toLowerCase().includes('image') || (value || "").toString().includes('assets/'));
                                                        const isIcon = k === 'icon';
                                                        return `
                                                            <td>
                                                                ${isImage ? `<img src="${value}?v=${Date.now()}" class="cms-thumb shadow-sm">` : 
                                                                (isIcon ? `<div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;"><i class="${value} text-dark"></i></div>` :
                                                                `<div class="text-truncate" style="max-width: 200px;">${value}</div>`)}
                                                            </td>
                                                        `;
                                                    }).join('')}
                                                    <td class="text-end">
                                                        <div class="d-flex justify-content-end gap-2">
                                                            <button type="button" class="cms-action-btn edit" onclick="editCmsItem('${type}', '', ${i})" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="cms-action-btn delete" onclick="removeItem(event, '${type}', '', ${i})" title="Hapus">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            `).join('')}
                                        </tbody>
                                    </table>
                                </div>`;
                            })() : (() => {
                                const isAllImages = data.length > 0 && data.every(item => !item || item.toString().includes('assets/') || item.toString().includes('uploads/')) && data.some(item => item && (item.toString().includes('assets/') || item.toString().includes('uploads/')));
                                return `
                                <div class="row g-3">
                                    ${data.map((item, i) => {
                                        const isActualImage = item && (item.toString().includes('assets/') || item.toString().includes('uploads/'));
                                        if (isAllImages) {
                                            return `
                                            <div class="col-6 col-md-3 col-lg-2">
                                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white h-100 position-relative">
                                                    <div class="position-absolute top-0 end-0 p-2 d-flex gap-1 z-2">
                                                        <button type="button" class="btn btn-light btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" style="width:28px; height:28px;" onclick="this.nextElementSibling.click()" title="Ganti">
                                                            <i class="fas fa-camera small"></i>
                                                        </button>
                                                        <input type="file" class="d-none" accept="image/*" onchange="handleCMSImageUpload(this, '${type}', '')">
                                                        <button type="button" class="btn btn-danger btn-sm rounded-circle shadow-sm p-0 d-flex align-items-center justify-content-center" style="width:28px; height:28px;" onclick="removeItem(event, '${type}', '', ${i})" title="Hapus">
                                                            <i class="fas fa-times small"></i>
                                                        </button>
                                                    </div>
                                                    <div class="ratio ratio-1x1 bg-light d-flex align-items-center justify-content-center">
                                                        ${isActualImage ? 
                                                            `<img src="${item}?v=${Date.now()}" class="object-fit-contain p-3 w-100 h-100">` : 
                                                            `<div class="text-muted small text-center p-2"><i class="fas fa-image fa-2x mb-2 d-block opacity-25"></i>Pilih Gambar</div>`
                                                        }
                                                    </div>
                                                    <input type="hidden" data-path="" data-index="${i}" value="${item}">
                                                </div>
                                            </div>`;
                                        }
                                        const isImage = (item.toString().includes('assets/') || item.toString().includes('uploads/'));
                                        return `
                                        <div class="col-md-6">
                                            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex align-items-center gap-3 cms-card">
                                                ${isImage ? `
                                                    <div class="rounded-3 overflow-hidden border shadow-sm" style="width: 60px; height: 45px; flex-shrink: 0;">
                                                        <img src="${item}?v=${Date.now()}" class="w-100 h-100 object-fit-cover">
                                                    </div>
                                                ` : ''}
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control border-0 bg-light rounded-pill px-3" value="${item}" data-path="" data-index="${i}">
                                                </div>
                                                <div class="d-flex gap-1">
                                                    ${isImage ? `
                                                        <button type="button" class="btn btn-link text-dark p-1 shadow-none" onclick="this.nextElementSibling.click()">
                                                            <i class="fas fa-upload"></i>
                                                        </button>
                                                        <input type="file" class="d-none" accept="image/*" onchange="handleCMSImageUpload(this, '${type}', '')">
                                                    ` : ''}
                                                    <button type="button" class="btn btn-link text-danger p-1 text-decoration-none shadow-none" onclick="removeItem(event, '${type}', '', ${i})">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    `}).join('')}
                                </div>`;
                            })()}
                        </div>
                    `;
                } else {
                    html += renderRecursive(data, type);
                }
                
                html += `</form></div>`;
                container.innerHTML = html;

                // Initialize Summernote for direct forms
                $(`#cms-form-${type} .summernote`).summernote({
                    placeholder: 'Ketik konten di sini...',
                    tabsize: 2,
                    height: 150,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['view', ['codeview']]
                    ],
                    callbacks: {
                        onChange: function(contents, $editable) {
                            $(this).val(contents);
                        }
                    }
                });

            } catch (err) {
                container.innerHTML = `<div class="alert alert-danger px-4 py-3 rounded-4">❌ Gagal memuat data: ${err.message}</div>`;
                console.error(err);
            }
        }

        async function saveCMS(type) {
            const form = document.getElementById(`cms-form-${type}`);
            const saveBtn = form.closest('.tab-pane').querySelector('button[onclick^="saveCMS"]');
            
            const originalBtnHtml = saveBtn.innerHTML;
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';

            try {
                const resp = await fetch(`data/${type}.json?v=${Date.now()}`);
                const currentData = await resp.json();
            
                const inputs = form.querySelectorAll('input, textarea');
                inputs.forEach(input => {
                    const path = input.getAttribute('data-path');
                    const index = input.getAttribute('data-index');

                    if (!path) return;

                    const keys = path.split('.');
                    let ref = currentData;
                    for (let i = 0; i < keys.length - 1; i++) {
                        ref = ref[keys[i]];
                    }
                    const lastKey = keys[keys.length - 1];

                    let value = input.value;
                    if (input.dataset.isRich === 'true') {
                        // Clean up HTML tags
                        value = value.replace(/<strong>/g, '<b>').replace(/<\/strong>/g, '</b>').trim();
                    }

                    if (index !== null) {
                        ref[lastKey][index] = value;
                    } else {
                        ref[lastKey] = value;
                    }
                });

                const result = await saveContent(type, currentData);
                if (result && result.status === 'success') {
                    await loadCMS(type);
                }
            } catch (err) {
                showToast(err.message, 'error', 'Gagal Menyimpan');
                console.error(err);
            } finally {
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalBtnHtml;
            }
        }

        async function handleCMSImageUpload(input, type, path, index = null, subKey = null) {
            if (!input.files || !input.files[0]) return;

            const file = input.files[0];
            const formData = new FormData();
            formData.append('type', type);
            formData.append('action', 'upload');
            formData.append('file', file);

            const originalBtn = input.previousElementSibling;
            const originalHtml = originalBtn.innerHTML;
            originalBtn.disabled = true;
            originalBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

            try {
                const resp = await fetch('update_content.php', { method: 'POST', body: formData });
                const result = await resp.json();
                
                if (result.status === 'success') {
                    // Update the value in current form view
                    const container = input.closest('.cms-premium-form');
                    let targetInput;
                    if (index !== null) {
                        if (subKey) targetInput = container.querySelector(`input[data-path="${path}"][data-index="${index}"][data-subkey="${subKey}"]`);
                        else targetInput = container.querySelector(`input[data-path="${path}"][data-index="${index}"]`);
                    } else {
                        targetInput = container.querySelector(`input[data-path="${path}"]`);
                    }

                    if (targetInput) {
                        targetInput.value = result.path;
                        // Reload view to show new image (simpler than manual DOM update)
                        await saveCMS(type); 
                    }
                } else {
                    showToast(result.message, 'error', 'Gagal Upload');
                }
            } catch (err) {
                showToast(err.message, 'error', 'Kesalahan Upload');
            } finally {
                originalBtn.disabled = false;
                originalBtn.innerHTML = originalHtml;
            }
        }

        async function editCmsItem(type, path, index) {
            const resp = await fetch(`data/${type}.json?v=${Date.now()}`);
            const data = await resp.json();
            
            const keys = path ? path.split('.').filter(k => k) : [];
            let ref = data;
            for (let i = 0; i < keys.length; i++) {
                ref = ref[keys[i]];
            }
            const item = Array.isArray(ref) ? ref[index] : ref;

            document.getElementById('cms-edit-type').value = type;
            document.getElementById('cms-edit-path').value = path || "";
            document.getElementById('cms-edit-index').value = index;
            document.getElementById('cmsModalTitle').innerText = `Edit Item ${getLabel(type)}`;

            const container = document.getElementById('cms-modal-fields');
            container.innerHTML = "";

            for (const key in item) {
                if (key === 'id' || key === 'icon' || key === 'class') continue;

                const label = getLabel(key);
                let val = item[key] || "";
                
                // Special handling for arrays (e.g., list of strings)
                let isArray = Array.isArray(val);
                const isRich = key.includes('content') || key.includes('description') || key.includes('text') || key.includes('answer') || key.includes('question') || key.includes('address') || isArray;

                if (isArray) {
                    if (val.length > 0 && typeof val[0] === 'object') {
                        continue; 
                    }
                    if (isRich) {
                        // Convert array to HTML list for Summernote
                        val = `<ul>${val.map(line => `<li>${line}</li>`).join('')}</ul>`;
                    } else {
                        val = val.join('\n');
                    }
                }

                const isLarge = isRich || isArray || (val || "").toString().length > 100;
                const isImage = (key.toLowerCase().includes('image') || (val || "").toString().includes('assets/'));

                const html = `
                    <div class="col-12">
                        <label class="form-label fw-bold text-muted small text-uppercase mb-2">${label} ${isArray ? '(Daftar Poin)' : ''}</label>
                        ${isImage ? `
                            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-4">
                                <div class="rounded-4 overflow-hidden border bg-white shadow-sm" style="width: 120px; height: 90px; flex-shrink: 0;">
                                    <img src="${val}?v=${Date.now()}" id="modal-img-preview-${key}" class="w-100 h-100 object-fit-cover">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control mb-2 border-0 bg-white rounded-pill px-3" name="${key}" value="${(val || "").toString().replace(/"/g, '&quot;')}">
                                    <button type="button" class="btn btn-sm btn-dark rounded-pill px-4" onclick="this.nextElementSibling.click()">
                                        <i class="fas fa-upload me-1"></i> Ganti Gambar
                                    </button>
                                    <input type="file" class="d-none" accept="image/*" onchange="handleModalImageUpload(this, '${key}')">
                                </div>
                            </div>
                        ` : (isLarge ? 
                            `<textarea class="form-control border-0 bg-light rounded-4 p-3 px-4 fs-6 ${isRich ? 'summernote' : ''}" name="${key}" rows="5" data-is-array="${isArray}" data-is-rich="${isRich}">${val}</textarea>` :
                            `<input type="text" class="form-control form-control-lg border-0 bg-light rounded-pill px-4 fs-6" name="${key}" value="${(val || "").toString().replace(/"/g, '&quot;')}">`
                        )}
                    </div>
                `;
                container.innerHTML += html;
            }

            const modalEl = document.getElementById('cmsEditModal');
            const modal = new bootstrap.Modal(modalEl);
            
            // Initialize Summernote when modal is shown
            modalEl.addEventListener('shown.bs.modal', function () {
                $('.summernote').summernote({
                    placeholder: 'Ketik konten di sini...',
                    tabsize: 2,
                    height: 200,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['view', ['codeview']]
                    ],
                    callbacks: {
                        onChange: function(contents, $editable) {
                            // Sync with textarea
                            $(this).val(contents);
                        }
                    }
                });
            }, { once: true });

            // Destroy summernote on hide
            modalEl.addEventListener('hidden.bs.modal', function () {
                $('.summernote').summernote('destroy');
            }, { once: true });

            modal.show();
        }

        async function handleModalImageUpload(input, fieldKey) {
            if (!input.files || !input.files[0]) return;
            const type = document.getElementById('cms-edit-type').value;
            
            const formData = new FormData();
            formData.append('type', type);
            formData.append('action', 'upload');
            formData.append('file', input.files[0]);

            const btn = input.previousElementSibling;
            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Uploading...';

            try {
                const resp = await fetch('update_content.php', { method: 'POST', body: formData });
                const result = await resp.json();
                if (result.status === 'success') {
                    const inputField = document.querySelector(`#cms-edit-form [name="${fieldKey}"]`);
                    if (inputField) inputField.value = result.path;
                    const preview = document.getElementById(`modal-img-preview-${fieldKey}`);
                    if (preview) preview.src = result.path + '?v=' + Date.now();
                    showToast('Gambar berhasil diunggah', 'success');
                } else {
                    showToast(result.message, 'error');
                }
            } catch (err) {
                showToast(err.message, 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalHtml;
            }
        }

        async function saveCmsItem() {
            const type = document.getElementById('cms-edit-type').value;
            const path = document.getElementById('cms-edit-path').value;
            const index = document.getElementById('cms-edit-index').value;
            const form = document.getElementById('cms-edit-form');
            
            try {
                const resp = await fetch(`data/${type}.json?v=${Date.now()}`);
                const data = await resp.json();
                
                const keys = path ? path.split('.').filter(k => k) : [];
                let ref = data;
                for (let i = 0; i < keys.length; i++) {
                    ref = ref[keys[i]];
                }
                const item = Array.isArray(ref) ? ref[index] : ref;

                // Update item with form values
                const formData = new FormData(form);
                formData.forEach((value, key) => {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        if (input.dataset.isRich === 'true') {
                            if (input.dataset.isArray === 'true') {
                                // Extract <li> items from HTML
                                const tempDiv = document.createElement('div');
                                tempDiv.innerHTML = value;
                                const items = Array.from(tempDiv.querySelectorAll('li')).map(li => {
                                    // Replace <strong> with <b> for user preference
                                    return li.innerHTML.replace(/<strong>/g, '<b>').replace(/<\/strong>/g, '</b>').trim();
                                });
                                // If no <li> found, try splitting by <p> or <br> as fallback
                                if (items.length === 0 && value.trim() !== "") {
                                    item[key] = value.replace(/<strong>/g, '<b>').replace(/<\/strong>/g, '</b>').split(/<br\/?>|<\/p><p>/).map(s => s.replace(/<[^>]*>/g, '').trim()).filter(s => s !== "");
                                } else {
                                    item[key] = items;
                                }
                            } else {
                                // Just a rich text string
                                item[key] = value.replace(/<strong>/g, '<b>').replace(/<\/strong>/g, '</b>').trim();
                            }
                        } else if (input.dataset.isArray === 'true') {
                            // Standard array splitting (newline)
                            item[key] = value.split('\n').map(s => s.trim()).filter(s => s !== "");
                        } else {
                            item[key] = value;
                        }
                    }
                });

                const result = await saveContent(type, data);
                if (result && result.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('cmsEditModal')).hide();
                    await loadCMS(type);
                }
            } catch (err) {
                showToast(err.message, 'error', 'Gagal Menyimpan');
                console.error(err);
            }
        }

        async function addItem(event, type, path) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            const btn = event ? event.currentTarget : null;
            if (btn) btn.disabled = true;

            try {
                const resp = await fetch(`data/${type}.json?v=${Date.now()}`);
                const data = await resp.json();
                
                const keys = path ? path.split('.').filter(k => k) : [];
                let ref = data;
                for (let i = 0; i < keys.length; i++) {
                    ref = ref[keys[i]];
                }
                const array = ref;

                if (Array.isArray(array)) {
                    let newItem;
                    if (array.length > 0 && typeof array[0] === 'object') {
                        newItem = { ...array[0] };
                        for (const sk in newItem) {
                            if (sk === 'id') newItem[sk] = Date.now();
                            else newItem[sk] = "";
                        }
                    } else {
                        newItem = "";
                    }
                    
                    array.unshift(newItem);
                    const result = await saveContent(type, data);
                    if (result && result.status === 'success') {
                        await loadCMS(type);
                        // Automatically open modal for the new item
                        if (typeof newItem === 'object') {
                            editCmsItem(type, path, 0);
                        }
                    }
                }
            } catch (err) {
                console.error(err);
                showToast(err.message, 'error', 'Gagal Menambah Item');
            } finally {
                if (btn) btn.disabled = false;
            }
        }

        async function removeItem(event, type, path, index) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            if (!confirm('Hapus item ini?')) return;

            const btn = event ? event.currentTarget : null;
            if (btn) btn.disabled = true;

            try {
                const resp = await fetch(`data/${type}.json?v=${Date.now()}`);
                const data = await resp.json();
                
                const keys = path ? path.split('.').filter(k => k) : [];
                let ref = data;
                for (let i = 0; i < keys.length; i++) {
                    ref = ref[keys[i]];
                }
                const array = ref;

                if (Array.isArray(array)) {
                    array.splice(index, 1);
                    const result = await saveContent(type, data);
                    if (result && result.status === 'success') {
                        await loadCMS(type);
                    }
                }
            } catch (err) {
                console.error(err);
                showToast(err.message, 'error', 'Gagal Menghapus Item');
            } finally {
                if (btn) btn.disabled = false;
            }
        }

        // Add Member Logic
        document.addEventListener('DOMContentLoaded', () => {
            const addMemberModalEl = document.getElementById('addMemberModal');
            if (addMemberModalEl) {
                addMemberModalEl.addEventListener('show.bs.modal', function() {
                    const date = new Date();
                    const random = Math.floor(1000 + Math.random() * 9000);
                    const regNum = `PKDT-TS-${date.getFullYear()}${(date.getMonth() + 1).toString().padStart(2, '0')}-${random}`;
                    const regInput = document.getElementById('a-reg-number');
                    if (regInput) regInput.value = regNum;
                });
            }

            const addMemberForm = document.getElementById('addMemberForm');
            if (addMemberForm) {
                addMemberForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    console.log('Form submission intercepted');
                    const formData = new FormData(this);
                    const btn = this.querySelector('button[type="submit"]');
                    if (btn) btn.disabled = true;

                    try {
                        const resp = await fetch('submit.php', {
                            method: 'POST',
                            body: formData
                        });
                        const result = await resp.json();
                        if (result.status === 'success') {
                            showToast('Anggota berhasil ditambahkan!', 'success');
                            const modalInstance = bootstrap.Modal.getInstance(addMemberModalEl);
                            if (modalInstance) modalInstance.hide();
                            this.reset();
                            const preview = document.getElementById('a-photo-preview');
                            if (preview) preview.src = 'assets/img/avatar-placeholder.png';
                            if (typeof loadMembers === 'function') await loadMembers();
                        } else {
                            showToast(result.message, 'error');
                        }
                    } catch (err) {
                        showToast('Gagal menghubungi server', 'error');
                    } finally {
                        if (btn) btn.disabled = false;
                    }
                });
            }
        });

        // Auto-load Hero Section on first open
        window.addEventListener('DOMContentLoaded', () => {
            loadCMS('hero');
        });
    </script>
        </main>

    <!-- Rekomendasi Anggota Khusus Modal -->
    <div class="modal fade" id="rekomendasiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-bottom py-3 px-4" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-25 p-2 rounded-3">
                            <i class="fas fa-star fs-5 text-white"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-white">Rekomendasi Anggota Khusus</h5>
                            <small class="text-white text-opacity-75">Jadikan anggota biasa sebagai Anggota Khusus</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="rek-reg-number">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small text-uppercase">Nama Anggota</label>
                        <div id="rek-member-name" class="fw-bold fs-5 text-dark"></div>
                    </div>
                    <div class="alert alert-warning border-0 rounded-3 small">
                        <i class="fas fa-info-circle me-2"></i>
                        Anggota yang direkomendasikan akan mendapatkan status <strong>Anggota Khusus</strong> dan akan ditandai dengan ikon bintang di daftar anggota.
                    </div>
                    <div class="mb-3">
                        <label for="rek-alasan" class="form-label fw-semibold">Alasan Rekomendasi <span class="text-danger">*</span></label>
                        <textarea id="rek-alasan" class="form-control border-0 bg-light rounded-3" rows="4" placeholder="Tuliskan alasan mengapa anggota ini layak mendapatkan status Anggota Khusus..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 pb-4 pt-3 gap-2">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-warning rounded-3 px-5 fw-bold" onclick="saveRekomendasi()">
                        <i class="fas fa-star me-2"></i>SIMPAN REKOMENDASI
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Penilaian Anggota Modal -->
    <div class="modal fade" id="penilaianModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Header -->
                <div class="modal-header border-0 p-0">
                    <div class="w-100 px-4 pt-4 pb-3" style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px;background:rgba(255,255,255,0.15)">
                                    <i class="fas fa-clipboard-check text-white fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-white fs-6">Penilaian Anggota</div>
                                    <small class="text-white opacity-75">Berikan penilaian kinerja anggota</small>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                </div>
                <!-- Body -->
                <div class="modal-body p-4">
                    <input type="hidden" id="pen-reg-number">
                    <!-- Member Info Card -->
                    <div class="rounded-3 p-3 mb-4" style="background:#f0fdfa;border:1px solid #99f6e4;">
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <div class="text-muted" style="font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;">Nama Anggota</div>
                                <div class="fw-bold text-dark fs-6 text-uppercase" id="pen-member-name">—</div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="text-muted" style="font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;">Jabatan</div>
                                <div class="fw-semibold text-dark" id="pen-member-jabatan">—</div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="text-muted" style="font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;">Sektor</div>
                                <div class="fw-semibold text-dark" id="pen-member-sektor">—</div>
                            </div>
                        </div>
                    </div>

                    <!-- Rating Grid -->
                    <div class="mb-4">
                        <div class="fw-bold text-dark mb-3" style="font-size:13px;letter-spacing:0.5px;">PENILAIAN</div>
                        <div class="d-flex flex-column gap-3">
                            <!-- Loyalitas -->
                            <div class="d-flex align-items-center justify-content-between gap-3 p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
                                <div class="fw-semibold text-dark" style="min-width:160px;">Loyalitas</div>
                                <div class="d-flex gap-2" data-group="loyalitas">
                                    <?php foreach([1,2,3,4,5] as $n): ?>
                                    <button type="button" class="pen-rating-btn rounded-2 fw-bold border-0" data-group="loyalitas" data-val="<?php echo $n; ?>" style="width:38px;height:38px;font-size:14px;background:#e2e8f0;color:#64748b;transition:all .15s ease;"><?php echo $n; ?></button>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <!-- Keaktifan -->
                            <div class="d-flex align-items-center justify-content-between gap-3 p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
                                <div class="fw-semibold text-dark" style="min-width:160px;">Keaktifan</div>
                                <div class="d-flex gap-2" data-group="keaktifan">
                                    <?php foreach([1,2,3,4,5] as $n): ?>
                                    <button type="button" class="pen-rating-btn rounded-2 fw-bold border-0" data-group="keaktifan" data-val="<?php echo $n; ?>" style="width:38px;height:38px;font-size:14px;background:#e2e8f0;color:#64748b;transition:all .15s ease;"><?php echo $n; ?></button>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <!-- Anggota Terbanyak -->
                            <div class="d-flex align-items-center justify-content-between gap-3 p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
                                <div class="fw-semibold text-dark" style="min-width:160px;">Anggota Terbanyak</div>
                                <div class="d-flex gap-2" data-group="anggota_terbanyak">
                                    <?php foreach([1,2,3,4,5] as $n): ?>
                                    <button type="button" class="pen-rating-btn rounded-2 fw-bold border-0" data-group="anggota_terbanyak" data-val="<?php echo $n; ?>" style="width:38px;height:38px;font-size:14px;background:#e2e8f0;color:#64748b;transition:all .15s ease;"><?php echo $n; ?></button>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3" style="background:linear-gradient(90deg,#f0fdfa,#fff);border:2px solid #0d9488;">
                        <div class="fw-bold text-dark" style="min-width:80px;">TOTAL</div>
                        <div class="d-flex align-items-center">
                            <div id="pen-total" class="fw-black fs-3 me-1" style="color:#0d9488;min-width:48px;text-align:center;">0</div>
                            <span class="text-muted fs-6">/ 15</span>
                        </div>
                        <div class="ms-2">
                            <div id="pen-total-label" class="badge px-3 py-2" style="background:#e2e8f0;color:#64748b;font-size:12px;">Belum dinilai</div>
                        </div>
                    </div>

                    <!-- Komentar -->
                    <div class="mb-1">
                        <label class="fw-bold text-dark mb-2 d-block" style="font-size:13px;letter-spacing:0.5px;">KOMENTAR <span class="text-muted fw-normal">(opsional)</span></label>
                        <textarea id="pen-komentar" class="form-control" rows="3" placeholder="Tuliskan catatan atau komentar mengenai kinerja anggota..." style="resize:vertical;border-radius:10px;border:1.5px solid #e2e8f0;font-size:14px;"></textarea>
                    </div>
                </div>
                <!-- Footer -->
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn px-4 fw-semibold rounded-3" data-bs-dismiss="modal" style="background:#f1f5f9;color:#64748b;">Batal</button>
                    <button type="button" class="btn px-4 fw-bold rounded-3 text-white" onclick="savePenilaian()" style="background:linear-gradient(135deg,#0d9488,#0f766e);gap:8px;" id="pen-save-btn">
                        <i class="fas fa-check-circle me-2"></i>SIMPAN PENILAIAN
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Member Modal -->
    <div class="modal fade" id="addMemberModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-white border-bottom py-3 px-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-dark p-2 rounded-3 text-white">
                            <i class="fas fa-user-plus fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Tambah Anggota Baru</h5>
                            <small class="text-muted">Lengkapi data anggota dengan teliti</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white" style="max-height: 80vh; overflow-y: auto;">
                    <form id="addMemberForm" enctype="multipart/form-data">
                        <input type="hidden" name="status" value="Approved">

                        <div class="section-badge mb-3">Data Calon Anggota</div>

                        <div class="text-center mb-4">
                            <div class="photo-upload-wrapper">
                                <img id="a-photo-preview" src="assets/img/avatar-placeholder.png" class="photo-preview-img">
                                <label for="a-photo" class="photo-upload-btn">
                                    <i class="fas fa-camera fa-sm"></i>
                                </label>
                                <input type="file" name="photo" id="a-photo" class="d-none" accept="image/*" onchange="previewImage(this, 'a-photo-preview')">
                            </div>
                            <div class="photo-upload-label">Pas Foto Anggota</div>
                        </div>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <label class="small fw-bold text-muted mb-1 text-uppercase">NAMA LENGKAP</label>
                                <input type="text" name="full_name" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2 fw-bold" placeholder="Input nama lengkap..." required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 text-uppercase">TEMPAT LAHIR</label>
                                <input type="text" name="birth_place" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2" placeholder="Kota lahir">
                            </div>
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 text-uppercase">TANGGAL LAHIR</label>
                                <input type="date" name="birth_date" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 text-uppercase">JENIS KELAMIN</label>
                                <select name="gender" class="form-select bg-light border-0 rounded-3 fs-6 px-3 py-2">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 text-uppercase">PENDIDIKAN</label>
                                <select name="education" class="form-select bg-light border-0 rounded-3 fs-6 px-3 py-2">
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 text-uppercase">PEKERJAAN</label>
                                <select name="occupation" class="form-select bg-light border-0 rounded-3 fs-6 px-3 py-2">
                                    <option value="PNS">PNS</option>
                                    <option value="PENSIUN">PENSIUN</option>
                                    <option value="KARYAWAN SWASTA">KARYAWAN SWASTA</option>
                                    <option value="SECURITY">SECURITY</option>
                                    <option value="WIRASWASTA">WIRASWASTA</option>
                                    <option value="IRT">IRT</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 text-uppercase">NIK</label>
                                <input type="text" name="nik" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2" placeholder="16 digit NIK">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <label class="small fw-bold text-muted mb-1 text-uppercase">HP</label>
                                <input type="text" name="phone" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2" placeholder="Nomor WhatsApp">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 text-uppercase">KECAMATAN</label>
                                <select name="sector" id="a-sector" class="form-select bg-light border-0 rounded-3 fs-6 px-3 py-2" onchange="updateKelurahanDropdownAdd(this.value)">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 text-uppercase">KELURAHAN</label>
                                <select name="subsector" id="a-subsector" class="form-select bg-light border-0 rounded-3 fs-6 px-3 py-2" onchange="updateMemberIdAdd()">
                                    <option value="">Pilih Kelurahan</option>
                                    <!-- Populated by JS -->
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1 text-uppercase">ALAMAT LENGKAP</label>
                            <textarea name="address" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2" rows="2" placeholder="Jalan, No Rumah, RT/RW..."></textarea>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <label class="small fw-bold text-muted mb-1 text-uppercase">NO ANGGOTA</label>
                                <input type="text" name="no_anggota" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2 fw-bold" placeholder="Akan otomatis jika disetujui, atau input manual..." readonly>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 text-uppercase">JABATAN</label>
                                <input type="text" name="position" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2" placeholder="Contoh: Anggota">
                            </div>
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 text-uppercase">KODE PANGGIL</label>
                                <input type="text" name="call_code" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2" placeholder="Contoh: 001">
                            </div>
                        </div>

                        <input type="hidden" name="reg_number" id="a-reg-number">

                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1 text-uppercase">LAMPIRAN DOKUMEN (PDF/ZIP)</label>
                            <input type="file" name="reg_file" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2">
                        </div>

                        <div class="section-badge mb-3 d-none">REKOMENDASI CETAK KARTU</div>
                        <div class="mb-4 d-none">
                            <textarea name="card_recommendation" class="form-control bg-light border-0 rounded-4 p-3" rows="3" placeholder="Catatan khusus pencetakan..."></textarea>
                        </div>

                        <div class="d-grid gap-2 border-top pt-4">
                            <button type="submit" class="btn btn-dark rounded-3 py-3 fw-bold text-uppercase shadow-sm">
                                <i class="fas fa-save me-2"></i> SIMPAN ANGGOTA BARU
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-auto d-none d-lg-block">
            <div class="container text-center">
                <p class="mb-0 opacity-50 small">&copy; <?php echo date('Y'); ?> Admin Panel Pokdar Kamtibmas Polres Tangerang Selatan.</p>
            </div>
        </footer>
    </div>
    <!-- Bottom Sheets for Mobile Navigation -->
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasAdminMenu" aria-labelledby="offcanvasAdminMenuLabel">
        <div class="offcanvas-header pb-0">
            <div class="action-sheet-handle"></div>
            <h6 class="fw-bold mb-0 w-100 text-center">Navigasi Admin</h6>
        </div>
        <div class="offcanvas-body">
            <div class="mobile-nav-list">
                <a href="index.php" class="mobile-nav-item">
                    <i class="fas fa-home"></i> Beranda Utama
                </a>
                <a href="#" class="mobile-nav-item active" onclick="switchAdminTab('pendaftaran-tab', 'Database Anggota', 'user-shield', this)">
                    <i class="fas fa-user-shield"></i> Database Anggota
                </a>
                <a href="#" class="mobile-nav-item" onclick="switchAdminTab('cms-tab', 'Manajemen Konten', 'edit', this); loadCMS('hero')">
                    <i class="fas fa-edit"></i> Manajemen Konten
                </a>
                <a href="#" class="mobile-nav-item text-danger" onclick="switchAdminTab('trash-tab', 'Arsip Keluar', 'trash-alt', this); loadTrash()">
                    <i class="fas fa-trash-alt"></i> Arsip Keluar
                </a>
                <div class="border-top my-2"></div>
                <a href="logout.php" class="mobile-nav-item text-danger">
                    <i class="fas fa-sign-out-alt"></i> Keluar Sistem
                </a>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasCmsMenu" aria-labelledby="offcanvasCmsMenuLabel">
        <div class="offcanvas-header pb-0">
            <div class="action-sheet-handle"></div>
            <h6 class="fw-bold mb-0 w-100 text-center">Pilih Kelola Konten</h6>
        </div>
        <div class="offcanvas-body">
            <div class="mobile-nav-list" id="mobile-cms-nav-list">
                <!-- Populated via loadCMS/JS -->
            </div>
        </div>
    </div>

    <!-- CMS Edit Modal -->
    <div class="modal fade cms-premium-modal" id="cmsEditModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0" id="cmsModalTitle">Edit Item</h5>
                        <p class="small text-muted mb-0" id="cmsModalSubtitle">Sesuaikan konten dengan teliti.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 p-lg-5">
                    <form id="cms-edit-form">
                        <input type="hidden" id="cms-edit-type">
                        <input type="hidden" id="cms-edit-path">
                        <input type="hidden" id="cms-edit-index">
                        <div id="cms-modal-fields" class="row g-4">
                            <!-- Populated by JS -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 p-4 p-lg-5 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-dark rounded-pill px-4 fw-bold" onclick="saveCmsItem()">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="toast-container" class="toast-container"></div>

    <!-- Mobile Fixed Bottom Nav -->
    <div class="mobile-bottom-nav d-lg-none">
        <a href="index.php" class="mobile-bottom-item text-decoration-none">
            <i class="fas fa-home"></i>
            <span>Beranda</span>
        </a>
        <a href="#" class="mobile-bottom-item active text-decoration-none" onclick="switchAdminTab('pendaftaran-tab', 'Database Anggota', 'user-shield', this)">
            <i class="fas fa-user-shield"></i>
            <span>Database</span>
        </a>
        <a href="#" class="mobile-bottom-item text-decoration-none" onclick="switchAdminTab('cms-tab', 'Manajemen Konten', 'edit', this); loadCMS('hero')">
            <i class="fas fa-edit"></i>
            <span>Konten</span>
        </a>
        <a href="#" class="mobile-bottom-item text-decoration-none" onclick="switchAdminTab('trash-tab', 'Arsip Keluar', 'trash-alt', this); loadTrash()">
            <i class="fas fa-trash-alt"></i>
            <span>Arsip</span>
        </a>
        <a href="logout.php" class="mobile-bottom-item text-danger text-decoration-none">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
    </div>
</body>
</html>
