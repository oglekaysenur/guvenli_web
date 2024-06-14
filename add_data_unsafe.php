<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    date_default_timezone_set('Europe/Istanbul');

    // Veriyi ve anlık saati birleştir
    $data = $_POST['data'] . strval(time());
    
    // Anlık saat ve tarihi eklemek
    $currentTime = date('Y-m-d H:i:s'); // Format: 2024-06-14 14:35:00
    $dataWithTime = $_POST['data'] . ' ' . $currentTime;
    $query = "INSERT INTO data (data) VALUES ('$dataWithTime')";
    mysqli_query($conn, $query);
    echo "Data added successfully.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Data</title>
</head>
<body>
    <form method="post" action="add_data_unsafe.php">
        <label for="data">Data:</label>
        <input type="text" name="data" id="data" required>
        <button type="submit">Add</button>
    </form>
</body>
</html>
