<?php
session_start();
if ($_SESSION['role'] != 'dosen') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?= $_SESSION['name'] ?> (Dosen)</h1>
        <a href="view_jadwal.php" class="btn btn-primary">Lihat Jadwal</a>
        <a href="input_absensi.php" class="btn btn-primary">Input Absensi</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
