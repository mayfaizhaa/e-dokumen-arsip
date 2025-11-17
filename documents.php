<?php
require './config/init.php';
require_login();

$q = trim($_GET['q'] ?? '');
$category = isset($_GET['category']) ? (int)$_GET['category'] : null;
$tag = trim($_GET['tag'] ?? '');

$sql = 'SELECT d.*, u.full_name, v.original_name, v.mime, v.size, v.uploaded_at
FROM documents d
JOIN users u ON d.created_by = u.id
LEFT JOIN document_versions v ON v.id = d.current_version_id
WHERE d.is_active = 1';

$params = [];

if ($q) { 
    $sql .= ' AND (d.title LIKE ? OR d.description LIKE ?)';
    $params[] = "%$q%";
    $params[] = "%$q%";
}

if ($category) { 
    $sql .= ' AND d.category_id = ?'; 
    $params[] = $category; 
}

if ($tag) {
    $sql = 'SELECT d.*, u.full_name, v.original_name, v.mime, v.size, v.uploaded_at
    FROM documents d
    JOIN users u ON d.created_by = u.id
    LEFT JOIN document_versions v ON v.id = d.current_version_id
    JOIN document_tags dt ON dt.document_id = d.id
    JOIN tags t ON t.id = dt.tag_id
    WHERE d.is_active = 1 AND t.name = ?';

    $params = [$tag];
}

$stmt = $pdo->prepare($sql . ' ORDER BY d.created_at DESC LIMIT 100');
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

function e($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html>
<head>
<title>Daftar Dokumen</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Daftar Dokumen</h2>

<p>Halo, <?= e(current_user()['username'] ?? '') ?> 
| <a href="./auth/logout.php">Logout</a> 
| <a href="upload.php">Upload</a></p>

<form method="get">
<input name="q" placeholder="Cari judul/desc" value="<?= e($q) ?>">
<input name="tag" placeholder="tag" value="<?= e($tag) ?>">
<input name="category" placeholder="kategori id" value="<?= e($category) ?>">
<button>Cari</button>
</form>

<?php if(!empty($_GET['msg'])) echo '<p class="success">' . e($_GET['msg']) . '</p>'; ?>

<table class="doclist">
<tr>
<th>ID</th><th>Judul</th><th>File</th><th>By</th><th>Uploaded</th><th>Aksi</th>
</tr>

<?php foreach ($rows as $r): ?>
<tr>
<td><?= e($r['id']) ?></td>
<td><?= e($r['title']) ?></td>
<td><?= e($r['original_name'] ?: '-') ?></td>
<td><?= e($r['full_name']) ?></td>
<td><?= e($r['uploaded_at']) ?></td>
<td>
<a href="view_document.php?id=<?= e($r['id']) ?>">Lihat</a>
<a href="download.php?id=<?= e($r['id']) ?>">Download</a>
<?php 
$u = current_user();
if ($u['role'] === 'admin' || $u['id'] == $r['created_by']): ?>
    <a href="edit_document.php?id=<?= e($r['id']) ?>">Edit</a>
    <a href="delete_document.php?id=<?= e($r['id']) ?>" onclick="return confirm('Yakin hapus dokumen ini?')">Hapus</a>
<?php endif; ?>
</td>
</td>
</tr>
<?php endforeach; ?>

</table>
</body>
</html>
