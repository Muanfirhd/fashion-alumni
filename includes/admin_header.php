<?php
// includes/admin_header.php — Layout admin dengan sidebar
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../functions.php';
$page_title = $page_title ?? 'Dashboard';
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($page_title) ?> | FAOSC Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
</head>
<body class="admin-body">
<div class="admin-wrapper">
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand brand-logo">FAOSC<span>.</span></div>
    <div class="sidebar-label">PENTADBIRAN</div>
    <ul class="sidebar-menu">
      <li><a href="dashboard.php" class="<?= $current=='dashboard.php'?'active':'' ?>"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
      <li><a href="alumni.php" class="<?= in_array($current,['alumni.php','alumni_add.php','alumni_edit.php'])?'active':'' ?>"><i class="bi bi-people"></i> Alumni</a></li>
      <li><a href="portfolio.php" class="<?= in_array($current,['portfolio.php','portfolio_add.php','portfolio_edit.php'])?'active':'' ?>"><i class="bi bi-images"></i> Portfolio</a></li>
      <li><a href="kerjaya.php" class="<?= in_array($current,['kerjaya.php','kerjaya_add.php','kerjaya_edit.php'])?'active':'' ?>"><i class="bi bi-briefcase"></i> Kerjaya</a></li>
      <li><a href="event.php" class="<?= in_array($current,['event.php','event_add.php','event_edit.php'])?'active':'' ?>"><i class="bi bi-calendar-event"></i> Event</a></li>
      <li><a href="index.php"><i class="bi bi-globe"></i> Lihat Laman</a></li>
      <li><a href="logout.php" class="text-danger-link"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
  </aside>
  <div class="admin-main">
    <header class="admin-topbar">
      <button class="btn sidebar-toggle d-lg-none" id="sidebarToggle" aria-label="Buka menu"><i class="bi bi-list"></i></button>
      <h1 class="admin-page-title"><?= e($page_title) ?></h1>
      <span class="admin-user"><i class="bi bi-person-circle me-1"></i><?= e($_SESSION['admin_username'] ?? 'Admin') ?></span>
    </header>
    <main class="admin-content">
