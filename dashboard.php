<?php
// dashboard.php — Dashboard admin (statistik + mesej hubungi)
$page_title = 'Dashboard';
require_once __DIR__ . '/includes/admin_header.php';

$count = function($table) use ($conn) {
    $r = $conn->query("SELECT COUNT(*) AS c FROM `$table`");
    return $r ? (int)$r->fetch_assoc()['c'] : 0;
};
$mesej = $conn->query("SELECT * FROM contact ORDER BY tarikh DESC LIMIT 10");
$alumni_baru = $conn->query("SELECT id, nama, tahun_tamat, bidang FROM alumni ORDER BY id DESC LIMIT 5");
?>
<div class="row g-3 mb-4">
  <div class="col-6 col-xl-3">
    <div class="card dash-card p-3 d-flex flex-row align-items-center gap-3">
      <div class="icon-circle"><i class="bi bi-people"></i></div>
      <div><div class="fs-3 fw-bold serif"><?= $count('alumni') ?></div><div class="text-muted small">Jumlah Alumni</div></div>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="card dash-card p-3 d-flex flex-row align-items-center gap-3">
      <div class="icon-circle"><i class="bi bi-images"></i></div>
      <div><div class="fs-3 fw-bold serif"><?= $count('portfolio') ?></div><div class="text-muted small">Jumlah Portfolio</div></div>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="card dash-card p-3 d-flex flex-row align-items-center gap-3">
      <div class="icon-circle"><i class="bi bi-briefcase"></i></div>
      <div><div class="fs-3 fw-bold serif"><?= $count('kerjaya') ?></div><div class="text-muted small">Peluang Kerjaya</div></div>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="card dash-card p-3 d-flex flex-row align-items-center gap-3">
      <div class="icon-circle"><i class="bi bi-calendar-event"></i></div>
      <div><div class="fs-3 fw-bold serif"><?= $count('event') ?></div><div class="text-muted small">Jumlah Event</div></div>
    </div>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-6">
    <div class="card dash-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="serif mb-0">Alumni Terkini</h5>
          <a href="alumni_add.php" class="btn btn-gold btn-sm-e">+ Tambah</a>
        </div>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead><tr><th>Nama</th><th>Tahun</th><th>Bidang</th><th></th></tr></thead>
            <tbody>
              <?php while ($a = $alumni_baru->fetch_assoc()): ?>
              <tr>
                <td><?= e($a['nama']) ?></td>
                <td><?= e($a['tahun_tamat']) ?></td>
                <td><?= e($a['bidang']) ?></td>
                <td><a href="alumni_edit.php?id=<?= (int)$a['id'] ?>" class="btn btn-outline-dark btn-sm-e">Edit</a></td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card dash-card">
      <div class="card-body">
        <h5 class="serif mb-3">Mesej Hubungi Terkini</h5>
        <?php if ($mesej->num_rows === 0): ?>
          <p class="text-muted mb-0">Tiada mesej setakat ini.</p>
        <?php endif; ?>
        <?php while ($m = $mesej->fetch_assoc()): ?>
        <div class="border-bottom py-2">
          <div class="d-flex justify-content-between">
            <strong><?= e($m['nama']) ?></strong>
            <small class="text-muted"><?= e(date('d/m/Y H:i', strtotime($m['tarikh']))) ?></small>
          </div>
          <small class="text-muted"><?= e($m['email']) ?></small>
          <p class="mb-0 small"><?= e($m['mesej']) ?></p>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
