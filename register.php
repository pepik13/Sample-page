<?php include "header.php"; ?>
<?php
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? "");
    $email = trim($_POST['email'] ?? "");
    $pass = $_POST['password'] ?? "";
    if (strlen($name) < 2) $msg = "Name is too short";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $msg = "Invalid email";
    elseif (strlen($pass) < 6) $msg = "Password too short (min 6)";
    else {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
        try { $stmt->execute([$name, $email, $hash]); $msg = "Account created. You can login now."; }
        catch (PDOException $e) { $msg = "Email already used?"; }
    }
}
?>
<h1>Register</h1>
<?php if ($msg): ?><p class="notice"><?= h($msg) ?></p><?php endif; ?>
<form method="post">
  <label>Name<input type="text" name="name" required></label>
  <label>Email<input type="email" name="email" required></label>
  <label>Password<input type="password" name="password" required></label>
  <button type="submit">Create account</button>
</form>
<?php include "footer.php"; ?>
