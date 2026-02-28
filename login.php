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

    // Hardcoded credentials for simplicity as requested
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: admin.php");
        exit();
    } else {
        $error = 'Username atau Password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Pokdar Kamtibmas</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
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
                        <h2 class="fw-bold h3 mb-2">Login Admin</h2>
                        <p class="text-muted small">Silakan masuk untuk mengelola data keanggotaan.</p>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger border-0 rounded-3 py-2 px-3 mb-4 small fw-bold">
                            ⚠️ <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">
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
                        <button type="submit" class="btn btn-accent btn-lg w-100 rounded-pill fw-bold text-dark mb-4 py-2 fs-6">Masuk Sekarang</button>
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
            
            // Toggle orientation of the eye icon (optional: change icon to eye-slash)
            this.classList.toggle('text-primary');
        });
    </script>
</body>
</html>
