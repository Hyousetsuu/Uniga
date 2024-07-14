<?php
include 'config.php';
session_start();

// Pastikan user yang login adalah admin
if ($_SESSION['role'] !== 'admin') {
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Hapus data mata kuliah yang terkait dengan dosen ini
    $sql = "DELETE FROM mata_kuliah WHERE dosen_id='$id'";
    if ($conn->query($sql) === TRUE) {
        // Hapus data dosen dari tabel dosen
        if ($conn->query($sql) === TRUE) {
            // Hapus data dosen dari tabel users
            $sql = "DELETE FROM users WHERE id='$id' AND role='dosen'";
            if ($conn->query($sql) === TRUE) {
                header("Location: admin_edit_dosen.php");
                exit();
            } else {
                echo "Error deleting user: " . $conn->error;
            }
        } else {
            echo "Error deleting dosen: " . $conn->error;
        }
    } else {
        echo "Error deleting mata kuliah: " . $conn->error;
    }
} else {
    header("Location: admin_edit_dosen.php");
    exit();
}
?>

