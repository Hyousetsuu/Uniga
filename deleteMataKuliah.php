<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mata_kuliah_id'])) {
    $mata_kuliah_id = $_POST['mata_kuliah_id'];

    // Prepare the DELETE statement
    $query = "DELETE FROM matakuliah WHERE id=?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $mata_kuliah_id);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: matakuliah.php?message=Data berhasil dihapus');
            exit();
        } else {
            die("Error executing statement: " . mysqli_stmt_error($stmt));
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Error preparing statement: " . mysqli_error($conn));
    }
} else {
    header('Location: matakuliah.php');
    exit();
}
?>
