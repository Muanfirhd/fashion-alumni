<?php
// event.php — Senarai event
$page_title = 'Event';
require_once __DIR__ . '/includes/header.php';
$is_admin = isset($_SESSION['admin_id']);
$result = $conn->query("SELECT * FROM event ORDER BY tarikh ASC");
?>
<section class="page-banner">
  <div class="container"><h1>Event Alumni</h1><p>Program, bengkel dan majlis rasmi komuniti FAOSC.</p></div>
</section>
<section class="section">
  <div class="container">
    <?php if (isset($_GET['msg'])): ?><div class="alert alert-success auto-dismiss"><?= e($_GET['msg']) ?></div><?php endif; ?>
    <?php if ($is_admin): ?><div class="mb-4"><a href="event_add.php" class="btn btn-gold"><i class="bi bi-plus-lg"></i> Tambah Event</a></div><?php endif; ?>
    <div class="row g-4">
      <?php if ($result->num_rows === 0): ?><p class="text-muted">Tiada event setakat ini.</p><?php endif; ?>
      <?php while ($ev = $result->fetch_assoc()): ?>
      <div class="col-md-6 col-lg-4">
        <div class="e-card">
          <?php if ($ev['gambar']): ?>
            <img src="uploads/event/<?= e($ev['gambar']) ?>" height="200" alt="<?= e($ev['nama_event']) ?>">
          <?php else: ?>
            <div class="d-flex align-items-center justify-content-center bg-dark text-warning" style="height:200px;"><i class="bi bi-calendar-event fs-1"></i></div>
          <?php endif; ?>
          <div class="p-4">
            <span class="card-tag gold"><i class="bi bi-calendar3 me-1"></i><?= e(date('d M Y', strtotime($ev['tarikh']))) ?></span>
            <h5 class="serif mt-2"><?= e($ev['nama_event']) ?></h5>
            <div class="small text-muted mb-2"><i class="bi bi-geo-alt me-1"></i><?= e($ev['lokasi']) ?></div>
            <p class="section-sub small"><?= e($ev['penerangan']) ?></p>
            <?php if ($is_admin): ?>
            <div class="d-flex gap-2">
              <a href="event_edit.php?id=<?= (int)$ev['id'] ?>" class="btn btn-outline-dark btn-sm-e"><i class="bi bi-pencil"></i> Edit</a>
              <a href="event_delete.php?id=<?= (int)$ev['id'] ?>" class="btn btn-outline-danger btn-sm-e confirm-delete"><i class="bi bi-trash"></i> Padam</a>
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
