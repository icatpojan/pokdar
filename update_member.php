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
            $row['full_name'] = $_POST['full_name'];
            $row['gender'] = $_POST['gender'];
            $row['sector'] = $_POST['sector'];
            $row['subsector'] = $_POST['subsector'];
            $row['address'] = $_POST['address'];
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
