<?php
include 'koneksi.php';

$id_presensi = $_GET['id'] ?? null;
if (!$id_presensi) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM presensi_ekskul WHERE id_presensi = :id");
$stmt->execute([':id' => $id_presensi]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Data tidak ditemukan!");
}

$error = '';

if (isset($_POST['update'])) {
    $nama_peserta     = trim($_POST['nama_peserta']);
    $kelas            = trim($_POST['kelas']);
    $ekstrakurikuler  = trim($_POST['ekstrakurikuler']);
    $tanggal          = trim($_POST['tanggal']);
    $status           = trim($_POST['status']);
    $keterangan       = trim($_POST['keterangan']); // Opsional

    if (empty($nama_peserta) || empty($kelas) || empty($ekstrakurikuler) || empty($tanggal) || empty($status)) {
        $error = "Semua kolom wajib diisi, kecuali Keterangan!";
    } else {
        $sql = "UPDATE presensi_ekskul SET 
                nama_peserta = :nama_peserta, 
                kelas = :kelas, 
                ekstrakurikuler = :ekstrakurikuler, 
                tanggal = :tanggal, 
                status = :status, 
                keterangan = :keterangan 
                WHERE id_presensi = :id_presensi";
                
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nama_peserta'    => $nama_peserta,
            ':kelas'           => $kelas,
            ':ekstrakurikuler' => $ekstrakurikuler,
            ':tanggal'         => $tanggal,
            ':status'          => $status,
            ':keterangan'      => $keterangan,
            ':id_presensi'     => $id_presensi
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
    <title>Edit Presensi - Justin</title>
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
                        <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Data Presensi</h5>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- Notifikasi Error -->
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i><?= $error ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Peserta <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_peserta" value="<?= htmlspecialchars($data['nama_peserta']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="kelas" value="<?= htmlspecialchars($data['kelas']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Ekstrakurikuler <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="ekstrakurikuler" value="<?= htmlspecialchars($data['ekstrakurikuler']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal" value="<?= $data['tanggal'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status Kehadiran <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" required>
                                    <option value="Hadir" <?= $data['status'] == 'Hadir' ? 'selected' : '' ?>>Hadir</option>
                                    <option value="Izin" <?= $data['status'] == 'Izin' ? 'selected' : '' ?>>Izin</option>
                                    <option value="Sakit" <?= $data['status'] == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                                    <option value="Alpha" <?= $data['status'] == 'Alpha' ? 'selected' : '' ?>>Alpha</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Keterangan <span class="text-muted fw-normal">(Opsional)</span></label>
                                <input type="text" class="form-control" name="keterangan" value="<?= htmlspecialchars($data['keterangan']) ?>">
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-secondary">Batal</a>
                                <button type="submit" name="update" class="btn btn-primary">Update Data</button>
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