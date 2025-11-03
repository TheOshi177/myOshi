<?php
require_once __DIR__ . '/../session_config.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!==true) exit;

$user = preg_replace('/[^A-Za-z0-9_\-]/','',$_SESSION['username']);
$user = substr($user,0,32);
$userDir = realpath(__DIR__.'/users/'.$user);

if (!isset($_GET['file'])) exit;

$file = str_replace(['..','\\'], '', $_GET['file']);
$path = realpath($userDir.'/'.$file);

if($path===false || strpos($path,$userDir)!==0 || !is_file($path)) exit;

// Typ MIME
$ext = strtolower(pathinfo($path,PATHINFO_EXTENSION));
switch($ext){
    case 'jpg':
    case 'jpeg': header('Content-Type: image/jpeg'); break;
    case 'png': header('Content-Type: image/png'); break;
    case 'gif': header('Content-Type: image/gif'); break;
    default: exit;
}

readfile($path);
exit;
?>
