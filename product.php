<?php include "header.php"; ?>
<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();
if(!$p){ echo "<p>Product not found</p>"; include "footer.php"; exit; }
?>
<div class="product">
     <img src="images/<?= h($p['image']) ?>" alt="<? h($p['name']) ?>" />
     <div>
        <h1><?= h($p['name']) ?></h1>
        <p class="price big"><?= price($p['price']) ?></p>
        <p class="muted">Category: <?= h($p['category'] ?? 'Uncategorised)') ?></p>
        <p><?= n12br(h($p['description'])) ?></p>
        <form acction="add_to_cart.php" method="post">
            <input type="hidden" name="id" value="<?=$p['id'] ?>"/>
            <input type="number" name="qty" value="1" min="1"/>
            <button type="submit">Add to cart</button>
        </form>
    </div>
</div>
<?php include "footer.php"; ?>