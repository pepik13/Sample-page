<?php include "header.php"; ?>
<section class"hero">
    <div class="slider">
        <div class="slides">
            <img src="images/banner1.jpg" alt="Hot deals">
            <img src="images/banner2.jpg" alt="Work & Study">
            <img src="images/banner3.jpg" alt="Smart wearables">
        </div>
        <button class="prev" aria-label="Previous">‹</button>
        <button class="next" aria-label="Next">›</button>
    </div>
</section>
<?php
$q = isset($_GET['q']) ? '%' . $_GET['q'] . '%' : '%';
$stmt = $pdo->prepare("SELECT id,name,price,image FROM products  WHERE name LIKE ? OR description LIKE ? ORDER BY id DESC");
$stmt->execute([$q, $q]);
$products = $stmt->fetchAll();
?>
<h1>Latest Electronics</h1>
<div class="grid">
    <?php foreach ($products as $p): ?>
       <div class="card">
        <a href="product.php?id=<?= $p['id'] ?>">
            <img src="images/<?= h($p['image']) ?>" alt="<?= h($p['name']) ?>"/>
            <h3><?= h($p['name']) ?></h3>
        </a>
        <p class="price"><?= price($p['price']) ?></p>
        <from action="add_to_cart.php" method="post">
            <input type="hidden" name="id" value="<?= $p['id'] ?>"/>
            <input type="number" name="qty" value="1" min="1"/>
            <button type="submit">Add to cart</button>
        </from>
        <div>
    <?php endforeach; ?>
</div>
<?php include "footer.php"; ?>