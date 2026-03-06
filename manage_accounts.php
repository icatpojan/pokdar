<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true || ($_SESSION['user_role'] ?? '') !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$action = $_POST['action'] ?? '';
$type = $_POST['type'] ?? ''; // 'admin' or 'karesort'

if (!in_array($type, ['admin', 'karesort'])) {
    if ($action !== 'load') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid type']);
        exit();
    }
}

$adminFile = 'data/admin.json';
$karesortFile = 'data/karesort.json';

// Helper to load data
function loadData($file) {
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?: [];
}

// Helper to save data
function saveData($file, $data) {
    return file_put_contents($file, json_encode(array_values($data), JSON_PRETTY_PRINT));
}

switch ($action) {
    case 'load':
        echo json_encode([
            'status' => 'success',
            'admin' => loadData($adminFile),
            'karesort' => loadData($karesortFile)
        ]);
        break;

    case 'save':
        $file = ($type === 'admin') ? $adminFile : $karesortFile;
        $data = loadData($file);
        $index = isset($_POST['index']) ? (int)$_POST['index'] : -1;
        
        $newData = [
            'username' => $_POST['username'] ?? '',
            'password' => $_POST['password'] ?? '',
        ];

        // For login consistency
        if ($type === 'karesort') {
            $newData['name'] = $_POST['username'] ?? ''; // karesort uses 'name' for login
            // You can add more fields for karesort here if needed, like sector
        }

        if ($index >= 0 && isset($data[$index])) {
            $data[$index] = array_merge($data[$index], $newData);
        } else {
            // Check for duplicate username
            foreach ($data as $u) {
                if (($u['username'] ?? $u['name'] ?? '') === $newData['username']) {
                    echo json_encode(['status' => 'error', 'message' => 'Username sudah terdaftar']);
                    exit();
                }
            }
            $data[] = $newData;
        }

        if (saveData($file, $data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }
        break;

    case 'delete':
        $file = ($type === 'admin') ? $adminFile : $karesortFile;
        $data = loadData($file);
        $index = isset($_POST['index']) ? (int)$_POST['index'] : -1;

        if ($type === 'admin' && count($data) <= 1) {
             echo json_encode(['status' => 'error', 'message' => 'Tidak bisa menghapus akun admin terakhir']);
             exit();
        }

        if ($index >= 0 && isset($data[$index])) {
            array_splice($data, $index, 1);
            if (saveData($file, $data)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Index tidak valid']);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid']);
        break;
}
