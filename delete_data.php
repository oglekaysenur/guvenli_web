<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
        exit();
    }

    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM data2 WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Data deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete data or data not found']);
    }
}
?>
