<?php
require_once __DIR__ . '/../session_config.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../login.php');
    exit;
}

$user = preg_replace('/[^A-Za-z0-9_\-]/', '', $_SESSION['username']);
$target = basename($_GET['file']); // może być folder
$path = __DIR__ . '/users/' . $user . '/' . $target;

// funkcja rekurencyjnie usuwa folder
function deleteDir($dir) {
    if (!file_exists($dir)) return;
    if (is_file($dir) || is_link($dir)) {
        unlink($dir);
        return;
    }
    foreach (scandir($dir) as $item) {
        if ($item === '.' || $item === '..') continue;
        deleteDir($dir . DIRECTORY_SEPARATOR . $item);
    }
    rmdir($dir);
}

// usuń folder lub plik
if (file_exists($path)) {
    deleteDir($path);
}

header('Location: mycloud.php');
exit;
?>
