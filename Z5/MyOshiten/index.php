<?php
require_once '../session_config.php';

// Sprawdzenie, czy użytkownik jest zalogowany
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../index.php");
    exit;
}

// Pobranie listy utworów z folderu songs
$songsDir = 'songs';
$songs = array_filter(scandir($songsDir), function($file) use ($songsDir) {
    return preg_match('/\.(mp3|wav|ogg)$/i', $file) && is_file("$songsDir/$file");
});
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Oshiten - Odtwarzacz</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">My Oshiten 🎵</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <span class="nav-link">Witaj, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </li>
                </ul>
                <a href="../logout.php" class="btn btn-warning">Wyloguj</a>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <audio id="audioPlayer" class="w-100" controls>
                    <source src="" type="audio/mpeg">
                    Twoja przeglądarka nie obsługuje odtwarzacza audio.
                </audio>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h3>Lista utworów:</h3>
                <ul class="list-group" id="songsList">
                    <?php foreach($songs as $song): ?>
                        <li class="list-group-item list-group-item-action"
                            data-src="songs/<?php echo urlencode($song); ?>">
                            <?php echo htmlspecialchars($song); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </main>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
