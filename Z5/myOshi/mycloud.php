<?php
require_once __DIR__ . '/../session_config.php';
require_once __DIR__ . '/../connect.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../login.php');
    exit;
}

// Sanitizacja użytkownika
$user = preg_replace('/[^A-Za-z0-9_\-]/', '', $_SESSION['username']);
$user = substr($user, 0, 32);
$userDir = realpath(__DIR__ . '/users/' . $user);

if (!is_dir($userDir)) mkdir($userDir, 0755, true);

// Pobranie bieżącego katalogu (względem katalogu użytkownika)
$relDir = isset($_GET['dir']) ? $_GET['dir'] : '';
$relDir = trim($relDir, '/');
$relDir = preg_replace('/[^A-Za-z0-9_\-\/]/', '', $relDir); // pozwól tylko na litery, cyfry, "-" i "/"
$currentDir = realpath($userDir . '/' . $relDir);

// Sprawdzenie, czy katalog jest w katalogu użytkownika
if ($currentDir === false || strpos($currentDir, $userDir) !== 0) {
    $currentDir = $userDir;
    $relDir = '';
}

// Pobranie plików i folderów
$items = array_diff(scandir($currentDir), ['.', '..']);

// Flash messages
$flash = '';
if (isset($_SESSION['flash_success'])) { $flash = '<div class="alert alert-success">'.$_SESSION['flash_success'].'</div>'; unset($_SESSION['flash_success']); }
if (isset($_SESSION['flash_error'])) { $flash .= '<div class="alert alert-danger">'.$_SESSION['flash_error'].'</div>'; unset($_SESSION['flash_error']); }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>MyCloud - <?php echo htmlspecialchars($user); ?></title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body class="container py-4">

<h2>📁 MyCloud — <?php echo htmlspecialchars($user); ?></h2>

<?php echo $flash; ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
<?php
$pathParts = explode('/', $relDir);
$pathAcc = '';
echo '<li class="breadcrumb-item"><a href="mycloud.php">root</a></li>';
foreach ($pathParts as $part) {
    if ($part === '') continue;
    $pathAcc .= ($pathAcc ? '/' : '') . $part;
    echo '<li class="breadcrumb-item"><a href="?dir='.urlencode($pathAcc).'">'.htmlspecialchars($part).'</a></li>';
}
?>
</ol>
</nav>

<!-- Formularz upload -->
<form action="upload.php" method="post" enctype="multipart/form-data" class="mb-3">
<input type="file" name="fileToUpload" class="form-control mb-2" required>
<input type="hidden" name="dir" value="<?php echo htmlspecialchars($relDir); ?>">
<button type="submit" class="btn btn-primary">Prześlij plik</button>
</form>

<!-- Formularz tworzenia folderu -->
<form action="mkdir.php" method="post" class="mb-3">
<input type="text" name="dirname" placeholder="Nazwa katalogu" class="form-control mb-2" required>
<input type="hidden" name="dir" value="<?php echo htmlspecialchars($relDir); ?>">
<button type="submit" class="btn btn-secondary">Utwórz folder</button>
</form>

<h4>Zawartość katalogu:</h4>
<ul class="list-group mb-3">
<?php foreach ($items as $item):
    $itemPath = $currentDir . '/' . $item;
    $relItemPath = ($relDir ? $relDir.'/' : '') . $item;
    if (is_dir($itemPath)):
?>
<li class="list-group-item d-flex justify-content-between align-items-center">
    <strong>📁 <a href="?dir=<?php echo urlencode($relItemPath); ?>"><?php echo htmlspecialchars($item); ?></a></strong>
    <div>
        <a href="delete.php?file=<?php echo urlencode($relItemPath); ?>" class="btn btn-danger btn-sm">Usuń</a>
    </div>
</li>
<?php else: 
    $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));
?>
<li class="list-group-item d-flex justify-content-between align-items-center">
    <?php echo htmlspecialchars($item); ?>
    <div>
        <a href="download.php?file=<?php echo urlencode($relItemPath); ?>" class="btn btn-success btn-sm">Pobierz</a>
        <a href="delete.php?file=<?php echo urlencode($relItemPath); ?>" class="btn btn-danger btn-sm">Usuń</a>
        <?php if (in_array($ext, ['jpg','jpeg','png','gif'])): ?>
            <button class="btn btn-info btn-sm" onclick="window.open('download.php?file=<?php echo urlencode($relItemPath); ?>','_blank')">Podgląd</button>
        <?php elseif (in_array($ext, ['mp3'])): ?>
            <audio controls src="download.php?file=<?php echo urlencode($relItemPath); ?>"></audio>
        <?php elseif (in_array($ext, ['mp4','webm'])): ?>
            <video controls width="250" src="download.php?file=<?php echo urlencode($relItemPath); ?>"></video>
        <?php endif; ?>
    </div>
</li>
<?php endif; endforeach; ?>
</ul>

<a href="../Panel_Profil.php" class="btn btn-outline-secondary">Powrót</a>
</body>
</html>
