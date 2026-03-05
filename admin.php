<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
$userRole = $_SESSION['user_role'] ?? 'admin';
$userSector = $_SESSION['user_sector'] ?? '';
?>
<script>
    window.USER_ROLE = "<?php echo $userRole; ?>";
    window.USER_SECTOR = "<?php echo $userSector; ?>";
</script>
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
    <link rel="icon" type="image/png" href="assets/image.png">

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

        .btn-action-text {
            padding: 2px 8px !important;
            font-size: 10px !important;
            font-weight: 700 !important;
            border-radius: 4px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .action-btns {
            display: flex;
            flex-wrap: nowrap;
            gap: 4px;
            justify-content: flex-end;
            align-items: center;
            width: auto;
        }

        @media (max-width: 768px) {
            .btn-action-text {
                padding: 6px 2px !important;
                font-size: 9px !important;
                width: 68px !important;
                flex: none !important;
                text-align: center;
                display: inline-block;
            }
            .action-btns {
                width: 140px !important;
                flex-wrap: wrap !important;
                justify-content: flex-end;
            }
            .stats-card-compact {
                max-width: 160px !important;
                padding: 10px !important;
            }
            .stats-count {
                font-size: 1.5rem !important;
            }
            .stats-label {
                font-size: 9px !important;
            }
            .kasektor-header {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 15px;
            }
            .table-responsive {
                font-size: 13px;
            }
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
                color: #fff;
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
            min-width: unset; /* Allow mobile to be flexible */
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 0;
        }

        @media (min-width: 992px) {
            .cms-table {
                min-width: 800px; /* Only force width on desktop */
            }
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

        @media (max-width: 768px) {
            .cms-table tbody td {
                padding: 12px 10px; /* Smaller padding on mobile */
            }
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
                            <button class="nav-link active py-3 px-4" id="pendaftaran-tab" data-bs-toggle="tab" data-bs-target="#pendaftaran" type="button" role="tab" onclick="loadMembers('biasa')">Database Anggota</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-3 px-4" id="pendaftaran-khusus-tab" data-bs-toggle="tab" data-bs-target="#pendaftaran-khusus" type="button" role="tab" onclick="loadMembers('khusus')">Anggota Penuh</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-3 px-4" id="kasektor-tab" data-bs-toggle="tab" data-bs-target="#kasektor-section" type="button" role="tab" onclick="loadKasektor()">Kasektor</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-3 px-4" id="trash-tab" data-bs-toggle="tab" data-bs-target="#trash-section" type="button" role="tab" onclick="loadTrash()">Anggota Keluar</button>
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
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0 d-none d-lg-block">Daftar Database Anggota</h5>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-dark rounded-3 px-3 d-flex align-items-center gap-2" onclick="printMemberList('biasa')">
                                        <i class="fas fa-print"></i> <span class="d-none d-md-inline">Cetak Daftar</span>
                                    </button>
                                    <button class="btn btn-dark rounded-3 px-4 py-2 fw-bold shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                                        <i class="fas fa-user-plus"></i> Tambah Anggota
                                    </button>
                                </div>
                            </div>
                            
                            <div class="row g-2 mb-3">
                                <div class="col-md-5 col-lg-4">
                                    <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                        <input type="text" class="form-control border-start-0 ps-0" id="search-biasa" placeholder="Cari nama, NIK, atau nomor..." onkeyup="handleSearch('biasa')">
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <select class="form-select shadow-sm rounded-3 fw-bold text-uppercase" id="filter-sector-biasa" onchange="handleFilterChange('biasa')" style="font-size: 13px;">
                                        <option value="">Semua Kecamatan</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <select class="form-select shadow-sm rounded-3 fw-bold text-uppercase" id="filter-subsector-biasa" onchange="loadMembers('biasa')" style="font-size: 13px;">
                                        <option value="">Semua Kelurahan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive cms-table-container">
                                <table class="table cms-table align-middle border-0">
                                    <thead>
                                        <tr class="small text-uppercase fw-bold text-muted">
                                            <th class="border-0 d-none d-md-table-cell">No Anggota</th>
                                            <th class="border-0">Nama Lengkap</th>
                                            <th class="border-0 d-none d-sm-table-cell">L/P</th>
                                            <th class="border-0 d-none d-md-table-cell">Sektor</th>
                                            <th class="border-0 d-none d-lg-table-cell">Telepon</th>
                                            <th class="border-0">Status</th>
                                            <th class="border-0 text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="member-table-body" class="border-top-0">
                                        <!-- Loaded via JS -->
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="spinner-border text-accent" role="status"></div>
                                                <p class="mt-2 text-muted">Memuat data anggota...</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination Biasa -->
                            <div class="d-flex justify-content-between align-items-center mt-3 px-2">
                                <div class="text-muted small" id="info-biasa">Memuat info...</div>
                                <nav>
                                    <ul class="pagination pagination-sm mb-0" id="pagination-biasa"></ul>
                                </nav>
                            </div>
                        </div>

                        <!-- Tab Anggota Penuh -->
                        <div class="tab-pane fade" id="pendaftaran-khusus" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0 d-none d-lg-block">Daftar Anggota Penuh</h5>
                                <button class="btn btn-outline-warning text-dark border-warning-subtle rounded-3 px-3 d-flex align-items-center gap-2 fw-bold" onclick="printMemberList('khusus')">
                                    <i class="fas fa-print"></i> <span class="d-none d-md-inline">Cetak Daftar Penuh</span>
                                </button>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-md-5 col-lg-4">
                                    <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                        <input type="text" class="form-control border-start-0 ps-0" id="search-khusus" placeholder="Cari nama, NIK, atau nomor..." onkeyup="handleSearch('khusus')">
                                    </div>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <select class="form-select shadow-sm rounded-3 fw-bold text-uppercase" id="filter-sector-khusus" onchange="handleFilterChange('khusus')" style="font-size: 13px;">
                                        <option value="">Semua Kecamatan</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <select class="form-select shadow-sm rounded-3 fw-bold text-uppercase" id="filter-subsector-khusus" onchange="loadMembers('khusus')" style="font-size: 13px;">
                                        <option value="">Semua Kelurahan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive cms-table-container">
                                <table class="table cms-table align-middle border-0">
                                    <thead>
                                        <tr class="small text-uppercase fw-bold text-muted">
                                            <th class="border-0 d-none d-md-table-cell">No Anggota</th>
                                            <th class="border-0">Nama Lengkap</th>
                                            <th class="border-0 d-none d-sm-table-cell">L/P</th>
                                            <th class="border-0 d-none d-md-table-cell">Sektor</th>
                                            <th class="border-0 d-none d-lg-table-cell">Telepon</th>
                                            <th class="border-0">Status</th>
                                            <th class="border-0 text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="member-khusus-table-body" class="border-top-0">
                                        <!-- Loaded via JS -->
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="spinner-border text-accent" role="status"></div>
                                                <p class="mt-2 text-muted">Memuat data Anggota Penuh...</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination Khusus -->
                            <div class="d-flex justify-content-between align-items-center mt-3 px-2">
                                <div class="text-muted small" id="info-khusus">Memuat info...</div>
                                <nav>
                                    <ul class="pagination pagination-sm mb-0" id="pagination-khusus"></ul>
                                </nav>
                            </div>
                        </div>

                        <!-- Tab Kasektor -->
                        <div class="tab-pane fade" id="kasektor-section" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4 kasektor-header">
                                <div>
                                    <h4 class="fw-bold mb-1">Manajemen Kasektor</h4>
                                    <p class="text-muted small mb-0">Kelola data ketua sektor, password, dan lakukan penilaian kinerja.</p>
                                </div>
                                <button class="btn btn-dark rounded-3 px-3 py-2 fw-bold shadow-sm d-flex align-items-center gap-2" onclick="openKasektorModal()" style="font-size: 13px;">
                                    <i class="fas fa-plus"></i> Tambah Kasektor
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle border-0">
                                    <thead class="table-light">
                                        <tr class="small text-uppercase fw-bold text-muted">
                                            <th class="border-0">Nama Kasektor</th>
                                            <th class="border-0">Sektor / Kecamatan</th>
                                            <th class="border-0 text-center">Penilaian</th>
                                            <th class="border-0 text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="kasektor-table-body" class="border-top-0">
                                        <!-- Loaded via JS -->
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <div class="spinner-border text-accent" role="status"></div>
                                                <p class="mt-2 text-muted">Memuat data kasektor...</p>
                                            </td>
                                        </tr>
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
                                        <select name="sector" id="m-sector" class="form-select bg-light border-0 rounded-3 fs-6 px-3 py-2" onchange="updateKelurahanDropdown(this.value)" required>
                                            <!-- Options will be populated by JS -->
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">KELURAHAN</label>
                                        <select name="subsector" id="m-subsector" class="form-select bg-light border-0 rounded-3 fs-6 px-3 py-2" onchange="updateMemberId()" required>
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
            // Global check for session expiry/unauthorized
            if (message && String(message).toLowerCase().includes('unauthorized')) {
                window.location.href = 'login.php';
                return;
            }
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

        // Paging & Search State
        let currentPageBiasa = 1;
        let currentPageKhusus = 1;
        const itemsPerPage = 10;
        let searchQueryBiasa = "";
        let searchQueryKhusus = "";

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
                loadMembers('biasa');
                loadMembers('khusus');
            } catch (err) {
                console.error('Gagal memuat data:', err);
            }
        }

        function populatePolsekDropdown() {
            const selects = [
                document.getElementById('m-sector'), 
                document.getElementById('a-sector'),
                document.getElementById('filter-sector-biasa'),
                document.getElementById('filter-sector-khusus'),
                document.getElementById('kasektor-sector')
            ];

            // Get assigned code for Kasektor
            const assignedP = polsekData.find(p => p.id === window.USER_SECTOR);
            const assignedKode = assignedP ? assignedP.kode : null;
            const allowedPolseks = assignedKode ? polsekData.filter(p => p.kode === assignedKode) : [];

            selects.forEach(select => {
                if(!select) return;
                const isFilter = select.id.startsWith('filter-');
                
                // Placeholder
                select.innerHTML = `<option value="">${isFilter ? 'SEMUA KECAMATAN' : 'Pilih Kecamatan'}</option>`;
                
                polsekData.forEach(p => {
                    // Filter if Kasektor: allow all Polseks with the same code
                    if (window.USER_ROLE === 'kasektor' && assignedKode) {
                        if (p.kode !== assignedKode) return;
                    }

                    const opt = document.createElement('option');
                    opt.value = p.id;
                    opt.textContent = p.nama.toUpperCase();
                    select.appendChild(opt);
                });

                // Restriction for Kasektor
                if (window.USER_ROLE === 'kasektor' && assignedKode) {
                    if (allowedPolseks.length === 1) {
                        // Only one Polsek for this code, pre-select and disable
                        select.selectedIndex = 1;
                        select.disabled = true;
                        if (isFilter) {
                            const type = select.id.replace('filter-sector-', '');
                            handleFilterChange(type);
                        } else if (select.onchange) {
                            select.onchange();
                        }
                    } else {
                        // Multiple Polseks for this code, allow selection but stay within allowedPolseks
                        select.disabled = false;
                        // Pre-select the specifically assigned one if adding/editing
                        if (!isFilter && window.USER_SECTOR) {
                            select.value = window.USER_SECTOR;
                            if (select.onchange) select.onchange();
                        }
                    }
                }
            });
        }

        function handleFilterChange(type) {
            const sectorVal = document.getElementById(`filter-sector-${type}`).value;
            const subsectorSelect = document.getElementById(`filter-subsector-${type}`);
            
            if(!subsectorSelect) return;

            subsectorSelect.innerHTML = '<option value="">SEMUA KELURAHAN</option>';
            if (sectorVal) {
                const filteredSub = kelurahanData.filter(k => 
                    k.polsek_id === sectorVal || k.polsek_id.startsWith(sectorVal)
                );
                filteredSub.sort((a, b) => a.nama.localeCompare(b.nama));
                filteredSub.forEach(k => {
                    const opt = document.createElement('option');
                    opt.value = k.kode;
                    opt.textContent = k.nama.toUpperCase();
                    subsectorSelect.appendChild(opt);
                });
            }
            loadMembers(type);
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
            // Custom Select Dropdowns
            const pTab = document.getElementById('pendaftaran-tab');
            const pkTab = document.getElementById('pendaftaran-khusus-tab');
            if (pTab) pTab.addEventListener('shown.bs.tab', () => loadMembers('biasa'));
            if (pkTab) pkTab.addEventListener('shown.bs.tab', () => loadMembers('khusus'));

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
                        await refreshMembers();
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
                    await refreshMembers();
                    showToast(`Pendaftaran Berhasil ${status === 'Approved' ? 'Disetujui' : 'Ditolak'}!`, 'success');
                } else {
                    showToast(result.message, 'error');
                }
            } catch (err) {
                showToast('Gagal menghubungi server', 'error');
            }
        }

        async function refreshMembers() {
            try {
                const resp = await fetch('data/pendaftaran.json?v=' + Date.now());
                allMembersData = await resp.json();
                loadMembers('biasa');
                loadMembers('khusus');
            } catch (err) {
                console.error('Refresh error:', err);
            }
        }

        async function loadMembers(type = 'biasa') {
            const isKhusus = type === 'khusus';
            const tableBody = isKhusus ? document.getElementById('member-khusus-table-body') : document.getElementById('member-table-body');
            const infoEl = isKhusus ? document.getElementById('info-khusus') : document.getElementById('info-biasa');
            const paginationEl = isKhusus ? document.getElementById('pagination-khusus') : document.getElementById('pagination-biasa');

            if (!tableBody) return;

            try {
                // Filter by member_type and search query
                let filtered = allMembersData.filter(m => {
                    // type 'biasa' now means ALL MEMBERS as requested (Database Anggota)
                    // type 'khusus' includes both Approved and Pending recommendations
                    const matchType = isKhusus 
                        ? (m.rekomendasi_status === 'Approved' || m.rekomendasi_status === 'Pending') 
                        : true;
                    const query = (isKhusus ? searchQueryKhusus : searchQueryBiasa).toLowerCase();
                    
                    // Normalize sector values for comparison
                    const mSector = String(m.sector || "").padStart(2, '0');
                    const mSubsector = String(m.subsector || "").padStart(2, '0');

                    // Specific filters
                    let filterSector = document.getElementById(`filter-sector-${type}`).value;
                    const filterSubsector = document.getElementById(`filter-subsector-${type}`).value;
                    
                    // Match sector: ID match or Code match
                    let matchSector = !filterSector || 
                                       m.sector === filterSector || 
                                       mSector === filterSector || 
                                       filterSector.startsWith(mSector + "-") || 
                                       filterSector === mSector;

                    // ROLE-BASED RESTRICTION: Kasektor forced to their assigned code
                    if (window.USER_ROLE === 'kasektor' && window.USER_SECTOR) {
                        const assignedP = polsekData.find(p => p.id === window.USER_SECTOR);
                        const assignedKode = assignedP ? assignedP.kode : null;
                        
                        if (assignedKode) {
                            // Resolve this member's Polsek Kode
                            const memP = polsekData.find(p => p.id === m.sector || p.kode === mSector);
                            const memKode = memP ? memP.kode : mSector;

                            if (!filterSector) {
                                // "Semua Kecamatan" selected -> match by assigned code
                                matchSector = (memKode === assignedKode);
                            } else {
                                // Specific Polsek selected -> ensure it's one belonging to their code
                                const selectedP = polsekData.find(p => p.id === filterSector);
                                if (selectedP && selectedP.kode !== assignedKode) {
                                    matchSector = false;
                                }
                            }
                        }
                    }

                    // Match subsector: Code match
                    const matchSubsector = !filterSubsector || m.subsector === filterSubsector || mSubsector === filterSubsector;

                    // Lookup names for search
                    const pObj = polsekData.find(p => p.id === m.sector || p.kode === mSector);
                    const kObj = kelurahanData.find(k => (k.polsek_id === m.sector || k.polsek_id.startsWith(mSector)) && (k.kode === m.subsector || k.kode === mSubsector));
                    const sectorName = pObj ? pObj.nama.toLowerCase() : "";
                    const subsectorName = kObj ? kObj.nama.toLowerCase() : "";

                    if (!query) return matchType && matchSector && matchSubsector;

                    const matchSearch = String(m.full_name || "").toLowerCase().includes(query) || 
                                        String(m.no_anggota || m.reg_number || "").toLowerCase().includes(query) ||
                                        String(m.nik || "").toLowerCase().includes(query) ||
                                        String(m.phone || "").toLowerCase().includes(query) ||
                                        sectorName.includes(query) ||
                                        subsectorName.includes(query);
                    return matchType && matchSector && matchSubsector && matchSearch;
                });

                // Sort newest first
                filtered.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));

                const totalItems = filtered.length;
                const totalPages = Math.ceil(totalItems / itemsPerPage);
                let currentPage = isKhusus ? currentPageKhusus : currentPageBiasa;
                
                if (currentPage > totalPages && totalPages > 0) currentPage = totalPages;
                if (totalPages === 0) currentPage = 1;
                if (isKhusus) currentPageKhusus = currentPage; else currentPageBiasa = currentPage;

                const startIdx = (currentPage - 1) * itemsPerPage;
                const endIdx = Math.min(startIdx + itemsPerPage, totalItems);
                const paginatedItems = filtered.slice(startIdx, endIdx);

                // Update counter
                const counterEl = document.getElementById('active-member-count');
                if(counterEl) counterEl.innerText = allMembersData.length;

                // Info text
                if (infoEl) infoEl.innerText = totalItems > 0 ? `Menampilkan ${startIdx + 1} - ${endIdx} dari ${totalItems} data` : 'Tidak ada data';

                if (totalItems === 0) {
                    tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-5 text-muted">Belum ada data anggota ${isKhusus ? 'penuh' : ''}.</td></tr>`;
                    if (paginationEl) paginationEl.innerHTML = '';
                    return;
                }

                let html = '';
                paginatedItems.forEach(row => {
                    const date = new Date(row.timestamp);
                    const longDate = date.toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) + ', ' +
                                    date.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'});

                    const status = row.status || 'Pending';
                    let statusBadge = ''; 
                    if(status === 'Rejected') statusBadge = `<span class="badge bg-danger-subtle text-danger border px-2">Rejected</span>`;

                    const mSector = String(row.sector || "").padStart(2, '0');
                    const mSubsector = String(row.subsector || "").padStart(2, '0');
                    const pObj = polsekData.find(p => p.id === row.sector || p.kode === mSector);
                    const kObj = kelurahanData.find(k => (k.polsek_id === row.sector || k.polsek_id.startsWith(mSector)) && (k.kode === row.subsector || k.kode === mSubsector));
                    const sectorName = pObj ? pObj.nama : (row.sector || '-');
                    const subsectorName = kObj ? kObj.nama : (row.subsector || '-');

                    const isRowKhusus = (row.member_type || '') === 'Khusus';
                    const isApproved = status === 'Approved';
                    const rekStatus = row.rekomendasi_status || '';
                    
                    let khususBadge = '';
                    if (isRowKhusus && rekStatus === 'Approved') {
                        khususBadge = `<span class="badge bg-dark text-white border px-2"><i class="fas fa-star text-warning me-1"></i>Penuh</span>`;
                    } else if (rekStatus === 'Pending') {
                        khususBadge = `<span class="badge bg-info-subtle text-info border px-2"><i class="fas fa-hourglass-half me-1"></i>Pending Ajuan</span>`;
                    } else if (rekStatus === 'Rejected') {
                        khususBadge = `<span class="badge bg-danger-subtle text-danger border px-2"><i class="fas fa-times-circle me-1"></i>Ajuan Ditolak</span>`;
                    }
                    
                    let penilaianBadge = '';
                    // Hiding member assessment badge for now as requested
                    /*
                    if (row.penilaian && row.penilaian.total !== undefined) {
                        const pt = row.penilaian.total;
                        let pColor = '#64748b', pBg = '#e2e8f0';
                        if (pt >= 14)     { pBg = '#0d9488'; pColor = '#fff'; }
                        else if (pt >= 11){ pBg = '#d1fae5'; pColor = '#065f46'; }
                        else if (pt >= 6) { pBg = '#dbeafe'; pColor = '#1e40af'; }
                        else if (pt >= 1) { pBg = '#fef3c7'; pColor = '#92400e'; }
                        const pLabel = pt >= 14 ? 'Sangat Baik' : pt >= 11 ? 'Baik' : pt >= 6 ? 'Cukup Baik' : 'Perlu Pembinaan';
                        penilaianBadge = `<span class="badge px-2 py-1" style="background:${pBg};color:${pColor};font-size:11px;" title="Penilaian: Total ${pt}/15"><i class="fas fa-clipboard-check me-1"></i>${pt}/15</span>`;
                    }
                    */

                    const safeAlasan = (row.rekomendasi_alasan || '').replace(/'/g, "\\'" ).replace(/\n/g, '\\n');
                    const safeName = row.full_name.replace(/'/g, "\\'");
                    const safePosition = (row.position || '').replace(/'/g,"\\'");

                    let rekBtn = '';
                    let penilaianBtn = '';
                    if (isApproved) {
                        const hasSubmitted = rekStatus !== '';
                        const rekBtnLabel = hasSubmitted ? 'AJUAN' : 'REKOM';
                        rekBtn = hasSubmitted
                            ? `<button class="btn btn-warning btn-action-text" onclick="openRekomendasiModal('${row.reg_number}', '${safeName}', '${safeAlasan}', '${type}')">${rekBtnLabel}</button>`
                            : `<button class="btn btn-outline-warning btn-action-text" onclick="openRekomendasiModal('${row.reg_number}', '${safeName}', '', '${type}')">${rekBtnLabel}</button>`;
                    }    
                        // Hiding assessment button
                        // penilaianBtn = `<button class="btn btn-sm btn-outline-info rounded-3" title="Penilaian" onclick="openPenilaianModal('${row.reg_number}', '${safeName}', '${safePosition}')"><i class="fas fa-clipboard-check"></i></button>`;
                    

                    html += `
                        <tr>
                            <td class="d-none d-md-table-cell"><code class="bg-light p-1 rounded">${row.no_anggota || row.reg_number}</code></td>
                            <td>
                                <div class="fw-bold text-uppercase">${row.full_name}</div>
                                <div class="d-md-none small text-muted">${row.no_anggota || row.reg_number}</div>
                            </td>
                            <td class="d-none d-sm-table-cell"><span class="badge bg-light text-dark">${row.gender === 'Laki-laki' ? 'L' : (row.gender === 'Perempuan' ? 'P' : '-')}</span></td>
                            <td class="small d-none d-md-table-cell text-uppercase text-truncate" style="max-width:150px">
                                <div class="fw-bold" style="font-size:11px">${sectorName}</div>
                                <div class="text-muted small" style="font-size:10px">${subsectorName}</div>
                            </td>
                            <td class="d-none d-lg-table-cell small text-muted">${row.phone || '-'}</td>
                            <td>
                                <div class="d-flex flex-column gap-1 align-items-start">
                                    <div class="d-flex flex-wrap gap-1">
                                        ${statusBadge}
                                        ${khususBadge}
                                    </div>
                                    ${penilaianBadge}
                                </div>
                            </td>
                            <td class="text-end" style="width: 1%;">
                                <div class="action-btns">
                                    <button class="btn btn-primary btn-action-text"
                                            onclick="openDetailModal('${row.reg_number}', '${longDate}')">
                                        PROFILE
                                    </button>
                                    <button class="btn btn-secondary btn-action-text" onclick="printMemberCard('${row.reg_number}')">
                                        ${(isRowKhusus && rekStatus === 'Approved') ? 'CETAK CARD' : 'CETAK ID'}
                                    </button>
                                    ${rekBtn}
                                    ${penilaianBtn}
                                    <button class="btn btn-danger btn-action-text" onclick="moveToTrash('${row.reg_number}')">
                                        KELUAR
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                });
                tableBody.innerHTML = html;
                renderPagination(type, totalPages, currentPage);
            } catch (err) {
                console.error('Gagal render anggota:', err);
            }
        }

        function handleSearch(type) {
            const query = document.getElementById('search-' + type).value;
            if (type === 'khusus') {
                searchQueryKhusus = query;
                currentPageKhusus = 1;
            } else {
                searchQueryBiasa = query;
                currentPageBiasa = 1;
            }
            loadMembers(type);
        }

        function renderPagination(type, totalPages, currentPage) {
            const paginationEl = type === 'khusus' ? document.getElementById('pagination-khusus') : document.getElementById('pagination-biasa');
            if (!paginationEl) return;

            let html = '';
            // Prev
            html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="javascript:void(0)" onclick="changePage('${type}', ${currentPage - 1})"><i class="fas fa-chevron-left"></i></a>
                    </li>`;
            
            // Pages
            let start = Math.max(1, currentPage - 2);
            let end = Math.min(totalPages, start + 4);
            if (end - start < 4) start = Math.max(1, end - 4);

            for (let i = start; i <= end; i++) {
                html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a class="page-link" href="javascript:void(0)" onclick="changePage('${type}', ${i})">${i}</a>
                        </li>`;
            }

            // Next
            html += `<li class="page-item ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}">
                        <a class="page-link" href="javascript:void(0)" onclick="changePage('${type}', ${currentPage + 1})"><i class="fas fa-chevron-right"></i></a>
                    </li>`;
            
            paginationEl.innerHTML = html;
        }

        function changePage(type, page) {
            if (type === 'khusus') currentPageKhusus = page;
            else currentPageBiasa = page;
            loadMembers(type);
        }

        function openDetailModal(reg, date) {
            const dummy = document.createElement('button');
            dummy.setAttribute('data-reg', reg);
            dummy.setAttribute('data-date', date);
            dummy.setAttribute('data-bs-toggle', 'modal');
            dummy.setAttribute('data-bs-target', '#detailModal');
            document.body.appendChild(dummy);
            dummy.click();
            document.body.removeChild(dummy);
        }

        function printMemberList(type) {
            const isKhusus = type === 'khusus';
            let sectorFilter = document.getElementById(`filter-sector-${type}`).value;
            const subsectorFilter = document.getElementById(`filter-subsector-${type}`).value;
            const query = (isKhusus ? searchQueryKhusus : searchQueryBiasa).toLowerCase();

            let filtered = allMembersData.filter(m => {
                // type 'khusus' includes both Approved and Pending recommendations
                const matchType = isKhusus 
                    ? (m.rekomendasi_status === 'Approved' || m.rekomendasi_status === 'Pending') 
                    : true;
                
                // Normalize sector values for comparison
                const mSector = String(m.sector || "").padStart(2, '0');
                const mSubsector = String(m.subsector || "").padStart(2, '0');

                // Match sector: ID match or Code match (consistent with loadMembers)
                let matchSector = !sectorFilter || 
                                   m.sector === sectorFilter || 
                                   mSector === sectorFilter || 
                                   sectorFilter.startsWith(mSector + "-") || 
                                   sectorFilter === mSector;

                // ROLE-BASED RESTRICTION: Kasektor forced to their assigned code
                if (window.USER_ROLE === 'kasektor' && window.USER_SECTOR) {
                    const assignedP = polsekData.find(p => p.id === window.USER_SECTOR);
                    const assignedKode = assignedP ? assignedP.kode : null;
                    
                    if (assignedKode) {
                        // Resolve this member's Polsek Kode
                        const memP = polsekData.find(p => p.id === m.sector || p.kode === mSector);
                        const memKode = memP ? memP.kode : mSector;

                        if (!sectorFilter) {
                            // "Semua Kecamatan" selected -> match by assigned code
                            matchSector = (memKode === assignedKode);
                        } else {
                            // Specific Polsek selected -> ensure it's one belonging to their code
                            const selectedP = polsekData.find(p => p.id === sectorFilter);
                            if (selectedP && selectedP.kode !== assignedKode) {
                                matchSector = false;
                            }
                        }
                    }
                }

                // Match subsector: Code match
                const matchSubsector = !subsectorFilter || m.subsector === subsectorFilter || mSubsector === subsectorFilter;
                
                // Lookup names for search
                const pObj = polsekData.find(p => p.id === m.sector || p.kode === mSector);
                const kObj = kelurahanData.find(k => (k.polsek_id === m.sector || k.polsek_id.startsWith(mSector)) && (k.kode === m.subsector || k.kode === mSubsector));
                
                const sectorName = (pObj ? pObj.nama : (m.sector || '-')).toLowerCase();
                const subsectorName = (kObj ? kObj.nama : (m.subsector || '-')).toLowerCase();

                if (!query) return matchType && matchSector && matchSubsector;

                const matchSearch = String(m.full_name || "").toLowerCase().includes(query) || 
                                    String(m.no_anggota || m.reg_number || "").toLowerCase().includes(query) ||
                                    String(m.nik || "").toLowerCase().includes(query) ||
                                    String(m.phone || "").toLowerCase().includes(query) ||
                                    sectorName.includes(query) ||
                                    subsectorName.includes(query);

                return matchType && matchSector && matchSubsector && matchSearch;
            });

            // Sort newest first to match display
            filtered.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));

            if (filtered.length === 0) {
                showToast('Tidak ada data untuk dicetak.', 'warning');
                return;
            }

            let tableRows = filtered.map((m, i) => {
                const pObj = polsekData.find(p => p.id === m.sector || p.kode === m.sector);
                const sector = pObj ? pObj.nama : (m.sector || '-');
                return `
                    <tr>
                        <td align="center">${i + 1}</td>
                        <td>${m.no_anggota || m.reg_number}</td>
                        <td>${String(m.full_name).toUpperCase()}</td>
                        <td>${m.nik || '-'}</td>
                        <td align="center">${m.gender === 'Laki-laki' ? 'L' : 'P'}</td>
                        <td>${sector}</td>
                        <td align="center">${m.status || 'Pending'}</td>
                    </tr>
                `;
            }).join('');

            const printHTML = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Daftar ${isKhusus ? 'Anggota Penuh' : 'Database Anggota'}</title>
                    <style>
                        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 30px; color: #333; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        th, td { border: 1px solid #999; padding: 10px; text-align: left; font-size: 11px; }
                        th { background-color: #f0f0f0; text-transform: uppercase; }
                        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
                        .title { margin: 0; font-size: 18px; font-weight: bold; }
                        .subtitle { margin: 5px 0 0; font-size: 12px; color: #666; }
                        @media print { .no-print { display: none; } }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <div class="title">DAFTAR ANGGOTA POKDAR KAMTIBMAS BHAYANGKARA</div>
                        <div class="subtitle">Kategori: ${isKhusus ? 'Anggota Penuh' : 'Database Anggota (Semua)'} | Dicetak pada: ${new Date().toLocaleString('id-ID')}</div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Anggota</th>
                                <th>Nama Lengkap</th>
                                <th>NIK</th>
                                <th>L/P</th>
                                <th>Sektor</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${tableRows}
                        </tbody>
                    </table>
                    <script>window.onload = function() { window.print(); }<\/script>
                </body>
                </html>
            `;

            const printWin = window.open('', '_blank');
            printWin.document.write(printHTML);
            printWin.document.close();
        }

        function openRekomendasiModal(regNumber, memberName, existingAlasan = '', context = 'biasa') {
            const member = allMembersData.find(m => m.reg_number === regNumber);
            const rekStatus = member ? (member.rekomendasi_status || '') : '';
            
            document.getElementById('rek-reg-number').value = regNumber;
            document.getElementById('rek-member-name').textContent = memberName.toUpperCase();
            
            const alasanField = document.getElementById('rek-alasan');
            alasanField.value = existingAlasan ? existingAlasan.replace(/\\n/g, '\n') : '';

            // Layout & Accessibility based on status
            // Editable if empty OR Rejected
            const isReadonly = (rekStatus === 'Pending' || rekStatus === 'Approved');
            alasanField.readOnly = isReadonly;
            if (isReadonly) {
                alasanField.classList.add('bg-white');
                alasanField.classList.remove('bg-light');
            } else {
                alasanField.classList.remove('bg-white');
                alasanField.classList.add('bg-light');
            }

            // Buttons visibility
            const btnSimpan = document.querySelector('button[onclick="saveRekomendasi()"]');
            const btnApprove = document.getElementById('btn-rek-approve');
            const btnReject = document.getElementById('btn-rek-reject');
            
            // Only show approve/reject for admins/kasektor on pending items in the 'khusus' tab
            const canProcess = (window.USER_ROLE === 'admin' || window.USER_ROLE === 'kasektor') && (context === 'khusus');
            
            if (rekStatus === '' || rekStatus === 'Rejected') {
                btnSimpan.classList.remove('d-none');
                if(btnApprove) btnApprove.classList.add('d-none');
                if(btnReject) btnReject.classList.add('d-none');
            } else if (rekStatus === 'Pending') {
                btnSimpan.classList.add('d-none');
                if (canProcess) {
                    if(btnApprove) btnApprove.classList.remove('d-none');
                    if(btnReject) btnReject.classList.remove('d-none');
                }
            } else {
                // Approved
                btnSimpan.classList.add('d-none');
                if(btnApprove) btnApprove.classList.add('d-none');
                if(btnReject) btnReject.classList.add('d-none');
            }

            // Update modal subtitle
            const subtitle = document.querySelector('#rekomendasiModal small');
            if (subtitle) {
                if (rekStatus === 'Approved') subtitle.textContent = 'Status: Sudah Menjadi Anggota Penuh';
                else if (rekStatus === 'Pending') subtitle.textContent = 'Status: Menunggu Ajuan';
                else if (rekStatus === 'Rejected') subtitle.textContent = 'Status: Ajuan Ditolak (Silakan ajukan ulang)';
                else subtitle.textContent = 'Jadikan anggota biasa sebagai Anggota Penuh';
            }

            const modal = new bootstrap.Modal(document.getElementById('rekomendasiModal'));
            modal.show();
        }

        async function processRekomendasi(status) {
            const reg = document.getElementById('rek-reg-number').value;
            const confirmMsg = status === 'Approved' ? 'Setujui anggota ini menjadi Anggota Penuh?' : 'Tolak ajuan anggota ini?';
            if (!confirm(confirmMsg)) return;

            try {
                const formData = new FormData();
                formData.append('reg_number', reg);
                formData.append('rekomendasi_status', status);
                if (status === 'Approved') {
                    formData.append('member_type', 'Khusus');
                } else {
                    // Rejection: reset to Biasa and clear recommendation data implicitly via Rejected status
                    formData.append('member_type', 'Biasa');
                }

                const resp = await fetch('update_member.php', { method: 'POST', body: formData });
                const result = await resp.json();

                bootstrap.Modal.getInstance(document.getElementById('rekomendasiModal')).hide();

                if (result.status === 'success') {
                    const msg = status === 'Approved' ? 'Anggota berhasil disetujui!' : 'Ajuan berhasil ditolak.';
                    showToast(msg, 'success');
                    await refreshMembers();
                } else {
                    showToast(result.message || 'Gagal memproses rekomendasi.', 'error');
                }
            } catch (err) {
                showToast('Gagal menghubungi server.', 'error');
            }
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
                formData.append('rekomendasi_alasan', alasan);
                formData.append('rekomendasi_status', 'Pending'); // Initial submission

                const resp = await fetch('update_member.php', { method: 'POST', body: formData });
                const result = await resp.json();

                if (result.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('rekomendasiModal')).hide();
                    showToast('Ajuan berhasil dikirim! Menunggu persetujuan.', 'success');
                    await refreshMembers();
                } else {
                    showToast(result.message || 'Gagal menyimpan rekomendasi.', 'error');
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
            const isKhusus = (member.member_type || '') === 'Khusus' && (member.rekomendasi_status === 'Approved');
            
            // Note: Pending members in "Anggota Penuh" tab will print the "Biasa" card design automatically
            // because isKhusus will be false. No warning needed here anymore.
            const baseUrl = window.location.href.replace('admin.php', '').replace(/\?.*$/, '');
            const photoSrc = member.photo_path || member.profile_path || 'assets/img/avatar-placeholder.png';
            const fullPhotoSrc = baseUrl + photoSrc.replace(/\\/g, '/');
            const fullLogoSrc = baseUrl + 'assets/image.png';

            // ── Two card designs ──────────────────────────────────
            const cardBg = isKhusus
                ? 'linear-gradient(135deg, #0f172a 0%, #1e293b 100%)'
                : 'linear-gradient(135deg, #1e3a5f 0%, #0d2137 100%)';

            const accentColor = isKhusus ? '#f59e0b' : '#3b82f6';

            const cardHTML = `<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>Kartu Anggota - ${member.full_name || ''}</title>
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;900&display=swap');
                * { margin:0; padding:0; box-sizing:border-box; }
                body { font-family:'Outfit',sans-serif; background:#f1f5f9; display:flex; flex-direction:column; justify-content:center; align-items:center; min-height:100vh; }
                .card { width:85.6mm; height:54mm; background:${cardBg}; border-radius:14px; position:relative; overflow:hidden; color:white; display:flex; padding:15px; box-shadow:0 20px 50px rgba(0,0,0,0.3); }
                
                /* Decorative patterns */
                .card::before { content:''; position:absolute; top:-20%; right:-10%; width:150px; height:150px; background:${accentColor}; border-radius:50%; opacity:0.1; filter:blur(40px); }
                .card::after { content:''; position:absolute; bottom:-20%; left:-10%; width:180px; height:180px; background:${accentColor}; border-radius:50%; opacity:0.08; filter:blur(50px); }
                
                .left-panel { width:75px; display:flex; flex-direction:column; gap:8px; position:relative; z-index:2; }
                .logo-box { width:45px; height:45px; background:white; padding:4px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.2); }
                .logo-box img { width:100%; height:100%; object-fit:contain; }
                
                .photo-box { width:75px; height:95px; border-radius:10px; overflow:hidden; border:2px solid ${accentColor}; box-shadow:0 8px 15px rgba(0,0,0,0.3); margin-top:5px; }
                .photo-box img { width:100%; height:100%; object-fit:cover; }
                
                .right-panel { flex:1; padding-left:15px; display:flex; flex-direction:column; position:relative; z-index:2; }
                .header { border-bottom:1px solid rgba(255,255,255,0.1); padding-bottom:5px; margin-bottom:8px; }
                .org { font-size:6px; font-weight:600; text-transform:uppercase; letter-spacing:1px; opacity:0.7; }
                .org-city { font-size:9px; font-weight:800; letter-spacing:0.5px; }
                
                .member-name { font-size:13px; font-weight:900; text-transform:uppercase; margin-bottom:2px; line-height:1.2; word-break:break-word; }
                
                .type-badge { display:inline-flex; align-items:center; background:${isKhusus ? accentColor : 'rgba(255,255,255,0.1)'}; color:${isKhusus ? '#000' : '#fff'}; font-size:7px; font-weight:800; padding:2px 8px; border-radius:50px; margin-bottom:10px; text-transform:uppercase; letter-spacing:0.5px; }
                
                .info-grid { display:grid; grid-template-columns:1fr; gap:5px; margin-bottom:auto; }
                .info-item { display:flex; flex-direction:column; }
                .info-label { font-size:5px; text-transform:uppercase; opacity:0.5; font-weight:700; letter-spacing:0.5px; }
                .info-value { font-size:8px; font-weight:600; color:rgba(255,255,255,0.95); }
                
                .footer { margin-top:10px; background:rgba(0,0,0,0.2); padding:4px 10px; border-radius:6px; border:1px solid rgba(255,255,255,0.05); display:flex; justify-content:center; }
                .id-number { font-family:'Courier New', monospace; font-size:9px; font-weight:800; letter-spacing:1.5px; }
                
                @media print {
                    body { background:white; }
                    .card { box-shadow:none; -webkit-print-color-adjust: exact; }
                }
            </style></head><body>
            <div class="card">
                <div class="left-panel">
                    <div class="logo-box">
                        <img src="${fullLogoSrc}" alt="Logo">
                    </div>
                    <div class="photo-box">
                        <img src="${fullPhotoSrc}" onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2275%22 height=%2295%22><rect fill=%22%23334155%22 width=%2275%22 height=%2295%22 rx=%2210%22/><circle fill=%22%2364748b%22 cx=%2237%22 cy=%2235%22 r=%2215%22/><ellipse fill=%22%2364748b%22 cx=%2237%22 cy=%2280%22 rx=%2225%22 ry=%2215%22/></svg>'">
                    </div>
                </div>
                <div class="right-panel">
                    <div class="header">
                        <div class="org">Pokdar Kamtibmas</div>
                        <div class="org-city">Kota Tangerang Selatan</div>
                    </div>
                    
                    <div class="member-name">${member.full_name || '-'}</div>
                    <div class="type-badge">${isKhusus ? '★ Anggota Khusus' : 'Anggota Biasa'}</div>
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">NIK</span>
                            <span class="info-value">${member.nik || '-'}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Sektor / Kelurahan</span>
                            <span class="info-value">${sectorName} / ${subsectorName}</span>
                        </div>
                        ${member.position ? `
                        <div class="info-item">
                            <span class="info-label">Jabatan</span>
                            <span class="info-value">${member.position}</span>
                        </div>` : ''}
                    </div>
                    
                    <div class="footer">
                        <div class="id-number">${member.no_anggota || member.reg_number}</div>
                    </div>
                </div>
            </div>
            <script>window.onload = function() { setTimeout(() => { window.print(); }, 500); }<\/script>
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
                    await refreshMembers();
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
                    await refreshMembers();
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
                            <td class="text-end" style="width: 1%;">
                                <div class="action-btns">
                                    <button onclick="restoreMember('${row.reg_number}')" class="btn btn-success btn-action-text">Pulihkan</button>
                                    <button onclick="permanentDelete('${row.reg_number}')" class="btn btn-outline-danger btn-action-text">Hapus</button>
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
                    await refreshMembers();
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
            'video_link': 'Link Video atau Iframe YouTube',
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

        // Utility to render fields recursively for the CMS
        function renderRecursive(obj, currentKey, path = []) {
            let fieldsHtml = "";
            let keys = Object.keys(obj).filter(k => !['id', 'class', 'icon'].includes(k));
            
            // Handle lists of people (e.g. advisors, coordinators) as a grouped table
            const childObjects = keys.filter(k => typeof obj[k] === 'object' && obj[k] !== null && !Array.isArray(obj[k]));
            if (childObjects.length > 1) {
                const firstChild = obj[childObjects[0]];
                if (firstChild && typeof firstChild === 'object' && (firstChild.name || firstChild.position)) {
                    fieldsHtml += `
                        <div class="col-12 mb-5 pb-4 border-bottom border-light">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 mb-0 h5">
                                    <div class="bg-accent rounded-pill" style="width:12px; height:6px;"></div>
                                    Daftar ${getLabel(currentKey)}
                                </label>
                            </div>
                            <div class="cms-table-container">
                                <table class="cms-table">
                                    <thead><tr><th>Posisi</th><th>Nama</th><th>Foto</th><th class="text-end px-3">Aksi</th></tr></thead>
                                    <tbody>
                                        ${childObjects.map(k => {
                                            const item = obj[k];
                                            const itemPath = [...path, k].join('.');
                                            return `
                                                <tr>
                                                    <td><div class="fw-bold">${item.position || getLabel(k)}</div></td>
                                                    <td><div class="text-truncate" style="max-width: 250px;">${item.name || ""}</div></td>
                                                    <td><img src="${item.image || 'assets/user.png'}?v=${Date.now()}" class="cms-thumb shadow-sm"></td>
                                                    <td class="text-end px-3">
                                                        <button type="button" class="cms-action-btn edit" onclick="editCmsItem('${window._currentCmsType || 'hero'}', '${itemPath}', null)"><i class="fas fa-edit"></i></button>
                                                    </td>
                                                </tr>
                                            `;
                                        }).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                    keys = keys.filter(k => !childObjects.includes(k));
                }
            }

            for (const key of keys) {
                try {
                    const label = getLabel(key);
                    const val = obj[key];
                    const fullPath = [...path, key];
                    const dataPath = fullPath.join('.');

                    if (Array.isArray(val)) {
                        const isObjectArray = val.length > 0 && typeof val[0] === 'object';
                        fieldsHtml += `
                            <div class="col-12 mb-5 pb-4 border-bottom border-light">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <label class="form-label fw-bold text-dark d-flex align-items-center gap-3 mb-0 h5">
                                        <div class="bg-accent rounded-pill" style="width:12px; height:6px;"></div>
                                        ${label}
                                    </label>
                                    <button class="btn btn-dark btn-sm rounded-pill px-4 fw-bold shadow-sm" type="button" onclick="addItem(event, '${window._currentCmsType || 'hero'}', '${dataPath}')">
                                        <i class="fas fa-plus me-1"></i> Tambah Item
                                    </button>
                                </div>
                                <div class="cms-table-container">
                                    ${isObjectArray ? (() => {
                                        let vKeys = val.length > 0 ? Object.keys(val[0]).filter(k => k !== 'id' && (typeof val[0][k] !== 'object' || val[0][k] === null)) : [];
                                        if (window._currentCmsType === 'hero' || key === 'buttons') vKeys = ['text', 'link'];
                                        return `
                                        <table class="cms-table">
                                            <thead><tr>${vKeys.map(k => `<th>${getLabel(k)}</th>`).join('')}<th class="text-end px-3">Aksi</th></tr></thead>
                                            <tbody>
                                                ${val.map((item, i) => `
                                                    <tr>
                                                        ${vKeys.map(k => {
                                                            if (k === 'image') {
                                                                return `<td>
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <img src="${item[k] || 'assets/user.png'}?v=${Date.now()}" class="cms-thumb shadow-sm" onerror="this.src='assets/user.png'">
                                                                        <label class="btn btn-sm btn-light rounded-pill px-2" title="Ganti foto">
                                                                            <i class="fas fa-upload fa-xs"></i>
                                                                            <input type="file" class="d-none" accept="image/*" onchange="handleCMSImageUpload(this, '${window._currentCmsType || 'structure'}', '${dataPath}', ${i}, false, '${k}')">
                                                                        </label>
                                                                    </div>
                                                                </td>`;
                                                            }
                                                            return `<td><div class="text-truncate" style="max-width:200px;">${item[k] || ''}</div></td>`;
                                                        }).join('')}
                                                        <td class="text-end px-3">
                                                            <div class="d-flex justify-content-end gap-2">
                                                                <button type="button" class="cms-action-btn edit" onclick="editCmsItem('${window._currentCmsType || 'hero'}', '${dataPath}', ${i})"><i class="fas fa-edit"></i></button>
                                                                <button type="button" class="cms-action-btn delete" onclick="removeItem(event, '${window._currentCmsType || 'hero'}', '${dataPath}', ${i})"><i class="fas fa-trash-alt"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                `).join('')}
                                            </tbody>
                                        </table>`;
                                    })() : `
                                    <div class="row g-3">
                                        ${val.map((item, i) => {
                                            const isImgArr = (key === 'images' || key === 'partners');
                                            if (isImgArr) {
                                                return `
                                                <div class="${key === 'partners' ? 'col-md-2 col-sm-3 col-6' : 'col-md-4 col-sm-6'}">
                                                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white position-relative" style="aspect-ratio:16/10;">
                                                        <img src="${(item || '').toString()}?v=${Date.now()}" class="w-100 h-100 ${key === 'partners' ? 'object-fit-contain p-2' : 'object-fit-cover'}" onerror="this.src='assets/image.png'">
                                                        <input type="text" class="d-none" data-path="${dataPath}" data-index="${i}" value="${(item || '').toString().replace(/"/g, '&quot;')}">
                                                        <div class="position-absolute top-0 end-0 m-2 d-flex gap-1">
                                                            <label class="btn btn-sm btn-light rounded-pill px-2 shadow-sm" title="Ganti gambar">
                                                                <i class="fas fa-upload fa-xs"></i>
                                                                <input type="file" class="d-none" accept="image/*" onchange="handleCMSImageUpload(this, '${window._currentCmsType || 'hero'}', '${dataPath}', ${i}, true)">
                                                            </label>
                                                            <button type="button" class="btn btn-sm btn-danger rounded-pill px-2 shadow-sm" title="Hapus" onclick="removeItem(event, '${window._currentCmsType || 'hero'}', '${dataPath}', ${i})"><i class="fas fa-times fa-xs"></i></button>
                                                        </div>
                                                    </div>
                                                </div>`;
                                            }
                                            return `
                                            <div class="col-md-6">
                                                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex align-items-center gap-3">
                                                    <input type="text" class="form-control border-0 bg-light rounded-pill px-3" data-path="${dataPath}" data-index="${i}" value="${(item || '').toString().replace(/"/g, '&quot;')}">
                                                    <button type="button" class="btn btn-link text-danger p-0" onclick="removeItem(event, '${window._currentCmsType || 'hero'}', '${dataPath}', ${i})"><i class="fas fa-times"></i></button>
                                                </div>
                                            </div>`;
                                        }).join('')}
                                    </div>`}
                                </div>
                            </div>
                        `;
                    } else if (typeof val === 'object' && val !== null) {
                        fieldsHtml += `
                            <div class="col-12">
                                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white border-top border-4 border-accent">
                                    <label class="form-label fw-bold text-dark mb-3 text-uppercase small" style="letter-spacing:1px;">${label}</label>
                                    <div class="row g-3">${renderRecursive(val, key, fullPath)}</div>
                                </div>
                            </div>
                        `;
                    } else {
                        const isRich = key === 'welcome_text' || ((key.includes('content') || key.includes('description') || key === 'full' || key.includes('news')) && (window._currentCmsType !== 'hero'));
                        const isLarge = isRich || (val || "").toString().length > 100 || key === 'lead_text' || key === 'title_primary';
                        const colClass = (path.length > 0 || key === 'title_primary' || key === 'lead_text' || key === 'video_link' || key === 'welcome_text') ? "col-12" : "col-md-6";
                        const isImage = key.toLowerCase().includes('image') || (val || "").toString().includes('assets/');

                        fieldsHtml += `
                            <div class="${colClass} mb-2">
                                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                                    <label class="form-label fw-bold text-muted small text-uppercase mb-2" style="letter-spacing:0.5px;">${label}</label>
                                    ${isImage ? `
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-4 overflow-hidden border bg-light shadow-sm" style="width:100px; height:75px;">
                                                <img src="${val}?v=${Date.now()}" class="w-100 h-100 object-fit-cover">
                                            </div>
                                            <div class="flex-grow-1">
                                                <input type="text" class="form-control mb-2 border-0 bg-light rounded-pill px-3 fs-6" data-path="${dataPath}" value="${(val || "").toString()}">
                                                <button type="button" class="btn btn-sm btn-outline-dark rounded-pill px-3" onclick="this.nextElementSibling.click()"><i class="fas fa-upload me-1"></i> Ganti Gambar</button>
                                                <input type="file" class="d-none" accept="image/*" onchange="handleCMSImageUpload(this, '${window._currentCmsType || 'hero'}', '${dataPath}')">
                                            </div>
                                        </div>
                                    ` : (isLarge ? 
                                        `<textarea class="form-control border-0 bg-light rounded-4 p-3 fs-6 ${isRich ? 'summernote' : ''}" data-path="${dataPath}" data-is-rich="${isRich}" rows="3">${val}</textarea>` :
                                        `<input type="text" class="form-control form-control-lg border-0 bg-light rounded-pill px-4 fs-6" data-path="${dataPath}" value="${(val || "").toString().replace(/"/g, '&quot;')}">`
                                    )}
                                </div>
                            </div>
                        `;
                    }
                } catch (e) {
                    console.error("Error rendering key: " + key, e);
                    fieldsHtml += `<div class="col-12 alert alert-danger">Error rendering ${key}</div>`;
                }
            }
            return fieldsHtml;
        }

        async function loadCMS(type) {
            window._currentCmsType = type;
            const container = document.getElementById('cms-editor-container');
            container.innerHTML = `<div class="text-center py-5"><div class="spinner-border text-accent mb-3" role="status"></div><p class="text-muted">Mengambil data ${type}...</p></div>`;

            try {
                const resp = await fetch(`data/${type}.json?v=${Date.now()}`);
                const data = await resp.json();

                // Sync UI (Tabs and Sidebar)
                const activePill = document.querySelector(`#cms-pills-tab [onclick*="loadCMS('${type}')"]`);
                if (activePill) {
                    document.querySelectorAll('#cms-pills-tab .nav-link').forEach(p => p.classList.remove('active'));
                    activePill.classList.add('active');
                    if (document.getElementById('active-cms-pill-label')) document.getElementById('active-cms-pill-label').innerText = activePill.innerText.trim();
                }
                
                // Mobile Menu Sync
                const mobileMenu = document.getElementById('mobile-cms-nav-list');
                if (mobileMenu) {
                    mobileMenu.querySelectorAll('.mobile-nav-item').forEach(item => {
                        if (item.innerText.trim() === activePill?.innerText.trim()) item.classList.add('active');
                        else item.classList.remove('active');
                    });
                }

                // ── Special Case: Statistik Utama ────────────────
                if (type === 'stats') {
                    window._statsData = Array.isArray(data) ? data : [];

                    window._renderStats = function() {
                        const items = window._statsData;
                        container.innerHTML = `
                        <div class="cms-animate-content">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div><h2 class="fw-bold mb-0 text-dark">Statistik Utama</h2><p class="text-muted mb-0 small">Kelola angka statistik yang tampil di website.</p></div>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn text-white rounded-pill px-4" style="background:#8b5cf6;" onclick="window._openStatsModal()"><i class="fas fa-plus me-2"></i>Tambah Statistik</button>
                                </div>
                            </div>
                            <div class="cms-table-container">
                                <table class="table cms-table align-middle border-0" style="min-width: unset;">
                                    <thead>
                                        <tr class="small text-uppercase fw-bold text-muted">
                                            <th class="border-0">Icon</th>
                                            <th class="border-0">Label</th>
                                            <th class="border-0">Angka</th>
                                            <th class="border-0 text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${items.length === 0 ? `<tr><td colspan="4" class="text-center py-5">Belum ada statistik.</td></tr>` :
                                        items.map((item, i) => `
                                        <tr>
                                            <td><i class="${item.icon || 'fas fa-chart-bar'} fa-lg text-primary"></i></td>
                                            <td class="fw-medium">${item.label || '—'}</td>
                                            <td><span class="badge bg-dark rounded-pill px-3 py-1">${item.number || '—'}</span></td>
                                            <td class="text-end">
                                                <div class="d-flex gap-2 justify-content-end">
                                                    <button type="button" class="cms-action-btn edit" onclick="window._openStatsModal(${i})"><i class="fas fa-edit"></i></button>
                                                    <button type="button" class="cms-action-btn delete" onclick="window._deleteStats(${i})"><i class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </td>
                                        </tr>`).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>`;
                    };

                    window._saveStats = async () => {
                        const res = await saveContent('stats', window._statsData);
                        if (res?.status === 'success') showToast('Statistik Utama diperbarui!');
                    };
                    window._deleteStats = async (i) => { 
                        if(confirm('Hapus statistik ini?')) { 
                            window._statsData.splice(i,1); 
                            await window._saveStats(); 
                            window._renderStats(); 
                        } 
                    };
                    window._openStatsModal = (i = -1) => {
                        const m = document.getElementById('statsModal');
                        const isEdit = i >= 0;
                        m.querySelector('#stats-modal-label').innerHTML = isEdit ? '<i class="fas fa-edit me-2"></i>Edit Statistik' : '<i class="fas fa-chart-bar me-2"></i>Tambah Statistik';
                        m.querySelector('#stats-edit-index').value = i;
                        const item = isEdit ? window._statsData[i] : {icon: 'fas fa-star', number: '', label: ''};
                        m.querySelector('#stats-f-icon').value = item.icon || 'fas fa-star';
                        m.querySelector('#stats-f-number').value = item.number || '';
                        m.querySelector('#stats-f-label').value = item.label || '';
                        // Preview icon
                        m.querySelector('#stats-icon-preview').className = (item.icon || 'fas fa-star') + ' fa-2x text-primary';
                        bootstrap.Modal.getOrCreateInstance(m).show();
                    };
                    window._submitStatsForm = () => {
                        const m = document.getElementById('statsModal');
                        const idx = parseInt(m.querySelector('#stats-edit-index').value);
                        const item = {
                            icon: m.querySelector('#stats-f-icon').value || 'fas fa-star',
                            number: m.querySelector('#stats-f-number').value,
                            label: m.querySelector('#stats-f-label').value
                        };
                        if (!item.label.trim()) { alert('Label tidak boleh kosong'); return; }
                        if (idx >= 0) window._statsData[idx] = item; else window._statsData.push(item);
                        bootstrap.Modal.getInstance(m).hide();
                        window._saveStats();
                        window._renderStats();
                    };

                    window._renderStats();
                    return;
                }

                // ── Special Case: Berita & Artikel ───────────────
                if (type === 'news') {
                    window._newsData = Array.isArray(data) ? data : [];

                    window._renderNews = function() {
                        const items = window._newsData;
                        container.innerHTML = `
                        <div class="cms-animate-content">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div><h2 class="fw-bold mb-0 text-dark">Berita &amp; Artikel</h2><p class="text-muted mb-0 small">Kelola daftar berita dan artikel.</p></div>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn text-white rounded-pill px-4" style="background:#10b981;" onclick="window._openNewsModal()"><i class="fas fa-plus me-2"></i>Tambah Berita</button>
                                </div>
                            </div>
                            <div class="cms-table-container">
                                <table class="table cms-table align-middle border-0">
                                    <thead>
                                        <tr class="small text-uppercase fw-bold text-muted">
                                            <th class="border-0">Judul</th>
                                            <th class="border-0 d-none d-md-table-cell">Tag</th>
                                            <th class="border-0 text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${items.length === 0 ? `<tr><td colspan="3" class="text-center py-5">Belum ada berita.</td></tr>` :
                                        items.map((item, i) => `
                                        <tr>
                                            <td class="fw-medium">${item.title || '—'}</td>
                                            <td class="d-none d-md-table-cell"><span class="badge bg-light text-dark rounded-pill px-3 py-1">${item.tag || '—'}</span></td>
                                            <td class="text-end">
                                                <div class="d-flex gap-2 justify-content-end">
                                                    <button type="button" class="cms-action-btn edit" onclick="window._openNewsModal(${i})"><i class="fas fa-edit"></i></button>
                                                    <button type="button" class="cms-action-btn delete" onclick="window._deleteNews(${i})"><i class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </td>
                                        </tr>`).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>`;
                    };

                    window._saveNews = async () => {
                        const res = await saveContent('news', window._newsData);
                        if (res?.status === 'success') showToast('Berita & Artikel diperbarui!');
                    };
                    window._deleteNews = async (i) => { 
                        if(confirm('Hapus berita ini?')) { 
                            window._newsData.splice(i,1); 
                            await window._saveNews();
                            window._renderNews(); 
                        } 
                    };
                    window._openNewsModal = (i = -1) => {
                        const m = document.getElementById('newsModal');
                        const isEdit = i >= 0;
                        m.querySelector('#news-modal-title-label').innerHTML = isEdit ? '<i class="fas fa-edit me-2"></i>Edit Berita' : '<i class="fas fa-newspaper me-2"></i>Tambah Berita';
                        m.querySelector('#news-edit-index').value = i;
                        const item = isEdit ? window._newsData[i] : {tag:'', title:'', description:'', image:'', link:'#'};
                        m.querySelector('#news-f-tag').value = item.tag || '';
                        m.querySelector('#news-f-title').value = item.title || '';
                        m.querySelector('#news-f-image').value = item.image || '';
                        m.querySelector('#news-f-link').value = item.link || '#';
                        $('#news-f-description').summernote('code', item.description || '');
                        bootstrap.Modal.getOrCreateInstance(m).show();
                    };
                    window._submitNewsForm = () => {
                        const m = document.getElementById('newsModal');
                        const idx = parseInt(m.querySelector('#news-edit-index').value);
                        const item = {
                            id: idx >= 0 ? (window._newsData[idx].id || idx+1) : (window._newsData.length + 1),
                            tag: m.querySelector('#news-f-tag').value,
                            title: m.querySelector('#news-f-title').value,
                            description: $('#news-f-description').summernote('code'),
                            image: m.querySelector('#news-f-image').value,
                            link: m.querySelector('#news-f-link').value || '#'
                        };
                        if (!item.title.trim()) { alert('Judul tidak boleh kosong'); return; }
                        if (idx >= 0) window._newsData[idx] = item; else window._newsData.push(item);
                        bootstrap.Modal.getInstance(m).hide();
                        window._saveNews();
                        window._renderNews();
                    };

                    // Initialize Summernote in Modal if not already
                    if (!$('#news-f-description').data('summernote')) {
                        $('#news-f-description').summernote({
                            placeholder: 'Ketik deskripsi berita...', tabsize: 2, height: 180,
                            toolbar: [['style', ['bold', 'italic', 'underline', 'clear']], ['para', ['ul', 'ol', 'paragraph']], ['view', ['codeview']]]
                        });
                    }

                    window._renderNews();
                    return;
                }

                // ── Special Case: Jadwal Agenda ───────────────────
                if (type === 'jadwal_kegiatan') {
                    window._jadwalData = Array.isArray(data) ? data : [];
                    
                    // Initialize Modal if not exists
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
                                                <div class="col-12 col-sm-6"><label class="form-label fw-semibold small">Hari / Tanggal</label><input type="text" id="jadwal-f-haritgl" class="form-control rounded-3" placeholder="cth: Sabtu, 15 Maret 2026"></div>
                                                <div class="col-12 col-sm-6"><label class="form-label fw-semibold small">Jam</label><input type="text" id="jadwal-f-jam" class="form-control rounded-3" placeholder="cth: 08:00 WIB"></div>
                                                <div class="col-12"><label class="form-label fw-semibold small">Kegiatan</label><input type="text" id="jadwal-f-keterangan" class="form-control rounded-3" placeholder="Nama kegiatan..."></div>
                                                <div class="col-12 col-sm-6"><label class="form-label fw-semibold small">Tempat</label><input type="text" id="jadwal-f-tempat" class="form-control rounded-3" placeholder="Lokasi"></div>
                                                <div class="col-12 col-sm-6"><label class="form-label fw-semibold small">CP</label><input type="text" id="jadwal-f-cp" class="form-control rounded-3" placeholder="Kontak"></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 px-4 pb-4 pt-2 gap-2">
                                            <button type="button" class="btn btn-outline-secondary rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="button" class="btn fw-bold rounded-3 text-white px-4" style="background:linear-gradient(135deg,#0d9488,#0f766e);" onclick="window._submitJadwalForm()">
                                                <i class="fas fa-check me-2"></i>Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        document.body.appendChild(mDiv.firstElementChild);
                    }

                    window._renderJadwal = function() {
                        const events = window._jadwalData;
                        container.innerHTML = `
                        <div class="cms-animate-content">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div><h2 class="fw-bold mb-0 text-dark">Jadwal Agenda</h2><p class="text-muted mb-0 small">Kelola daftar agenda kegiatan.</p></div>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn text-white rounded-pill px-4" style="background:#0d9488;" onclick="window._openJadwalModal()"><i class="fas fa-plus me-2"></i>Tambah</button>
                                </div>
                            </div>
                            <div class="row g-3">
                                ${events.length === 0 ? `<div class="col-12 text-center py-5">Belum ada agenda.</div>` :
                                events.map((ev, i) => `
                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge bg-light text-dark rounded-pill">${ev.hari_tgl || '—'}</span>
                                            <div class="d-flex gap-1">
                                                <button class="btn btn-sm btn-light" onclick="window._editJadwal(${i})"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-sm btn-light text-danger" onclick="window._deleteJadwal(${i})"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </div>
                                        <h6 class="fw-bold mb-2">${ev.keterangan || '—'}</h6>
                                        <div class="small text-muted"><i class="far fa-clock me-1"></i>${ev.jam || '—'}</div>
                                    </div>
                                </div>`).join('')}
                            </div>
                        </div>`;
                    };

                    window._saveJadwal = async () => {
                        const res = await saveContent('jadwal_kegiatan', window._jadwalData);
                        if (res?.status === 'success') showToast('Jadwal Agenda diperbarui!');
                    };
                    window._deleteJadwal = async (i) => { 
                        if(confirm('Hapus?')) { 
                            window._jadwalData.splice(i,1); 
                            await window._saveJadwal();
                            window._renderJadwal(); 
                        } 
                    };
                    window._openJadwalModal = () => {
                        const m = document.getElementById('jadwalAgendaModal');
                        m.querySelector('#jadwal-edit-index').value = -1;
                        ['haritgl','jam','keterangan','tempat','cp'].forEach(k => m.querySelector('#jadwal-f-'+k).value = '');
                        bootstrap.Modal.getOrCreateInstance(m).show();
                    };
                    window._submitJadwalForm = () => {
                        const m = document.getElementById('jadwalAgendaModal');
                        const idx = parseInt(m.querySelector('#jadwal-edit-index').value);
                        const data = {
                            hari_tgl: m.querySelector('#jadwal-f-haritgl').value,
                            jam: m.querySelector('#jadwal-f-jam').value,
                            keterangan: m.querySelector('#jadwal-f-keterangan').value,
                            tempat: m.querySelector('#jadwal-f-tempat').value,
                            cp: m.querySelector('#jadwal-f-cp').value
                        };
                        if (idx >= 0) window._jadwalData[idx] = data; else window._jadwalData.push(data);
                        bootstrap.Modal.getInstance(m).hide();
                        window._saveJadwal();
                        window._renderJadwal();
                    };
                    window._editJadwal = (i) => {
                        const m = document.getElementById('jadwalAgendaModal');
                        const ev = window._jadwalData[i];
                        m.querySelector('#jadwal-edit-index').value = i;
                        m.querySelector('#jadwal-f-haritgl').value = ev.hari_tgl || '';
                        m.querySelector('#jadwal-f-jam').value = ev.jam || '';
                        m.querySelector('#jadwal-f-keterangan').value = ev.keterangan || '';
                        m.querySelector('#jadwal-f-tempat').value = ev.tempat || '';
                        m.querySelector('#jadwal-f-cp').value = ev.cp || '';
                        bootstrap.Modal.getOrCreateInstance(m).show();
                    };

                    window._renderJadwal();
                    return;
                }

                // ── Special Case: Tanya Jawab (FAQ) ──────────────────
                if (type === 'faq') {
                    window._faqData = Array.isArray(data) ? data : [];
                    
                    window._renderFAQ = function() {
                        const faqs = window._faqData;
                        container.innerHTML = `
                        <div class="cms-animate-content">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div><h2 class="fw-bold mb-0 text-dark">Tanya Jawab (FAQ)</h2><p class="text-muted mb-0 small">Kelola daftar pertanyaan dan jawaban.</p></div>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn text-white rounded-pill px-4" style="background:#3b82f6;" onclick="window._openFAQModal()"><i class="fas fa-plus me-2"></i>Tambah FAQ</button>
                                </div>
                            </div>
                            <div class="cms-table-container">
                                <table class="table cms-table align-middle border-0" style="min-width: unset;">
                                    <thead>
                                        <tr class="small text-uppercase fw-bold text-muted">
                                            <th class="border-0">Pertanyaan</th>
                                            <th class="border-0 text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${faqs.length === 0 ? `<tr><td colspan="2" class="text-center py-5">Belum ada FAQ.</td></tr>` :
                                        faqs.map((faq, i) => `
                                        <tr>
                                            <td class="fw-medium">${faq.question || '—'}</td>
                                            <td class="text-end">
                                                <div class="d-flex gap-2 justify-content-end">
                                                    <button type="button" class="cms-action-btn edit" onclick="window._openFAQModal(${i})"><i class="fas fa-edit"></i></button>
                                                    <button type="button" class="cms-action-btn delete" onclick="window._deleteFAQ(${i})"><i class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </td>
                                        </tr>`).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>`;
                    };

                    window._saveFAQ = async () => {
                        const res = await saveContent('faq', window._faqData);
                        if (res?.status === 'success') showToast('FAQ diperbarui!');
                    };
                    window._deleteFAQ = async (i) => { 
                        if(confirm('Hapus FAQ ini?')) { 
                            window._faqData.splice(i,1); 
                            await window._saveFAQ();
                            window._renderFAQ(); 
                        } 
                    };
                    window._openFAQModal = (i = -1) => {
                        const m = document.getElementById('faqModal');
                        const isEdit = i >= 0;
                        m.querySelector('#faqModalLabel').innerHTML = isEdit ? '<i class="fas fa-edit me-2"></i>Edit FAQ' : '<i class="fas fa-question-circle me-2"></i>Tambah FAQ';
                        m.querySelector('#faq-edit-index').value = i;
                        
                        const faq = isEdit ? window._faqData[i] : {question: '', answer: ''};
                        m.querySelector('#faq-f-question').value = faq.question;
                        
                        // Set Summernote content
                        $('#faq-f-answer').summernote('code', faq.answer);
                        
                        bootstrap.Modal.getOrCreateInstance(m).show();
                    };
                    window._submitFAQForm = () => {
                        const m = document.getElementById('faqModal');
                        const idx = parseInt(m.querySelector('#faq-edit-index').value);
                        const data = {
                            question: m.querySelector('#faq-f-question').value,
                            answer: $('#faq-f-answer').summernote('code')
                        };
                        
                        if (!data.question.trim()) { alert('Pertanyaan tidak boleh kosong'); return; }
                        
                        if (idx >= 0) window._faqData[idx] = data; else window._faqData.push(data);
                        bootstrap.Modal.getInstance(m).hide();
                        window._saveFAQ();
                        window._renderFAQ();
                    };

                    // Initialize Summernote in Modal if not already
                    if (!$('#faq-f-answer').data('summernote')) {
                        $('#faq-f-answer').summernote({
                            placeholder: 'Ketik jawaban di sini...', tabsize: 2, height: 200,
                            toolbar: [['style', ['bold', 'italic', 'underline', 'clear']], ['para', ['ul', 'ol', 'paragraph']], ['view', ['codeview']]]
                        });
                    }

                    window._renderFAQ();
                    return;
                }

                // ── Default CMS Case ──────────────────────────────
                let html = `
                    <div class="cms-animate-content">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-4 mb-4 cms-header-spacer">
                            <div class="pe-sm-5 text-center text-sm-start w-100">
                                <h2 class="fw-bold mb-0 text-dark cms-section-title" style="letter-spacing:-0.02em;">Manajemen ${getLabel(type)}</h2>
                                <p class="text-muted mb-0 cms-section-subtitle">Data disimpan secara otomatis saat Anda melakukan perubahan.</p>
                            </div>
                        </div>
                        <form id="cms-form-${type}" class="cms-premium-form">
                            <div class="row g-4 px-2">
                                ${renderRecursive(data, type)}
                            </div>
                        </form>
                    </div>
                `;

                container.innerHTML = html;

                // Init Summernote
                $(`#cms-form-${type} .summernote`).summernote({
                    placeholder: 'Ketik konten di sini...', tabsize: 2, height: 150,
                    toolbar: [['style', ['bold', 'italic', 'underline', 'clear']], ['para', ['ul', 'ol', 'paragraph']], ['view', ['codeview']]],
                    callbacks: { 
                        onChange: function(contents) { 
                            $(this).val(contents);
                            clearTimeout(window._cmsAutoSaveTimer);
                            window._cmsAutoSaveTimer = setTimeout(() => saveCMS(type, true), 1000);
                        } 
                    }
                });

                // Auto-save on input or change
                const form = document.getElementById(`cms-form-${type}`);
                form.addEventListener('input', (e) => {
                    if (e.target.classList.contains('summernote')) return; 
                    clearTimeout(window._cmsAutoSaveTimer);
                    window._cmsAutoSaveTimer = setTimeout(() => saveCMS(type, true), 800);
                });
                form.addEventListener('change', () => {
                    clearTimeout(window._cmsAutoSaveTimer);
                    saveCMS(type, true);
                });

            } catch (err) {
                container.innerHTML = `<div class="alert alert-danger px-4 py-3 rounded-4">❌ Gagal memuat data: ${err.message}</div>`;
                console.error(err);
            }
        }

        async function saveCMS(type, isAuto = false) {
            const form = document.getElementById(`cms-form-${type}`);
            if (!form) return;
            const saveBtn = form.closest('.tab-pane')?.querySelector('button[onclick^="saveCMS"]');
            
            let originalBtnHtml = "";
            if (saveBtn) {
                originalBtnHtml = saveBtn.innerHTML;
                saveBtn.disabled = true;
                saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
            }
            
            if (isAuto) {
                const toast = document.createElement('div');
                toast.className = 'position-fixed bottom-0 end-0 p-3';
                toast.style.zIndex = '1060';
                toast.innerHTML = `<div class="bg-dark text-white rounded-pill px-3 py-1 small shadow-lg animate-up"><i class="fas fa-sync-alt fa-spin me-2"></i>Auto-saving...</div>`;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 1000);
            }

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

        async function handleCMSImageUpload(input, type, path, index = null, reRender = false, subKey = null) {
            if (!input.files || !input.files[0]) return;

            const file = input.files[0];
            const formData = new FormData();
            formData.append('type', type);
            formData.append('action', 'upload');
            formData.append('file', file);

            // The trigger element may be a <label> or a <button>
            const triggerEl = input.closest('label') || input.previousElementSibling;
            if (triggerEl) {
                triggerEl.style.opacity = '0.5';
                triggerEl.style.pointerEvents = 'none';
            }

            try {
                const resp = await fetch('update_content.php', { method: 'POST', body: formData });
                const result = await resp.json();
                
                if (result.status === 'success') {
                    if (subKey) {
                        // Object array item: update the img in the table row directly, then save
                        const row = input.closest('tr');
                        const img = row ? row.querySelector('img.cms-thumb') : null;
                        if (img) img.src = result.path + '?v=' + Date.now();
                        // Push new path into the in-memory data and save
                        const cmsResp = await fetch(`data/${type}.json?v=${Date.now()}`);
                        const cmsData = await cmsResp.json();
                        const keys = path ? path.split('.').filter(k => k) : [];
                        let target = cmsData;
                        for (const k of keys) target = target[k];
                        if (Array.isArray(target) && target[index]) target[index][subKey] = result.path;
                        await saveContent(type, cmsData);
                        showToast('Foto diperbarui!');
                    } else if (reRender) {
                        // For image array cards: find hidden input within the same card
                        const card = input.closest('.card, .col-md-4, .col-sm-6');
                        const hiddenInput = card ? card.querySelector(`input[data-path="${path}"][data-index="${index}"]`) : null;
                        if (hiddenInput) {
                            hiddenInput.value = result.path;
                            // Update the visible image
                            const img = card.querySelector('img');
                            if (img) img.src = result.path + '?v=' + Date.now();
                        }
                    } else {
                        // Legacy: find input in the CMS form
                        const container = input.closest('.cms-premium-form');
                        let targetInput;
                        if (index !== null) {
                            targetInput = container.querySelector(`input[data-path="${path}"][data-index="${index}"]`);
                        } else {
                            targetInput = container.querySelector(`input[data-path="${path}"]`);
                        }
                        if (targetInput) {
                            targetInput.value = result.path;
                            await saveCMS(type);
                        }
                    }
                } else {
                    showToast(result.message, 'error', 'Gagal Upload');
                }
            } catch (err) {
                showToast(err.message, 'error', 'Kesalahan Upload');
            } finally {
                if (triggerEl) {
                    triggerEl.style.opacity = '';
                    triggerEl.style.pointerEvents = '';
                }
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
                            if (typeof refreshMembers === 'function') await refreshMembers();
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

        // Auto-load Hero Section on first open and Populate Mobile CMS Menu
        window.addEventListener('DOMContentLoaded', () => {
            if (window.USER_ROLE === 'admin') {
                loadCMS('hero');

                // Populate Mobile CMS Menu from Desktop Pills
                const cmsPills = document.querySelectorAll('#cms-pills-tab .nav-link');
                const mobileCmsNav = document.getElementById('mobile-cms-nav-list');
                if (cmsPills.length > 0 && mobileCmsNav) {
                    mobileCmsNav.innerHTML = '';
                    cmsPills.forEach(pill => {
                        const link = document.createElement('a');
                        link.href = '#';
                        link.className = 'mobile-nav-item' + (pill.classList.contains('active') ? ' active' : '');
                        
                        const icon = pill.querySelector('i')?.cloneNode(true);
                        const text = document.createTextNode(' ' + pill.innerText.trim());
                        
                        if (icon) link.appendChild(icon);
                        link.appendChild(text);
                        
                        link.onclick = (e) => {
                            e.preventDefault();
                            pill.click();
                            const offcanvasEl = document.getElementById('offcanvasCmsMenu');
                            if (offcanvasEl) {
                                const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
                                if (offcanvas) offcanvas.hide();
                            }
                        };
                        mobileCmsNav.appendChild(link);
                    });
                }
            } else {
                // For Kasektor, hide specific admin tabs but ALLOW content management
                const adminOnlyTabs = ['kasektor-tab', 'trash-tab'];
                adminOnlyTabs.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.parentElement.style.display = 'none';
                });

                // Update CMS tab click for Kasektor to default to 'news'
                const cmsTab = document.getElementById('cms-tab');
                if (cmsTab) {
                    cmsTab.setAttribute('onclick', "loadCMS('news')");
                }

                // Filter CMS pills for Kasektor
                const cmsPills = document.querySelectorAll('#cms-pills-tab .nav-link');
                cmsPills.forEach(pill => {
                    const text = pill.innerText.toLowerCase();
                    const allowed = ['berita', 'galeri', 'jadwal'];
                    const isAllowed = allowed.some(a => text.includes(a));
                    if (!isAllowed) {
                        pill.style.display = 'none';
                    }
                });

                // Hide mobile counterparts
                const mobileNavs = document.querySelectorAll('.mobile-nav-item, .mobile-bottom-item');
                mobileNavs.forEach(nav => {
                    const text = nav.innerText.toLowerCase();
                    // ALLOW 'konten' for Kasektor
                    if (text.includes('kasektor') || text.includes('arsip') || text.includes('keluar')) {
                        if (!text.includes('keluar sistem')) { // Keep logout
                             nav.style.display = 'none';
                        }
                    }
                });

                // Show database anggota by default
                const pendaftaranTab = document.getElementById('pendaftaran-tab');
                if (pendaftaranTab) {
                    bootstrap.Tab.getOrCreateInstance(pendaftaranTab).show();
                    loadMembers('biasa');
                }
            }
        });

        // ── Kasektor Management ──────────────────────────────
        let allKasektor = [];

        async function loadKasektor() {
            const tbody = document.getElementById('kasektor-table-body');
            tbody.innerHTML = `<tr><td colspan="4" class="text-center py-5"><div class="spinner-border text-accent" role="status"></div></td></tr>`;
            
            try {
                const formData = new FormData();
                formData.append('action', 'load');
                const resp = await fetch('manage_kasektor.php', { method: 'POST', body: formData });
                const result = await resp.json();
                
                if (result.status === 'success') {
                    allKasektor = result.data;
                    renderKasektor();
                    populateKasektorSectorDropdown();
                } else {
                    showToast(result.message, 'error');
                }
            } catch (err) {
                showToast('Gagal memuat data kasektor', 'error');
            }
        }

        function renderKasektor() {
            const tbody = document.getElementById('kasektor-table-body');
            if (allKasektor.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center py-5 text-muted">Belum ada data kasektor.</td></tr>`;
                return;
            }

            tbody.innerHTML = allKasektor.map((k, i) => {
                const pObj = polsekData.find(p => p.id === k.sector || p.kode === k.sector);
                const sectorName = pObj ? pObj.nama : '—';
                const assessment = k.assessment || {};
                const total = assessment.total || 0;
                
                let ratingHtml = '<span class="text-muted small">Belum dinilai</span>';
                if (total > 0) {
                    let badgeClass = 'bg-secondary';
                    if (total <= 5) badgeClass = 'bg-danger';
                    else if (total <= 10) badgeClass = 'bg-warning text-dark';
                    else if (total <= 13) badgeClass = 'bg-info text-white';
                    else badgeClass = 'bg-success';
                    ratingHtml = `<span class="badge ${badgeClass}">${total}/15</span>`;
                }

                return `
                    <tr>
                        <td>
                            <div class="fw-bold fs-7" style="line-height:1.2;">${k.full_name || k.name}</div>
                            <div class="d-flex align-items-center gap-2 mt-1" style="font-size: 10px;">
                                <span class="badge bg-light text-dark border"><i class="fas fa-user me-1"></i>${k.name}</span>
                                <span class="badge bg-light text-dark border"><i class="fas fa-key me-1"></i>${k.password}</span>
                            </div>
                        </td>
                        <td class="small">${sectorName}</td>
                        <td class="text-center">${ratingHtml}</td>
                        <td class="text-end" style="width: 1%;">
                            <div class="action-btns">
                                <button class="btn btn-info btn-action-text text-white" onclick="openPenilaianKasektorModal(${i})">NILAI</button>
                                <button class="btn btn-dark btn-action-text" onclick="openKasektorModal(${i})">EDIT</button>
                                <button class="btn btn-outline-danger btn-action-text" onclick="deleteKasektor(${i})">HAPUS</button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function populateKasektorSectorDropdown() {
            const select = document.getElementById('kasektor-sector');
            if (!select) return;
            select.innerHTML = '<option value="">Pilih Sektor</option>';
            polsekData.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.id;
                opt.textContent = p.nama.toUpperCase();
                select.appendChild(opt);
            });
        }

        function populateKasektorMemberDropdown(currentName = '', filterSector = '') {
            const select = document.getElementById('kasektor-name');
            if (!select) return;
            
            select.innerHTML = '<option value="">Pilih Anggota Penuh...</option>';
            
            // Filter members who are "Khusus" (Anggota Penuh) and Approved
            let fullMembers = allMembersData.filter(m => 
                (m.rekomendasi_status === 'Approved')
            );

            // Additional sector filter if provided
            if (filterSector) {
                fullMembers = fullMembers.filter(m => {
                    const mSector = String(m.sector || "").padStart(2, '0');
                    return m.sector === filterSector || mSector === filterSector || filterSector.startsWith(mSector + "-") || filterSector === mSector;
                });
            }

            // Sort by name
            fullMembers.sort((a, b) => a.full_name.localeCompare(b.full_name));

            const addedNames = new Set();
            
            // Add current name if it's not in the list (for legacy support or if member was deleted)
            if (currentName && !fullMembers.some(m => m.full_name === currentName)) {
                const opt = document.createElement('option');
                opt.value = currentName;
                opt.textContent = currentName + ' (Anggota Tidak Ditemukan/Lama)';
                select.appendChild(opt);
                addedNames.add(currentName);
            }

            fullMembers.forEach(m => {
                const opt = document.createElement('option');
                opt.value = m.full_name;
                opt.textContent = m.full_name;
                select.appendChild(opt);
                addedNames.add(m.full_name);
            });
        }

        function openKasektorModal(index = -1) {
            const m = document.getElementById('kasektorModal');
            document.getElementById('kasektor-index').value = index;
            
            if (index >= 0) {
                const k = allKasektor[index];
                document.getElementById('kasektorModalTitle').textContent = 'Edit Kasektor';
                document.getElementById('kasektor-sector').value = k.sector;
                populateKasektorMemberDropdown(k.full_name || k.name, k.sector);
                document.getElementById('kasektor-name').value = k.full_name || k.name;
                document.getElementById('kasektor-username').value = k.name;
                document.getElementById('kasektor-password').value = k.password;
            } else {
                document.getElementById('kasektorModalTitle').textContent = 'Tambah Kasektor';
                document.getElementById('kasektorForm').reset();
                populateKasektorMemberDropdown();
            }
            
            bootstrap.Modal.getOrCreateInstance(m).show();
        }

        async function saveKasektor() {
            const index = document.getElementById('kasektor-index').value;
            const name = document.getElementById('kasektor-name').value;
            const username = document.getElementById('kasektor-username').value;
            const password = document.getElementById('kasektor-password').value;
            const sector = document.getElementById('kasektor-sector').value;

            if (!name || !username || !password || !sector) {
                showToast('Lengkapi semua data!', 'warning');
                return;
            }

            const formData = new FormData();
            formData.append('action', 'save');
            formData.append('index', index);
            formData.append('name', name);
            formData.append('username', username);
            formData.append('password', password);
            formData.append('sector', sector);

            try {
                const resp = await fetch('manage_kasektor.php', { method: 'POST', body: formData });
                const result = await resp.json();
                if (result.status === 'success') {
                    showToast('Data kasektor berhasil disimpan', 'success');
                    bootstrap.Modal.getInstance(document.getElementById('kasektorModal')).hide();
                    loadKasektor();
                } else {
                    showToast(result.message, 'error');
                }
            } catch (err) { showToast('Gagal menyimpan data', 'error'); }
        }

        async function deleteKasektor(index) {
            if (!confirm('Hapus data kasektor ini?')) return;
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('index', index);
            try {
                const resp = await fetch('manage_kasektor.php', { method: 'POST', body: formData });
                const result = await resp.json();
                if (result.status === 'success') {
                    showToast('Data kasektor berhasil dihapus', 'success');
                    loadKasektor();
                }
            } catch (err) { showToast('Gagal menghapus data', 'error'); }
        }

        function openPenilaianKasektorModal(index) {
            const k = allKasektor[index];
            const m = document.getElementById('penilaianKasektorModal');
            document.getElementById('pen-kas-index').value = index;
            document.getElementById('pen-kas-name').textContent = k.full_name || k.name;
            
            const pObj = polsekData.find(p => p.id === k.sector || p.kode === k.sector);
            document.getElementById('pen-kas-sector').textContent = pObj ? pObj.nama : '—';

            // Reset ratings
            document.querySelectorAll('.pen-kas-btn').forEach(btn => {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-secondary');
            });

            const assessment = k.assessment || {};
            ['kepemimpinan', 'koordinasi', 'laporan'].forEach(group => {
                const val = assessment[group];
                if (val) {
                    const btn = m.querySelector(`[data-group="${group}"] [data-val="${val}"]`);
                    if (btn) btn.click();
                }
            });

            document.getElementById('pen-kas-komentar').value = assessment.komentar || '';
            updatePenilaianKasektorTotal();
            bootstrap.Modal.getOrCreateInstance(m).show();
        }

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('pen-kas-btn')) {
                const group = e.target.parentElement.dataset.group;
                e.target.parentElement.querySelectorAll('.pen-kas-btn').forEach(b => {
                    b.classList.remove('btn-primary');
                    b.classList.add('btn-outline-secondary');
                });
                e.target.classList.remove('btn-outline-secondary');
                e.target.classList.add('btn-primary');
                updatePenilaianKasektorTotal();
            }
        });

        function updatePenilaianKasektorTotal() {
            const m = document.getElementById('penilaianKasektorModal');
            let total = 0;
            const groups = ['kepemimpinan', 'koordinasi', 'laporan'];
            groups.forEach(group => {
                const active = m.querySelector(`[data-group="${group}"] .btn-primary`);
                if (active) total += parseInt(active.dataset.val);
            });

            document.getElementById('pen-kas-total').textContent = total;
            const lbl = document.getElementById('pen-kas-label');
            lbl.className = 'badge';
            if (total === 0) { lbl.textContent = 'Belum dinilai'; lbl.classList.add('bg-secondary'); }
            else if (total <= 5) { lbl.textContent = 'Perlu Pembinaan'; lbl.classList.add('bg-danger'); }
            else if (total <= 10) { lbl.textContent = 'Cukup Baik'; lbl.classList.add('bg-warning', 'text-dark'); }
            else if (total <= 13) { lbl.textContent = 'Baik'; lbl.classList.add('bg-info', 'text-white'); }
            else { lbl.textContent = 'Sangat Baik'; lbl.classList.add('bg-success'); }
        }

        async function savePenilaianKasektor() {
            const index = document.getElementById('pen-kas-index').value;
            const m = document.getElementById('penilaianKasektorModal');
            const getVal = (group) => {
                const active = m.querySelector(`[data-group="${group}"] .btn-primary`);
                return active ? parseInt(active.dataset.val) : 0;
            };

            const assessment = {
                kepemimpinan: getVal('kepemimpinan'),
                koordinasi: getVal('koordinasi'),
                laporan: getVal('laporan'),
                total: parseInt(document.getElementById('pen-kas-total').textContent),
                komentar: document.getElementById('pen-kas-komentar').value,
                updated_at: new Date().toISOString()
            };

            const formData = new FormData();
            formData.append('action', 'update_assessment');
            formData.append('index', index);
            formData.append('assessment', JSON.stringify(assessment));

            try {
                const resp = await fetch('manage_kasektor.php', { method: 'POST', body: formData });
                const result = await resp.json();
                if (result.status === 'success') {
                    showToast('Penilaian kasektor berhasil disimpan', 'success');
                    bootstrap.Modal.getInstance(m).hide();
                    loadKasektor();
                }
            } catch (err) { showToast('Gagal menyimpan penilaian', 'error'); }
        }

        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }
    </script>
        </main>

    <!-- Rekomendasi Anggota Khusus Modal -->
    <div class="modal fade" id="rekomendasiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="modal-header border-0 text-white px-4 pt-4 pb-3" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="rek-modal-title"><i class="fas fa-star me-2"></i>Ajuan Anggota Penuh</h5>
                            <small class="opacity-75">Jadikan anggota sebagai Anggota Penuh</small>
                        </div>
                        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
                    </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="rek-reg-number">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small text-uppercase">Nama Anggota</label>
                        <div id="rek-member-name" class="fw-bold fs-5 text-dark"></div>
                    </div>
                    <div class="alert alert-warning border-0 rounded-3 small">
                        <i class="fas fa-info-circle me-2"></i>
                        <p class="text-muted small mb-4">
                            Anggota yang diajukan akan mendapatkan status <strong>Anggota Penuh</strong> dan akan ditandai dengan ikon bintang di daftar anggota.
                        </p>
                        <label for="rek-alasan" class="form-label fw-semibold">Alasan Ajuan <span class="text-danger">*</span></label>
                        <textarea id="rek-alasan" class="form-control border-0 bg-light rounded-3" rows="4" placeholder="Tuliskan alasan mengapa anggota ini layak mendapatkan status Anggota Penuh..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 pb-4 pt-3 gap-2">
                    <button type="button" class="btn btn-light rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger rounded-3 px-4 d-none" id="btn-rek-reject" onclick="processRekomendasi('Rejected')">
                        <i class="fas fa-times me-2"></i>TOLAK
                    </button>
                    <button type="button" class="btn btn-success rounded-3 px-4 d-none" id="btn-rek-approve" onclick="processRekomendasi('Approved')">
                        <i class="fas fa-check me-2"></i>TERIMA
                    </button>
                    <button type="button" class="btn btn-warning rounded-3 px-5 fw-bold" onclick="saveRekomendasi()">
                        <i class="fas fa-star me-2"></i>SIMPAN AJUAN
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
                                <select name="sector" id="a-sector" class="form-select bg-light border-0 rounded-3 fs-6 px-3 py-2" onchange="updateKelurahanDropdownAdd(this.value)" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="small fw-bold text-muted mb-1 text-uppercase">KELURAHAN</label>
                                <select name="subsector" id="a-subsector" class="form-select bg-light border-0 rounded-3 fs-6 px-3 py-2" onchange="updateMemberIdAdd()" required>
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
                <a href="#" class="mobile-nav-item" onclick="switchAdminTab('pendaftaran-tab', 'Database Anggota', 'user-shield', this)">
                    <i class="fas fa-user-shield"></i> Anggota Biasa
                </a>
                <a href="#" class="mobile-nav-item" onclick="switchAdminTab('pendaftaran-khusus-tab', 'Anggota Penuh', 'star', this)">
                    <i class="fas fa-star"></i> Anggota Penuh
                </a>
                <a href="#" class="mobile-nav-item" onclick="switchAdminTab('kasektor-tab', 'Kasektor', 'user-shield', this); loadKasektor()">
                    <i class="fas fa-user-shield"></i> Kasektor
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

    <!-- Kasektor Management Modal -->
    <div class="modal fade" id="kasektorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 bg-dark text-white p-4">
                    <div>
                        <h5 class="fw-bold mb-0" id="kasektorModalTitle">Tambah Kasektor</h5>
                        <small class="opacity-75">Kelola data ketua sektor</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="kasektorForm">
                        <input type="hidden" id="kasektor-index" value="-1">
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1 text-uppercase">SEKTOR / KECAMATAN</label>
                            <select id="kasektor-sector" class="form-select bg-light border-0 rounded-3 px-3 py-2 fw-bold" onchange="populateKasektorMemberDropdown('', this.value)" required>
                                <option value="">Pilih Sektor</option>
                                <!-- Populated via JS -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1 text-uppercase">PILIH ANGGOTA PENUH</label>
                            <select id="kasektor-name" class="form-select bg-light border-0 rounded-3 px-3 py-2 fw-bold" required>
                                <option value="">Pilih Anggota...</option>
                                <!-- Populated via JS -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1 text-uppercase">USERNAME</label>
                            <input type="text" id="kasektor-username" class="form-control bg-light border-0 rounded-3 px-3 py-2 fw-bold" placeholder="Username untuk login..." required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1 text-uppercase">PASSWORD</label>
                            <div class="input-group">
                                <input type="password" id="kasektor-password" class="form-control bg-light border-0 rounded-start-3 px-3 py-2 fw-bold" placeholder="Password akses..." required>
                                <button class="btn btn-light border-0 rounded-end-3" type="button" onclick="togglePassword('kasektor-password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-dark rounded-pill px-4 fw-bold" onclick="saveKasektor()">
                        <i class="fas fa-save me-2"></i> Simpan Kasektor
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Penilaian Kasektor Modal -->
    <div class="modal fade" id="penilaianKasektorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 p-0">
                    <div class="w-100 px-4 pt-4 pb-3" style="background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:46px;height:46px;background:rgba(255,255,255,0.15)">
                                    <i class="fas fa-star text-white fs-5"></i>
                                </div>
                                <h5 class="fw-bold text-white mb-0">Penilaian Kasektor</h5>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="pen-kas-index">
                    <div class="rounded-3 p-3 mb-4" style="background:#f5f3ff;border:1px solid #ddd6fe;">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="text-muted small fw-bold text-uppercase">Nama Kasektor</div>
                                <div class="fw-bold text-dark" id="pen-kas-name">—</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted small fw-bold text-uppercase">Sektor</div>
                                <div class="fw-bold text-dark" id="pen-kas-sector">—</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="fw-bold text-dark mb-3 small text-uppercase">Kriteria Penilaian</div>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
                                <div class="fw-semibold">Kepemimpinan</div>
                                <div class="d-flex gap-2" data-group="kepemimpinan">
                                    <button type="button" class="pen-kas-btn btn btn-sm btn-outline-secondary px-3" data-val="1">1</button>
                                    <button type="button" class="pen-kas-btn btn btn-sm btn-outline-secondary px-3" data-val="2">2</button>
                                    <button type="button" class="pen-kas-btn btn btn-sm btn-outline-secondary px-3" data-val="3">3</button>
                                    <button type="button" class="pen-kas-btn btn btn-sm btn-outline-secondary px-3" data-val="4">4</button>
                                    <button type="button" class="pen-kas-btn btn btn-sm btn-outline-secondary px-3" data-val="5">5</button>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
                                <div class="fw-semibold">Koordinasi Anggota</div>
                                <div class="d-flex gap-2" data-group="koordinasi">
                                    <button type="button" class="pen-kas-btn btn btn-sm btn-outline-secondary px-3" data-val="1">1</button>
                                    <button type="button" class="pen-kas-btn btn btn-sm btn-outline-secondary px-3" data-val="2">2</button>
                                    <button type="button" class="pen-kas-btn btn btn-sm btn-outline-secondary px-3" data-val="3">3</button>
                                    <button type="button" class="pen-kas-btn btn btn-sm btn-outline-secondary px-3" data-val="4">4</button>
                                    <button type="button" class="pen-kas-btn btn btn-sm btn-outline-secondary px-3" data-val="5">5</button>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
                                <div class="fw-semibold">Laporan Kegiatan</div>
                                <div class="d-flex gap-2" data-group="laporan">
                                    <button type="button" class="pen-kas-btn btn btn-sm btn-outline-secondary px-3" data-val="1">1</button>
                                    <button type="button" class="pen-kas-btn btn btn-sm btn-outline-secondary px-3" data-val="2">2</button>
                                    <button type="button" class="pen-kas-btn btn btn-sm btn-outline-secondary px-3" data-val="3">3</button>
                                    <button type="button" class="pen-kas-btn btn btn-sm btn-outline-secondary px-3" data-val="4">4</button>
                                    <button type="button" class="pen-kas-btn btn btn-sm btn-outline-secondary px-3" data-val="5">5</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-4" style="background:#f5f3ff; border:2px solid #4f46e5;">
                        <div class="fw-bold" style="min-width:80px;">TOTAL:</div>
                        <div class="fs-3 fw-black text-primary" id="pen-kas-total">0</div>
                        <div class="ms-auto">
                            <span id="pen-kas-label" class="badge">Belum dinilai</span>
                        </div>
                    </div>

                    <textarea id="pen-kas-komentar" class="form-control rounded-3" rows="3" placeholder="Tambahkan catatan khusus..."></textarea>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" onclick="savePenilaianKasektor()">
                        <i class="fas fa-save me-2"></i> Simpan Penilaian
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Modal -->
    <div class="modal fade" id="statsModal" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
                <div class="modal-header border-0 text-white px-4 pt-4 pb-3" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed);">
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="stats-modal-label"><i class="fas fa-chart-bar me-2"></i>Tambah Statistik</h5>
                        <small class="opacity-75">Isi detail angka statistik</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 pb-2 pt-4">
                    <input type="hidden" id="stats-edit-index" value="-1">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Icon (Font Awesome Class)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white" style="min-width: 50px; justify-content: center;">
                                    <i id="stats-icon-preview" class="fas fa-star fa-2x text-primary"></i>
                                </span>
                                <input type="text" id="stats-f-icon" class="form-control rounded-end-3" placeholder="cth: fas fa-users" oninput="document.getElementById('stats-icon-preview').className = this.value + ' fa-2x text-primary'">
                            </div>
                            <div class="form-text">Gunakan class Font Awesome, cth: <code>fas fa-users</code>, <code>fas fa-smile</code></div>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold small">Angka</label>
                            <input type="text" id="stats-f-number" class="form-control rounded-3" placeholder="cth: 1234">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold small">Label</label>
                            <input type="text" id="stats-f-label" class="form-control rounded-3" placeholder="cth: Anggota">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-2 gap-2">
                    <button type="button" class="btn btn-outline-secondary rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn fw-bold rounded-3 text-white px-4" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed);" onclick="window._submitStatsForm()">
                        <i class="fas fa-check me-2"></i>Simpan Statistik
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- News Modal -->
    <div class="modal fade" id="newsModal" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
                <div class="modal-header border-0 text-white px-4 pt-4 pb-3" style="background:linear-gradient(135deg,#10b981,#059669);">
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="news-modal-title-label"><i class="fas fa-newspaper me-2"></i>Tambah Berita</h5>
                        <small class="opacity-75">Isi detail berita atau artikel</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 pb-2 pt-3">
                    <input type="hidden" id="news-edit-index" value="-1">
                    <div class="row g-3">
                        <div class="col-12 col-sm-4">
                            <label class="form-label fw-semibold small">Tag / Kategori</label>
                            <input type="text" id="news-f-tag" class="form-control rounded-3" placeholder="cth: Kegiatan">
                        </div>
                        <div class="col-12 col-sm-8">
                            <label class="form-label fw-semibold small">Judul</label>
                            <input type="text" id="news-f-title" class="form-control rounded-3" placeholder="Judul berita...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Deskripsi</label>
                            <textarea id="news-f-description" class="summernote"></textarea>
                        </div>
                        <div class="col-12 col-sm-8">
                            <label class="form-label fw-semibold small">Path Gambar</label>
                            <input type="text" id="news-f-image" class="form-control rounded-3" placeholder="cth: assets/kegiatan/giat.jpg">
                        </div>
                        <div class="col-12 col-sm-4">
                            <label class="form-label fw-semibold small">Link URL</label>
                            <input type="text" id="news-f-link" class="form-control rounded-3" placeholder="#" value="#">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-2 gap-2">
                    <button type="button" class="btn btn-outline-secondary rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn fw-bold rounded-3 text-white px-4" style="background:linear-gradient(135deg,#10b981,#059669);" onclick="window._submitNewsForm()">
                        <i class="fas fa-check me-2"></i>Simpan Berita
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Modal -->
    <div class="modal fade" id="faqModal" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
                <div class="modal-header border-0 text-white px-4 pt-4 pb-3" style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="faqModalLabel"><i class="fas fa-question-circle me-2"></i>Tambah FAQ</h5>
                        <small class="opacity-75" id="faq-modal-subtitle">Isi detail pertanyaan dan jawaban</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 pb-2 pt-3">
                    <input type="hidden" id="faq-edit-index" value="-1">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Pertanyaan</label>
                            <input type="text" id="faq-f-question" class="form-control rounded-3" placeholder="Masukkan pertanyaan...">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Jawaban</label>
                            <textarea id="faq-f-answer" class="summernote"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-2 gap-2">
                    <button type="button" class="btn btn-outline-secondary rounded-3 px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn fw-bold rounded-3 text-white px-4" style="background:linear-gradient(135deg,#3b82f6,#2563eb);" onclick="window._submitFAQForm()">
                        <i class="fas fa-check me-2"></i>Simpan FAQ
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="toast-container" class="toast-container"></div>

    <!-- Mobile Fixed Bottom Nav -->
    <div class="mobile-bottom-nav d-lg-none">
        <a href="#" class="mobile-bottom-item active text-decoration-none" onclick="switchAdminTab('pendaftaran-tab', 'Database Anggota', 'user-shield', this)">
            <i class="fas fa-user-shield"></i>
            <span>Biasa</span>
        </a>
        <a href="#" class="mobile-bottom-item text-decoration-none" onclick="switchAdminTab('pendaftaran-khusus-tab', 'Anggota Penuh', 'star', this)">
            <i class="fas fa-star"></i>
            <span>Penuh</span>
        </a>
        <a href="#" class="mobile-bottom-item text-decoration-none" onclick="switchAdminTab('kasektor-tab', 'Kasektor', 'user-shield', this); loadKasektor()">
            <i class="fas fa-user-shield"></i>
            <span>Kasektor</span>
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
