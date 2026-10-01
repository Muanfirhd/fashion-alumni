<?php
// event_add.php — Tambah event (admin)
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$errors = [];
$data = ['nama_event'=>'','tarikh'=>'','lokasi'=>'','penerangan'=>''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($data as $k => $v) { $data[$k] = trim($_POST[$k] ?? ''); }
    if ($data['nama_event'] === '') { $errors[] = 'Nama event diperlukan.'; }
    if ($data['tarikh'] === '')     { $errors[] = 'Tarikh diperlukan.'; }

    $gambar = null;
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = upload_gambar('gambar', 'event');
        if ($gambar === false) { $errors[] = 'Gambar tidak sah (JPG/PNG/GIF/WEBP, maks 2MB).'; $gambar = null; }
    }
    if (!$errors) {
        $stmt = $conn->prepare("INSERT INTO event (nama_event, tarikh, lokasi, penerangan, gambar) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $data['nama_event'], $data['tarikh'], $data['lokasi'], $data['penerangan'], $gambar);
        if ($stmt->execute()) { header("Location: event.php?msg=" . urlencode("Event berjaya ditambah.")); exit(); }
        $errors[] = 'Gagal menyimpan rekod.';
    }
}
$page_title = 'Tambah Event';
require_once __DIR__ . '/includes/admin_header.php';
?>
<div class="card dash-card"><div class="card-body p-4">
  <h4 class="serif mb-4">Tambah Event</h4>
  <?php foreach ($errors as $err): ?><div class="alert alert-danger py-2 small"><?= e($err) ?></div><?php endforeach; ?>
  <form method="post" enctype="multipart/form-data">
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">Nama Event *</label><input type="text" name="nama_event" class="form-control" value="<?= e($data['nama_event']) ?>" required></div>
      <div class="col-md-3"><label class="form-label">Tarikh *</label><input type="date" name="tarikh" class="form-control" value="<?= e($data['tarikh']) ?>" required></div>
      <div class="col-md-3"><label class="form-label">Lokasi</label><input type="text" name="lokasi" class="form-control" value="<?= e($data['lokasi']) ?>"></div>
      <div class="col-12"><label class="form-label">Penerangan</label><textarea name="penerangan" class="form-control" rows="3"><?= e($data['penerangan']) ?></textarea></div>
      <div class="col-12"><label class="form-label">Poster / Gambar Event</label><input type="file" name="gambar" class="form-control" accept="image/*"></div>
    </div>
    <div class="mt-4 d-flex gap-2">
      <button class="btn btn-gold" type="submit"><i class="bi bi-save"></i> Simpan</button>
      <a href="event.php" class="btn btn-outline-secondary">Batal</a>
    </div>
  </form>
</div></div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
