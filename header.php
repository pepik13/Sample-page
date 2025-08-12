<?php require_once __DIR__ . "/config.php"; ?>
<?php require_once __DIR__ . "/functions.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Electro Shop</title>
  <link rel="stylesheet" href="assets/css/style.css"/>
  <script defer src="assets/js/slider.js"></script>
</head>
<body>
<header class="header">
  <div class="brand"><a href="index.php">⚡ Electro Shop</a></div>
  <form class="search" action="index.php" method="get">
    <input type="text" name="q" placeholder="Search electronics..." value="<?= isset($_GET['q']) ? h($_GET['q']) : '' ?>"/>
    <button type="submit">Search</button>
  </form>
  <nav class="nav">
    <a href="index.php">Home</a>
    <div class="dropdown">
      <button class="dropbtn">Categories ▾</button>
      <div class="dropdown-content">
        <a href="category.php?c=Laptops">Laptops</a>
        <a href="category.php?c=Tablets">Tablets</a>
        <a href="category.php?c=Watches">Watches</a>
        <a href="category.php?c=Accessories">Accessories</a>
      </div>
    </div>
    <a href="cart.php">Cart (<?= isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0 ?>)</a>
    <a href="about.php">About</a>
    <a href="contact.php">Contact</a>
    <?php if (is_logged_in()): ?>
      <span class="hello">Hi, <?= h($_SESSION['user_name']) ?></span>
      <?php if (is_admin()): ?>
        <a class="admin" href="admin_products.php">Admin</a>
      <?php endif; ?>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    <?php endif; ?>
  </nav>
</header>
<marquee class="ticker">🔥 Big Summer Sale — Laptops, Tablets, Watches, Accessories — Limited time only!</marquee>
<main class="container">
