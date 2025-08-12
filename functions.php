<?php
function price($value) { return number_format((float)$value, 2) . " £"; }
function is_logged_in() { return isset($_SESSION['user_id']); }
function is_admin() { return !empty($_SESSION['is_admin']); }
function ensure_admin() {
    if (!is_admin()) { header("Location: login.php"); exit; }
}
function h($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>