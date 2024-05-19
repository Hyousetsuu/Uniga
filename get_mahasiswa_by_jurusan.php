<?php
include 'config.php';

$jurusan = $_GET['jurusan'];
$sql = "SELECT id, name FROM users WHERE role='mahasiswa' AND jurusan='$jurusan'";
$result = $conn->query($sql);

$mahasiswa = [];
while($row = $result->fetch_assoc()) {
    $mahasiswa[] = $row;
}

echo json_encode($mahasiswa);
?>
