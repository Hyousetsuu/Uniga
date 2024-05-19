<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $role = $_POST['role'];
    $jurusan = isset($_POST['jurusan']) ? $_POST['jurusan'] : null;
    $mata_kuliah = isset($_POST['mata_kuliah']) ? $_POST['mata_kuliah'] : null;

    $sql = "INSERT INTO users (username, password, name, role) VALUES ('$username', '$password', '$name', '$role')";

    if ($conn->query($sql) === TRUE) {
        $user_id = $conn->insert_id;
        
        if ($role == 'mahasiswa' && $jurusan) {
            $sql = "INSERT INTO mahasiswa (user_id, jurusan) VALUES ('$user_id', '$jurusan')";
            $conn->query($sql);
        } elseif ($role == 'dosen' && $mata_kuliah) {
            $sql = "INSERT INTO mata_kuliah (nama_mata_kuliah, dosen_id) VALUES ('$mata_kuliah', '$user_id')";
            $conn->query($sql);
        }

        // Redirect to login page after successful registration
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
