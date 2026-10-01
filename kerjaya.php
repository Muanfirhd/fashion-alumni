<?php
// kerjaya.php — Senarai peluang kerjaya
$page_title = 'Peluang Kerjaya';
require_once __DIR__ . '/includes/header.php';
$is_admin = isset($_SESSION['admin_id']);
$result = $conn->query("SELECT * FROM kerjaya ORDER BY tarikh_post DESC, id DESC");
?>
<section class="page-banner">
  <div class="container"><h1>Peluang Kerjaya</h1><p>Jawatan kosong terkini dalam industri fesyen.</p></div>
</section>
<section class="section">
  <div class="container">
    <?php if (isset($_GET['msg'])): ?><div class="alert alert-success auto-dismiss"><?= e($_GET['msg']) ?></div><?php endif; ?>
    <?php if ($is_admin): ?><div class="mb-4"><a href="kerjaya_add.php" class="btn btn-gold"><i class="bi bi-plus-lg"></i> Tambah Kerjaya</a></div><?php endif; ?>
    <div class="row g-4">
      <?php if ($result->num_rows === 0): ?><p class="text-muted">Tiada peluang kerjaya setakat ini.</p><?php endif; ?>
      <?php while ($k = $result->fetch_assoc()): ?>
      <div class="col-md-6 col-lg-4">
        <div class="e-card p-4">
          <span class="card-tag"><i class="bi bi-clock me-1"></i><?= e(date('d M Y', strtotime($k['tarikh_post']))) ?></span>
          <h5 class="serif mt-2"><?= e($k['jawatan']) ?></h5>
          <div class="small mb-2" style="color:var(--gold);font-weight:600;"><i class="bi bi-building me-1"></i><?= e($k['syarikat']) ?></div>
          <div class="small text-muted mb-2"><i class="bi bi-geo-alt me-1"></i><?= e($k['lokasi']) ?></div>
          <p class="section-sub small"><?= e($k['penerangan']) ?></p>
          <?php if ($is_admin): ?>
          <div class="d-flex gap-2">
            <a href="kerjaya_edit.php?id=<?= (int)$k['id'] ?>" class="btn btn-outline-dark btn-sm-e"><i class="bi bi-pencil"></i> Edit</a>
            <a href="kerjaya_delete.php?id=<?= (int)$k['id'] ?>" class="btn btn-outline-danger btn-sm-e confirm-delete"><i class="bi bi-trash"></i> Padam</a>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
