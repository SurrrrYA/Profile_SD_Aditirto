<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../helpers.php';
require_login();

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM berita WHERE id=?");
    $stmt->execute([$id]);
}
header("Location: berita_list.php");
exit;
