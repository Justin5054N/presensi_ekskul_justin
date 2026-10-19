<?php
include 'koneksi.php';

// Ambil nilai filter dari URL (jika ada)
$filter_status = $_GET['status'] ?? '';
$filter_ekskul = $_GET['ekstrakurikuler'] ?? '';

$sql = "SELECT * FROM presensi_ekskul WHERE 1=1";
$params = [];

if (!empty($filter_status)) {
    $sql .= " AND status = :status";
    $params[':status'] = $filter_status;
}

if (!empty($filter_ekskul)) {
    $sql .= " AND ekstrakurikuler = :ekstrakurikuler";
    $params[':ekstrakurikuler'] = $filter_ekskul;
}

$sql .= " ORDER BY id_presensi DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$stmtEkskulList = $pdo->query("SELECT DISTINCT ekstrakurikuler FROM presensi_ekskul ORDER BY ekstrakurikuler ASC");
$ekskulList = $stmtEkskulList->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Ekstrakurikuler - Justin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-calendar-check-fill me-2"></i>Presensi Ekskul Justin</a>
            <div class="navbar-nav ms-auto flex-row gap-3">
                <a class="nav-link active fw-bold text-white" href="index.php"><i class="bi bi-table me-1"></i> Data Presensi</a>
                <a class="nav-link text-white-50" href="dashboard.php"><i class="bi bi-speedometer2 me-1"></i> Statistik</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark">Data Presensi Ekstrakurikuler</h3>
                <p class="text-muted mb-0">Kelola data kehadiran peserta ekstrakurikuler dengan mudah.</p>
            </div>
            <a href="tambah.php" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Presensi
            </a>
        </div>

        <!-- Form Filter -->
        <div class="card shadow-sm border-0 rounded-4 mb-4 p-3 bg-white">
            <form method="GET" action="" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold small text-muted">Filter Status</label>
                    <select name="status" class="form-select">
                        <option value="">-- Semua Status --</option>
                        <option value="Hadir" <?= $filter_status == 'Hadir' ? 'selected' : '' ?>>Hadir</option>
                        <option value="Izin" <?= $filter_status == 'Izin' ? 'selected' : '' ?>>Izin</option>
                        <option value="Sakit" <?= $filter_status == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                        <option value="Alpha" <?= $filter_status == 'Alpha' ? 'selected' : '' ?>>Alpha</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold small text-muted">Filter Ekstrakurikuler</label>
                    <select name="ekstrakurikuler" class="form-select">
                        <option value="">-- Semua Ekstrakurikuler --</option>
                        <?php foreach ($ekskulList as $eks): ?>
                            <option value="<?= htmlspecialchars($eks) ?>" <?= $filter_ekskul == $eks ? 'selected' : '' ?>><?= htmlspecialchars($eks) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-dark w-100"><i class="bi bi-filter me-1"></i> Filter</button>
                    <a href="index.php" class="btn btn-outline-secondary w-100"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset</a>
                </div>
            </form>
        </div>

        <!-- Tabel Data -->
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <!-- HEADER DISAMAIN DENGAN WARNA NAVBAR (bg-primary) -->
                        <thead class="bg-primary text-white text-uppercase fs-7">
                            <tr>
                                <th class="py-3 ps-4 bg-primary text-white">#</th>
                                <th class="py-3 bg-primary text-white">Nama Peserta</th>
                                <th class="py-3 bg-primary text-white">Kelas</th>
                                <th class="py-3 bg-primary text-white">Ekstrakurikuler</th>
                                <th class="py-3 bg-primary text-white">Tanggal</th>
                                <th class="py-3 bg-primary text-white">Status</th>
                                <th class="py-3 bg-primary text-white">Keterangan</th>
                                <th class="py-3 text-center bg-primary text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $badgeClass = match($row['status']) {
                                    'Hadir' => 'bg-success',
                                    'Izin'  => 'bg-primary',
                                    'Sakit' => 'bg-warning text-dark',
                                    'Alpha' => 'bg-danger',
                                    default => 'bg-secondary'
                                };

                                echo "<tr>
                                    <td class='ps-4 fw-bold'>{$no}</td>
                                    <td><strong>" . htmlspecialchars($row['nama_peserta']) . "</strong></td>
                                    <td>" . htmlspecialchars($row['kelas']) . "</td>
                                    <td>" . htmlspecialchars($row['ekstrakurikuler']) . "</td>
                                    <td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>
                                    <td><span class='badge {$badgeClass} px-2 py-1'>{$row['status']}</span></td>
                                    <td>" . (!empty($row['keterangan']) ? htmlspecialchars($row['keterangan']) : '<span class="text-muted fst-italic">Tidak ada</span>') . "</td>
                                    <td class='text-center'>
                                        <a href='edit.php?id={$row['id_presensi']}' class='btn btn-sm btn-warning text-white me-1' title='Edit'><i class='bi bi-pencil-square'></i></a>
                                        <a href='hapus.php?id={$row['id_presensi']}' class='btn btn-sm btn-danger' title='Hapus' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'><i class='bi bi-trash'></i></a>
                                    </td>
                                </tr>";
                                $no++;
                            }
                            if ($no == 1) {
                                echo "<tr><td colspan='8' class='text-center py-4 text-muted'>Tidak ada data presensi yang sesuai.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>