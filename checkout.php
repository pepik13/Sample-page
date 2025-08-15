<?php include "header.php"; ?>
<?php
if (empty($_SESSION['cart'])) { echo "<p>Cart is empty.</p>"; include "footer.php"; exit; }
$total = 0; foreach ($_SESSION['cart'] as $it) $total += $it['price'] * $it['qty'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
    $uid = $_SESSION['user_id'] ?? null;
    $stmt->execute([$uid, $total]);
    $order_id = $pdo->lastInsertId();
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
    foreach ($_SESSION['cart'] as $it) $stmt->execute([$order_id, $it['id'], $it['qty'], $it['price']]);
    $pdo->commit();
    $_SESSION['cart'] = [];
    echo "<h1>Thank you!</h1><p>Your order #{$order_id} has been placed.</p>";
    include "footer.php"; exit;
}
?>
<h1>Checkout</h1>
<p>Total to pay: <strong><?= price($total) ?></strong></p>
<form method="post">
  <p>This is a demo checkout (no real payment).</p>
  <button type="submit">Place order</button>
</form>
<?php include "footer.php"; ?>
