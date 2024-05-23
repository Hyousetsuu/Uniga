<?php
session_start();
if ($_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $mahasiswa_id = $_GET['id'];
    $result = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id = $mahasiswa_id");
    $mahasiswa = mysqli_fetch_assoc($result);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mahasiswa_id = $_POST['id'];
    $jurusan = $_POST['jurusan'];
    mysqli_query($koneksi, "UPDATE mahasiswa SET jurusan = '$jurusan' WHERE id = $mahasiswa_id");
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Mahasiswa</title>
</head>
<body>
    <h1>Edit Mahasiswa</h1>
    <form method="POST" action="edit_mahasiswa.php">
        <input type="hidden" name="id" value="<?php echo $mahasiswa['id']; ?>">
        <label for="jurusan">Jurusan:</label>
        <select name="jurusan">
            <option value="S1-Teknik Informatika" <?php echo $mahasiswa['jurusan'] == 'S1-Teknik Informatika' ? 'selected' : ''; ?>>S1-Teknik Informatika</option>
            <option value="S1-Ilmu Komputer" <?php echo $mahasiswa['jurusan'] == 'S1-Ilmu Komputer' ? 'selected' : ''; ?>>S1-Ilmu Komputer</option>
            <option value="S1-Ilmu Komunikasi" <?php echo $mahasiswa['jurusan'] == 'S1-Ilmu Komunikasi' ? 'selected' : ''; ?>>S1-Ilmu Komunikasi</option>
            <option value="D3-Teknik Informatika" <?php echo $mahasiswa['jurusan'] == 'D3-Teknik Informatika' ? 'selected' : ''; ?>>D3-Teknik Informatika</option>
        </select>
        <button type="submit">Update</button>
    </form>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
