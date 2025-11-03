<?php
require_once '../session_config.php';
require_once '../connect.php';
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    http_response_code(403); exit("Brak dostępu");
}

// Pobranie ostatnich 50 wizyt
$stmt = $pdo->query("SELECT * FROM goscieportalu ORDER BY datetime DESC LIMIT 50");
$visits = $stmt->fetchAll();

// Generowanie wierszy <tbody>
foreach($visits as $v):
?>
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
