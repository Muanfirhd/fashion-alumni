<?php
// portfolio.php — Galeri portfolio fesyen
$page_title = 'Portfolio';
require_once __DIR__ . '/includes/header.php';
$is_admin = isset($_SESSION['admin_id']);
$result = $conn->query("SELECT p.*, a.nama AS nama_alumni FROM portfolio p LEFT JOIN alumni a ON a.id = p.alumni_id ORDER BY p.id DESC");
?>
<section class="page-banner">
  <div class="container"><h1>Portfolio Fesyen</h1><p>Koleksi hasil rekaan terbaik alumni kami.</p></div>
</section>
<section class="section">
  <div class="container">
    <?php if (isset($_GET['msg'])): ?><div class="alert alert-success auto-dismiss"><?= e($_GET['msg']) ?></div><?php endif; ?>
    <?php if ($is_admin): ?><div class="mb-4"><a href="portfolio_add.php" class="btn btn-gold"><i class="bi bi-plus-lg"></i> Tambah Portfolio</a></div><?php endif; ?>
    <div class="row g-4">
      <?php if ($result->num_rows === 0): ?><p class="text-muted">Tiada portfolio setakat ini.</p><?php endif; ?>
      <?php while ($p = $result->fetch_assoc()): ?>
      <div class="col-sm-6 col-lg-4">
        <div class="e-card">
          <?php if ($p['gambar']): ?>
            <img src="uploads/portfolio/<?= e($p['gambar']) ?>" height="240" alt="<?= e($p['nama_rekaan']) ?>">
          <?php else: ?>
            <div class="d-flex align-items-center justify-content-center bg-dark text-warning" style="height:240px;"><i class="bi bi-image fs-1"></i></div>
          <?php endif; ?>
          <div class="p-4">
            <span class="card-tag gold"><i class="bi bi-person me-1"></i><?= e($p['nama_alumni'] ?? 'Alumni') ?></span>
            <h5 class="mt-2 serif"><?= e($p['nama_rekaan']) ?></h5>
            <p class="section-sub small"><?= e($p['penerangan']) ?></p>
            <?php if ($is_admin): ?>
            <div class="d-flex gap-2 mt-2">
              <a href="portfolio_edit.php?id=<?= (int)$p['id'] ?>" class="btn btn-outline-dark btn-sm-e"><i class="bi bi-pencil"></i> Edit</a>
              <a href="portfolio_delete.php?id=<?= (int)$p['id'] ?>" class="btn btn-outline-danger btn-sm-e confirm-delete"><i class="bi bi-trash"></i> Padam</a>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
