<?php
// portfolio_edit.php — Kemas kini portfolio (admin)
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM portfolio WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();
if (!$p) { header("Location: portfolio.php"); exit(); }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $p['nama_rekaan'] = trim($_POST['nama_rekaan'] ?? '');
    $p['penerangan']  = trim($_POST['penerangan'] ?? '');
    $p['alumni_id']   = (int)($_POST['alumni_id'] ?? 0) ?: null;
    if ($p['nama_rekaan'] === '') { $errors[] = 'Nama rekaan diperlukan.'; }

    if (!empty($_FILES['gambar']['name'])) {
        $baru = upload_gambar('gambar', 'portfolio');
        if ($baru === false) { $errors[] = 'Gambar tidak sah.'; }
        else { padam_gambar('portfolio', $p['gambar']); $p['gambar'] = $baru; }
    }
    if (!$errors) {
        $stmt = $conn->prepare("UPDATE portfolio SET nama_rekaan=?, penerangan=?, gambar=?, alumni_id=? WHERE id=?");
        $stmt->bind_param("sssii", $p['nama_rekaan'], $p['penerangan'], $p['gambar'], $p['alumni_id'], $id);
        if ($stmt->execute()) { header("Location: portfolio.php?msg=" . urlencode("Portfolio berjaya dikemas kini.")); exit(); }
        $errors[] = 'Gagal mengemas kini.';
    }
}
$alumni_list = $conn->query("SELECT id, nama FROM alumni ORDER BY nama ASC");
$page_title = 'Kemas Kini Portfolio';
require_once __DIR__ . '/includes/admin_header.php';
?>
<div class="card dash-card"><div class="card-body p-4">
  <h4 class="serif mb-4">Kemas Kini: <?= e($p['nama_rekaan']) ?></h4>
  <?php foreach ($errors as $err): ?><div class="alert alert-danger py-2 small"><?= e($err) ?></div><?php endforeach; ?>
  <form method="post" enctype="multipart/form-data">
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">Nama Rekaan *</label><input type="text" name="nama_rekaan" class="form-control" value="<?= e($p['nama_rekaan']) ?>" required></div>
      <div class="col-md-6"><label class="form-label">Alumni</label>
        <select name="alumni_id" class="form-select">
          <option value="">— Pilih Alumni —</option>
          <?php while ($a = $alumni_list->fetch_assoc()): ?><option value="<?= (int)$a['id'] ?>" <?= $p['alumni_id']==$a['id']?'selected':'' ?>><?= e($a['nama']) ?></option><?php endwhile; ?>
        </select>
      </div>
      <div class="col-12"><label class="form-label">Penerangan</label><textarea name="penerangan" class="form-control" rows="3"><?= e($p['penerangan']) ?></textarea></div>
      <div class="col-md-8"><label class="form-label">Tukar Gambar</label><input type="file" name="gambar" class="form-control" accept="image/*"></div>
      <div class="col-md-4"><?php if ($p['gambar']): ?><label class="form-label">Gambar Semasa</label><br><img src="uploads/portfolio/<?= e($p['gambar']) ?>" style="height:60px;border-radius:.5rem;" alt=""><?php endif; ?></div>
    </div>
    <div class="mt-4 d-flex gap-2">
      <button class="btn btn-gold" type="submit"><i class="bi bi-save"></i> Kemas Kini</button>
      <a href="portfolio.php" class="btn btn-outline-secondary">Batal</a>
    </div>
  </form>
</div></div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
