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
    <title>Sampah - Pokdar Kamtibmas</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark custom-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
                <img src="assets/image.png" alt="Logo Polri" style="height: 45px;">
                <div class="logo-text d-flex flex-column">
                    <span class="main-title text-white fw-bold" style="font-size: 1.1rem; letter-spacing: 1px;">SAMPAH DATA</span>
                    <span class="sub-title" style="color: #ffd700; font-size: 0.8rem;">Arsip Anggota Keluar</span>
                </div>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-lg-3 align-items-center">
                    <li class="nav-item"><a class="nav-link text-white-50" href="admin.php">Kembali ke Admin</a></li>
                    <li class="nav-item">
                        <a href="logout.php" class="btn btn-danger rounded-pill px-4 fw-bold">Keluar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-5">
        <div class="container">
            <div class="row mb-5 animate-up">
                <div class="col-12">
                    <h1 class="fw-bold display-5">Riwayat Anggota Keluar</h1>
                    <p class="text-muted fs-5">Daftar arsip data anggota yang telah dihapus dari database aktif.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden animate-up delay-1">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="small text-uppercase fw-bold text-muted">
                                    <th class="px-4 py-3 border-0 d-none d-md-table-cell">Reg Number</th>
                                    <th class="py-3 border-0">Nama Lengkap</th>
                                    <th class="py-3 border-0 d-none d-sm-table-cell">L/P</th>
                                    <th class="py-3 border-0 d-none d-md-table-cell">Sektor</th>
                                    <th class="py-3 border-0 d-none d-lg-table-cell text-end">Aksi</th>
                                    <th class="px-4 py-3 border-0 text-end">Tanggal Masuk</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                <?php
                                    $trashFile = 'data/sampah.json';
                                    $data = file_exists($trashFile) ? json_decode(file_get_contents($trashFile), true) : [];
                                    if (is_array($data) && count($data) > 0):
                                        foreach (array_reverse($data) as $row):
                                ?>
                                        <tr>
                                            <td class="px-4 d-none d-md-table-cell"><code class="bg-light p-1 rounded"><?php echo htmlspecialchars($row['reg_number']); ?></code></td>
                                            <td>
                                                <div class="fw-bold"><?php echo htmlspecialchars($row['full_name']); ?></div>
                                                <div class="d-md-none small text-muted"><?php echo htmlspecialchars($row['reg_number']); ?></div>
                                            </td>
                                            <td class="d-none d-sm-table-cell"><span class="badge bg-light text-dark"><?php echo htmlspecialchars($row['gender'] === 'Laki-laki' ? 'L' : 'P'); ?></span></td>
                                            <td class="d-none d-md-table-cell small">Sektor <?php echo htmlspecialchars($row['sector']); ?></td>
                                            <td class="text-end px-3">
                                                <div class="btn-group rounded-pill shadow-sm">
                                                    <button class="btn btn-sm btn-light rounded-pill px-3 shadow-sm border"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#detailModal" 
                                                        data-reg="<?php echo htmlspecialchars($row['reg_number']); ?>"
                                                        data-name="<?php echo htmlspecialchars($row['full_name']); ?>"
                                                        data-gender="<?php echo htmlspecialchars($row['gender']); ?>"
                                                        data-sector="<?php echo htmlspecialchars($row['sector']); ?>"
                                                        data-subsector="<?php echo htmlspecialchars($row['subsector'] ?? '-'); ?>"
                                                        data-date="<?php echo date('d F Y, H:i', strtotime($row['timestamp'])); ?>"
                                                        data-address="<?php echo htmlspecialchars($row['address'] ?? 'Tidak ada data alamat'); ?>">
                                                    Detail
                                                </button>
                                                </div>
                                            </td>
                                            <td class="px-4 small text-muted text-end"><?php echo date('d/m/y H:i', strtotime($row['timestamp'])); ?></td>
                                        </tr>
                                <?php endforeach; else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">Belum ada data di arsip sampah.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4 text-dark">
                <div class="modal-header border-0 pb-0 text-start">
                    <h5 class="fw-bold">Detail Arsip Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-start">
                    <div class="text-center mb-4">
                        <div class="bg-secondary d-inline-block p-3 rounded-circle mb-2 text-white fs-3 opacity-75">📂</div>
                        <h4 class="fw-bold mb-1" id="m-name">Nama Anggota</h4>
                        <span class="badge bg-light text-dark fw-normal border" id="m-reg">REG-000</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-6 text-start">
                            <label class="small text-muted d-block">Jenis Kelamin</label>
                            <span class="fw-bold" id="m-gender">-</span>
                        </div>
                        <div class="col-6 text-start">
                            <label class="small text-muted d-block">Tanggal Masuk</label>
                            <span class="fw-bold" id="m-date">-</span>
                        </div>
                        <div class="col-6 text-start">
                            <label class="small text-muted d-block">Sektor</label>
                            <span class="fw-bold" id="m-sector">-</span>
                        </div>
                        <div class="col-6 text-start">
                            <label class="small text-muted d-block">Sub Sektor</label>
                            <span class="fw-bold" id="m-subsector">-</span>
                        </div>
                        <div class="col-12 mt-4 pt-3 border-top text-start">
                            <label class="small text-muted d-block">Alamat Domisili</label>
                            <p class="mb-0 fw-bold" id="m-address">-</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-dark w-100 rounded-pill fw-bold" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-5 bg-dark text-white text-center mt-5">
        <div class="container">
            <p class="mb-0 opacity-50 small">&copy; 2026 Admin Panel Pokdar Kamtibmas Polres Tangerang Selatan.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script>
        // Modal Population
        const detailModal = document.getElementById('detailModal');
        if (detailModal) {
            detailModal.addEventListener('show.bs.modal', event => {
                const btn = event.relatedTarget;
                document.getElementById('m-name').textContent = btn.getAttribute('data-name');
                document.getElementById('m-reg').textContent = btn.getAttribute('data-reg');
                document.getElementById('m-gender').textContent = btn.getAttribute('data-gender');
                document.getElementById('m-sector').textContent = 'Sektor ' + btn.getAttribute('data-sector');
                document.getElementById('m-subsector').textContent = 'Sub ' + btn.getAttribute('data-subsector');
                document.getElementById('m-date').textContent = btn.getAttribute('data-date');
                document.getElementById('m-address').textContent = btn.getAttribute('data-address');
            });
        }
    </script>
</body>
</html>
