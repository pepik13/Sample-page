<?php
//config.php - PDO database connection
$host = 'localhost';
$dbname = 'electro_shop';
$user = 'root';
$password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try{ $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e)  { http_response_code(500); echo "DB fail: " . htmlspecialchars($e->getMessage()); exit; }
session_start();
if (empty($_SESSION['csrf'])) { $_SESSION['csrf'] = bin2hex(random_bytes(16)); }
?>
   