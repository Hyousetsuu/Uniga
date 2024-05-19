<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $jurusan = $_POST['jurusan'];

    $conn->query("INSERT INTO users (name, username, password, role) VALUES ('$name', '$username', '$password', 'mahasiswa')");
    $user_id = $conn->insert_id;

    $conn->query("INSERT INTO mahasiswa (user_id, jurusan) VALUES ('$user_id', '$jurusan')");

    header("Location: manage_mahasiswa.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Tambah Mahasiswa</h2>
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
                <label for="jurusan" class="form-label">Jurusan</label>
                <select class="form-select" id="jurusan" name="jurusan" required>
                    <option value="S1-Teknik Informatika">S1-Teknik Informatika</option>
                    <option value="S1-Ilmu Komputer">S1-Ilmu Komputer</option>
                    <option value="S1-Ilmu Komunikasi">S1-Ilmu Komunikasi</option>
                    <option value="D3-Teknik Informatika">D3-Teknik Informatika</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>
</body>
</html>
