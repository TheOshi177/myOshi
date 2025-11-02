<?php
require_once 'session_config.php';
require_once 'connect.php';

if (!isset($_SESSION['loggedin']) || !($_SESSION['is_admin'] ?? false)) {
    header("Location: domeny.php");
    exit();
}

$host = trim($_POST['host'] ?? '');
$port = (int)($_POST['port'] ?? 0);
$user_id = (int)($_POST['user_id'] ?? 0);

if (!$host || $port <= 0 || !$user_id) {
    die("Niepoprawne dane. Wróć i spróbuj ponownie.");
}

$stmt = $pdo->prepare("INSERT INTO domeny (host, port, user_id) VALUES (?, ?, ?)");
try {
    $stmt->execute([$host, $port, $user_id]);
    header("Location: domeny.php");
    exit();
} catch (PDOException $e) {
    die("Błąd dodawania hosta: " . htmlspecialchars($e->getMessage()));
}
?>
