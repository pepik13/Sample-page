<?php include "header.php"; ?>
<?php
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!hash_equals($_SESSION['csrf'], $_POST['csrf'] ?? '')) { die("Invalid CSRF"); }
    $name = trim($_POST['name'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $desc = trim($_POST['description'] ?? '');
    $cat = trim($_POST['category'] ?? '');
    $image = trim($_POST['image'] ?? '');
    if ($name && $price > 0 && $image && $cat) {
        $stmt = $pdo->prepare("INSERT INTO products (name, price, descrription , category, image) VALUES (?,?,?,?,?)");
        $stmt->execute([$name, $price, $desc, $cat, $image]);
        $msg = "<p class='success'>Product added successfully!</p>";
    }else {$msg = "<p class='error'>Please fill in all fields correctly.</p>";}
}
?>
<h1>Admin - Add Product</h1>
<?php if ($msg): ?><p class="notice"><?= h($msg) ?></p><?php endif; ?>
    <form method="post">
        <input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>"/>
        <label>Name<input type="text" name="name" required></label>
        <label>Category
            <select name="category" required>
                <option value="">-- choose --</option>
                <option>Laptops</option>
                <option>Tablets</option>
                <option>Watches</option>
                <option>Phones</option>
                <option>Accessories</option>
            </select>
        </label>
        <label>Image filename(in images/)<input type=="text" name="image" placeholder="phone.jpg" required></label>
        <label>Description<textarea name="description" rows="5"></textarea></label>
        <button type="submit">Save</button>
        <a class="btn" href="admin_products.php">Back</a>
    </form>
<?php include "footer.php"; ?>