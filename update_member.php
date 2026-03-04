<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataFile = 'data/pendaftaran.json';
    $data = json_decode(file_get_contents($dataFile), true);
    
    $regNumber = $_POST['reg_number'];
    $found = false;

    foreach ($data as &$row) {
        if ($row['reg_number'] === $regNumber) {
            $row['full_name'] = $_POST['full_name'] ?? $row['full_name'];
            $row['gender'] = $_POST['gender'] ?? $row['gender'];
            $row['sector'] = $_POST['sector'] ?? $row['sector'];
            $row['subsector'] = $_POST['subsector'] ?? $row['subsector'];
            $row['address'] = $_POST['address'] ?? $row['address'];
            
            // New fields
            $row['birth_place'] = $_POST['birth_place'] ?? ($row['birth_place'] ?? '');
            $row['birth_date'] = $_POST['birth_date'] ?? ($row['birth_date'] ?? '');
            $row['education'] = $_POST['education'] ?? ($row['education'] ?? '');
            $row['occupation'] = $_POST['occupation'] ?? ($row['occupation'] ?? '');
            $row['nik'] = $_POST['nik'] ?? ($row['nik'] ?? '');
            $row['phone'] = $_POST['phone'] ?? ($row['phone'] ?? '');
            $row['no_anggota'] = $_POST['no_anggota'] ?? ($row['no_anggota'] ?? '');
            $row['position'] = $_POST['position'] ?? ($row['position'] ?? '');
            $row['call_code'] = $_POST['call_code'] ?? ($row['call_code'] ?? '');
            $row['card_recommendation'] = $_POST['card_recommendation'] ?? ($row['card_recommendation'] ?? '');
            $row['approval'] = $_POST['approval'] ?? ($row['approval'] ?? '');

            // Handle Photo Upload
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                $fileExtension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $newFileName = time() . '_' . rand(1000, 9999) . '.' . $fileExtension;
                $targetFile = $uploadDir . $newFileName;
                
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                    $row['photo_path'] = $targetFile; // Update path to member photo specifically
                }
            }

            // Update status if present in POST
            if (isset($_POST['status'])) {
                $row['status'] = $_POST['status'];
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
