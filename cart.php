<?php include "header.php"; ?>
<?php
if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
$items = $_SESSION['cart']; $total = 0;
foreach ($items as $it) $total += $it['price'] * $it['qty'];
if(isset($POST['update'])) {
    foreach ($items as $id=> $it) {
        if(isset($_POST['qty'][$id])) {
            $q = max(0, intval($_POST['qty'][$id]));
            if ($q == 0) unset($_SESSION['cart'][$id]);
            else $_SESSION['cart'][$id]['qty'] = $q;
        }
    }
    header("Location: cart.php");
    exit;
}
?>
<h1>Your Cart</h1>
<?php if (empty($_SESSION['cart'])): ?>
    <p>Cart is empty.</p>
<?php else: ?>
    ,form method="post">
    <table class="cart">
        <tr><th>Item</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr>
        <?php foreach ($_SESSION['cart'] as $id => $it): ?>
            <tr>
                <td><img class="thumb" src="images/<? = h($it['image']) ?>" alt=""/> <?= h($it['name']) ?></td>
                <td><?=price($it['price']) ?></td>
                <td><input type="number" name="qty[<?= $id ?>]" value="<?= $it['qty'] ?>" min="0"/></td>
        <td><?= price($it['price'] * $it['qty']) ?></td>
      </tr>
    <?php endforeach; ?>
    <tr><td colspan="3" class="right">Total</td><td><?= price($total) ?></td></tr>
  </table>
  <div class="actions">
    <button type="submit" name="update">Update</button>
    <a class="btn" href="checkout.php">Checkout</a>
  </div>
  </form>
<?php endif; ?>
<?php include "footer.php"; ?>
