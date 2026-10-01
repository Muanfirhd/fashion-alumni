<?php
// event_edit.php — Kemas kini event (admin)
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM event WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$ev = $stmt->get_result()->fetch_assoc();
if (!$ev) { header("Location: event.php"); exit(); }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (['nama_event','tarikh','lokasi','penerangan'] as $k) { $ev[$k] = trim($_POST[$k] ?? ''); }
    if ($ev['nama_event'] === '') { $errors[] = 'Nama event diperlukan.'; }
    if ($ev['tarikh'] === '')     { $errors[] = 'Tarikh diperlukan.'; }

    if (!empty($_FILES['gambar']['name'])) {
        $baru = upload_gambar('gambar', 'event');
        if ($baru === false) { $errors[] = 'Gambar tidak sah.'; }
        else { padam_gambar('event', $ev['gambar']); $ev['gambar'] = $baru; }
    }
    if (!$errors) {
        $stmt = $conn->prepare("UPDATE event SET nama_event=?, tarikh=?, lokasi=?, penerangan=?, gambar=? WHERE id=?");
        $stmt->bind_param("sssssi", $ev['nama_event'], $ev['tarikh'], $ev['lokasi'], $ev['penerangan'], $ev['gambar'], $id);
        if ($stmt->execute()) { header("Location: event.php?msg=" . urlencode("Event berjaya dikemas kini.")); exit(); }
        $errors[] = 'Gagal mengemas kini.';
    }
}
$page_title = 'Kemas Kini Event';
require_once __DIR__ . '/includes/admin_header.php';
?>
<div class="card dash-card"><div class="card-body p-4">
  <h4 class="serif mb-4">Kemas Kini: <?= e($ev['nama_event']) ?></h4>
  <?php foreach ($errors as $err): ?><div class="alert alert-danger py-2 small"><?= e($err) ?></div><?php endforeach; ?>
  <form method="post" enctype="multipart/form-data">
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">Nama Event *</label><input type="text" name="nama_event" class="form-control" value="<?= e($ev['nama_event']) ?>" required></div>
      <div class="col-md-3"><label class="form-label">Tarikh *</label><input type="date" name="tarikh" class="form-control" value="<?= e($ev['tarikh']) ?>" required></div>
      <div class="col-md-3"><label class="form-label">Lokasi</label><input type="text" name="lokasi" class="form-control" value="<?= e($ev['lokasi']) ?>"></div>
      <div class="col-12"><label class="form-label">Penerangan</label><textarea name="penerangan" class="form-control" rows="3"><?= e($ev['penerangan']) ?></textarea></div>
      <div class="col-md-8"><label class="form-label">Tukar Poster / Gambar</label><input type="file" name="gambar" class="form-control" accept="image/*"></div>
      <div class="col-md-4"><?php if ($ev['gambar']): ?><label class="form-label">Gambar Semasa</label><br><img src="uploads/event/<?= e($ev['gambar']) ?>" style="height:60px;border-radius:.5rem;" alt=""><?php endif; ?></div>
    </div>
    <div class="mt-4 d-flex gap-2">
      <button class="btn btn-gold" type="submit"><i class="bi bi-save"></i> Kemas Kini</button>
      <a href="event.php" class="btn btn-outline-secondary">Batal</a>
    </div>
  </form>
</div></div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
