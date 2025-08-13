<?php include "header.php"; ?>
<?php
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $pass = $_POST['password'] ?? '';
    $stmr = $pdo-> prepare("SELECT id, name, password_hash, is_admin From users WHERE email=?");
    $stmt->execute([$email]);
    $u = $stmt->fetch();
    if ($u && password_verify($pass, $u['password_hash'])) {
        $_SESSION['user_id'] = $u['id'];
        $_SESSION['user_name']= $u['name'];
        $_SESSION['is_addmin'] = (bool)$u['is_admin'];
        header("Location: ". (is_admin() ? "admin_products.php" : "index.php"));
        exit;
    }else {
        $error = "Invalid email or password.";
    }
}
?>
<h1>Login</h1>
<?php if ($error): ?><p class="error"><?= h($error) ?></p><?php endif; ?>
    <form method="post">
        <label>Email<input type="email" name="email" required></label>
        <label>Password<input type="password" name="password" required></label>
        <button type="submit">Login</button>
    </form>
<p>Don't have an account? <a href="register.php">Register here</a>.</p>
<?php include "footer.php"; ?>