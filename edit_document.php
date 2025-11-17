<?php
require './config/init.php';
require_login();

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM documents WHERE id = ?");
$stmt->execute([$id]);
$doc = $stmt->fetch();

if (!$doc) die("Dokumen tidak ditemukan.");

$user = current_user();
if ($user['role'] !== 'admin' && $user['id'] != $doc['created_by']) {
    die("Anda tidak punya akses.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);

    $update = $pdo->prepare("UPDATE documents SET title=?, description=? WHERE id=?");
    $update->execute([$title, $desc, $id]);

    log_action($pdo, $user['id'], 'edit', "document=$id");

    header("Location: documents.php?msg=Dokumen berhasil diupdate");
    exit;
}
?>
<!doctype html>
<html>
<head><title>Edit Dokumen</title></head>
<body>
<h2>Edit Dokumen</h2>

<form method="post">
Judul:<br>
<input name="title" value="<?= htmlspecialchars($doc['title']) ?>"><br><br>

Deskripsi:<br>
<textarea name="description"><?= htmlspecialchars($doc['description']) ?></textarea><br><br>

<button>Simpan Perubahan</button>
</form>

<p><a href="documents.php">Kembali</a></p>
</body>
</html>
