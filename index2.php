<?php
// Load data
$newsData = json_decode(file_get_contents('data/news.json'), true);
$structureData = json_decode(file_get_contents('data/structure.json'), true);
$heroData = json_decode(file_get_contents('data/hero.json'), true);
$statsData = json_decode(file_get_contents('data/stats.json'), true);
$tentangData = json_decode(file_get_contents('data/tentang.json'), true);
$sejarahData = json_decode(file_get_contents('data/sejarah.json'), true);
$kegiatanData = json_decode(file_get_contents('data/kegiatan.json'), true);
$faqData = json_decode(file_get_contents('data/faq.json'), true);
$contactData = json_decode(file_get_contents('data/contact.json'), true);
$regData = json_decode(file_get_contents('data/registrasi.json'), true);

$pimpinan = $structureData['pimpinan'];
$pelaksana = $structureData['pelaksana'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokdar Kamtibmas - Premium Corporate</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Lexend:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Style -->
    <link rel="stylesheet" href="css/style2.css?v=3.0">
</head>

<body>

    <!-- Double Tier Header UGM Style -->
    <header class="header-ugm">
        <div class="nav-top-tier">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Brand -->
                    <a class="navbar-brand d-flex align-items-center gap-3" href="#">
                        <img src="assets/image.png" alt="Logo">
                        <div class="brand-text d-none d-md-block">
                            <h4 class="fw-800">POKDAR KAMTIBMAS</h4>
                            <p class="mb-0 small fw-600 text-white opacity-75">POLRES TANGERANG SELATAN</p>
                        </div>
                    </a>

                    <!-- Right Side Utility -->
                    <div class="text-end">
                        <div class="nav-social-icons mb-2">
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-x-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-tiktok"></i></a>
                            <span class="ms-3 border-start ps-3 border-secondary border-opacity-50">
                                <img src="https://flagcdn.com/w20/id.png" alt="ID" width="18" class="me-1"> ID <i class="fas fa-chevron-down ms-1 small"></i>
                                <i class="fas fa-search ms-3 opacity-75"></i>
                            </span>
                        </div>
                        <div class="top-utility-links d-none d-lg-block">
                            <a href="#">Email</a>
                            <a href="#">Anggota</a>
                            <a href="#">Polri</a>
                            <a href="#">Masyarakat</a>
                            <a href="login.php" class="fw-bold">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Nav Tier -->
        <nav class="navbar navbar-expand-lg nav-bottom-tier p-0">
            <div class="container justify-content-center">
                <button class="navbar-toggler border-0 py-2 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#bottomNav">
                    <i class="fas fa-bars"></i> Menu
                </button>
                <div class="collapse navbar-collapse" id="bottomNav">
                    <ul class="navbar-nav mx-auto align-items-center">
                        <li class="nav-item"><a class="nav-link" href="#home">Pendaftaran</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about">Sejarah</a></li>
                        <li class="nav-item"><a class="nav-link" href="#organisasi">Organisasi</a></li>
                        <li class="nav-item"><a class="nav-link" href="#kegiatan">Kegiatan</a></li>
                        <li class="nav-item"><a class="nav-link active-link" href="#berita">Berita Terbaru</a></li>
                        <li class="nav-item"><a class="nav-link" href="#kontak">Layanan</a></li>
                        <li class="nav-item"><a class="nav-link" href="#kontak">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="corporate-hero">
        <div class="hero-pattern"></div>
        <div class="container position-relative text-center">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h6 class="hero-tagline animate-up mb-4">Pokdar Kamtibmas Bhayangkara</h6>
                    <h1 class="hero-title animate-up mb-4">Menjaga Keamanan,<br>Membangun Kepercayaan.</h1>
                    <p class="fs-5 opacity-100 mb-5 animate-up text-muted mx-auto" style="max-width: 800px;">Sinergi Masyarakat dan POLRI untuk menciptakan lingkungan yang aman, tertib, dan kondusif melalui kemitraan yang strategis.</p>
                    <div class="d-flex gap-4 animate-up justify-content-center">
                        <a href="#pendaftaran" class="btn btn-cta">Gabung Bersama Kami</a>
                        <a href="#about" class="btn btn-link text-primary text-decoration-none fw-700">Pelajari Selengkapnya <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Corporate -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-4">
                <?php foreach($statsData as $stat): ?>
                <div class="col-6 col-lg-3">
                    <div class="text-center p-4">
                        <h2 class="fw-800 text-primary mb-1"><?php echo $stat['number']; ?></h2>
                        <p class="text-muted fw-600 mb-0 small text-uppercase"><?php echo $stat['label']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Sejarah / History -->
    <section id="about" class="section-padding bg-soft">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="history-img-wrap">
                        <img src="assets/kegiatan-1.jpg" alt="Sejarah" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-6">
                    <h6 class="text-primary fw-800 text-uppercase mb-3" style="letter-spacing: 2px;">Sejarah & Visi</h6>
                    <h2 class="display-5 fw-800 mb-4"><?php echo $sejarahData['title_highlight']; ?></h2>
                    <p class="text-muted mb-5"><?php echo $sejarahData['description']; ?></p>
                    
                    <div class="row g-4">
                        <?php foreach($sejarahData['timeline'] as $item): ?>
                        <div class="col-md-6">
                            <div class="d-flex gap-3">
                                <div class="icon-wrap" style="flex-shrink: 0; width: 45px; height: 45px; font-size: 1rem;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h6 class="fw-700 mb-1"><?php echo $item['title']; ?></h6>
                                    <p class="small text-muted mb-0"><?php echo $item['content']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Organisasi / Structure -->
    <section id="organisasi" class="section-padding">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="text-primary fw-800 text-uppercase mb-3">Kepengurusan</h6>
                <h2 class="fw-800 display-6">Struktur Organisasi <span class="text-primary">Stratejik</span></h2>
            </div>
            
            <!-- Ketua -->
            <div class="row justify-content-center mb-5">
                <div class="col-md-4">
                    <div class="corporate-card org-card">
                        <img src="assets/user.png" alt="Ketua" class="org-avatar">
                        <p class="org-pos">Ketua Umum</p>
                        <h5 class="fw-800 mb-0"><?php echo $pimpinan['ketua']['name']; ?></h5>
                    </div>
                </div>
            </div>

            <!-- Divisi -->
            <div class="row g-4 justify-content-center">
                <?php foreach($pelaksana as $item): ?>
                <div class="col-md-3">
                    <div class="corporate-card p-4 text-center">
                        <p class="org-pos small mb-2"><?php echo $item['dept']; ?></p>
                        <h6 class="fw-700 mb-0"><?php echo $item['lead']; ?></h6>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Visi & Misi -->
    <section class="section-padding bg-white">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 order-lg-2">
                    <div class="p-5 bg-navy rounded-5 shadow-lg position-relative overflow-hidden">
                        <div class="hero-pattern opacity-25"></div>
                        <h2 class="text-white fw-800 mb-4">Visi & Misi Kami</h2>
                        <p class="text-white opacity-75 mb-0">Mewujudkan kemitraan masyarakat yang proaktif dan responsif dalam mendukung tugas kepolisian daerah Tangerang Selatan.</p>
                    </div>
                </div>
                <div class="col-lg-7 order-lg-1">
                    <div class="row g-4">
                        <?php foreach($tentangData['cards'] as $card): ?>
                        <div class="col-md-6">
                            <div class="corporate-card">
                                <div class="icon-wrap"><i class="<?php echo $card['icon']; ?>"></i></div>
                                <h5 class="fw-800"><?php echo $card['title']; ?></h5>
                                <ul class="list-unstyled small text-muted mt-3">
                                    <?php foreach($card['content'] as $item): ?>
                                    <li class="mb-2 d-flex gap-2"><i class="fas fa-circle text-primary mt-1" style="font-size: 0.4rem;"></i> <?php echo $item; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kegiatan Gallery -->
    <section id="kegiatan" class="section-padding bg-soft">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div>
                    <h6 class="text-primary fw-800 text-uppercase mb-3">Portfolio Kegiatan</h6>
                    <h2 class="fw-800">Aksi Nyata Dalam <span class="text-primary">Masyarakat</span></h2>
                </div>
                <a href="#" class="btn btn-outline-primary fw-700 px-4 rounded-3 d-none d-md-block">Lihat Semua Kegiatan</a>
            </div>

            <div class="row g-4">
                <?php 
                $kegiatan_images = [
                    'assets/kegiatan/giat (1).jpg',
                    'assets/kegiatan/giat (2).jpg',
                    'assets/kegiatan/giat (3).jpg'
                ];
                foreach($kegiatan_images as $index => $img): 
                ?>
                <div class="col-md-4">
                    <div class="corporate-card p-0 overflow-hidden">
                        <img src="<?php echo $img; ?>" alt="Giat" class="img-fluid w-100" style="height: 300px; object-fit: cover; transition: transform 0.5s ease;">
                        <div class="p-4">
                            <span class="small text-primary fw-700">Dokumentasi Giat</span>
                            <h6 class="fw-800 mt-2">Patroli Wilayah Terpadu Sektor <?php echo $index + 1; ?></h6>
                            <p class="small text-muted mb-0"><?php echo date('d M Y', strtotime("-$index days")); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Pendaftaran & Kontak -->
    <section id="kontak" class="section-padding">
        <div class="container">
            <div class="row g-5">
                <!-- Kontak Info -->
                <div class="col-lg-4">
                    <h3 class="fw-800 mb-4">Ingin berdiskusi atau mendapat informasi lebih lanjut?</h3>
                    <p class="text-muted mb-5">Tim kami siap membantu menyelaraskan kerjasama keamanan di wilayah Anda.</p>
                    
                    <div class="d-flex gap-4 mb-4">
                        <div class="icon-wrap" style="flex-shrink: 0;"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <h6 class="fw-800 mb-1">Kantor Pusat</h6>
                            <p class="small text-muted"><?php echo $contactData['footer_address']; ?></p>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-4 mb-4">
                        <div class="icon-wrap" style="flex-shrink: 0;"><i class="fas fa-phone"></i></div>
                        <div>
                            <h6 class="fw-800 mb-1">Telepon & WhatsApp</h6>
                            <p class="small text-muted"><?php echo $contactData['phone_display']; ?> (Hotline)</p>
                        </div>
                    </div>

                    <div class="d-flex gap-4">
                        <div class="icon-wrap" style="flex-shrink: 0;"><i class="fas fa-envelope"></i></div>
                        <div>
                            <h6 class="fw-800 mb-1">Email Resmi</h6>
                            <p class="small text-muted"><?php echo $contactData['email']; ?></p>
                        </div>
                    </div>
                </div>

                <!-- Formulir Pendaftaran -->
                <div class="col-lg-8" id="pendaftaran">
                    <div class="corporate-card p-5">
                        <h4 class="fw-800 mb-4">Formulir Kemitraan Strategis</h4>
                        <form id="reg-web-form">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-700">Nama Lengkap Sesuai KTP</label>
                                    <input type="text" name="full_name" class="form-control bg-light border-0 py-3 rounded-3" placeholder="Contoh: Budi Santoso" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-700">Email Aktif</label>
                                    <input type="email" name="email" class="form-control bg-light border-0 py-3 rounded-3" placeholder="email@contoh.com" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-700">Unggah Scan Formulir (PDF/JPG)</label>
                                    <div class="bg-light p-4 rounded-3 border-2 border-dashed border-secondary text-center">
                                        <input type="file" name="reg_file" class="form-control" hidden id="fileInput">
                                        <label for="fileInput" class="mb-0 cursor-pointer">
                                            <i class="fas fa-cloud-upload-alt text-primary mb-2" style="font-size: 2rem;"></i>
                                            <p class="mb-0 fw-600">Pilih berkas atau tarik ke sini</p>
                                            <p class="small text-muted mb-0">Maksimal berkas 5MB</p>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-cta bg-primary text-white w-100 py-3">Kirim Pendaftaran Sekarang</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Corporate -->
    <footer class="corporate-footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <img src="assets/image.png" alt="Logo" class="footer-logo">
                    <h5 class="text-white fw-800">POKDAR KAMTIBMAS</h5>
                    <p class="small opacity-75">Kelompok Sadar Keamanan dan Ketertiban Masyarakat wilayah hukum Polres Tangerang Selatan. Menjadi garda terdepan kemitraan masyarakat dan POLRI.</p>
                    <div class="mt-4">
                        <?php foreach($contactData['social'] as $social): ?>
                        <a href="<?php echo $social['link']; ?>" class="social-circle"><i class="<?php echo $social['icon']; ?>"></i></a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-lg-2 ms-auto">
                    <h6 class="footer-title">Navigasi</h6>
                    <ul class="footer-links">
                        <li><a href="#home">Beranda</a></li>
                        <li><a href="#about">Sejarah</a></li>
                        <li><a href="#organisasi">Organisasi</a></li>
                        <li><a href="#kegiatan">Kegiatan</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="footer-title">Bantuan</h6>
                    <ul class="footer-links">
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#kontak">Kontak Kami</a></li>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="footer-title">Berlangganan News</h6>
                    <p class="small mb-3">Dapatkan update keamanan wilayah langsung ke email Anda.</p>
                    <div class="input-group">
                        <input type="text" class="form-control bg-white bg-opacity-10 border-0 text-white" placeholder="Email Anda">
                        <button class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
            <hr class="my-5 border-white opacity-10">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small mb-0 text-white opacity-50">&copy; <?php echo date('Y'); ?> Pokdar Kamtibmas. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="small mb-0 text-white opacity-50">Modern Corporate Experience.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Intersection Observer for Reveal Animations
            const revealOptions = {
                threshold: 0.15,
                rootMargin: "0px 0px -50px 0px"
            };

            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, revealOptions);

            // Targets for reveal - Simplified selector for better performance
            const targets = document.querySelectorAll('.animate-up, .corporate-card');
            targets.forEach(t => {
                t.classList.add('reveal-prep');
                revealObserver.observe(t);
            });

            // Navbar scroll background
            window.addEventListener('scroll', () => {
                const nav = document.querySelector('.header-ugm');
                if (nav) {
                    if (window.scrollY > 50) {
                        nav.classList.add('nav-scrolled');
                    } else {
                        nav.classList.remove('nav-scrolled');
                    }
                }
            }, { passive: true });
        });
    </script>
</body>

</html>
