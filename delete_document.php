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

$del = $pdo->prepare("UPDATE documents SET is_active = 0 WHERE id = ?");
$del->execute([$id]);

log_action($pdo, $user['id'], 'delete', "document=$id");

header("Location: documents.php?msg=Dokumen berhasil dihapus");
exit;
