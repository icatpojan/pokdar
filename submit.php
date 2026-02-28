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
        'timestamp' => date('Y-m-d H:i:s')
    ];

    // Handle File Upload (optional but requested earlier)
    if (isset($_FILES['reg_file'])) {
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = basename($_FILES["reg_file"]["name"]);
        $targetFilePath = $targetDir . time() . "_" . $fileName;
        if (move_uploaded_file($_FILES["reg_file"]["tmp_name"], $targetFilePath)) {
            $newData['file_path'] = $targetFilePath;
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
