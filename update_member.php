<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if POST data is empty but content-length is large
    $contentLength = (int)($_SERVER['CONTENT_LENGTH'] ?? 0);
    if (empty($_POST) && $contentLength > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Ukuran file mungkin terlalu besar (Maksimum server terlampaui)']);
        exit;
    }

    $dataFile = 'data/pendaftaran.json';
    $data = json_decode(file_get_contents($dataFile), true);
    
    $regNumber = $_POST['reg_number'];
    $found = false;

    foreach ($data as &$row) {
        if ($row['reg_number'] === $regNumber) {

            // Partial update: only overwrite fields that are explicitly sent in POST
            $updatableFields = [
                'full_name', 'gender', 'sector', 'subsector', 'address',
                'birth_place', 'birth_date', 'education', 'occupation',
                'nik', 'phone', 'no_anggota', 'position', 'call_code',
                'card_recommendation', 'approval', 'status',
                'member_type', 'rekomendasi_alasan', 'rekomendasi_status',
                'file_path'
            ];
            foreach ($updatableFields as $field) {
                if (array_key_exists($field, $_POST)) {
                    $row[$field] = $_POST[$field];
                }
            }
            // Penilaian is a JSON object
            if (isset($_POST['penilaian'])) {
                $decoded = json_decode($_POST['penilaian'], true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $row['penilaian'] = $decoded;
                }
            }

            // Handle Photo Upload
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                $fileExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $newFileName = time() . '_img_' . rand(1000, 9999) . '.' . $fileExtension;
                $targetFile = $uploadDir . $newFileName;
                
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                    $row['photo_path'] = $targetFile;
                }
            }

            // Handle Registration File Upload
            if (isset($_FILES['reg_file']) && $_FILES['reg_file']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                $fileExtension = pathinfo($_FILES['reg_file']['name'], PATHINFO_EXTENSION);
                $newFileName = time() . '_ref_' . rand(1000, 9999) . '.' . $fileExtension;
                $targetFile = $uploadDir . $newFileName;
                
                if (move_uploaded_file($_FILES['reg_file']['tmp_name'], $targetFile)) {
                    $row['file_path'] = $targetFile;
                }
            }

            $found = true;
            break;
        }
    }

    if ($found) {
        if (file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT))) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menulis ke database']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
    }
}
?>
