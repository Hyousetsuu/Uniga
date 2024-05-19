<?php
session_start();
if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit();
}

include 'config.php';

$mahasiswa_id = $_SESSION['id'];

// Query to get absensi data for the logged-in mahasiswa
$sql = "
SELECT a.*, j.mata_kuliah, j.hari, j.jam, j.jam_selesai, j.sks, u.name as dosen_name 
FROM absensi a 
JOIN jadwal j ON a.jadwal_id = j.id 
JOIN users u ON j.dosen_id = u.id 
WHERE a.mahasiswa_id = '$mahasiswa_id'
";
$result = $conn->query($sql);

if (!$result) {
    die('Query Error: ' . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Absensi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Absensi Mahasiswa</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>SKS</th>
                    <th>Dosen</th>
                    <th>Waktu Absen</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['mata_kuliah']) ?></td>
                        <td><?= htmlspecialchars($row['hari']) ?></td>
                        <td><?= htmlspecialchars($row['jam']) ?></td>
                        <td><?= htmlspecialchars($row['jam_selesai']) ?></td>
                        <td><?= htmlspecialchars($row['sks']) ?></td>
                        <td><?= htmlspecialchars($row['dosen_name']) ?></td>
                        <td><?= htmlspecialchars($row['waktu_absen']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>
