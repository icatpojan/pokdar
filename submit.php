<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataFile = 'data/pendaftaran.json';
    
    // Ensure file exists
    if (!file_exists($dataFile)) {
        file_put_contents($dataFile, json_encode([]));
    }

    // Get current data
    $currentData = json_decode(file_get_contents($dataFile), true);
    if (!is_array($currentData)) {
        $currentData = [];
    }

    // Collect data from POST
    $newData = [
        'reg_number' => $_POST['reg_number'] ?? 'N/A',
        'full_name' => $_POST['full_name'] ?? 'N/A',
        'address' => $_POST['address'] ?? 'N/A',
        'gender' => $_POST['gender'] ?? 'N/A',
        'sector' => $_POST['sector'] ?? 'N/A',
        'subsector' => $_POST['subsector'] ?? 'N/A',
        'birth_place' => $_POST['birth_place'] ?? '',
        'birth_date' => $_POST['birth_date'] ?? '',
        'education' => $_POST['education'] ?? '',
        'occupation' => $_POST['occupation'] ?? '',
        'nik' => $_POST['nik'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'no_anggota' => $_POST['no_anggota'] ?? '',
        'position' => $_POST['position'] ?? '',
        'call_code' => $_POST['call_code'] ?? '',
        'card_recommendation' => $_POST['card_recommendation'] ?? '',
        'status' => $_POST['status'] ?? 'Pending',
        'timestamp' => date('Y-m-d H:i:s')
    ];

    // Handle Registration Attachment
    if (isset($_FILES['reg_file']) && $_FILES['reg_file']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = time() . "_ref_" . basename($_FILES["reg_file"]["name"]);
        if (move_uploaded_file($_FILES["reg_file"]["tmp_name"], $targetDir . $fileName)) {
            $newData['file_path'] = $targetDir . $fileName;
        }
    }

    // Handle Profile Photo
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = time() . "_img_" . basename($_FILES["photo"]["name"]);
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetDir . $fileName)) {
            $newData['photo_path'] = $targetDir . $fileName;
        }
    }

    // Add new data and save
    $currentData[] = $newData;
    if (file_put_contents($dataFile, json_encode($currentData, JSON_PRETTY_PRINT))) {
        echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
}
?>
