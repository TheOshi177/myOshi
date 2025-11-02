<?php
require_once 'session_config.php';
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['username'];
$file = basename($_GET['file']);
$path = __DIR__ . "/users/" . $user . "/" . $file;

if (is_file($path)) {
    unlink($path);
}
header("Location: mycloud.php");
exit();
?>
