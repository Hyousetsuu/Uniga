<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    exit;
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $mahasiswa_id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT mahasiswa.*, users.name FROM mahasiswa JOIN users ON mahasiswa.user_id = users.id WHERE mahasiswa.id = $mahasiswa_id");
    $mahasiswa = mysqli_fetch_assoc($result);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mahasiswa_id = $_POST['id'];
    $name = $_POST['name'];
    $jurusan = $_POST['jurusan'];
    $user_id = $_POST['user_id'];

    mysqli_query($conn, "UPDATE users SET name = '$name' WHERE id = $user_id");
    mysqli_query($conn, "UPDATE mahasiswa SET jurusan = '$jurusan' WHERE id = $mahasiswa_id");

    header('Location: admin_edit_mahasiswa.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SSO - Login</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                                <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>SSO</h3>
                            <h3>Edit</h3>
                        </div>
                        <form method="POST" action="edit_mahasiswa.php">
                            <div class="form-floating mb-3">
                                <input type="hidden" name="id" value="<?php echo $mahasiswa['id']; ?>">
                                <input type="hidden" name="user_id" value="<?php echo $mahasiswa['user_id']; ?>">
                                <input class="form-control" type="text" name="name" value="<?php echo $mahasiswa['name']; ?>" required>
                                <label for="floatingInput">Nama Mahasiswa</label>
                            </div>
                            <div class="form-floating mb-4">
                                <select class="form-select" name="jurusan" required>
                                <option value="S1-Teknik Informatika" <?php echo $mahasiswa['jurusan'] == 'S1-Teknik Informatika' ? 'selected' : ''; ?>>S1-Teknik Informatika</option>
                                <option value="S1-Ilmu Komputer" <?php echo $mahasiswa['jurusan'] == 'S1-Ilmu Komputer' ? 'selected' : ''; ?>>S1-Ilmu Komputer</option>
                                <option value="S1-Ilmu Komunikasi" <?php echo $mahasiswa['jurusan'] == 'S1-Ilmu Komunikasi' ? 'selected' : ''; ?>>S1-Ilmu Komunikasi</option>
                                <option value="D3-Teknik Informatika" <?php echo $mahasiswa['jurusan'] == 'D3-Teknik Informatika' ? 'selected' : ''; ?>>D3-Teknik Informatika</option>
                                </select>
                                <label for="floatingPassword">Jurusan</label>
                            </div>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">EDIT</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
