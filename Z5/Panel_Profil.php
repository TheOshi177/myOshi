<?php
require_once 'session_config.php';

// Sprawdzenie, czy użytkownik jest zalogowany
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/url.js"></script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <a class="navbar-brand" href="Panel_Profil.php">Profil</a>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Lista</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/Z5/monitoring/Panel_1.php">Informacje o użytkowniku</a></li>
                            <li><a class="dropdown-item" href="Panel_2.php">Strona 2</a></li>
                            <li><a class="dropdown-item" href="Panel_3.php">Strona 3</a></li>
                        </ul>
                    </li>
                <a class="navbar-brand" href="domeny/domeny.php">Domeny</a>
                <a href="mycloud.php" class="btn btn-info">📁 Mój dysk (MyCloud)</a>
                </ul>
                <!-- Przycisk Wyloguj -->
                <a href="logout.php" class="btn btn-warning me-3">Wyloguj</a>
            </div>
        </div>
    </nav>

    <!-- Modal Wylogowania -->
    <div class="modal fade" id="LogoutModal" tabindex="-1" aria-labelledby="LogoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Wyloguj</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
                </div>
                <div class="modal-body">
                    <p>Czy na pewno chcesz się wylogować?</p>
                    <a href="logout.php" class="btn btn-warning w-100">Wyloguj</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Strona główna -->
    <main>
        <div class="container mt-4">
            <div class="domain-section mt-3 text-center">
                <h1><p>Witaj, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</p></h1>
            </div>
            <div class="default-page-notice mt-3">
                <h1>Profil</h1>
                <div class="notice-content">
                    <p class="notice-text">
                        <span class="lang-pl">To jest strona główna użytkownika.</span>
                        <span class="lang-en" style="display:none;">This is the user homepage.</span>
                        <code>Prog. Aplikacji Sieciowych</code>
                    </p>
                </div>
                <p class="notice-footer text-center">
                    <span class="lang-pl">utworzono: Mon Oct 6 09:47:35 2025</span>
                    <span class="lang-en" style="display:none;">created: Mon Oct 6 09:47:35 2025</span>
                </p>
            </div>
        </div>
    </main>

    <script>
        // Automatyczne wykrywanie języka przeglądarki
        (function() {
            const userLang = navigator.language || navigator.userLanguage;
            const isPolish = userLang.toLowerCase().startsWith('pl');
            if (!isPolish) {
                document.querySelectorAll('.lang-pl').forEach(el => el.style.display = 'none');
                document.querySelectorAll('.lang-en').forEach(el => {
                    if (el.tagName === 'SPAN') el.style.display = 'inline';
                    else el.style.display = 'block';
                });
                document.documentElement.lang = 'en';
            }
        })();
    </script>

</body>
</html>
