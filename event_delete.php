<?php
// event_delete.php — Padam event (admin)
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare("SELECT gambar FROM event WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if ($row) {
        padam_gambar('event', $row['gambar']);
        $stmt = $conn->prepare("DELETE FROM event WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: event.php?msg=" . urlencode("Event telah dipadam."));
        exit();
    }
}
header("Location: event.php");
exit();
