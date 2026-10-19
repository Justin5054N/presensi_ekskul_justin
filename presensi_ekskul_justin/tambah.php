<?php
include 'koneksi.php';

$error = '';

if (isset($_POST['tambah'])) {
    $nama_peserta     = trim($_POST['nama_peserta']);
    $kelas            = trim($_POST['kelas']);
    $ekstrakurikuler  = trim($_POST['ekstrakurikuler']);
    $tanggal          = trim($_POST['tanggal']);
    $status           = trim($_POST['status']);
    $keterangan       = trim($_POST['keterangan']); // Opsional, boleh kosong

    // Validasi: Cek apakah field wajib kosong (selain keterangan)
    if (empty($nama_peserta) || empty($kelas) || empty($ekstrakurikuler) || empty($tanggal) || empty($status)) {
        $error = "Semua kolom wajib diisi, kecuali Keterangan!";
    } else {
        // Jika lolos validasi, simpan ke database
        $sql = "INSERT INTO presensi_ekskul (nama_peserta, kelas, ekstrakurikuler, tanggal, status, keterangan) 
                VALUES (:nama_peserta, :kelas, :ekstrakurikuler, :tanggal, :status, :keterangan)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nama_peserta'    => $nama_peserta,
            ':kelas'           => $kelas,
            ':ekstrakurikuler' => $ekstrakurikuler,
            ':tanggal'         => $tanggal,
            ':status'          => $status,
            ':keterangan'      => $keterangan
        ]);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Presensi - Justin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-calendar-check-fill me-2"></i>Presensi Ekskul Justin</a>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-primary text-white py-3 rounded-top-4">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Presensi Baru</h5>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Notifikasi Error jika ada form kosong -->
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $error ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Peserta <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_peserta" placeholder="Contoh: Budi Santoso" value="<?= htmlspecialchars($_POST['nama_peserta'] ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="kelas" placeholder="Contoh: XI RPL 1" value="<?= htmlspecialchars($_POST['kelas'] ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Ekstrakurikuler <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="ekstrakurikuler" placeholder="Contoh: Paskibra / Futsal" value="<?= htmlspecialchars($_POST['ekstrakurikuler'] ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal" value="<?= $_POST['tanggal'] ?? date('Y-m-d') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status Kehadiran <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" required>
                                    <option value="Hadir" <?= (isset($_POST['status']) && $_POST['status'] == 'Hadir') ? 'selected' : '' ?>>Hadir</option>
                                    <option value="Izin" <?= (isset($_POST['status']) && $_POST['status'] == 'Izin') ? 'selected' : '' ?>>Izin</option>
                                    <option value="Sakit" <?= (isset($_POST['status']) && $_POST['status'] == 'Sakit') ? 'selected' : '' ?>>Sakit</option>
                                    <option value="Alpha" <?= (isset($_POST['status']) && $_POST['status'] == 'Alpha') ? 'selected' : '' ?>>Alpha</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Keterangan <span class="text-muted fw-normal">(Opsional)</span></label>
                                <input type="text" class="form-control" name="keterangan" placeholder="Contoh: Dispensasi lomba" value="<?= htmlspecialchars($_POST['keterangan'] ?? '') ?>">
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-secondary">Batal</a>
                                <button type="submit" name="tambah" class="btn btn-primary">Simpan Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>