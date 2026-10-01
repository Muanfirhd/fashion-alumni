<?php
// contact.php — Borang hubungi kami
$page_title = 'Hubungi Kami';
require_once __DIR__ . '/includes/header.php';

$success = ''; $errors = [];
$nama = ''; $email = ''; $mesej = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mesej = trim($_POST['mesej'] ?? '');
    if ($nama === '')  { $errors[] = 'Nama diperlukan.'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'E-mel tidak sah.'; }
    if ($mesej === '') { $errors[] = 'Mesej diperlukan.'; }
    if (!$errors) {
        $stmt = $conn->prepare("INSERT INTO contact (nama, email, mesej) VALUES (?,?,?)");
        $stmt->bind_param("sss", $nama, $email, $mesej);
        if ($stmt->execute()) { $success = 'Terima kasih! Mesej anda telah diterima.'; $nama = $email = $mesej = ''; }
        else { $errors[] = 'Gagal menghantar mesej. Sila cuba lagi.'; }
    }
}
?>
<section class="page-banner">
  <div class="container"><h1>Hubungi Kami</h1><p>Ada pertanyaan? Pihak pengurusan sedia membantu.</p></div>
</section>
<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-5">
        <h3 class="serif">Maklumat Perhubungan</h3>
        <div class="gold-line"></div>
        <p class="section-sub">Sila hubungi pihak pengurusan FAOSC untuk sebarang pertanyaan mengenai keahlian alumni, kerjasama industri atau event.</p>
        <ul class="list-unstyled mt-4">
          <li class="mb-3"><i class="bi bi-envelope me-2" style="color:var(--gold);"></i>info@faosc.edu.my</li>
          <li class="mb-3"><i class="bi bi-telephone me-2" style="color:var(--gold);"></i>+603-1234 5678</li>
          <li class="mb-3"><i class="bi bi-geo-alt me-2" style="color:var(--gold);"></i>Kuala Lumpur, Malaysia</li>
          <li><i class="bi bi-clock me-2" style="color:var(--gold);"></i>Isnin – Jumaat, 9:00 pagi – 5:00 petang</li>
        </ul>
      </div>
      <div class="col-lg-7">
        <div class="card e-card p-4">
          <?php if ($success): ?><div class="alert alert-success auto-dismiss"><?= e($success) ?></div><?php endif; ?>
          <?php foreach ($errors as $err): ?><div class="alert alert-danger py-2 small"><?= e($err) ?></div><?php endforeach; ?>
          <form method="post">
            <div class="row g-3">
              <div class="col-md-6"><label class="form-label">Nama *</label><input type="text" name="nama" class="form-control" value="<?= e($nama) ?>" required></div>
              <div class="col-md-6"><label class="form-label">E-mel *</label><input type="email" name="email" class="form-control" value="<?= e($email) ?>" required></div>
              <div class="col-12"><label class="form-label">Mesej *</label><textarea name="mesej" class="form-control" rows="5" required><?= e($mesej) ?></textarea></div>
            </div>
            <button class="btn btn-gold mt-4" type="submit"><i class="bi bi-send"></i> Hantar Mesej</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
