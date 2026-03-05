<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true || ($_SESSION['user_role'] ?? '') !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$dataFile = 'data/kasektor.json';

// Helper to load data
function loadKasektor($file) {
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?: [];
}

// Helper to save data
function saveKasektor($file, $data) {
    return file_put_contents($file, json_encode(array_values($data), JSON_PRETTY_PRINT));
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'load':
        echo json_encode(['status' => 'success', 'data' => loadKasektor($dataFile)]);
        break;

    case 'save':
        $data = loadKasektor($dataFile);
        $index = isset($_POST['index']) ? (int)$_POST['index'] : -1;
        $newData = [
            'name' => $_POST['username'] ?? '',    // The login username
            'full_name' => $_POST['name'] ?? '',   // The selected member name
            'password' => $_POST['password'] ?? '',
            'sector' => $_POST['sector'] ?? '',
            'assessment' => isset($_POST['assessment']) ? json_decode($_POST['assessment'], true) : null,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($index >= 0 && isset($data[$index])) {
            // Update existing, preserve assessment if not provided
            if (!$newData['assessment']) $newData['assessment'] = $data[$index]['assessment'] ?? null;
            $data[$index] = $newData;
        } else {
            // Add new
            $data[] = $newData;
        }

        if (saveKasektor($dataFile, $data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save data']);
        }
        break;

    case 'delete':
        $data = loadKasektor($dataFile);
        $index = isset($_POST['index']) ? (int)$_POST['index'] : -1;

        if ($index >= 0 && isset($data[$index])) {
            array_splice($data, $index, 1);
            if (saveKasektor($dataFile, $data)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete data']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid index']);
        }
        break;

    case 'update_assessment':
        $data = loadKasektor($dataFile);
        $index = isset($_POST['index']) ? (int)$_POST['index'] : -1;
        $assessment = isset($_POST['assessment']) ? json_decode($_POST['assessment'], true) : null;

        if ($index >= 0 && isset($data[$index])) {
            $data[$index]['assessment'] = $assessment;
            if (saveKasektor($dataFile, $data)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to save assessment']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid index']);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}
