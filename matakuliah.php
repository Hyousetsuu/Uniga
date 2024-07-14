<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mata Kuliah - Siakad</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="matakuliah.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h2>Siakad</h2>
        </div>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="fakulltas.php"><i class="fas fa-building"></i> Fakultas</a></li>
            <li><a href="programstudi.php"><i class="fas fa-graduation-cap"></i> Program Studi</a></li>
            <li><a href="matakuliah.php" class="active"><i class="fas fa-book"></i> Mata Kuliah</a></li>
            <li><a href="dosen.php"><i class="fas fa-chalkboard-teacher"></i> Dosen</a></li>
            <li><a href="mahasiswa.php"><i class="fas fa-user-graduate"></i> Mahasiswa</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
        <button id="sidebar-toggle"><i class="fas fa-bars"></i></button>
            <img src="anime-girl-horn-katana-fantasy-4k-wallpaper-uhdpaper.com-726@0@j.jpg" alt="User" width="30" height="30">
            <div>
                <h4>Admin</h4>
                <small>Connected</small>
            </div>
        </header>

        <main>
            <div class="content-container card">
                <h2>Mata Kuliah</h2>
                <button class="add" onclick="openModal()">Tambah Data Mata Kuliah</button>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Fakultas</th>
                                <th>Program Studi</th>
                                <th>Nama Mata Kuliah</th>
                                <th>Jumlah SKS</th>
                                <th>Dosen Pengampu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include("koneksi.php");

                            // Query untuk mengambil data mata kuliah
                            $sql = "SELECT matakuliah.id, fakultas.nama_fakultas, program_studi.nama_program_studi, 
                                    matakuliah.nama_mata_kuliah, matakuliah.jumlah_sks, dosen.nama_dosen
                                    FROM matakuliah 
                                    INNER JOIN program_studi ON matakuliah.id_program_studi = program_studi.id
                                    INNER JOIN dosen ON matakuliah.id_dosen = dosen.id
                                    INNER JOIN fakultas ON program_studi.id_fakultas = fakultas.id";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $no = 1;
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$no}</td>
                                            <td>{$row['nama_fakultas']}</td>
                                            <td>{$row['nama_program_studi']}</td>
                                            <td>{$row['nama_mata_kuliah']}</td>
                                            <td>{$row['jumlah_sks']}</td>
                                            <td>{$row['nama_dosen']}</td>
                                            <td>
                                                <form action='editMataKuliah.php' method='post' class='edit-form'>
                                                    <input type='hidden' name='mata_kuliah_id' value='{$row['id']}'>
                                                    <button type='submit' name='edit' class='add'>Edit</button>
                                                </form>
                                                <form action='deleteMataKuliah.php' method='post' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")' class='delete-form'>
                                                    <input type='hidden' name='mata_kuliah_id' value='{$row['id']}'>
                                                    <button type='submit' name='delete' class='add'>Delete</button>
                                                </form>
                                            </td>
                                          </tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='7'>Tidak ada data mata kuliah tersedia.</td></tr>";
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                    <div class="empty-state">
                        Tidak ada data program studi lain saat ini.
                    </div>
                </div>
            </div>

            <!-- Modal untuk Tambah Data Mata Kuliah -->
<!-- Modal untuk Tambah Data Mata Kuliah -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Tambah Data Mata Kuliah</h2>
        <form action="addmatakuliah.php" method="post">
            <label for="fakultas">Fakultas:</label><br>
            <select name="fakultas" id="fakultas" required>
                <?php
                include("koneksi.php");
                $fakultas_query = "SELECT id, nama_fakultas FROM fakultas";
                $fakultas_result = $conn->query($fakultas_query);

                while ($row_fakultas = $fakultas_result->fetch_assoc()) {
                    echo "<option value='{$row_fakultas['id']}'>{$row_fakultas['nama_fakultas']}</option>";
                }
                ?>
            </select><br><br>

            <label for="program_studi">Program Studi:</label><br>
            <select name="program_studi" id="program_studi" required>
                <?php
                $sql_program_studi = "SELECT id, nama_program_studi FROM program_studi";
                $result_program_studi = $conn->query($sql_program_studi);

                while ($row_program_studi = $result_program_studi->fetch_assoc()) {
                    echo "<option value='{$row_program_studi['id']}'>{$row_program_studi['nama_program_studi']}</option>";
                }
                ?>
            </select><br><br>

            <label for="nama_mata_kuliah">Nama Mata Kuliah:</label><br>
            <input type="text" id="nama_mata_kuliah" name="matakuliah" required><br><br>

            <label for="jumlah_sks">Jumlah SKS:</label><br>
            <input type="number" id="jumlah_sks" name="jumlah_sks" required><br><br>

            <label for="dosen">Dosen Pengampu:</label><br>
            <select name="dosen" id="dosen" required>
                <?php
                $sql_dosen = "SELECT id, nama_dosen FROM dosen";
                $result_dosen = $conn->query($sql_dosen);

                while ($row_dosen = $result_dosen->fetch_assoc()) {
                    echo "<option value='{$row_dosen['id']}'>{$row_dosen['nama_dosen']}</option>";
                }
                ?>
            </select><br><br>

            <input type="submit" value="Tambah Mata Kuliah">
        </form>
    </div>
</div>


            <!-- Modal untuk Tambah Fakultas -->
        </main>
    </div>

    <button class="tombol" onclick="scrollToTop()">
        <span class="svgIcon"><i class="fas fa-arrow-up"></i></span>
    </button>

    <script>
        function openModal() {
            document.getElementById('modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }

        function openFakultasModal() {
            document.getElementById('fakultasModal').style.display = 'block';
        }

        function closeFakultasModal() {
            document.getElementById('fakultasModal').style.display = 'none';
        }

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>

</body>
<footer class="footer">
    <div class="footer-content">
        <p>💀&copy;2024 SIAKAD. All rights reserved.💀</p>
        <p>
            <a href="#">Privacy Policy</a> |
            <a href="#">Terms of Service</a> |
            <a href="#">Contact Us</a>
        </p>
    </div>
</footer>
</html>
