<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
        exit();
    }

    $id = $_POST['id'];
    $data = $_POST['data'];

    // Önce var olup olmadığını kontrol et
    $check_stmt = $conn->prepare("SELECT * FROM data2 WHERE id=?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Data not found']);
    } else {
        $stmt = $conn->prepare("UPDATE data2 SET content=? WHERE id=?");
        $stmt->bind_param("si", $data, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Data updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update data']);
        }
    }
}
?>
