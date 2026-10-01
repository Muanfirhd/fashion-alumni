<?php
// alumni_delete.php — Padam alumni (admin)
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare("SELECT gambar FROM alumni WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if ($row) {
        padam_gambar('alumni', $row['gambar']);
        $stmt = $conn->prepare("DELETE FROM alumni WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: alumni.php?msg=" . urlencode("Rekod alumni telah dipadam."));
        exit();
    }
}
header("Location: alumni.php");
exit();
