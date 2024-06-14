<?php
session_start();
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Data Management</h1>

        <div class="card mb-4">
            <div class="card-header">Add Data</div>
            <div class="card-body">
                <form id="addForm">
                    <div class="form-group">
                        <label for="data">Data:</label>
                        <input type="text" class="form-control" name="data" id="data" required>
                        <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Delete Data</div>
            <div class="card-body">
                <form id="deleteForm">
                    <div class="form-group">
                        <label for="id">ID:</label>
                        <input type="text" class="form-control" name="id" id="id" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Update Data</div>
            <div class="card-body">
                <form id="updateForm">
                    <div class="form-group">
                        <label for="id">ID:</label>
                        <input type="text" class="form-control" name="id" id="update_id" required>
                    </div>
                    <div class="form-group">
                        <label for="data">Data:</label>
                        <input type="text" class="form-control" name="data" id="update_data" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Update</button>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Search Data</div>
            <div class="card-body">
                <form id="searchForm">
                    <div class="form-group">
                        <label for="keyword">Keyword:</label>
                        <input type="text" class="form-control" name="keyword" id="keyword" required>
                    </div>
                    <button type="submit" class="btn btn-info">Search</button>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Search Results</div>
            <div class="card-body" id="results"></div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#addForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'add_data.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        var res = JSON.parse(response);
                        Swal.fire({
                            icon: res.status === 'success' ? 'success' : 'error',
                            title: res.status === 'success' ? 'Success' : 'Error',
                            text: res.message
                        });
                    }
                });
            });

            $('#deleteForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'delete_data.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        var res = JSON.parse(response);
                        Swal.fire({
                            icon: res.status === 'success' ? 'success' : 'error',
                            title: res.status === 'success' ? 'Success' : 'Error',
                            text: res.message
                        });
                    }
                });
            });

            $('#updateForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'update_data.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        var res = JSON.parse(response);
                        Swal.fire({
                            icon: res.status === 'success' ? 'success' : 'error',
                            title: res.status === 'success' ? 'Success' : 'Error',
                            text: res.message
                        });
                    }
                });
            });

            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'search_data.php',
                    data: $(this).serialize(),
                    success: function(response) {
                        var data = JSON.parse(response);
                        var results = '<ul class="list-group">';
                        data.forEach(function(item) {
                            results += '<li class="list-group-item">' + item.content + '</li>';
                        });
                        results += '</ul>';
                        $('#results').html(results);
                    }
                });
            });
        });
    </script>
</body>
</html>
