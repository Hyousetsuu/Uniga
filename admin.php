<?php
include 'config.php';
session_start();

// Pastikan user yang login adalah admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT u.*, GROUP_CONCAT(mk.nama_mata_kuliah SEPARATOR ', ') AS mata_kuliah 
        FROM users u 
        LEFT JOIN mata_kuliah mk ON u.id = mk.dosen_id 
        WHERE u.id='$id' AND u.role='dosen'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $dosen = $result->fetch_assoc();
} else {
    die("Dosen tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
    $mata_kuliah = isset($_POST['mata_kuliah']) ? explode(', ', $conn->real_escape_string($_POST['mata_kuliah'])) : [];

    $sql = "UPDATE users SET name='$name' WHERE id='$id'";
    $conn->query($sql);

    $conn->query("DELETE FROM mata_kuliah WHERE dosen_id='$id'");
    foreach ($mata_kuliah as $mk) {
        $mk = trim($mk);
        if ($mk != '') {
            $conn->query("INSERT INTO mata_kuliah (nama_mata_kuliah, dosen_id) VALUES ('$mk', '$id')");
        }
    }

    header("Location: admin_edit_dosen.php");
    exit();
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
                        
                        <form method="POST">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" name="name" value="<?php echo htmlspecialchars($dosen['name']); ?>" required><br>
                                <label for="floatingInput">Nama Dosen</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input class="form-control" type="text" name="mata_kuliah" value="<?php echo htmlspecialchars($dosen['mata_kuliah']); ?>" required><br>
                                <label for="floatingPassword">Mata Kuliah</label>
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
