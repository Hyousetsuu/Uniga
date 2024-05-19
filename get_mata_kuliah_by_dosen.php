<?php
include 'config.php';

$dosen_id = $_GET['dosen_id'];
$sql = "SELECT nama_mata_kuliah FROM mata_kuliah WHERE dosen_id='$dosen_id'";
$result = $conn->query($sql);

$mata_kuliah = [];
while($row = $result->fetch_assoc()) {
    $mata_kuliah[] = $row;
}

echo json_encode($mata_kuliah);
?>
