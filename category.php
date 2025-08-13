<?php include "header.php"; ?>
<?php
$c = $_GET['c'] ?? '';
$mt = $pdo->prepare("SELECT id,name,price,image FROM products WHERE category = ? ORDER BY id DESC");
$mt->execute([$c]);
$products = $mt->fetchAll();
?>
<h1>Category: <?= h($c) ?></h1>
<div class="grid">
    <?php foreach($products as $p): ?>
        <div class="card">
            <a href="product.php?id=<?= $p['id'] ?>">
                <img src="images/<?= h($p['image']) ?>" alt="<?= h($p['name']) ?>"/>
                <h3><?= h($p['name']) ?></h3>
            </a>
            <p class="price"><?= price($p['price']) ?></p>
            <form action="add_to_cart.php" method="post">
                <input type="hidden" name="id" value="<?= $p['id'] ?>" />
                <input type="number" name="qty" value="1" min="1" />
                <button type="submit">Add to cart</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
<?php include "footer.php"; ?>
