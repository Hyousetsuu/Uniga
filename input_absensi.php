<?php
session_start();
if ($_SESSION['role'] != 'dosen') {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Ambil data mahasiswa dari tabel mahasiswa
$mahasiswa_sql = "SELECT m.id, u.name FROM mahasiswa m JOIN users u ON m.user_id = u.id";
$mahasiswa_result = $conn->query($mahasiswa_sql);

// Ambil data jadwal dari tabel jadwal
$jadwal_sql = "SELECT j.id, j.mata_kuliah, j.hari, j.jam, j.jam_selesai, j.sks, j.jurusan, u.name as dosen_name 
               FROM jadwal j JOIN users u ON j.dosen_id = u.id";
$jadwal_result = $conn->query($jadwal_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Input Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Input Absensi</h2>
        <form action="submit_absensi.php" method="POST">
            <div class="mb-3">
                <label for="jadwal" class="form-label">Jadwal</label>
                <select class="form-select" id="jadwal" name="jadwal_id" required>
                    <?php while($jadwal = $jadwal_result->fetch_assoc()): ?>
                        <option value="<?= $jadwal['id'] ?>"><?= $jadwal['mata_kuliah'] ?> - <?= $jadwal['hari'] ?> (<?= $jadwal['jam'] ?> - <?= $jadwal['jam_selesai'] ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="mahasiswa" class="form-label">Mahasiswa</label>
                <select class="form-select" id="mahasiswa" name="mahasiswa_id" required>
                    <?php while($mahasiswa = $mahasiswa_result->fetch_assoc()): ?>
                        <option value="<?= $mahasiswa['id'] ?>"><?= $mahasiswa['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="waktu_absen" class="form-label">Waktu Absen</label>
                <input type="datetime-local" class="form-control" id="waktu_absen" name="waktu_absen" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Hadir">Hadir</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Izin">Izin</option>
                    <option value="Tidak Hadir">Tidak Hadir</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
<?php $conn->close(); ?>
