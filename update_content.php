<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? '';
    
    $allowedTypes = ['hero', 'stats', 'tentang', 'sejarah', 'kegiatan', 'faq', 'contact', 'registrasi', 'news', 'structure', 'jadwal_kegiatan'];
    
    if (in_array($type, $allowedTypes)) {
        if (isset($_POST['action']) && $_POST['action'] === 'upload') {
            if (!isset($_FILES['file'])) {
                echo json_encode(['status' => 'error', 'message' => 'Tidak ada file diunggah']);
                exit();
            }

            $file = $_FILES['file'];
            $targetDir = "assets/kegiatan/";
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = "giat_" . time() . "_" . rand(1000, 9999) . "." . $ext;
            $targetPath = $targetDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                echo json_encode(['status' => 'success', 'path' => $targetPath]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan file']);
            }
            exit();
        }

        $dataFile = "data/$type.json";
        $data = json_decode($_POST['data'], true);
        if (file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))) {
            echo json_encode(['status' => 'success', 'message' => ucfirst($type) . ' berhasil diperbarui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data ' . $type]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Tipe data tidak valid']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
}
?>
