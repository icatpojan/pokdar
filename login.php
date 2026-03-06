<?php
session_start();

// If already logged in, redirect to admin
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $isAjax = isset($_POST['ajax']);

    $loginSuccess = false;
    $msg = '';

    // Check Admin data
    $adminFile = 'data/admin.json';
    if (file_exists($adminFile)) {
        $adminData = json_decode(file_get_contents($adminFile), true) ?: [];
        foreach ($adminData as $a) {
            if ($a['username'] === $username && $a['password'] === $password) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $username;
                $_SESSION['user_role'] = 'admin';
                $loginSuccess = true;
                break;
            }
        }
    }
    
    // Check Kasektor data
    if (!$loginSuccess) {
        $kasektorFile = 'data/kasektor.json';
        if (file_exists($kasektorFile)) {
            $kasektorData = json_decode(file_get_contents($kasektorFile), true) ?: [];
            foreach ($kasektorData as $k) {
                if ($k['name'] === $username && $k['password'] === $password) {
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_username'] = $username;
                    $_SESSION['user_role'] = 'kasektor';
                    $_SESSION['user_sector'] = $k['sector'] ?? '';
                    $loginSuccess = true;
                    break;
                }
            }
        }
    }

    // Check Karesort data
    if (!$loginSuccess) {
        $karesortFile = 'data/karesort.json';
        if (file_exists($karesortFile)) {
            $karesortData = json_decode(file_get_contents($karesortFile), true) ?: [];
            foreach ($karesortData as $kr) {
                if ($kr['name'] === $username && $kr['password'] === $password) {
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_username'] = $username;
                    $_SESSION['user_role'] = 'karesort';
                    $_SESSION['user_sector'] = $kr['sector'] ?? 'all';
                    $loginSuccess = true;
                    break;
                }
            }
        }
    }

    if ($loginSuccess) {
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Login Berhasil!']);
            exit();
        }
        header("Location: admin.php");
        exit();
    } else {
        $msg = 'Username atau Password salah!';
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $msg]);
            exit();
        }
        $error = $msg;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pokdar Kamtibmas</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .login-status {
            display: none;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 600;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4 py-5">
                <div class="card border-0 shadow-lg rounded-4 animate-up p-4 p-md-5 bg-white">
                    <div class="text-center mb-4">
                        <a href="index.php">
                            <img src="assets/image.png" alt="Logo" class="mb-3" style="height: 70px;">
                        </a>
                        <h2 class="fw-bold h3 mb-2">Login</h2>
                        <p class="text-muted small">Silakan masuk untuk mengelola data keanggotaan.</p>
                    </div>

                    <div id="loginStatus" class="login-status"></div>

                    <?php if ($error): ?>
                        <div id="phpError" class="alert alert-danger border-0 rounded-3 py-2 px-3 mb-4 small fw-bold">
                            ⚠️ <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form id="loginForm" action="login.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Username</label>
                            <input type="text" name="username" class="form-control form-control-lg rounded-3 fs-6" placeholder="Masukkan username" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Password</label>
                            <div class="position-relative">
                                <input type="password" name="password" id="passwordInput" class="form-control form-control-lg rounded-3 fs-6 pe-5" placeholder="Masukkan password" required>
                                <button type="button" id="togglePassword" class="btn position-absolute top-50 end-0 translate-middle-y border-0 pe-3 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8s0 8 0 8 3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="submit" id="btnLogin" class="btn btn-accent btn-lg w-100 rounded-pill fw-bold text-dark mb-4 py-2 fs-6">Masuk Sekarang</button>
                    </form>

                    <div class="text-center mt-2">
                        <a href="index.php" class="text-decoration-none text-muted small hover-primary transition">&larr; Kembali ke Beranda</a>
                    </div>
                </div>
                <p class="text-center mt-4 text-muted small opacity-50">&copy; 2026 Pokdar Kamtibmas Polres Tangerang Selatan</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('passwordInput');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('text-primary');
        });

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const btn = document.getElementById('btnLogin');
            const statusDiv = document.getElementById('loginStatus');
            const phpError = document.getElementById('phpError');
            
            if (phpError) phpError.style.display = 'none';
            
            const formData = new FormData(form);
            formData.append('ajax', '1');
            
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
            
            fetch('login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    statusDiv.innerHTML = '✅ ' + data.message;
                    statusDiv.className = 'login-status bg-success-subtle text-success d-block';
                    
                    setTimeout(() => {
                        statusDiv.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Redirecting...';
                        setTimeout(() => {
                            window.location.href = 'admin.php';
                        }, 1000);
                    }, 800);
                } else {
                    statusDiv.innerHTML = '⚠️ ' + data.message;
                    statusDiv.className = 'login-status bg-danger-subtle text-danger d-block';
                    btn.disabled = false;
                    btn.innerHTML = 'Masuk Sekarang';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                statusDiv.innerHTML = '⚠️ Terjadi kesalahan sistem.';
                statusDiv.className = 'login-status bg-danger-subtle text-danger d-block';
                btn.disabled = false;
                btn.innerHTML = 'Masuk Sekarang';
            });
        });
    </script>
</body>
</html>
