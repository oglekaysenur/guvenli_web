<?php
session_start();
include 'db.php';

// Oturum süresi kontrolü (30 dakika)
$timeout_duration = 1800;

if (isset($_SESSION['LAST_ACTIVITY']) && 
   (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: login_safe.php");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); // son aktivite zamanını güncelle

if (!isset($_SESSION['user_id'])) {
    header("Location: login_safe.php");
    exit();
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF token validation failed");
    }

    $data = $_POST['data'];
    $stmt = $conn->prepare("INSERT INTO data (data) VALUES (?)");
    $stmt->bind_param("s", $data);
    $stmt->execute();
    echo "Data added successfully.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Add Data</h2>
        <form method="post" action="add_data_safe.php" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="data">Data:</label>
                <input type="text" class="form-control" name="data" id="data" required>
                <div class="invalid-feedback">
                    Please provide data.
                </div>
            </div>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>
</html>
