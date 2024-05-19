<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['id'] = $user['id']; // Pastikan ID diatur

            // Check for mahasiswa role and get jurusan
            if ($user['role'] == 'mahasiswa') {
                $mahasiswa_sql = "SELECT jurusan FROM mahasiswa WHERE user_id=".$user['id'];
                $mahasiswa_result = $conn->query($mahasiswa_sql);
                if ($mahasiswa_result->num_rows > 0) {
                    $mahasiswa = $mahasiswa_result->fetch_assoc();
                    $_SESSION['jurusan'] = $mahasiswa['jurusan'];
                }
            }

            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($user['role'] == 'dosen') {
                header("Location: dosen_dashboard.php");
            } elseif ($user['role'] == 'mahasiswa') {
                header("Location: mahasiswa_dashboard.php");
            }
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this username.";
    }
}
$conn->close();
?>
