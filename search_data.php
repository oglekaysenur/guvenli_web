<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not authenticated']);
        exit();
    }

    $keyword = $_POST['keyword'];
    $stmt = $conn->prepare("SELECT * FROM data2 WHERE content LIKE ?");
    $like_keyword = "%".$keyword."%";
    $stmt->bind_param("s", $like_keyword);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    echo json_encode($data);
}
?>
