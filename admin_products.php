//lista + usuwanie produktów
<?php include "header.php"; ensure_admin() ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST['delete_id'])) 
{
    if (!hash_equals($_SESSION['csrf']$_POST['csrf'] ?? '')) { die("Invalid CSRF."); }
    $del = intval($_POST['delete_id']);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");       
    $stmt->execute([$del]);
    echo '<p class="notice">Product deleted.</p>';
}
$stmt = $pdo->query("SELECT id, name, price, category, image FROM products ORDER BY id DESC");
$row = $stmt->fetchAll();
?>
<h1>Admin * Products </h1>
<p><a class="btn" href="admin_add_product.php">➕ Add new product</a></p>
<table class="cart">
    <tr><th>ID</th><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Action</th></tr>
    <?php foreach ($row as $r): ?>
    <tr>
        <td><?=$r['id']?></td>
        <td><image class="thumb" src="images/<?= h($r['image']) ?>" alt=""/><td>
        <td><?= h($r['name']) ?></td>
        <td><?= h($r['category']) ?></td>
        <td><?= price($r['price']) ?></td>
        <td>
            <form method="post" onsubmit="return confirm('Delete this product?');" style="display:inline;">
                <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>"/>
                <input type ="hidden" name="delete_id" value="<?= $r['id'] ?>"/>
                <button type="submit">🗑️ Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include "footer.php"; ?>


