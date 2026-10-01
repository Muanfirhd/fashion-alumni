<?php
// kerjaya_delete.php — Padam kerjaya (admin)
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM kerjaya WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: kerjaya.php?msg=" . urlencode("Kerjaya telah dipadam."));
    exit();
}
header("Location: kerjaya.php");
exit();
