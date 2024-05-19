<?php
session_start();
if ($_SESSION['role'] != 'dosen') {
    header("Location: login.php");
    exit();
}
include 'config.php';

$dosen_id = $_SESSION['id'];
$sql = "SELECT * FROM jadwal WHERE dosen_id='$dosen_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Mengajar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Jadwal Mengajar</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>SKS</th>
                    <th>Nama Dosen</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['mata_kuliah'] ?></td>
                        <td><?= $row['hari'] ?></td>
                        <td><?= $row['jam'] ?></td>
                        <td><?= $row['sks'] ?></td>
                        <td>
                            <?php
                            $dosen_sql = "SELECT name FROM users WHERE id='{$row['dosen_id']}'";
                            $dosen_result = $conn->query($dosen_sql);
                            if ($dosen_result->num_rows > 0) {
                                $dosen = $dosen_result->fetch_assoc();
                                echo $dosen['name'];
                            }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>
