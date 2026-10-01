<?php
// kerjaya_add.php — Tambah kerjaya (admin)
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
$errors = [];
$data = ['jawatan'=>'','syarikat'=>'','lokasi'=>'','penerangan'=>'','tarikh_post'=>date('Y-m-d')];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (['jawatan','syarikat','lokasi','penerangan','tarikh_post'] as $k) { $data[$k] = trim($_POST[$k] ?? ''); }
    if ($data['jawatan'] === '')  { $errors[] = 'Jawatan diperlukan.'; }
    if ($data['syarikat'] === '') { $errors[] = 'Syarikat diperlukan.'; }
    if ($data['tarikh_post'] === '') { $data['tarikh_post'] = date('Y-m-d'); }
    if (!$errors) {
        $stmt = $conn->prepare("INSERT INTO kerjaya (jawatan, syarikat, lokasi, penerangan, tarikh_post) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $data['jawatan'], $data['syarikat'], $data['lokasi'], $data['penerangan'], $data['tarikh_post']);
        if ($stmt->execute()) { header("Location: kerjaya.php?msg=" . urlencode("Kerjaya berjaya ditambah.")); exit(); }
        $errors[] = 'Gagal menyimpan rekod.';
    }
}

$page_title = 'Tambah Kerjaya';
require_once __DIR__ . '/includes/admin_header.php';
?>
<div class="card dash-card"><div class="card-body p-4">
  <h4 class="serif mb-4">Tambah Kerjaya</h4>
  <?php foreach ($errors as $err): ?><div class="alert alert-danger py-2 small"><?= e($err) ?></div><?php endforeach; ?>
  <form method="post">
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">Jawatan *</label><input type="text" name="jawatan" class="form-control" value="<?= e($data['jawatan']) ?>" required></div>
      <div class="col-md-6"><label class="form-label">Syarikat *</label><input type="text" name="syarikat" class="form-control" value="<?= e($data['syarikat']) ?>" required></div>
      <div class="col-md-6"><label class="form-label">Lokasi</label><input type="text" name="lokasi" class="form-control" value="<?= e($data['lokasi']) ?>"></div>
      <div class="col-md-6"><label class="form-label">Tarikh Paparan</label><input type="date" name="tarikh_post" class="form-control" value="<?= e($data['tarikh_post']) ?>"></div>
      <div class="col-12"><label class="form-label">Penerangan</label><textarea name="penerangan" class="form-control" rows="4"><?= e($data['penerangan']) ?></textarea></div>
    </div>
    <div class="mt-4 d-flex gap-2">
      <button class="btn btn-gold" type="submit"><i class="bi bi-save"></i> Simpan</button>
      <a href="kerjaya.php" class="btn btn-outline-secondary">Batal</a>
    </div>
  </form>
</div></div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
