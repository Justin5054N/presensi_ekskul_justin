<?php
include 'koneksi.php';

$id_presensi = $_GET['id'] ?? null;

if ($id_presensi) {
    $sql = "DELETE FROM presensi_ekskul WHERE id_presensi = :id_presensi";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_presensi' => $id_presensi]);
}

header("Location: index.php");
exit;
?>