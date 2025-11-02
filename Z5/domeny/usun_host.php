<?php
require_once 'session_config.php';
require_once 'connect.php';

if (!isset($_SESSION['loggedin']) || !($_SESSION['is_admin'] ?? false)) {
    header("Location: domeny.php");
    exit();
}

$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM domeny WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: domeny.php");
exit();
?>
