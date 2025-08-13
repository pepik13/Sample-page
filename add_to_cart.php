<?php
require_once "config.php";
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$qty = isset($_POST['qty']) ? intval($_POST['qty']) : 1;
$stmt = $pdo->prepare("SELECT id,name,price,image FROM products WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();
if (!$item) {
    header("Location : index.php");
    exit;   
}
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
IF(!isset($_SESSION['cart'][$id])){
    $_SESSION['cart'][$id] = [
        'name' => $item['name'],
        'price' => $item['price'],
        'image' => $item['image'],
        'qty' => 0
    ];
}
$_SESSION['cart'][$id]['qty'] += $qty;
header("Location: cart.php");
exit;
?>