<?php
require_once __DIR__ . '/../session_config.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../login.php');
    exit;
}

$user = preg_replace('/[^A-Za-z0-9_\-]/', '', $_SESSION['username']);
$file = basename($_GET['file']);
$path = __DIR__ . '/users/' . $user . '/' . $file;

if (is_file($path)) unlink($path);

header('Location: mycloud.php');
?>
