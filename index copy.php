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
$sekretariat = $structureData['sekretariat'];
$bendahara = $structureData['bendahara'];
$pelaksana = $structureData['pelaksana'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokdar Kamtibmas - Polres Tangerang Selatan</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css?v=3.0">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg custom-navbar navbar-transparent fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#home">
                <img src="assets/image.png" alt="Logo" class="logo-img" style="height: 45px;">
                <div class="logo-text d-flex flex-column">
                    <span class="main-title fw-bold" style="font-size: 1.1rem; letter-spacing: 1px; color: #2c3e50;">POKDAR KAMTIBMAS</span>
                    <span class="sub-title" style="color: #ccac00; font-size: 0.8rem;">Polres Tangerang Selatan</span>
                </div>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars" style="color: #2c3e50;"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#organisasi">Organisasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kegiatan">Kegiatan</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="#pengurus">Pengurus</a></li> -->
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                    <li class="nav-item ms-lg-3"><a href="login.php" class="nav-link fw-bold">Login</a></li>
                    <li class="nav-item"><a href="#pendaftaran" class="btn btn-accent ms-lg-2">Registrasi</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Three.js -->
    <section id="home" class="hero">
        <canvas id="three-canvas"></canvas>
        <div class="decor-shape shape-1"></div>
        <div class="decor-shape shape-2"></div>
        
        <div class="container hero-content">
            <div class="row align-items-center py-5" style="min-height: 80vh;">
                <div class="col-lg-6 mb-5 mb-lg-0 text-center text-lg-start position-relative">
                    <div class="floating-badge d-none d-lg-flex" style="top: -60px; left: 0;">
                        <i class="fas fa-shield-alt text-accent"></i>
                        <span class="small fw-bold"><?php echo $heroData['badge']; ?></span>
                    </div>
                    
                    <h5 class="text-accent fw-bold mb-3"><?php echo $heroData['welcome_text']; ?></h5>
                    <h1 class="display-3 fw-bold mb-4" style="line-height: 1.1; color: #2c3e50;"><?php echo $heroData['title_primary']; ?></h1>
                    <p class="lead text-muted mb-5"><?php echo $heroData['lead_text']; ?></p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                        <?php foreach($heroData['buttons'] as $btn): ?>
                        <a href="<?php echo $btn['link']; ?>" class="<?php echo $btn['class']; ?>"><?php echo $btn['text']; ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-lg-6 position-relative">
                    <div class="floating-badge d-none d-lg-flex shadow-lg" style="bottom: -20px; right: 20px; background: var(--accent); border: none;">
                        <i class="fas fa-handshake text-dark"></i>
                        <span class="small fw-bold text-dark">Sinergi Masyarakat</span>
                    </div>
                    <div class="video-wrapper">
                        <!-- Placeholder for Intro Video -->
                        <div class="ratio ratio-16x9">
                            <iframe src="<?php echo $heroData['video_link']; ?>" title="Video Perkenalan Pokdar" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Stats Bar -->
    <div class="stats-bar">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <?php foreach($statsData as $stat): ?>
                <div class="col-6 col-md-3">
                    <div class="stat-card-item fade-up">
                        <div class="stat-icon-wrapper">
                            <i class="<?php echo $stat['icon']; ?>"></i>
                        </div>
                        <span class="stat-number"><?php echo $stat['number']; ?></span>
                        <span class="stat-label"><?php echo $stat['label']; ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Tentang Section -->
    <section id="tentang" class="section-padding">
        <div class="container">
            <div class="section-title text-center mb-5">
                <span class="badge bg-accent text-dark px-3 py-2 mb-3"><?php echo $tentangData['badge']; ?></span>
                <h2 class="fade-up fw-bold"><?php echo $tentangData['title']; ?></h2>
                <div class="mx-auto mt-2" style="width: 50px; height: 3px; background: var(--accent);"></div>
            </div>

            <!-- Mobile Carousel for Tentang -->
            <div id="tentangCarousel" class="carousel slide d-md-none mb-5" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach($tentangData['cards'] as $index => $card): ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <div class="premium-card text-center">
                            <div class="icon-box-sm mb-3 mx-auto">
                                <i class="<?php echo $card['icon']; ?> text-accent"></i>
                            </div>
                            <h6 class="fw-bold"><?php echo $card['title']; ?></h6>
                            <hr class="accent-line mx-auto">
                            <div class="small text-muted">
                                <?php if(isset($card['mobile_intro'])): ?>
                                <p class="small text-muted mb-3"><?php echo $card['mobile_intro']; ?></p>
                                <?php endif; ?>

                                <?php if(isset($card['mobile_content'])): ?>
                                    <?php foreach($card['mobile_content'] as $line): ?>
                                    <p class="mb-2"><?php echo $line; ?></p>
                                    <?php endforeach; ?>
                                <?php elseif(isset($card['content'])): ?>
                                    <ul class="small text-muted ps-3 mb-0 text-start <?php echo isset($card['is_list']) ? '' : 'list-unstyled'; ?>">
                                        <?php foreach($card['content'] as $line): ?>
                                        <li class="mb-1"><?php echo $line; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>

                                <?php if(isset($card['buttons'])): ?>
                                <div class="d-grid gap-2 mt-3">
                                    <?php foreach($card['buttons'] as $btn): ?>
                                    <a href="<?php echo $btn['link']; ?>" class="<?php echo $btn['class']; ?>"><?php echo $btn['text']; ?></a>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="carousel-indicators position-relative mt-3 mb-0">
                    <?php foreach($tentangData['cards'] as $index => $card): ?>
                    <button type="button" data-bs-target="#tentangCarousel" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>" aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>" style="background-color: var(--accent);"></button>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#tentangCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#tentangCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>

            <div class="row g-4 mb-5 d-none d-md-flex">
                <?php foreach($tentangData['cards'] as $card): ?>
                <div class="col-lg-3 col-md-6">
                    <div class="premium-card h-100 fade-up">
                        <div class="icon-box-sm mb-3">
                            <i class="<?php echo $card['icon']; ?> text-accent"></i>
                        </div>
                        <h6 class="fw-bold"><?php echo $card['title']; ?></h6>
                        <hr class="accent-line">
                        <div class="small text-muted">
                            <?php if(isset($card['full_intro'])): ?>
                            <p class="small text-muted mb-2"><?php echo $card['full_intro']; ?></p>
                            <?php endif; ?>

                            <?php if(isset($card['full_content'])): ?>
                                <ul class="small text-muted ps-3 mb-0 <?php echo isset($card['is_list']) ? '' : 'list-unstyled'; ?>">
                                    <?php foreach($card['full_content'] as $line): ?>
                                    <li class="mb-1"><?php echo $line; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php elseif(isset($card['content'])): ?>
                                <ul class="small text-muted ps-3 mb-3 list-unstyled">
                                    <?php foreach($card['content'] as $line): ?>
                                    <li><?php echo $line; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <?php if(isset($card['buttons'])): ?>
                            <div class="d-grid gap-2 mt-3">
                                <?php foreach($card['buttons'] as $btn): ?>
                                <a href="<?php echo $btn['link']; ?>" class="<?php echo $btn['class']; ?>"><?php echo $btn['text']; ?></a>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Sejarah Section -->
            <div class="row align-items-center mt-5 pt-lg-5">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="position-relative fade-up">
                        <img src="assets/pokdar.png" alt="Sejarah Pokdar" class="img-fluid rounded-4 shadow-lg">
                        <div class="accent-box d-none d-md-block"></div>
                    </div>
                </div>
                <div class="col-lg-7 ps-lg-5 text-center text-lg-start">
                    <div class="section-title mb-4">
                        <h6 class="text-accent fw-bold mb-2">SEJARAH BERDIRI</h6>
                        <h3 class="fade-up fw-semibold"><?php echo $sejarahData['title_highlight']; ?></h3>
                        <p class="text-muted small mt-3 italic">
                            <?php echo $sejarahData['description']; ?>
                        </p>
                    </div>
                    
                    <div class="timeline-simple mt-4 text-start">
                        <?php foreach($sejarahData['timeline'] as $item): ?>
                        <div class="timeline-item fade-up">
                            <div class="time-marker"></div>
                            <div class="time-content">
                                <h6 class="fw-bold mb-1"><?php echo $item['title']; ?></h6>
                                <p class="small text-muted mb-0"><?php echo $item['content']; ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Organisasi & Struktur Section -->
    <section id="organisasi" class="section-padding bg-alt overflow-hidden">
        <div class="container text-center">
            <div class="section-title mb-5">
                <span class="badge bg-accent text-dark px-3 py-2 mb-3">STRUKTUR ORGANISASI</span>
                <h2 class="fade-up fw-bold">Struktur <span class="text-accent">Kepengurusan</span></h2>
                <p class="text-muted fade-up">Periode Tahun 2022 - 2027</p>
            </div>
            
            <!-- Dewan-Dewan Supporting -->
            <div class="row justify-content-center g-3 mb-5">
                <div class="col-6 col-lg-3">
                    <div class="board-card fade-up">
                        <div class="board-title"><?php echo $structureData['pendukung']['pembina']; ?></div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="board-card fade-up">
                        <div class="board-title"><?php echo $structureData['pendukung']['penasehat']; ?></div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="board-card fade-up">
                        <div class="board-title"><?php echo $structureData['pendukung']['kehormatan']; ?></div>
                    </div>
                </div>
            </div>

            <!-- Pimpinan Utama -->
            <div class="leadership-top mb-5">
                <div class="row justify-content-center g-4">
                    <div class="col-lg-4">
                        <div class="structure-card main-leader fade-up">
                            <div class="card-badge">KETUA</div>
                            <img src="assets/user.png" alt="Ketua" class="mb-3">
                            <h5 class="fw-bold mb-1"><?php echo $pimpinan['ketua']['name']; ?></h5>
                            <p class="text-accent small fw-bold mb-0"><?php echo $pimpinan['ketua']['position']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center g-3 mt-2">
                    <?php foreach ($pimpinan['wakil_ketua'] as $wakil): ?>
                    <div class="col-6 col-lg-3">
                        <div class="structure-card sub-leader fade-up">
                            <div class="card-badge-small">WAKIL KETUA</div>
                            <h6 class="fw-bold mb-1"><?php echo $wakil['name']; ?></h6>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Sekretariat & Bendahara -->
            <div class="row justify-content-center g-4 mb-5">
                <div class="col-md-5">
                    <div class="structure-card fade-up h-100">
                        <div class="card-category">SEKRETARIAT</div>
                        <div class="py-2">
                            <p class="mb-1 fw-bold"><?php echo $sekretariat['sekretaris']['name']; ?></p>
                            <span class="badge bg-accent text-dark rounded-pill px-3">Sekretaris</span>
                        </div>
                        <hr class="my-2 opacity-10">
                        <div class="py-2">
                            <p class="mb-1"><?php echo $sekretariat['wakil_sekretaris']['name']; ?></p>
                            <span class="text-muted small">Wakil Sekretaris</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="structure-card fade-up h-100">
                        <div class="card-category">BENDAHARA</div>
                        <div class="py-2">
                            <p class="mb-1 fw-bold"><?php echo $bendahara['bendahara']['name']; ?></p>
                            <span class="badge bg-accent text-dark rounded-pill px-3">Bendahara</span>
                        </div>
                        <hr class="my-2 opacity-10">
                        <div class="py-2">
                            <p class="mb-1"><?php echo $bendahara['wakil_bendahara']['name']; ?></p>
                            <span class="text-muted small">Wakil Bendahara</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Unsur Pelaksana -->
            <h5 class="fw-bold mb-4 fade-up">UNSUR PELAKSANA</h5>
            <div class="row g-3 justify-content-center">
                <?php foreach ($pelaksana as $item): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="dept-card fade-up">
                        <div class="dept-name"><?php echo $item['dept']; ?></div>
                        <div class="dept-info p-3">
                            <p class="mb-1 fw-bold small"><?php echo $item['lead']; ?></p>
                            <hr class="my-1">
                            <p class="mb-0 text-muted" style="font-size: 0.75rem;"><?php echo $item['sub']; ?></p>
                            <span class="text-accent" style="font-size: 0.7rem;">Wakil</span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Footer Struktur -->
            <div class="mt-5 fade-up">
                <div class="bg-accent text-dark fw-bold p-3 rounded-pill shadow-sm d-inline-block px-5">
                    <?php echo $structureData['footer_title']; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Kegiatan Section (Gallery) -->
    <section id="kegiatan" class="section-padding">
        <div class="container">
            <div class="section-title text-center mb-5">
                <span class="badge bg-accent text-dark px-3 py-2 mb-3"><?php echo $kegiatanData['badge']; ?></span>
                <h2 class="fade-up fw-bold"><?php echo $kegiatanData['title_primary']; ?></h2>
                <p class="text-muted"><?php echo $kegiatanData['lead_text']; ?></p>
            </div>
            <!-- Mobile Carousel for Kegiatan -->
            <div id="kegiatanCarousel" class="carousel slide d-md-none" data-bs-ride="carousel">
                <div class="carousel-inner rounded-4 shadow-sm">
                    <?php 
                    $first = true;
                    foreach($kegiatanData['images'] as $img): 
                    ?>
                    <div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
                        <div class="gallery-item mb-0" style="aspect-ratio: 4/3;">
                            <img src="<?php echo $img; ?>" alt="Kegiatan Pokdar" class="img-fluid w-100 h-100 object-fit-cover">
                        </div>
                    </div>
                    <?php 
                    $first = false;
                    endforeach; 
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#kegiatanCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#kegiatanCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>

            <div class="row g-4 d-none d-md-flex">
                <?php 
                foreach($kegiatanData['images'] as $img): 
                ?>
                <div class="col-md-4 col-sm-6">
                    <div class="gallery-item fade-up shadow-sm">
                        <img src="<?php echo $img; ?>" alt="Kegiatan Pokdar" class="img-fluid rounded-4">
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

     <!-- Pendaftaran Section - Clean & White -->
    <section id="pendaftaran" class="pendaftaran-section section-padding">
        <div class="container">
            <div class="section-title text-center mb-5">
                <span class="badge bg-accent text-dark px-3 py-2 mb-3"><?php echo $regData['badge']; ?></span>
                <h2 class="fade-up fw-bold"><?php echo $regData['title_highlight']; ?></h2>
                <p class="text-muted mt-4"><?php echo $regData['description']; ?></p>
            </div>

            <div class="row g-4 align-items-stretch">
                <!-- Simple Download Card -->
                <div class="col-lg-5">
                    <div class="download-card-simple fade-up">
                        <h4 class="fw-bold mb-4">1. Unduh Formulir</h4>
                        <p class="text-muted mb-4">Silakan unduh template resmi pendaftaran dan lengkapi data diri Anda.</p>
                        
                        <div class="benefits-list-simple mb-4">
                            <div class="benefit-item-simple">
                                <i class="fas fa-check-circle benefit-icon-simple"></i>
                                <span>Format PDF Resmi Pokdar</span>
                            </div>
                            <div class="benefit-item-simple">
                                <i class="fas fa-check-circle benefit-icon-simple"></i>
                                <span>Panduan Pengisian Lengkap</span>
                            </div>
                            <div class="benefit-item-simple">
                                <i class="fas fa-check-circle benefit-icon-simple"></i>
                                <span>Informasi Persyaratan</span>
                            </div>
                        </div>

                        <a href="<?php echo $regData['template_doc']['url']; ?>" download class="premium-btn-download">
                            <i class="fas fa-file-download"></i>
                            <span><?php echo $regData['template_doc']['name']; ?></span>
                        </a>
                    </div>
                </div>

                <!-- Simple Upload Card -->
                <div class="col-lg-7">
                    <div class="upload-card-white fade-up">
                        <h4 class="fw-bold mb-4">2. Kirim Berkas</h4>
                        <form id="reg-web-form">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="small fw-bold mb-2 ms-1">Nama Lengkap</label>
                                    <input type="text" name="full_name" class="form-control form-input-clean" placeholder="Nama Sesuai KTP" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small fw-bold mb-2 ms-1">Alamat Email</label>
                                    <input type="email" name="email" class="form-control form-input-clean" placeholder="Email Aktif" required>
                                </div>
                                <div class="col-12">
                                    <div class="upload-zone-clean" id="drop-area">
                                        <input type="file" name="reg_file" id="fileElem" accept=".pdf,.doc,.docx,.jpg,.png" hidden required>
                                        <label for="fileElem" class="w-100 mb-0 cursor-pointer">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <h5 class="fw-bold mb-1">Klik atau Tarik File</h5>
                                            <p class="text-muted small mb-0" id="file-name-display">Scan formulir & KTP (PDF/JPG/PNG, Maks 5MB)</p>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn-submit-clean">
                                        <i class="fas fa-paper-plane me-2"></i> Kirim Pengajuan Keanggotaan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section-padding bg-alt">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="section-title text-center mb-5">
                        <span class="badge bg-accent text-dark px-3 py-2 mb-3">FAQ</span>
                        <h2 class="fade-up fw-bold">Pertanyaan <span class="text-accent">Sering Diajukan</span></h2>
                        <p class="text-muted">Mengenal lebih dalam tentang Pokdarkamtibmas Bhayangkara</p>
                    </div>
                    <div class="accordion" id="faqAccordion">
                        <?php foreach($faqData as $index => $faq): ?>
                        <div class="accordion-item fade-up shadow-sm mb-3 border-0 rounded-4 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button <?php echo $index === 0 ? '' : 'collapsed'; ?> fw-bold py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?php echo $index; ?>">
                                    <?php echo $faq['question']; ?>
                                </button>
                            </h2>
                            <div id="faq<?php echo $index; ?>" class="accordion-collapse collapse <?php echo $index === 0 ? 'show' : ''; ?>" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted lh-lg">
                                    <?php echo $faq['answer']; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

   

    <!-- Kontak Section -->
    <section id="kontak" class="section-padding">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5">
                    <div class="section-title mb-4 text-center text-lg-start">
                        <h2 class="fade-up text-center text-lg-start">Hubungi Kami</h2>
                        <p class="text-muted">Kami siap mendengarkan aspirasi dan koordinasi anda.</p>
                    </div>
                    <div class="contact-info">
                        <div class="d-flex flex-column flex-lg-row align-items-center mb-4 fade-up text-center text-lg-start">
                            <div class="btn-accent rounded-circle d-flex align-items-center justify-content-center mb-3 mb-lg-0 me-lg-3" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Alamat</h6>
                                <p class="text-muted mb-0"><?php echo $contactData['map_address']; ?></p>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-lg-row align-items-center mb-4 fade-up text-center text-lg-start">
                            <div class="btn-accent rounded-circle d-flex align-items-center justify-content-center mb-3 mb-lg-0 me-lg-3" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Email</h6>
                                <p class="text-muted mb-0"><?php echo $contactData['email']; ?></p>
                            </div>
                        </div>
                        <div class="mt-5 text-center text-lg-start">
                            <h6 class="fw-bold mb-3 fade-up">Instansi Terkait & Mitra</h6>
                            <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3 fade-up">
                                <?php foreach($contactData['partners'] as $p): ?>
                                <img src="<?php echo $p; ?>" style="height: 35px; opacity: 0.7;">
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="premium-card fade-up">
                        <form id="contact-form">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Nama Lengkap</label>
                                    <input type="text" class="form-control rounded-3" placeholder="Nama Anda" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Alamat Email</label>
                                    <input type="email" class="form-control rounded-3" placeholder="Email Anda" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Pesan</label>
                                    <textarea class="form-control rounded-3" rows="5" placeholder="Tuliskan pesan anda..." required></textarea>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-accent w-100 mt-3">Kirim Pesan Sekarang</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 bg-dark text-white">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <h5 class="fw-bold mb-3"><?php echo $contactData['phone_display']; ?></h5>
                    <p class="small opacity-50 mb-0"><?php echo $contactData['footer_address']; ?></p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="sosmed-links fs-4 mb-3">
                        <?php foreach($contactData['social'] as $social): ?>
                        <a href="<?php echo $social['link']; ?>" class="text-white me-3"><i class="<?php echo $social['icon']; ?>"></i></a>
                        <?php endforeach; ?>
                    </div>
                    <p class="mb-0 small opacity-50">&copy; <?php echo date('Y'); ?> Pokdar Kamtibmas. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating -->
    <a href="https://wa.me/<?php echo $contactData['phone_wa']; ?>" class="wa-float" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
