<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mata_kuliah = $_POST['mata_kuliah'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    $sks = $_POST['sks'];
    $jurusan = $_POST['jurusan'];
    $dosen_id = $_POST['dosen_id'];

    // Hitung jam selesai berdasarkan jumlah SKS
    $jam_selesai = date("H:i", strtotime("+".($sks * 50)." minutes", strtotime($jam)));

    $sql = "INSERT INTO jadwal (mata_kuliah, hari, jam, jam_selesai, sks, jurusan, dosen_id) VALUES ('$mata_kuliah', '$hari', '$jam', '$jam_selesai', '$sks', '$jurusan', '$dosen_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Jadwal berhasil ditambahkan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT id, name FROM users WHERE role='dosen'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Input Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Input Jadwal</h2>
        <form action="input_jadwal.php" method="POST">
            <div class="mb-3">
                <label for="dosen_id" class="form-label">Dosen</label>
                <select class="form-select" id="dosen_id" name="dosen_id" required onchange="updateMataKuliahList()">
                    <option value="">Pilih Dosen</option>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="mata_kuliah" class="form-label">Mata Kuliah</label>
                <select class="form-select" id="mata_kuliah" name="mata_kuliah" required>
                    <option value="">Pilih Mata Kuliah</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="hari" class="form-label">Hari</label>
                <input type="text" class="form-control" id="hari" name="hari" required>
            </div>
            <div class="mb-3">
                <label for="jam" class="form-label">Jam Mulai</label>
                <input type="time" class="form-control" id="jam" name="jam" required>
            </div>
            <div class="mb-3">
                <label for="sks" class="form-label">SKS</label>
                <input type="number" class="form-control" id="sks" name="sks" required>
            </div>
            <div class="mb-3">
                <label for="jurusan" class="form-label">Jurusan</label>
                <select class="form-select" id="jurusan" name="jurusan" required>
                    <option value="S1-Teknik Informatika">S1-Teknik Informatika</option>
                    <option value="S1-Ilmu Komputer">S1-Ilmu Komputer</option>
                    <option value="S1-Ilmu Komunikasi">S1-Ilmu Komunikasi</option>
                    <option value="D3-Teknik Informatika">D3-Teknik Informatika</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
    function updateMataKuliahList() {
        const dosenSelect = document.getElementById('dosen_id');
        const mataKuliahSelect = document.getElementById('mata_kuliah');
        const dosenId = dosenSelect.value;

        fetch(`get_mata_kuliah_by_dosen.php?dosen_id=${dosenId}`)
            .then(response => response.json())
            .then(data => {
                mataKuliahSelect.innerHTML = '<option value="">Pilih Mata Kuliah</option>';
                data.forEach(mataKuliah => {
                    mataKuliahSelect.innerHTML += `<option value="${mataKuliah.nama_mata_kuliah}">${mataKuliah.nama_mata_kuliah}</option>`;
                });
            });
    }
    </script>
</body>
</html>
<?php $conn->close(); ?>
