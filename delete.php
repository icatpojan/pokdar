<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true || ($_SESSION['user_role'] ?? '') !== 'admin') {
    if (isset($_GET['ajax'])) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    } else {
        header("Location: login.php");
    }
    exit();
}

if (isset($_GET['reg'])) {
    $regNumber = $_GET['reg'];
    $activeFile = 'data/pendaftaran.json';
    $trashFile = 'data/sampah.json';

    // Get active data
    $activeData = json_decode(file_get_contents($activeFile), true);
    $trashData = file_exists($trashFile) ? json_decode(file_get_contents($trashFile), true) : [];

    $foundIndex = -1;
    foreach ($activeData as $index => $row) {
        if ($row['reg_number'] === $regNumber) {
            $foundIndex = $index;
            break;
        }
    }

    if ($foundIndex !== -1) {
        // Move to trash
        $trashData[] = $activeData[$foundIndex];
        unset($activeData[$foundIndex]);
        
        // Re-index array
        $activeData = array_values($activeData);

        file_put_contents($activeFile, json_encode($activeData, JSON_PRETTY_PRINT));
        file_put_contents($trashFile, json_encode($trashData, JSON_PRETTY_PRINT));

        if (isset($_GET['ajax'])) {
            echo json_encode(['status' => 'success']);
            exit();
        }
    }
}

if (isset($_GET['ajax'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not found']);
    exit();
}
header('Location: admin.php');
exit();
?>
