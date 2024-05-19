<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'config.php';

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM jadwal WHERE id='$delete_id'");
    header("Location: manage_jadwal.php");
    exit();
}

$result = $conn->query("SELECT j.id, j.mata_kuliah, j.hari, j.jam, j.jam_selesai, j.sks, j.jurusan, u.name as dosen_name FROM jadwal j JOIN users u ON j.dosen_id = u.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Daftar Jadwal</h2>
        <a href="input_jadwal.php" class="btn btn-primary mb-3">Tambah Jadwal</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mata Kuliah</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>SKS</th>
                    <th>Jurusan</th>
                    <th>Dosen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['mata_kuliah']) ?></td>
                        <td><?= htmlspecialchars($row['hari']) ?></td>
                        <td><?= htmlspecialchars($row['jam']) ?></td>
                        <td><?= htmlspecialchars($row['jam_selesai']) ?></td>
                        <td><?= htmlspecialchars($row['sks']) ?></td>
                        <td><?= htmlspecialchars($row['jurusan']) ?></td>
                        <td><?= htmlspecialchars($row['dosen_name']) ?></td>
                        <td>
                            <a href="edit_jadwal.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="manage_jadwal.php?delete_id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>
