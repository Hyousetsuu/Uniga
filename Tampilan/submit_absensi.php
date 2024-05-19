<?php
session_start();
if ($_SESSION['role'] != 'dosen') {
    header("Location: login.php");
    exit();
}

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jadwal_id = $_POST['jadwal_id'];
    $mahasiswa_id = $_POST['mahasiswa_id'];
    $waktu_absen = $_POST['waktu_absen'];
    $status = $_POST['status'];

    $sql = "INSERT INTO absensi (jadwal_id, mahasiswa_id, waktu_absen, status) 
            VALUES ('$jadwal_id', '$mahasiswa_id', '$waktu_absen', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location: dosen_dashboard.php"); // Redirect after successful submission
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();

?>
