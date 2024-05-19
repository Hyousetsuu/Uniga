<?php
session_start();
include 'config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $mata_kuliah = $_POST['mata_kuliah'];

    // Insert user data into users table
    $conn->query("INSERT INTO users (username, password, role, name) VALUES ('$username', '$password', 'dosen', '$name')");
    $user_id = $conn->insert_id;

    // Insert dosen data into dosen table
    $conn->query("INSERT INTO dosen (user_id, mata_kuliah) VALUES ('$user_id', '$mata_kuliah')");

    header("Location: manage_dosen.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Tambah Dosen</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="mata_kuliah" class="form-label">Mata Kuliah</label>
                <input type="text" class="form-control" id="mata_kuliah" name="mata_kuliah" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>
</body>
</html>
