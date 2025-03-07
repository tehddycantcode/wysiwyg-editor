<?php
header('Content-Type: application/json');

// Ensure a file was uploaded
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => 'No file uploaded or upload error.']);
    http_response_code(400);
    exit;
}

// Set the upload directory
$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0777, true)) {
        echo json_encode(['error' => 'Failed to create upload directory.']);
        http_response_code(500);
        exit;
    }
}

// Generate a unique filename
$fileName = $uploadDir . uniqid() . '-' . basename($_FILES['file']['name']);
if (move_uploaded_file($_FILES['file']['tmp_name'], $fileName)) {
    echo json_encode(['location' => $fileName]);
} else {
    echo json_encode(['error' => 'File upload failed.']);
    http_response_code(500);
}
?>