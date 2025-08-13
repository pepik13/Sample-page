<?php include "header.php"; ?>
<?php
if (empty($_SESSION['cart'])) { echo"<P>Cart is Empty.</p>"; include "footer.php"; exit; }
$total = 0; foreach ($_SESSION['cart'] as $it) $total += $it['price'] * $it['qty'];
if ($_SESSION['REQUEST_METHOD'] === 'POST') {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
    $uid = $_SESSION['user_id'] ?? null;
    $stmt->execute([$uid, $total]);
    $orderId = $pdo->lastInsertId();
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($_SESSION['cart'] as $id ) $stmt->execute([$order_id, $it['id'], $it['qty'], $it['price']]);
    $pdo->commit();
    $_SESSION['cart'] = [];
    header("Location: order_success.php?id=$orderId");
    include "footer.php"; exit;
}
?>
<h1>Checkout</h1>
<p>Total to pay: <string><?= price($total) ?></strong></p>
<form method="post">
    <p>This is a demo checkout(no payment processing). Click below to confirm your order.</p>
    <button type="submit">Confirm Order</button>
</form>
<?php include "footer.php"; ?>