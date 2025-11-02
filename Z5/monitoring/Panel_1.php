<?php
require_once '../session_config.php';
require_once '../connect.php';

// Sprawdzenie, czy użytkownik jest zalogowany
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../index.php");
    exit;
}

// Pobranie ostatnich 50 wizyt
$stmt = $pdo->query("SELECT * FROM goscieportalu ORDER BY datetime DESC LIMIT 50");
$visits = $stmt->fetchAll();
?>
<!doctype html>
<html lang="pl">

<head>
    <link rel="shortcut icon" href="https://seohost.pl/files/main/favicon.png" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Panel użytkownika">
    <title>Panel Profil - <?php echo htmlspecialchars($_SESSION['username']); ?></title>
    <link href="https://default.seohost.pl/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/Z5/css/bootstrap.min.css">
    <script src="/Z5/js/bootstrap.bundle.min.js"></script>
    <style>
    table.table td, 
    table.table th {
        white-space: nowrap;       /* Tekst nie będzie się zawijał */
        vertical-align: middle;    /* Wyrównanie do środka pionowo */
    }

    table.table {
        font-size: 0.9rem;         /* Opcjonalnie: lekko mniejsza czcionka */
    }

    .table-responsive {
        overflow-x: auto;          /* Dodaje poziomy pasek przewijania jeśli tabela jest zbyt szeroka */
    }
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
                </ul>
            <a href="../logout.php" class="btn btn-warning me-3">Wyloguj</a>
        </div>
    </div>
</nav>

<main>
<div class="container mt-4">
    <h1 class="text-center">Witaj, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</h1>

    <h3 class="mt-4">Ostatnie wizyty</h3>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>IP</th>
                    <th>Data i czas</th>
                    <th>Kraj</th>
                    <th>Region</th>
                    <th>Miasto</th>
                    <th>Współrzędne</th>
                    <th>Przeglądarka</th>
                    <th>Rozdzielczość Ekranu</th>
                    <th>Rozdzielczość Okna</th>
                    <th>Kolory</th>
                    <th>Język</th>
                    <th>Cookies</th>
                    <th>Java</th>
                    <th>Mapa</th>
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

<!-- Wyślij dane przeglądarki i ekranu oraz odśwież tabelę -->
<script>
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

    fetch('geo_log.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    }).then(() => {
        // Odświeżamy tylko tbody tabeli po zapisaniu danych
        fetch('fetch_visits.php')
            .then(res => res.text())
            .then(html => {
                document.querySelector('table tbody').innerHTML = html;
            });
    }).catch(console.error);
})();
</script>

</body>
</html>
