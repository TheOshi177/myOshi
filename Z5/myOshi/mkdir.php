<?php
require_once __DIR__ . '/../session_config.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../login.php');
    exit;
}

$user = preg_replace('/[^A-Za-z0-9_\-]/', '', $_SESSION['username']);
$dirName = preg_replace('/[^A-Za-z0-9_\-]/', '', $_POST['dirname']);

$target = __DIR__ . '/users/' . $user . '/' . $dirName;
if (!is_dir($target)) mkdir($target, 0755, true);

header('Location: mycloud.php');
?>
