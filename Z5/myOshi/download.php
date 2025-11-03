<?php
require_once __DIR__ . '/../session_config.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!==true) exit;

$user = preg_replace('/[^A-Za-z0-9_\-]/','',$_SESSION['username']);
$user = substr($user,0,32);
$userDir = realpath(__DIR__.'/users/'.$user);

if (!isset($_GET['file'])) exit;

$file = str_replace(['..','\\'], '', $_GET['file']);
$path = realpath($userDir.'/'.$file);

if ($path===false || strpos($path,$userDir)!==0 || !is_file($path)) exit;

$downloadName = rawurlencode(basename($path));
header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$downloadName\"; filename*=UTF-8''$downloadName");
header("Content-Length: ".filesize($path));
readfile($path);
exit;
?>
