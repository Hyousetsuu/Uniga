<?php
session_start();
if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?= $_SESSION['name'] ?> (Mahasiswa)</h1>
        <a href="view_jadwal_mahasiswa.php" class="btn btn-primary">Lihat Jadwal</a>
        <a href="view_absensi_mahasiswa.php" class="btn btn-primary">Lihat Absensi</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
