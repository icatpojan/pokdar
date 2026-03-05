<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true || ($_SESSION['user_role'] ?? '') !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $regNumber = $_POST['reg_number'] ?? '';
    
    $activeFile = 'data/pendaftaran.json';
    $trashFile = 'data/sampah.json';
    
    $activeData = json_decode(file_get_contents($activeFile), true);
    $trashData = file_exists($trashFile) ? json_decode(file_get_contents($trashFile), true) : [];
    
    if ($action === 'restore') {
        $foundIndex = -1;
        foreach ($trashData as $index => $row) {
            if ($row['reg_number'] === $regNumber) {
                $foundIndex = $index;
                break;
            }
        }
        
        if ($foundIndex !== -1) {
            // Move back to active
            $activeData[] = $trashData[$foundIndex];
            unset($trashData[$foundIndex]);
            $trashData = array_values($trashData);
            
            file_put_contents($activeFile, json_encode($activeData, JSON_PRETTY_PRINT));
            file_put_contents($trashFile, json_encode($trashData, JSON_PRETTY_PRINT));
            
            echo json_encode(['status' => 'success']);
            exit();
        }
    } elseif ($action === 'delete') {
        $foundIndex = -1;
        foreach ($trashData as $index => $row) {
            if ($row['reg_number'] === $regNumber) {
                $foundIndex = $index;
                break;
            }
        }
        
        if ($foundIndex !== -1) {
            // Delete file if exists
            $filePath = $trashData[$foundIndex]['file_path'] ?? '';
            if ($filePath && file_exists($filePath)) {
                unlink($filePath);
            }
            
            unset($trashData[$foundIndex]);
            $trashData = array_values($trashData);
            
            file_put_contents($trashFile, json_encode($trashData, JSON_PRETTY_PRINT));
            
            echo json_encode(['status' => 'success']);
            exit();
        }
    }
}

echo json_encode(['status' => 'error', 'message' => 'Action failed']);
?>
