<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Register</h2>
        <form action="register.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen</option>
                </select>
            </div>
            <div id="additional-fields"></div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <script>
    document.getElementById('role').addEventListener('change', function () {
        var role = this.value;
        var additionalFields = document.getElementById('additional-fields');

        additionalFields.innerHTML = '';

        if (role === 'mahasiswa') {
            additionalFields.innerHTML = `
                <div class="mb-3">
                    <label for="jurusan" class="form-label">Jurusan</label>
                    <select class="form-select" id="jurusan" name="jurusan" required>
                        <option value="S1-Teknik Informatika">S1-Teknik Informatika</option>
                        <option value="S1-Ilmu Komputer">S1-Ilmu Komputer</option>
                        <option value="S1-Ilmu Komunikasi">S1-Ilmu Komunikasi</option>
                        <option value="D3-Teknik Informatika">D3-Teknik Informatika</option>
                    </select>
                </div>
            `;
        } else if (role === 'dosen') {
            additionalFields.innerHTML = `
                <div class="mb-3">
                    <label for="mata_kuliah" class="form-label">Mata Kuliah</label>
                    <input type="text" class="form-control" id="mata_kuliah" name="mata_kuliah" required>
                </div>
            `;
        }
    });
    </script>
</body>
</html>
