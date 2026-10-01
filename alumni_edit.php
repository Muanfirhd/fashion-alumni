<?php
// alumni_edit.php — Borang kemas kini alumni (admin)
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM alumni WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$alumni = $stmt->get_result()->fetch_assoc();
if (!$alumni) { header("Location: alumni.php"); exit(); }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (['nama','tahun_tamat','bidang','pekerjaan','telefon','email','alamat'] as $k) {
        $alumni[$k] = trim($_POST[$k] ?? '');
    }
    if ($alumni['nama'] === '') { $errors[] = 'Nama diperlukan.'; }
    if (!preg_match('/^\d{4}$/', $alumni['tahun_tamat'])) { $errors[] = 'Tahun tamat tidak sah.'; }
    if ($alumni['bidang'] === '') { $errors[] = 'Bidang diperlukan.'; }
    if ($alumni['email'] !== '' && !filter_var($alumni['email'], FILTER_VALIDATE_EMAIL)) { $errors[] = 'Format e-mel tidak sah.'; }

    $gambar = $alumni['gambar'];
    if (!empty($_FILES['gambar']['name'])) {
        $baru = upload_gambar('gambar', 'alumni');
        if ($baru === false) { $errors[] = 'Gambar tidak sah (JPG/PNG/GIF/WEBP, maks 2MB).'; }
        else { padam_gambar('alumni', $gambar); $gambar = $baru; }
    }

    if (!$errors) {
        $stmt = $conn->prepare("UPDATE alumni SET nama=?, tahun_tamat=?, bidang=?, pekerjaan=?, telefon=?, email=?, alamat=?, gambar=? WHERE id=?");
        $stmt->bind_param("ssssssssi", $alumni['nama'], $alumni['tahun_tamat'], $alumni['bidang'], $alumni['pekerjaan'], $alumni['telefon'], $alumni['email'], $alumni['alamat'], $gambar, $id);
        if ($stmt->execute()) {
            header("Location: alumni.php?msg=" . urlencode("Rekod alumni berjaya dikemas kini."));
            exit();
        }
        $errors[] = 'Gagal mengemas kini rekod.';
    }
}

$page_title = 'Kemas Kini Alumni';
require_once __DIR__ . '/includes/admin_header.php';
?>
<div class="card dash-card">
  <div class="card-body p-4">
    <h4 class="serif mb-4">Kemas Kini: <?= e($alumni['nama']) ?></h4>
    <?php foreach ($errors as $err): ?><div class="alert alert-danger py-2 small"><?= e($err) ?></div><?php endforeach; ?>
    <form method="post" enctype="multipart/form-data">
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Nama Penuh *</label><input type="text" name="nama" class="form-control" value="<?= e($alumni['nama']) ?>" required></div>
        <div class="col-md-3"><label class="form-label">Tahun Tamat *</label><input type="number" name="tahun_tamat" class="form-control" min="1990" max="2100" value="<?= e($alumni['tahun_tamat']) ?>" required></div>
        <div class="col-md-3"><label class="form-label">Bidang *</label>
          <select name="bidang" class="form-select" required>
            <?php foreach (['Pereka Fesyen','Pengurusan Fesyen','Tekstil & Fabrik','Fesyen Komunikasi','Pemasaran Fesyen','Lain-lain'] as $b): ?>
              <option <?= $alumni['bidang']===$b?'selected':'' ?>><?= e($b) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6"><label class="form-label">Pekerjaan</label><input type="text" name="pekerjaan" class="form-control" value="<?= e($alumni['pekerjaan']) ?>"></div>
        <div class="col-md-3"><label class="form-label">Telefon</label><input type="text" name="telefon" class="form-control" value="<?= e($alumni['telefon']) ?>"></div>
        <div class="col-md-3"><label class="form-label">E-mel</label><input type="email" name="email" class="form-control" value="<?= e($alumni['email']) ?>"></div>
        <div class="col-12"><label class="form-label">Alamat</label><textarea name="alamat" class="form-control" rows="2"><?= e($alumni['alamat']) ?></textarea></div>
        <div class="col-md-8"><label class="form-label">Tukar Gambar Profil</label><input type="file" name="gambar" class="form-control" accept="image/*"></div>
        <div class="col-md-4">
          <?php if ($alumni['gambar']): ?>
            <label class="form-label">Gambar Semasa</label><br>
            <img src="uploads/alumni/<?= e($alumni['gambar']) ?>" class="avatar-sm" alt="">
          <?php endif; ?>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button class="btn btn-gold" type="submit"><i class="bi bi-save"></i> Kemas Kini</button>
        <a href="alumni.php" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
