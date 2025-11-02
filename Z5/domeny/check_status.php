<?php
require_once 'session_config.php';
require_once 'connect.php';
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin'])) {
    echo json_encode(['status'=>'fail']);
    exit();
}

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(['status'=>'fail']);
    exit();
}

if ($_SESSION['is_admin'] ?? false) {
    $stmt = $pdo->prepare("SELECT host, port FROM domeny WHERE id = ?");
    $stmt->execute([$id]);
} else {
    $stmt = $pdo->prepare("SELECT host, port FROM domeny WHERE id=? AND user_id=?");
    $stmt->execute([$id, $_SESSION['user_id']]);
}

$row = $stmt->fetch();
if (!$row) {
    echo json_encode(['status'=>'fail']);
    exit();
}

$fp = @fsockopen($row['host'], $row['port'], $errno, $errstr, 2);
$status = $fp ? 'ok' : 'fail';
if ($fp) fclose($fp);

echo json_encode(['status'=>$status]);
?>
