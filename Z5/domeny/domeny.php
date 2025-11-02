<?php
require_once '../session_config.php';
require_once '../connect.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$is_admin = $_SESSION['is_admin'] ?? false;

// Pobieranie hostów
if ($is_admin) {
    $sql = "SELECT d.*, u.username FROM domeny d JOIN users5 u ON d.user_id = u.id ORDER BY d.id DESC";
    $stmt = $pdo->query($sql);
} else {
    $stmt = $pdo->prepare("SELECT * FROM domeny WHERE user_id = ? ORDER BY id DESC");
    $stmt->execute([$user_id]);
}
$domeny = $stmt->fetchAll();

// Lista użytkowników (dla admina)
$users = [];
if ($is_admin) {
    $users = $pdo->query("SELECT id, username FROM users5 ORDER BY username")->fetchAll();
}
?>
<!doctype html>
<html lang="pl">
<head>
    <link rel="shortcut icon" href="https://seohost.pl/files/main/favicon.png" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitoring usług - <?= htmlspecialchars($_SESSION['username']); ?></title>
    <link href="https://default.seohost.pl/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
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
<li><a class="dropdown-item" href="../monitoring/Panel_1.php">Informacje o użytkowniku</a></li>
<li><a class="dropdown-item" href="../Panel_2.php">Strona 2</a></li>
<li><a class="dropdown-item" href="../Panel_3.php">Strona 3</a></li>

</ul>

</li><a href="../myOshi/mycloud.php" class="btn btn-info">📁 Mój dysk (MyCloud)</a></ul>
<a href="../logout.php" class="btn btn-warning me-3">Wyloguj</a>
</div></div></nav>

<main>
<div class="container mt-4">
<div class="domain-section mt-3 text-center">
<h1>Monitoring usług użytkownika <strong><?= htmlspecialchars($_SESSION['username']); ?></strong></h1>
</div>

<?php if ($is_admin): ?>
<div class="mt-4 mb-4">
<h4>Dodaj nowego hosta</h4>
<form method="POST" action="dodaj_host.php" class="row g-3">
<div class="col-md-4">
<label for="host" class="form-label">Host</label>
<input type="text" class="form-control" id="host" name="host" required>
</div>
<div class="col-md-2">
<label for="port" class="form-label">Port</label>
<input type="number" class="form-control" id="port" name="port" required>
</div>
<div class="col-md-3">
<label for="user_id" class="form-label">Przypisz do użytkownika</label>
<select class="form-select" id="user_id" name="user_id" required>
<option value="">-- wybierz użytkownika --</option>
<?php foreach($users as $u): ?>
<option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['username']) ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="col-md-3 align-self-end">
<button type="submit" class="btn btn-success w-100">Dodaj hosta</button>
</div>
</form>
</div>
<?php endif; ?>

<div class="table-responsive mt-4">
<table class="table table-striped table-bordered" id="hostsTable">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Host</th>
<th>Port</th>
<th>Status</th>
<?php if ($is_admin): ?><th>Użytkownik</th><?php endif; ?>
<th>Akcja</th>
</tr>
</thead>
<tbody>
<?php foreach($domeny as $d): ?>
<tr data-id="<?= $d['id'] ?>">
<td><?= htmlspecialchars($d['id']) ?></td>
<td><?= htmlspecialchars($d['host']) ?></td>
<td><?= htmlspecialchars($d['port']) ?></td>
<td class="status-cell text-muted">⏳ Sprawdzanie...</td>
<?php if ($is_admin): ?>
<td><?= htmlspecialchars($d['username']) ?></td>
<?php endif; ?>
<td>
<?php if ($is_admin): ?>
<a href="usun_host.php?id=<?= $d['id'] ?>" class="btn btn-danger btn-sm"
onclick="return confirm('Na pewno chcesz usunąć tego hosta?');">Usuń</a>
<?php else: ?>
<span class="text-muted">Brak uprawnień</span>
<?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</main>

<script>
function checkHosts() {
    document.querySelectorAll('#hostsTable tbody tr').forEach(row => {
        const id = row.dataset.id;
        const cell = row.querySelector('.status-cell');
        cell.textContent = '⏳ Sprawdzanie...';

        fetch(`check_status.php?id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'ok') {
                cell.innerHTML = '<span style="color:green;font-weight:bold;">OK</span>';
            } else if (data.status === 'fail') {
                cell.innerHTML = '<span style="color:red;font-weight:bold;">Awaria</span>';
            } else {
                cell.innerHTML = '<span style="color:gray;">Błąd</span>';
            }
        })
        .catch(() => {
            cell.innerHTML = '<span style="color:gray;">Błąd</span>';
        });
    });
}

// pierwsze sprawdzenie po załadowaniu strony
document.addEventListener('DOMContentLoaded', () => {
    checkHosts();
    // powtarzaj co 30 sekund
    setInterval(checkHosts, 30000);
});
</script>
</body>
</html>
