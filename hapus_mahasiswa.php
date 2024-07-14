<?php
include 'config.php';
session_start();

// Pastikan user yang login adalah admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $mahasiswa_id = $_GET['id'];

    // Ambil user_id dari tabel mahasiswa
    $result = mysqli_query($conn, "SELECT user_id FROM mahasiswa WHERE id='$mahasiswa_id'");
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['user_id'];

    // Hapus dari tabel mahasiswa
    $sql = "DELETE FROM mahasiswa WHERE id='$mahasiswa_id'";
    if ($conn->query($sql) === TRUE) {
        // Hapus dari tabel users
        $sql = "DELETE FROM users WHERE id='$user_id'";
        if ($conn->query($sql) === TRUE) {
            header("Location: admin_edit_mahasiswa.php");
            exit();
        } else {
            echo "Error deleting user: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error deleting mahasiswa: " . $sql . "<br>" . $conn->error;
    }
} else {
    header("Location: admin_edit_mahasiswa.php");
    exit();
}
?>
