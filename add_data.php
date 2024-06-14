<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
        exit();
    }

    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['status' => 'error', 'message' => 'CSRF token validation failed']);
        exit();
    }

    $data = $_POST['data'];
    $stmt = $conn->prepare("INSERT INTO data2 (content) VALUES (?)");
    $stmt->bind_param("s", $data);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Data added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add data']);
    }
}
?>
