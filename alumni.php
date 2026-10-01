<?php
// alumni.php — Direktori alumni (awam); admin nampak butang urus
$page_title = 'Alumni';
require_once __DIR__ . '/includes/header.php';
$is_admin = isset($_SESSION['admin_id']);

$search = trim($_GET['q'] ?? '');
$tahun  = trim($_GET['tahun'] ?? '');
$bidang = trim($_GET['bidang'] ?? '');

// Senarai tahun & bidang unik untuk filter
$tahun_list  = $conn->query("SELECT DISTINCT tahun_tamat FROM alumni ORDER BY tahun_tamat DESC");
$bidang_list = $conn->query("SELECT DISTINCT bidang FROM alumni ORDER BY bidang ASC");

$sql = "SELECT * FROM alumni WHERE 1=1";
$params = []; $types = '';
if ($search !== '') { $sql .= " AND (nama LIKE ? OR pekerjaan LIKE ?)"; $like = "%$search%"; $params[] = $like; $params[] = $like; $types .= 'ss'; }
if ($tahun !== '')  { $sql .= " AND tahun_tamat = ?"; $params[] = $tahun; $types .= 's'; }
if ($bidang !== '') { $sql .= " AND bidang = ?"; $params[] = $bidang; $types .= 's'; }
$sql .= " ORDER BY tahun_tamat DESC, nama ASC";

$stmt = $conn->prepare($sql);
if ($params) { $stmt->bind_param($types, ...$params); }
$stmt->execute();
$result = $stmt->get_result();
?>
<section class="page-banner">
  <div class="container">
    <h1>Direktori Alumni</h1>
    <p>Kenali graduan fesyen kami dan perkembangan kerjaya mereka.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php if (isset($_GET['msg'])): ?>
      <div class="alert alert-success auto-dismiss"><?= e($_GET['msg']) ?></div>
    <?php endif; ?>

    <form method="get" class="card e-card p-3 mb-4">
      <div class="row g-2 align-items-end">
        <div class="col-md-4">
          <label class="form-label">Carian</label>
          <input type="text" name="q" class="form-control" placeholder="Nama atau pekerjaan…" value="<?= e($search) ?>">
        </div>
        <div class="col-md-3">
          <label class="form-label">Tahun Tamat</label>
          <select name="tahun" class="form-select">
            <option value="">Semua</option>
            <?php while ($t = $tahun_list->fetch_assoc()): ?>
              <option value="<?= e($t['tahun_tamat']) ?>" <?= $tahun==$t['tahun_tamat']?'selected':'' ?>><?= e($t['tahun_tamat']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Bidang</label>
          <select name="bidang" class="form-select">
            <option value="">Semua</option>
            <?php while ($b = $bidang_list->fetch_assoc()): ?>
              <option value="<?= e($b['bidang']) ?>" <?= $bidang==$b['bidang']?'selected':'' ?>><?= e($b['bidang']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="col-md-2 d-grid">
          <button class="btn btn-gold" type="submit"><i class="bi bi-search"></i> Cari</button>
        </div>
      </div>
    </form>

    <?php if ($is_admin): ?>
      <div class="mb-3"><a href="alumni_add.php" class="btn btn-gold"><i class="bi bi-plus-lg"></i> Tambah Alumni</a></div>
    <?php endif; ?>

    <div class="card e-card">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead><tr><th>Alumni</th><th>Tahun Tamat</th><th>Bidang</th><th>Pekerjaan</th><?php if ($is_admin): ?><th class="text-end">Tindakan</th><?php endif; ?></tr></thead>
          <tbody>
            <?php if ($result->num_rows === 0): ?>
              <tr><td colspan="5" class="text-center text-muted py-4">Tiada rekod dijumpai.</td></tr>
            <?php endif; ?>
            <?php while ($a = $result->fetch_assoc()): ?>
            <tr>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <?php if ($a['gambar']): ?>
                    <img src="uploads/alumni/<?= e($a['gambar']) ?>" class="avatar-sm" alt="<?= e($a['nama']) ?>">
                  <?php else: ?>
                    <span class="avatar-placeholder"><?= e(mb_strtoupper(mb_substr($a['nama'], 0, 1))) ?></span>
                  <?php endif; ?>
                  <div>
                    <div class="fw-semibold"><?= e($a['nama']) ?></div>
                    <small class="text-muted"><?= e($a['email']) ?></small>
                  </div>
                </div>
              </td>
              <td><span class="card-tag"><?= e($a['tahun_tamat']) ?></span></td>
              <td><?= e($a['bidang']) ?></td>
              <td><?= e($a['pekerjaan'] ?: '—') ?></td>
              <?php if ($is_admin): ?>
              <td class="text-end text-nowrap">
                <a href="alumni_edit.php?id=<?= (int)$a['id'] ?>" class="btn btn-outline-dark btn-sm-e"><i class="bi bi-pencil"></i></a>
                <a href="alumni_delete.php?id=<?= (int)$a['id'] ?>" class="btn btn-outline-danger btn-sm-e confirm-delete"><i class="bi bi-trash"></i></a>
              </td>
              <?php endif; ?>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
