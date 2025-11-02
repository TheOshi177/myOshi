<?php
require_once __DIR__ . '/../session_config.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../login.php');
    exit;
}

$user = preg_replace('/[^A-Za-z0-9_\-]/', '', $_SESSION['username']);
$file = basename($_GET['file']);
$path = __DIR__ . '/users/' . $user . '/' . $file;

if (!file_exists($path)) {
    echo "Plik nie istnieje.";
    exit;
}

header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$file\"");
header("Content-Length: " . filesize($path));
readfile($path);
exit;
?>
