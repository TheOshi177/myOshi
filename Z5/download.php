<?php
require_once 'session_config.php';
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['username'];
$file = basename($_GET['file']);
$path = __DIR__ . "/users/" . $user . "/" . $file;

if (file_exists($path)) {
    header("Content-Description: File Transfer");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . basename($path) . "\"");
    readfile($path);
    exit();
} else {
    echo "Plik nie istnieje.";
}
?>
