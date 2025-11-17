<?php
require './config/init.php';
require_login();

if (isset($_GET['ver'])) {
    $ver = (int)$_GET['ver'];
    $stmt = $pdo->prepare('SELECT dv.* 
                           FROM document_versions dv 
                           JOIN documents d ON d.id = dv.document_id 
                           WHERE dv.id = ? AND d.is_active = 1');
    $stmt->execute([$ver]);
    $v = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$v) { http_response_code(404); exit('File not found'); }

} elseif (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare('SELECT dv.* 
                           FROM documents d 
                           JOIN document_versions dv ON dv.id = d.current_version_id 
                           WHERE d.id = ? AND d.is_active = 1');
    $stmt->execute([$id]);
    $v = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$v) { http_response_code(404); exit('File not found'); }

} else { 
    http_response_code(400); 
    exit('Bad request'); 
}

$user = current_user();
if (!( $user['role'] === 'admin' || $user['role'] === 'staff' || $user['id'] == $v['uploaded_by'] )) {
    http_response_code(403); exit('Access denied');
}

$path = rtrim($config['upload_dir'], '/') . '/' . $v['filename'];
if (!file_exists($path)) { http_response_code(404); exit('File missing'); }

log_action($pdo, $user['id'], 'download', 'version=' . $v['id']);

header('Content-Description: File Transfer');
header('Content-Type: ' . $v['mime']);
header('Content-Disposition: attachment; filename="' . basename($v['original_name']) . '"');
header('Content-Length: ' . $v['size']);
readfile($path);
exit;
