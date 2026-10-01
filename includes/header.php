<?php
// includes/header.php — Layout atas + navbar (halaman awam)
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../functions.php';
$page_title = $page_title ?? 'FAOSC';
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($page_title) ?> | FAOSC</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;1,500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark faosc-navbar sticky-top">
  <div class="container">
    <a class="navbar-brand brand-logo" href="index.php">FAOSC<span>.</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-label="Togol navigasi">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link <?= $current=='index.php'?'active':'' ?>" href="index.php">Utama</a></li>
        <li class="nav-item"><a class="nav-link <?= $current=='alumni.php'?'active':'' ?>" href="alumni.php">Alumni</a></li>
        <li class="nav-item"><a class="nav-link <?= $current=='portfolio.php'?'active':'' ?>" href="portfolio.php">Portfolio</a></li>
        <li class="nav-item"><a class="nav-link <?= $current=='kerjaya.php'?'active':'' ?>" href="kerjaya.php">Kerjaya</a></li>
        <li class="nav-item"><a class="nav-link <?= $current=='event.php'?'active':'' ?>" href="event.php">Event</a></li>
        <li class="nav-item"><a class="nav-link <?= $current=='contact.php'?'active':'' ?>" href="contact.php">Hubungi</a></li>
        <?php if (isset($_SESSION['admin_id'])): ?>
        <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <?php else: ?>
        <li class="nav-item"><a class="nav-link btn-login-nav" href="login.php"><i class="bi bi-person-lock"></i> Admin</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
