<?php
session_start();
if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit();
}

include 'config.php';

$jurusan = $_SESSION['jurusan'];

$sql = "SELECT * FROM jadwal WHERE jurusan='$jurusan'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Jadwal Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Jadwal Mahasiswa</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>SKS</th>
                    <th>Dosen</th>
                    <th>Jurusan</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['mata_kuliah'] ?></td>
                        <td><?= $row['hari'] ?></td>
                        <td><?= $row['jam'] ?></td>
                        <td><?= $row['jam_selesai'] ?></td>
                        <td><?= $row['sks'] ?></td>
                        <td>
                            <?php 
                            $dosen_sql = "SELECT name FROM users WHERE id=".$row['dosen_id'];
                            $dosen_result = $conn->query($dosen_sql);
                            $dosen = $dosen_result->fetch_assoc();
                            echo $dosen['name'];
                            ?>
                        </td>
                        <td><?= $row['jurusan'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>
