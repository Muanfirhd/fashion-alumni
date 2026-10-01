<?php
// index.php — Halaman utama FAOSC
$page_title = 'Utama';
require_once __DIR__ . '/includes/header.php';

// Statistik
$stats = ['alumni'=>0,'portfolio'=>0,'kerjaya'=>0,'event'=>0];
foreach (['alumni','portfolio','kerjaya','event'] as $t) {
    $r = $conn->query("SELECT COUNT(*) AS c FROM `$t`");
    $stats[$t] = $r ? (int)$r->fetch_assoc()['c'] : 0;
}
// Data terkini
$portfolio = $conn->query("SELECT p.*, a.nama AS nama_alumni FROM portfolio p LEFT JOIN alumni a ON a.id=p.alumni_id ORDER BY p.id DESC LIMIT 3");
$kerjaya   = $conn->query("SELECT * FROM kerjaya ORDER BY tarikh_post DESC, id DESC LIMIT 3");
$event     = $conn->query("SELECT * FROM event ORDER BY tarikh ASC LIMIT 3");
?>
<section class="hero">
  <div class="container">
    <div class="kicker mb-3">Fashion Alumni One Stop Centre</div>
    <h1>Menghubungkan Bakat Fesyen,<br>Membina Masa Depan Industri.</h1>
    <p class="lead mt-3">FAOSC ialah portal sehenti untuk alumni bidang fesyen — direktori alumni, galeri portfolio, peluang kerjaya dan event industri, semuanya dalam satu platform.</p>
    <div class="mt-4 d-flex flex-wrap gap-2">
      <a href="alumni.php" class="btn btn-gold">Terokai Alumni</a>
      <a href="portfolio.php" class="btn btn-outline-light-e">Lihat Portfolio</a>
    </div>
  </div>
</section>

<section class="section section-dark">
  <div class="container">
    <div class="row g-3">
      <div class="col-6 col-lg-3"><div class="stat-box"><div class="stat-num" data-count="<?= $stats['alumni'] ?>"><?= $stats['alumni'] ?></div><div class="stat-label">Alumni</div></div></div>
      <div class="col-6 col-lg-3"><div class="stat-box"><div class="stat-num" data-count="<?= $stats['portfolio'] ?>"><?= $stats['portfolio'] ?></div><div class="stat-label">Portfolio</div></div></div>
      <div class="col-6 col-lg-3"><div class="stat-box"><div class="stat-num" data-count="<?= $stats['kerjaya'] ?>"><?= $stats['kerjaya'] ?></div><div class="stat-label">Kerjaya</div></div></div>
      <div class="col-6 col-lg-3"><div class="stat-box"><div class="stat-num" data-count="<?= $stats['event'] ?>"><?= $stats['event'] ?></div><div class="stat-label">Event</div></div></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <h2 class="section-title">Portfolio Terkini</h2>
    <div class="gold-line"></div>
    <div class="row g-4">
      <?php while ($p = $portfolio->fetch_assoc()): ?>
      <div class="col-md-4">
        <div class="e-card">
          <?php if ($p['gambar']): ?>
            <img src="uploads/portfolio/<?= e($p['gambar']) ?>" height="220" alt="<?= e($p['nama_rekaan']) ?>">
          <?php else: ?>
            <div class="d-flex align-items-center justify-content-center bg-dark text-warning" style="height:220px;"><i class="bi bi-image fs-1"></i></div>
          <?php endif; ?>
          <div class="p-4">
            <span class="card-tag gold"><?= e($p['nama_alumni'] ?? 'Alumni') ?></span>
            <h5 class="mt-2 serif"><?= e($p['nama_rekaan']) ?></h5>
            <p class="section-sub small mb-0"><?= e(mb_strimwidth($p['penerangan'] ?? '', 0, 110, '…')) ?></p>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
    <div class="text-center mt-4"><a href="portfolio.php" class="btn btn-gold">Lihat Semua Portfolio</a></div>
  </div>
</section>

<section class="section section-dark">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-6">
        <h2 class="section-title text-white">Peluang Kerjaya</h2>
        <div class="gold-line"></div>
        <?php while ($k = $kerjaya->fetch_assoc()): ?>
        <div class="p-3 mb-3 rounded" style="background:rgba(255,255,255,.05);border:1px solid rgba(201,164,92,.25);">
          <h5 class="serif text-white mb-1"><?= e($k['jawatan']) ?></h5>
          <div class="small" style="color:var(--gold);"><i class="bi bi-building me-1"></i><?= e($k['syarikat']) ?> &nbsp;<i class="bi bi-geo-alt ms-2 me-1"></i><?= e($k['lokasi']) ?></div>
        </div>
        <?php endwhile; ?>
        <a href="kerjaya.php" class="btn btn-outline-light-e mt-2">Semua Kerjaya</a>
      </div>
      <div class="col-lg-6">
        <h2 class="section-title text-white">Event Akan Datang</h2>
        <div class="gold-line"></div>
        <?php while ($ev = $event->fetch_assoc()): ?>
        <div class="p-3 mb-3 rounded d-flex gap-3 align-items-center" style="background:rgba(255,255,255,.05);border:1px solid rgba(201,164,92,.25);">
          <div class="text-center px-3 py-2 rounded" style="background:var(--gold);color:var(--ink);min-width:74px;">
            <div class="fw-bold fs-4"><?= date('d', strtotime($ev['tarikh'])) ?></div>
            <div class="small text-uppercase"><?= date('M Y', strtotime($ev['tarikh'])) ?></div>
          </div>
          <div>
            <h6 class="serif text-white mb-1"><?= e($ev['nama_event']) ?></h6>
            <div class="small" style="color:#a49c90;"><i class="bi bi-geo-alt me-1"></i><?= e($ev['lokasi']) ?></div>
          </div>
        </div>
        <?php endwhile; ?>
        <a href="event.php" class="btn btn-outline-light-e mt-2">Semua Event</a>
      </div>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
