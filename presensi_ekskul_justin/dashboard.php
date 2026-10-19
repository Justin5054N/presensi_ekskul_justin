<?php
include 'koneksi.php';

// Ambil statistik total data
$stmtTotal = $pdo->query("SELECT COUNT(*) FROM presensi_ekskul");
$totalData = $stmtTotal->fetchColumn();

// Ambil statistik berdasarkan status
$stmtHadir = $pdo->query("SELECT COUNT(*) FROM presensi_ekskul WHERE status = 'Hadir'");
$totalHadir = $stmtHadir->fetchColumn();

$stmtIzin = $pdo->query("SELECT COUNT(*) FROM presensi_ekskul WHERE status = 'Izin'");
$totalIzin = $stmtIzin->fetchColumn();

$stmtSakit = $pdo->query("SELECT COUNT(*) FROM presensi_ekskul WHERE status = 'Sakit'");
$totalSakit = $stmtSakit->fetchColumn();

$stmtAlpha = $pdo->query("SELECT COUNT(*) FROM presensi_ekskul WHERE status = 'Alpha'");
$totalAlpha = $stmtAlpha->fetchColumn();

// Ambil 5 data presensi terbaru untuk ringkasan di bawah
$stmtTerbaru = $pdo->query("SELECT * FROM presensi_ekskul ORDER BY id_presensi DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Statistik - Presensi Ekskul Justin</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-calendar-check-fill me-2"></i>Presensi Ekskul Justin</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php"><i class="bi bi-table me-1"></i> Data Presensi</a>
                <a class="nav-link active fw-bold" href="dashboard.php"><i class="bi bi-speedometer2 me-1"></i> Statistik</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        
        <!-- Header Section -->
        <div class="mb-4">
            <h3 class="fw-bold text-dark">Dashboard Statistik Kehadiran</h3>
            <p class="text-muted mb-0">Ringkasan data keseluruhan peserta ekstrakurikuler.</p>
        </div>

        <!-- Cards Statistik -->
        <div class="row g-4 mb-5">
            <!-- Total Data -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white text-dark p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 text-primary p-3 rounded-4 fs-3">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="ms-3">
                            <span class="text-muted d-block small fw-semibold text-uppercase">Total Rekap Presensi</span>
                            <h2 class="fw-bold mb-0"><?= $totalData ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hadir -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white text-dark p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success bg-opacity-10 text-success p-3 rounded-4 fs-3">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="ms-3">
                            <span class="text-muted d-block small fw-semibold text-uppercase">Total Hadir</span>
                            <h2 class="fw-bold mb-0 text-success"><?= $totalHadir ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Izin -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white text-dark p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 text-primary p-3 rounded-4 fs-3">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>
                        <div class="ms-3">
                            <span class="text-muted d-block small fw-semibold text-uppercase">Total Izin</span>
                            <h2 class="fw-bold mb-0 text-primary"><?= $totalIzin ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sakit -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white text-dark p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning bg-opacity-10 text-warning p-3 rounded-4 fs-3">
                            <i class="bi bi-bandaid-fill"></i>
                        </div>
                        <div class="ms-3">
                            <span class="text-muted d-block small fw-semibold text-uppercase">Total Sakit</span>
                            <h2 class="fw-bold mb-0 text-warning"><?= $totalSakit ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alpha -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 bg-white text-dark p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-danger bg-opacity-10 text-danger p-3 rounded-4 fs-3">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                        <div class="ms-3">
                            <span class="text-muted d-block small fw-semibold text-uppercase">Total Alpha / Tanpa Keterangan</span>
                            <h2 class="fw-bold mb-0 text-danger"><?= $totalAlpha ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Aktivitas Terbaru -->
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>5 Presensi Terbaru Masuk</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase fs-7">
                            <tr>
                                <th class="py-3 ps-4">Nama Peserta</th>
                                <th class="py-3">Kelas</th>
                                <th class="py-3">Ekstrakurikuler</th>
                                <th class="py-3">Tanggal</th>
                                <th class="py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $stmtTerbaru->fetch(PDO::FETCH_ASSOC)) {
                                $badgeClass = match($row['status']) {
                                    'Hadir' => 'bg-success',
                                    'Izin'  => 'bg-primary',
                                    'Sakit' => 'bg-warning text-dark',
                                    'Alpha' => 'bg-danger',
                                    default => 'bg-secondary'
                                };

                                echo "<tr>
                                    <td class='ps-4'><strong>" . htmlspecialchars($row['nama_peserta']) . "</strong></td>
                                    <td>" . htmlspecialchars($row['kelas']) . "</td>
                                    <td>" . htmlspecialchars($row['ekstrakurikuler']) . "</td>
                                    <td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>
                                    <td><span class='badge {$badgeClass} px-2 py-1'>{$row['status']}</span></td>
                                </tr>";
                            }
                            if ($totalData == 0) {
                                echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Belum ada data presensi.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>