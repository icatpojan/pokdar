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
            
            #adminTabs, #cms-pills-tab {
                flex-wrap: nowrap !important;
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                margin-top: 15px !important;
                margin-bottom: 5px !important;
                gap: 8px;
                padding: 6px !important;
                background: #f3f4f6;
                border-radius: 60px;
            }
            #adminTabs::-webkit-scrollbar, #cms-pills-tab::-webkit-scrollbar { display: none; }

            /* Scroll Indicator Wrapper */
            .scroll-wrapper {
                position: relative;
                margin: 5px 15px;
            }
            
            #adminTabs .nav-link, #cms-pills-tab .nav-link {
                white-space: nowrap !important;
                flex: 0 0 auto;
                padding: 8px 20px !important;
                font-size: 0.8rem;
                border-radius: 50px !important;
                border: none !important;
                color: #6b7280;
                background: transparent !important;
                font-weight: 600;
                transition: all 0.25s ease;
            }

            #adminTabs .nav-link.active, #cms-pills-tab .nav-link.active {
                background: #111827 !important;
                color: #ffffff !important;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            #adminTabs .nav-link::after, #cms-pills-tab .nav-link::after,
            #adminTabs .nav-link::before, #cms-pills-tab .nav-link::before {
                display: none !important;
            }

            #cms-pills-tab .nav-link {
                margin-bottom: 0 !important;
                border: 1px solid #f3f4f6 !important;
                background: #fff;
            }
            
            .cms-premium-form .card {
                padding: 1.5rem !important;
            }
            
            .navbar-brand img { height: 32px !important; }
            .logo-text span.main-title { font-size: 0.85rem !important; }
            .logo-text span.sub-title { font-size: 0.6rem !important; }
        }
    </style>
</head>
<body class="bg-light">
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
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
            <div class="row align-items-center mb-5 animate-up">
                <div class="col-lg-7 mb-4 mb-lg-0 mobile-text-center">
                    <h1 class="fw-bold display-5">Dashboard Pengelola</h1>
                    <p class="text-muted fs-5 mb-0">Selamat datang kembali! Kelola database anggota dan publikasi konten.</p>
                </div>
                <div class="col-lg-5 text-center">
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-end">
                        <?php
                            $dataFile = 'data/pendaftaran.json';
                            $data = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];
                            $total = is_array($data) ? count($data) : 0;
                        ?>
                        <div class="card bg-dark text-white border-0 shadow-sm rounded-4 text-center p-3 w-100" style="max-width: 200px;">
                            <span class="fs-2 mb-1" id="active-member-count"><?php echo $total; ?></span>
                            <span class="small opacity-75">Total Anggota Aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Section -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden animate-up delay-1">
                <div class="card-header bg-white p-0 scroll-wrapper">
                    <ul class="nav nav-tabs border-0" id="adminTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-3 px-4" id="cms-tab" data-bs-toggle="tab" data-bs-target="#cms" type="button" role="tab" onclick="loadCMS('hero')">Manajemen Konten</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active py-3 px-4" id="pendaftaran-tab" data-bs-toggle="tab" data-bs-target="#pendaftaran" type="button" role="tab">Database Anggota</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-3 px-4 text-danger" id="trash-tab" data-bs-toggle="tab" data-bs-target="#trash-section" type="button" role="tab" onclick="loadTrash()">Arsip Keluar 🗑️</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4 bg-white">
                    <div class="tab-content" id="adminTabsContent">
                        
                        <!-- Tab Manajemen Konten -->
                        <div class="tab-pane fade" id="cms" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-lg-3 scroll-wrapper">
                                    <div class="nav nav-pills" id="cms-pills-tab" role="tablist">
                                        <button class="nav-link active text-start" data-bs-toggle="pill" onclick="loadCMS('hero')"><i class="fas fa-rocket me-2 me-lg-3 text-accent"></i> Hero Section</button>
                                        <button class="nav-link text-start" data-bs-toggle="pill" onclick="loadCMS('stats')"><i class="fas fa-chart-bar me-2 me-lg-3 text-accent"></i> Statistik Utama</button>
                                        <button class="nav-link text-start" data-bs-toggle="pill" onclick="loadCMS('tentang')"><i class="fas fa-info-circle me-2 me-lg-3 text-accent"></i> Tentang Kami</button>
                                        <button class="nav-link text-start" data-bs-toggle="pill" onclick="loadCMS('sejarah')"><i class="fas fa-history me-2 me-lg-3 text-accent"></i> Sejarah & Timeline</button>
                                        <button class="nav-link text-start" data-bs-toggle="pill" onclick="loadCMS('structure')"><i class="fas fa-users me-2 me-lg-3 text-accent"></i> Struktur Organisasi</button>
                                        <button class="nav-link text-start" data-bs-toggle="pill" onclick="loadCMS('kegiatan')"><i class="fas fa-camera-retro me-2 me-lg-3 text-accent"></i> Galeri Kegiatan</button>
                                        <button class="nav-link text-start" data-bs-toggle="pill" onclick="loadCMS('faq')"><i class="fas fa-question-circle me-2 me-lg-3 text-accent"></i> Tanya Jawab (FAQ)</button>
                                        <button class="nav-link text-start" data-bs-toggle="pill" onclick="loadCMS('contact')"><i class="fas fa-address-book me-2 me-lg-3 text-accent"></i> Kontak & Media</button>
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
                            <div class="table-responsive">
                                <table class="table table-hover align-middle border-0">
                                    <thead class="table-light">
                                        <tr class="small text-uppercase fw-bold text-muted">
                                            <th class="border-0 d-none d-md-table-cell">Reg Number</th>
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
                                                <tr>
                                                    <td class="d-none d-md-table-cell"><code class="bg-light p-1 rounded"><?php echo htmlspecialchars($row['reg_number']); ?></code></td>
                                                    <td>
                                                        <div class="fw-bold"><?php echo htmlspecialchars($row['full_name']); ?></div>
                                                        <div class="d-md-none small text-muted"><?php echo htmlspecialchars($row['reg_number']); ?></div>
                                                    </td>
                                                    <td class="d-none d-sm-table-cell"><span class="badge bg-light text-dark"><?php echo htmlspecialchars($row['gender'] === 'Laki-laki' ? 'L' : 'P'); ?></span></td>
                                                    <td class="small d-none d-md-table-cell">Sektor <?php echo htmlspecialchars($row['sector']); ?> - Sub <?php echo htmlspecialchars($row['subsector']); ?></td>
                                                    <td class="d-none d-lg-table-cell">
                                                        <?php 
                                                            $status = $row['status'] ?? 'Pending';
                                                            $badgeClass = 'bg-warning-subtle text-warning';
                                                            if($status === 'Approved') $badgeClass = 'bg-success-subtle text-success';
                                                            if($status === 'Rejected') $badgeClass = 'bg-danger-subtle text-danger';
                                                        ?>
                                                        <span class="badge <?php echo $badgeClass; ?> border px-2"><?php echo $status; ?></span>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="btn-group rounded-pill shadow-sm">
                                                            <button class="btn btn-light px-3" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#detailModal" 
                                                                    data-reg="<?php echo htmlspecialchars($row['reg_number']); ?>"
                                                                    data-name="<?php echo htmlspecialchars($row['full_name']); ?>"
                                                                    data-gender="<?php echo htmlspecialchars($row['gender']); ?>"
                                                                    data-sector="<?php echo htmlspecialchars($row['sector']); ?>"
                                                                    data-subsector="<?php echo htmlspecialchars($row['subsector']); ?>"
                                                                    data-date="<?php echo date('d F Y, H:i', strtotime($row['timestamp'])); ?>"
                                                                    data-address="<?php echo htmlspecialchars($row['address']); ?>"
                                                                    data-status="<?php echo htmlspecialchars($row['status'] ?? 'Pending'); ?>"
                                                                    data-file="<?php echo htmlspecialchars($row['file_path'] ?? ''); ?>">
                                                                Review
                                                            </button>
                                                            <button onclick="moveToTrash('<?php echo $row['reg_number']; ?>')" class="btn btn-outline-danger px-3">Hapus</button>
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

                        <!-- Tab Arsip Keluar -->
                        <div class="tab-pane fade" id="trash-section" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h4 class="fw-bold mb-1">Arsip Anggota Keluar</h4>
                                    <p class="text-muted small mb-0">Daftar anggota yang telah dihapus. Anda dapat memulihkan atau menghapus permanen.</p>
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
                        <div class="bg-accent p-2 rounded-3 text-dark">
                            <i class="fas fa-user-check fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Review Pendaftaran Anggota</h5>
                            <small class="text-muted" id="m-reg-display">REG-000</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <!-- Left: PDF Viewer -->
                        <div class="col-lg-8 bg-light border-end" style="min-height: 600px;">
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
                        
                        <!-- Right: Data Controls -->
                        <div class="col-lg-4 p-4">
                            <form id="editMemberForm">
                                <input type="hidden" name="reg_number" id="m-reg-val">
                                <input type="hidden" name="status" id="m-status-val">

                                <div class="section-badge mb-3">Informasi Profil</div>
                                
                                <div class="mb-3">
                                    <label class="small fw-bold text-muted mb-1">Nama Lengkap</label>
                                    <input type="text" name="full_name" id="m-name" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2 fw-bold" required>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">Jenis Kelamin</label>
                                        <select name="gender" id="m-gender" class="form-select bg-light border-0 rounded-3 fs-6 px-3 h-auto py-2">
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                            <option value="N/A">N/A</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">Status</label>
                                        <div id="m-status-badge"></div>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">Sektor</label>
                                        <input type="text" name="sector" id="m-sector" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2">
                                    </div>
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted mb-1">Sub Sektor</label>
                                        <input type="text" name="subsector" id="m-subsector" class="form-control bg-light border-0 rounded-3 fs-6 px-3 py-2">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small fw-bold text-muted mb-1">Alamat Domisili</label>
                                    <textarea name="address" id="m-address" class="form-control bg-light border-0 rounded-3 fs-6 px-3" rows="3"></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="small fw-bold text-muted mb-1">Waktu Pendaftaran</label>
                                    <input type="text" id="m-date" class="form-control bg-light border-0 rounded-3 fs-7 px-3 py-2 text-muted" readonly>
                                </div>

                                <div class="d-grid gap-2 pt-3 border-top">
                                    <button type="submit" class="btn btn-dark rounded-3 py-2 fw-bold">
                                        <i class="fas fa-save me-2 text-accent"></i> Simpan Data Saja
                                    </button>
                                    <div class="row gx-2">
                                        <div class="col-6">
                                            <button type="button" onclick="setMemberStatus('Approved')" class="btn btn-success w-100 rounded-3 py-2 fw-bold small">
                                                <i class="fas fa-check-circle me-1"></i> Setujui
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script>
        // Modal Population for Edit
        const detailModal = document.getElementById('detailModal');
        if (detailModal) {
            detailModal.addEventListener('show.bs.modal', event => {
                const btn = event.relatedTarget;
                document.getElementById('m-name').value = btn.getAttribute('data-name');
                document.getElementById('m-reg-display').textContent = btn.getAttribute('data-reg');
                document.getElementById('m-reg-val').value = btn.getAttribute('data-reg');
                document.getElementById('m-gender').value = btn.getAttribute('data-gender');
                document.getElementById('m-sector').value = btn.getAttribute('data-sector').replace('Sektor ', '');
                document.getElementById('m-subsector').value = btn.getAttribute('data-subsector').replace('Sub ', '');
                document.getElementById('m-date').value = btn.getAttribute('data-date');
                document.getElementById('m-address').value = btn.getAttribute('data-address');
                document.getElementById('m-status-val').value = btn.getAttribute('data-status') || 'Pending';
                
                // Status Badge update
                const status = btn.getAttribute('data-status') || 'Pending';
                let badgeClass = 'bg-warning-subtle text-warning';
                if(status === 'Approved') badgeClass = 'bg-success-subtle text-success';
                if(status === 'Rejected') badgeClass = 'bg-danger-subtle text-danger';
                document.getElementById('m-status-badge').innerHTML = `<span class="badge ${badgeClass} border fw-bold w-100 py-2">${status}</span>`;

                const filePath = btn.getAttribute('data-file');
                const pdfViewer = document.getElementById('m-pdf-viewer');
                const noPdfMessage = document.getElementById('no-pdf-message');
                
                if (filePath && filePath !== 'N/A' && filePath !== '') {
                    pdfViewer.src = filePath;
                    pdfViewer.classList.remove('d-none');
                    noPdfMessage.classList.remove('d-flex');
                    noPdfMessage.classList.add('d-none');
                } else {
                    pdfViewer.src = '';
                    pdfViewer.classList.add('d-none');
                    noPdfMessage.classList.remove('d-none');
                    noPdfMessage.classList.add('d-flex');
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
                        alert('✅ Data anggota berhasil diperbarui!');
                    } else {
                        alert('❌ Error: ' + result.message);
                    }
                } catch (err) {
                    alert('❌ Gagal menghubungi server');
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
                    alert(`✅ Pendaftaran Berhasil ${status === 'Approved' ? 'Disetujui' : 'Ditolak'}!`);
                } else {
                    alert('❌ Error: ' + result.message);
                }
            } catch (err) {
                alert('❌ Gagal menghubungi server');
            }
        }

        async function loadMembers() {
            const tableBody = document.getElementById('member-table-body');
            try {
                const resp = await fetch('data/pendaftaran.json?v=' + Date.now());
                const data = await resp.json();
                
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
                    const formattedDate = date.toLocaleDateString('id-ID', {day: '2-digit', month: '2-digit', year: '2-digit'}) + ' ' + 
                                        date.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'});
                    
                    const longDate = date.toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) + ', ' +
                                    date.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'});

                    const status = row.status || 'Pending';
                    let statusBadge = `<span class="badge bg-warning-subtle text-warning border px-2">Pending</span>`;
                    if(status === 'Approved') statusBadge = `<span class="badge bg-success-subtle text-success border px-2">Approved</span>`;
                    if(status === 'Rejected') statusBadge = `<span class="badge bg-danger-subtle text-danger border px-2">Rejected</span>`;

                    html += `
                        <tr>
                            <td class="d-none d-md-table-cell"><code class="bg-light p-1 rounded">${row.reg_number}</code></td>
                            <td>
                                <div class="fw-bold">${row.full_name}</div>
                                <div class="d-md-none small text-muted">${row.reg_number}</div>
                            </td>
                            <td class="d-none d-sm-table-cell"><span class="badge bg-light text-dark">${row.gender === 'Laki-laki' ? 'L' : (row.gender === 'Perempuan' ? 'P' : '-')}</span></td>
                            <td class="small d-none d-md-table-cell">Sektor ${row.sector} - Sub ${row.subsector}</td>
                            <td class="d-none d-lg-table-cell">${statusBadge}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm rounded-pill shadow-sm">
                                    <button class="btn btn-light px-2 px-sm-3" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#detailModal" 
                                            data-reg="${row.reg_number}"
                                            data-name="${row.full_name}"
                                            data-gender="${row.gender}"
                                            data-sector="${row.sector}"
                                            data-subsector="${row.subsector}"
                                            data-date="${longDate}"
                                            data-address="${row.address}"
                                            data-status="${status}"
                                            data-file="${row.file_path || ''}">
                                        Review
                                    </button>
                                    <button onclick="moveToTrash('${row.reg_number}')" class="btn btn-outline-danger px-2 px-sm-3">Hapus</button>
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

        async function moveToTrash(reg) {
            if(!confirm('Pindahkan anggota ini ke sampah?')) return;
            try {
                const resp = await fetch('delete.php?reg=' + encodeURIComponent(reg) + '&ajax=1');
                const result = await resp.json();
                if(result.status === 'success') {
                    await loadMembers();
                } else {
                    alert('❌ Gagal menghapus: ' + result.message);
                }
            } catch (err) {
                alert('❌ Gagal menghubungi server');
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
                            <td class="d-none d-md-table-cell"><code class="bg-light p-1 rounded">${row.reg_number}</code></td>
                            <td>
                                <div class="fw-bold">${row.full_name}</div>
                                <div class="d-md-none small text-muted">${row.reg_number}</div>
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
                    alert('✅ Anggota berhasil dipulihkan!');
                }
            } catch (err) { alert('❌ Gagal menghubungi server'); }
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
                    alert('🗑️ Data telah dihapus secara permanen.');
                }
            } catch (err) { alert('❌ Gagal menghubungi server'); }
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
            'contact': 'Kontak & Media'
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
                    // Show a nicer toast instead of alert if possible, for now alert is fine
                    alert('✅ Data ' + type + ' berhasil diperbarui!');
                } else {
                    alert('❌ Gagal menyimpan: ' + result.message);
                }
                return result;
            } catch (err) {
                alert('❌ Terjadi kesalahan koneksi');
                console.error(err);
            }
        }

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
                
                let html = `
                    <div class="cms-animate-content">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4 border-bottom pb-4">
                            <div>
                                <h4 class="fw-bold mb-0 text-dark" style="letter-spacing: -0.5px;">Manajemen ${getLabel(type)}</h4>
                                <p class="small text-muted mb-0">Sesuaikan konten bagian ini dengan mudah dan cepat.</p>
                            </div>
                            <button class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm py-2 px-sm-4" onclick="saveCMS('${type}')">
                                <i class="fas fa-save me-2 text-accent"></i> Simpan Perubahan
                            </button>
                        </div>
                        <form id="cms-form-${type}" class="cms-premium-form">
                `;

                function renderRecursive(obj, currentKey, path = []) {
                    let fieldsHtml = "";
                    for (const key in obj) {
                        if (key === 'buttons' || key === 'id' || key === 'class' || key === 'icon') continue; // Hide these from CMS

                        const label = getLabel(key);
                        const val = obj[key];
                        const fullPath = [...path, key];
                        const dataPath = fullPath.join('.');

                        if (Array.isArray(val)) {
                            fieldsHtml += `
                                <div class="mb-5 pb-4 border-bottom border-light">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-3 mb-0 h5">
                                            <div class="bg-accent rounded-pill" style="width:12px; height:6px;"></div>
                                            ${label}
                                        </label>
                                        <button class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-bold" type="button" onclick="addItem(event, '${type}', '${dataPath}')">
                                            <i class="fas fa-plus me-1 text-accent"></i> Tambah Item
                                        </button>
                                    </div>
                                    <div id="array-container-${dataPath.replace(/\./g, '-')}" class="row g-4">
                                        ${val.map((item, i) => {
                                            if (typeof item === 'object') {
                                                return `
                                                    <div class="col-12" id="item-${dataPath.replace(/\./g, '-')}-${i}">
                                                        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-start border-4 border-accent position-relative cms-card">
                                                            <button type="button" class="btn btn-link text-danger position-absolute top-0 end-0 m-3 p-1 text-decoration-none shadow-none" onclick="removeItem(event, '${type}', '${dataPath}', ${i})">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                            <div class="row g-3">
                                                                ${Object.keys(item).filter(sk => sk !== 'id').map(subKey => `
                                                                    <div class="col-md-${Object.keys(item).length > 2 ? '6' : '12'}">
                                                                        <label class="small fw-bold text-muted mb-1">${getLabel(subKey)}</label>
                                                                        ${(subKey.toLowerCase().includes('image') || (item[subKey] || "").toString().includes('assets/')) ? `
                                                                            <div class="d-flex align-items-center gap-2">
                                                                                <div class="rounded-3 overflow-hidden border bg-light shadow-sm" style="width: 50px; height: 38px; flex-shrink: 0;">
                                                                                    <img src="${item[subKey]}?v=${Date.now()}" class="w-100 h-100 object-fit-cover">
                                                                                </div>
                                                                                <div class="input-group input-group-sm">
                                                                                    <input type="text" class="form-control border-0 bg-light rounded-start-3" 
                                                                                           data-path="${dataPath}" data-index="${i}" data-subkey="${subKey}" 
                                                                                           value="${(item[subKey] || "").toString().replace(/"/g, '&quot;')}">
                                                                                    <button type="button" class="btn btn-light border-0 px-2" onclick="this.nextElementSibling.click()">
                                                                                        <i class="fas fa-camera text-muted small"></i>
                                                                                    </button>
                                                                                    <input type="file" class="d-none" accept="image/*" onchange="handleCMSImageUpload(this, '${type}', '${dataPath}', ${i}, '${subKey}')">
                                                                                </div>
                                                                            </div>
                                                                        ` : ((item[subKey] || "").toString().length > 100 ? 
                                                                            `<textarea class="form-control bg-light border-0 rounded-3 px-3 fs-6" data-path="${dataPath}" data-index="${i}" data-subkey="${subKey}" rows="2">${item[subKey]}</textarea>` :
                                                                            `<input type="text" class="form-control form-control-lg rounded-3 bg-light border-0 px-3 fs-6" 
                                                                                   data-path="${dataPath}" data-index="${i}" data-subkey="${subKey}" 
                                                                                   value="${(item[subKey] || "").toString().replace(/"/g, '&quot;')}">`
                                                                        )}
                                                                    </div>
                                                                `).join('')}
                                                            </div>
                                                        </div>
                                                    </div>
                                                `;
                                            } else {
                                                return `
                                                            <div class="col-md-6" id="item-${dataPath.replace(/\./g, '-')}-${i}">
                                                                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center gap-3 cms-card">
                                                                    ${(item.toString().includes('assets/') || item.toString().includes('uploads/')) ? `
                                                                        <div class="rounded-3 overflow-hidden shadow-sm" style="width: 60px; height: 45px;">
                                                                            <img src="${item}?v=${Date.now()}" class="w-100 h-100 object-fit-cover shadow-sm bg-light">
                                                                        </div>
                                                                    ` : ''}
                                                                    <div class="flex-grow-1">
                                                                        <div class="input-group input-group-sm">
                                                                            <input type="text" class="form-control border-0 bg-light rounded-start-3 px-3" 
                                                                                   data-path="${dataPath}" data-index="${i}" 
                                                                                   value="${item.toString().replace(/"/g, '&quot;')}">
                                                                            <button type="button" class="btn btn-light border-0 px-3" onclick="this.nextElementSibling.click()">
                                                                                <i class="fas fa-camera text-muted"></i>
                                                                            </button>
                                                                            <input type="file" class="d-none" accept="image/*" onchange="handleCMSImageUpload(this, '${type}', '${dataPath}', ${i})">
                                                                        </div>
                                                                    </div>
                                                                    <button type="button" class="btn btn-link text-danger p-1 text-decoration-none shadow-none" onclick="removeItem(event, '${type}', '${dataPath}', ${i})">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                `;
                                            }
                                        }).join('')}
                                    </div>
                                </div>
                            `;
                        } else if (typeof val === 'object' && val !== null) {
                            fieldsHtml += `
                                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white border-top border-4 border-accent">
                                    <label class="form-label fw-bold text-dark mb-3 text-uppercase small" style="letter-spacing: 1px;">Data ${label}</label>
                                    <div class="row g-3 text-white">
                                        ${renderRecursive(val, key, fullPath)}
                                    </div>
                                </div>
                            `;
                        } else {
                            const isLarge = (val || "").toString().length > 100 || key.includes('text') || key.includes('description') || key.includes('answer');
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
                                            `<textarea class="form-control border-0 bg-light rounded-4 p-3 fs-6" data-path="${dataPath}" rows="4">${val}</textarea>` :
                                            `<input type="text" class="form-control form-control-lg border-0 bg-light rounded-pill px-4 fs-6" data-path="${dataPath}" value="${(val || "").toString().replace(/"/g, '&quot;')}">`
                                        )}
                                    </div>
                                </div>
                            `;
                        }
                    }
                    return fieldsHtml;
                }

                html += renderRecursive(data, type);
                html += `</form></div>`;
                container.innerHTML = html;

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
                    const subKey = input.getAttribute('data-subkey');
                    const index = input.getAttribute('data-index');

                    if (!path) return;

                    const keys = path.split('.');
                    let ref = currentData;
                    for (let i = 0; i < keys.length - 1; i++) {
                        ref = ref[keys[i]];
                    }
                    const lastKey = keys[keys.length - 1];

                    if (index !== null) {
                        if (subKey) {
                            ref[lastKey][index][subKey] = input.value;
                        } else {
                            ref[lastKey][index] = input.value;
                        }
                    } else {
                        ref[lastKey] = input.value;
                    }
                });

                const result = await saveContent(type, currentData);
                if (result && result.status === 'success') {
                    await loadCMS(type);
                }
            } catch (err) {
                alert('❌ Gagal menyimpan perubahan: ' + err.message);
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
                    alert('❌ Gagal upload: ' + result.message);
                }
            } catch (err) {
                alert('❌ Kesalahan upload: ' + err.message);
            } finally {
                originalBtn.disabled = false;
                originalBtn.innerHTML = originalHtml;
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
                
                const keys = path.split('.');
                let ref = data;
                for (let i = 0; i < keys.length - 1; i++) {
                    ref = ref[keys[i]];
                }
                const lastKey = keys[keys.length - 1];
                const array = ref[lastKey];

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
                    }
                }
            } catch (err) {
                console.error(err);
                alert('❌ Gagal menambah item: ' + err.message);
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
                
                const keys = path.split('.');
                let ref = data;
                for (let i = 0; i < keys.length - 1; i++) {
                    ref = ref[keys[i]];
                }
                const lastKey = keys[keys.length - 1];
                const array = ref[lastKey];

                if (Array.isArray(array)) {
                    array.splice(index, 1);
                    const result = await saveContent(type, data);
                    if (result && result.status === 'success') {
                        await loadCMS(type);
                    }
                }
            } catch (err) {
                console.error(err);
                alert('❌ Gagal menghapus item: ' + err.message);
            } finally {
                if (btn) btn.disabled = false;
            }
        }

        // Auto-load Hero Section on first open
        window.addEventListener('DOMContentLoaded', () => {
            loadCMS('hero');
        });
    </script>
        </main>

        <footer class="bg-dark text-white py-4 mt-auto">
            <div class="container text-center">
                <p class="mb-0 opacity-50 small">&copy; <?php echo date('Y'); ?> Admin Panel Pokdar Kamtibmas Polres Tangerang Selatan.</p>
            </div>
        </footer>
    </div>
</body>
</html>
