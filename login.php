<?php
// login.php — Log masuk admin
session_start();
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Sila isi nama pengguna dan kata laluan.';
    } else {
        $stmt = $conn->prepare("SELECT id, username, password FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                session_regenerate_id(true);
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_username'] = $row['username'];
                header("Location: dashboard.php");
                exit();
            }
        }
        $error = 'Nama pengguna atau kata laluan tidak sah.';
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login Admin | FAOSC</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
</head>
<body class="login-page">
<div class="container d-flex justify-content-center">
  <div class="login-card">
    <div class="text-center mb-4">
      <div class="brand-logo serif" style="color:var(--ink)!important;font-size:1.8rem;">FAOSC<span>.</span></div>
      <p class="text-muted small mb-0">Log Masuk Pentadbir</p>
    </div>
    <?php if ($error): ?>
      <div class="alert alert-danger py-2 small"><i class="bi bi-exclamation-circle me-1"></i><?= e($error) ?></div>
    <?php endif; ?>
    <form method="post" action="login.php" novalidate>
      <div class="mb-3">
        <label class="form-label" for="username">Nama Pengguna</label>
        <input type="text" class="form-control" id="username" name="username" required value="<?= e($_POST['username'] ?? '') ?>">
      </div>
      <div class="mb-4">
        <label class="form-label" for="password">Kata Laluan</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-gold w-100">Log Masuk</button>
    </form>
    <div class="text-center mt-3"><a href="index.php" class="small text-muted text-decoration-none"><i class="bi bi-arrow-left"></i> Kembali ke Laman Utama</a></div>
  </div>
</div>
</body>
</html>
