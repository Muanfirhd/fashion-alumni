<?php
// portfolio_delete.php — Padam portfolio (admin)
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare("SELECT gambar FROM portfolio WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if ($row) {
        padam_gambar('portfolio', $row['gambar']);
        $stmt = $conn->prepare("DELETE FROM portfolio WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: portfolio.php?msg=" . urlencode("Portfolio telah dipadam."));
        exit();
    }
}
header("Location: portfolio.php");
exit();
