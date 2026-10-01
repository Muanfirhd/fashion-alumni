<?php
// alumni_add.php — Borang tambah alumni (admin)
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$errors = [];
$data = ['nama'=>'','tahun_tamat'=>'','bidang'=>'','pekerjaan'=>'','telefon'=>'','email'=>'','alamat'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($data as $k => $v) { $data[$k] = trim($_POST[$k] ?? ''); }

    if ($data['nama'] === '')        { $errors[] = 'Nama diperlukan.'; }
    if ($data['tahun_tamat'] === '' || !preg_match('/^\d{4}$/', $data['tahun_tamat'])) { $errors[] = 'Tahun tamat tidak sah (cth: 2023).'; }
    if ($data['bidang'] === '')      { $errors[] = 'Bidang diperlukan.'; }
    if ($data['email'] !== '' && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) { $errors[] = 'Format e-mel tidak sah.'; }

    $gambar = null;
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = upload_gambar('gambar', 'alumni');
        if ($gambar === false) { $errors[] = 'Gambar tidak sah (JPG/PNG/GIF/WEBP, maks 2MB).'; $gambar = null; }
    }

    if (!$errors) {
        $stmt = $conn->prepare("INSERT INTO alumni (nama, tahun_tamat, bidang, pekerjaan, telefon, email, alamat, gambar) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssss", $data['nama'], $data['tahun_tamat'], $data['bidang'], $data['pekerjaan'], $data['telefon'], $data['email'], $data['alamat'], $gambar);
        if ($stmt->execute()) {
            header("Location: alumni.php?msg=" . urlencode("Alumni berjaya ditambah."));
            exit();
        }
        $errors[] = 'Gagal menyimpan rekod.';
    }
}
$page_title = 'Tambah Alumni';
require_once __DIR__ . '/includes/admin_header.php';
?>
<div class="card dash-card">
  <div class="card-body p-4">
    <h4 class="serif mb-4">Borang Tambah Alumni</h4>
    <?php foreach ($errors as $err): ?><div class="alert alert-danger py-2 small"><?= e($err) ?></div><?php endforeach; ?>
    <form method="post" enctype="multipart/form-data">
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Nama Penuh *</label><input type="text" name="nama" class="form-control" value="<?= e($data['nama']) ?>" required></div>
        <div class="col-md-3"><label class="form-label">Tahun Tamat *</label><input type="number" name="tahun_tamat" class="form-control" min="1990" max="2100" value="<?= e($data['tahun_tamat']) ?>" required></div>
        <div class="col-md-3"><label class="form-label">Bidang *</label>
          <select name="bidang" class="form-select" required>
            <option value="">— Pilih —</option>
            <?php foreach (['Pereka Fesyen','Pengurusan Fesyen','Tekstil & Fabrik','Fesyen Komunikasi','Pemasaran Fesyen','Lain-lain'] as $b): ?>
              <option <?= $data['bidang']===$b?'selected':'' ?>><?= e($b) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6"><label class="form-label">Pekerjaan</label><input type="text" name="pekerjaan" class="form-control" value="<?= e($data['pekerjaan']) ?>"></div>
        <div class="col-md-3"><label class="form-label">Telefon</label><input type="text" name="telefon" class="form-control" value="<?= e($data['telefon']) ?>"></div>
        <div class="col-md-3"><label class="form-label">E-mel</label><input type="email" name="email" class="form-control" value="<?= e($data['email']) ?>"></div>
        <div class="col-12"><label class="form-label">Alamat</label><textarea name="alamat" class="form-control" rows="2"><?= e($data['alamat']) ?></textarea></div>
        <div class="col-12"><label class="form-label">Gambar Profil</label><input type="file" name="gambar" class="form-control" accept="image/*"></div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button class="btn btn-gold" type="submit"><i class="bi bi-save"></i> Simpan</button>
        <a href="alumni.php" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
