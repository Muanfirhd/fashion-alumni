<?php
// portfolio_add.php — Tambah portfolio (admin)
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
$errors = [];
$nama_rekaan = ''; $penerangan = ''; $alumni_id = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_rekaan = trim($_POST['nama_rekaan'] ?? '');
    $penerangan  = trim($_POST['penerangan'] ?? '');
    $alumni_id   = (int)($_POST['alumni_id'] ?? 0);
    if ($nama_rekaan === '') { $errors[] = 'Nama rekaan diperlukan.'; }

    $gambar = null;
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = upload_gambar('gambar', 'portfolio');
        if ($gambar === false) { $errors[] = 'Gambar tidak sah (JPG/PNG/GIF/WEBP, maks 2MB).'; $gambar = null; }
    }
    if (!$errors) {
        $aid = $alumni_id > 0 ? $alumni_id : null;
        $stmt = $conn->prepare("INSERT INTO portfolio (nama_rekaan, penerangan, gambar, alumni_id) VALUES (?,?,?,?)");
        $stmt->bind_param("sssi", $nama_rekaan, $penerangan, $gambar, $aid);
        if ($stmt->execute()) { header("Location: portfolio.php?msg=" . urlencode("Portfolio berjaya ditambah.")); exit(); }
        $errors[] = 'Gagal menyimpan rekod.';
    }
}
$alumni_list = $conn->query("SELECT id, nama FROM alumni ORDER BY nama ASC");
$page_title = 'Tambah Portfolio';
require_once __DIR__ . '/includes/admin_header.php';
?>
<div class="card dash-card"><div class="card-body p-4">
  <h4 class="serif mb-4">Tambah Portfolio</h4>
  <?php foreach ($errors as $err): ?><div class="alert alert-danger py-2 small"><?= e($err) ?></div><?php endforeach; ?>
  <form method="post" enctype="multipart/form-data">
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">Nama Rekaan *</label><input type="text" name="nama_rekaan" class="form-control" value="<?= e($nama_rekaan) ?>" required></div>
      <div class="col-md-6"><label class="form-label">Alumni</label>
        <select name="alumni_id" class="form-select">
          <option value="">— Pilih Alumni —</option>
          <?php while ($a = $alumni_list->fetch_assoc()): ?><option value="<?= (int)$a['id'] ?>" <?= $alumni_id==$a['id']?'selected':'' ?>><?= e($a['nama']) ?></option><?php endwhile; ?>
        </select>
      </div>
      <div class="col-12"><label class="form-label">Penerangan</label><textarea name="penerangan" class="form-control" rows="3"><?= e($penerangan) ?></textarea></div>
      <div class="col-12"><label class="form-label">Gambar Rekaan</label><input type="file" name="gambar" class="form-control" accept="image/*"></div>
    </div>
    <div class="mt-4 d-flex gap-2">
      <button class="btn btn-gold" type="submit"><i class="bi bi-save"></i> Simpan</button>
      <a href="portfolio.php" class="btn btn-outline-secondary">Batal</a>
    </div>
  </form>
</div></div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
