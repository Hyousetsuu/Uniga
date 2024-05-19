<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?= $_SESSION['name'] ?> (Admin)</h1>
        <a href="input_jadwal.php" class="btn btn-primary">Input Jadwal</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
