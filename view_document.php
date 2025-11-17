<?php
require './config/init.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare('SELECT d.*, u.full_name FROM documents d JOIN users u ON d.created_by=u.id WHERE d.id=?');
$stmt->execute([$id]);
$doc = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$doc) die('Dokumen tidak ditemukan');

$vstmt = $pdo->prepare('SELECT * FROM document_versions WHERE document_id = ? ORDER BY uploaded_at DESC');
$vstmt->execute([$id]);
$versions = $vstmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Detail Dokumen</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<h2><?php echo htmlspecialchars($doc['title']); ?></h2>

<p><?php echo nl2br(htmlspecialchars($doc['description'])); ?></p>

<p>Created by: <?php echo htmlspecialchars($doc['full_name']); ?> at <?php echo htmlspecialchars($doc['created_at']); ?></p>

<h3>Versi</h3>
<ul>
<?php foreach ($versions as $v): ?>
  <li>
    <?php echo htmlspecialchars($v['uploaded_at']); ?> —
    <?php echo htmlspecialchars($v['original_name']); ?> —
    <a href="download.php?ver=<?php echo $v['id']; ?>">Download</a>
  </li>
<?php endforeach; ?>
</ul>

<p><a href="documents.php">Kembali</a></p>
</body>
</html>
