<?php
require_once '../session_config.php';
require_once '../connect.php';

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../index.php");
    exit;
}

$username = $_SESSION['username'];

// Pobranie ostatnich 50 wizyt
$stmt = $pdo->query("SELECT * FROM goscieportalu ORDER BY datetime DESC LIMIT 50");
$visits = $stmt->fetchAll();

// Pobranie liczby logowań
$stmt2 = $pdo->prepare("SELECT COUNT(*) FROM user_logins WHERE username = ?");
$stmt2->execute([$username]);
$login_count = $stmt2->fetchColumn();

// Pobranie ostatnich 10 dat logowań
$stmt3 = $pdo->prepare("SELECT login_datetime FROM user_logins WHERE username = ? ORDER BY login_datetime DESC LIMIT 10");
$stmt3->execute([$username]);
$last_logins = $stmt3->fetchAll(PDO::FETCH_COLUMN);
?>
<!doctype html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Panel Profil - <?= htmlspecialchars($username) ?></title>
<link href="https://default.seohost.pl/style.css" rel="stylesheet">
<link rel="stylesheet" href="/Z5/css/bootstrap.min.css">
<script src="/Z5/js/bootstrap.bundle.min.js"></script>
<style>
table.table td, table.table th { white-space: nowrap; vertical-align: middle; font-size: 0.9rem; }
.table-responsive { overflow-x:auto; }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
<div class="container-fluid">
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
<span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
<a class="navbar-brand" href="../Panel_Profil.php">Profil</a>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Lista</a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="Panel_1.php">Informacje o użytkowniku</a></li>
<li><a class="dropdown-item" href="../Panel_2.php">Strona 2</a></li>
<li><a class="dropdown-item" href="../Panel_3.php">Strona 3</a></li>
</ul>
</li>
<a class="navbar-brand" href="../domeny/domeny.php">Domeny</a>
<a href="../myOshi/mycloud.php" class="btn btn-info">📁 Mój dysk (MyCloud)</a>
</ul>
<a href="../logout.php" class="btn btn-warning me-3">Wyloguj</a>
</div>
</div>
</nav>

<main>
<div class="container mt-4">
<h1 class="text-center">Witaj, <strong><?= htmlspecialchars($username) ?></strong>!</h1>

<h3>Liczba logowań: <strong><?= $login_count ?></strong></h3>
<h4>Ostatnie 10 logowań:</h4>
<ul>
<?php foreach($last_logins as $d): ?>
<li><?= htmlspecialchars($d) ?></li>
<?php endforeach; ?>
</ul>

<h3 class="mt-4">Ostatnie wizyty</h3>
<div class="table-responsive">
<table class="table table-striped table-bordered">
<thead class="table-dark">
<tr>
<th>ID</th><th>IP</th><th>Data i czas</th><th>Kraj</th><th>Region</th>
<th>Miasto</th><th>Współrzędne</th><th>Przeglądarka</th>
<th>Rozdzielczość Ekranu</th><th>Rozdzielczość Okna</th>
<th>Kolory</th><th>Język</th><th>Cookies</th><th>Java</th><th>Mapa</th>
</tr>
</thead>
<tbody>
<?php foreach($visits as $v): ?>
<tr>
<td><?= htmlspecialchars($v['id']) ?></td>
<td><?= htmlspecialchars($v['ipaddress']) ?></td>
<td><?= htmlspecialchars($v['datetime']) ?></td>
<td><?= htmlspecialchars($v['country']) ?></td>
<td><?= htmlspecialchars($v['region']) ?></td>
<td><?= htmlspecialchars($v['city']) ?></td>
<td><?= htmlspecialchars($v['loc']) ?></td>
<td><?= htmlspecialchars($v['browser']) ?></td>
<td><?= htmlspecialchars($v['screen_total_width'].'x'.$v['screen_total_height']) ?></td>
<td><?= htmlspecialchars($v['screen_width'].'x'.$v['screen_height']) ?></td>
<td><?= htmlspecialchars($v['color_depth']) ?></td>
<td><?= htmlspecialchars($v['language']) ?></td>
<td><?= $v['cookies_enabled'] ? 'Tak' : 'Nie' ?></td>
<td><?= $v['java_enabled'] ? 'Tak' : 'Nie' ?></td>
<td><?php if($v['loc']): ?><a href="https://www.google.com/maps/place/<?= htmlspecialchars($v['loc']) ?>" target="_blank">Mapa</a><?php endif; ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</main>

<script>
// Wysyłanie danych przeglądarki i ekranu do geo_log.php
(function(){
const data = {
screenTotalWidth: window.screen.width,
screenTotalHeight: window.screen.height,
screenWidth: window.innerWidth,
screenHeight: window.innerHeight,
colorDepth: window.screen.colorDepth,
language: navigator.language || navigator.userLanguage,
cookiesEnabled: navigator.cookieEnabled ? 1 : 0,
javaEnabled: navigator.javaEnabled() ? 1 : 0
};
fetch('geo_log.php', { method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify(data) })
.catch(console.error);
})();
</script>

</body>
</html>
