<?php
session_start();

$config = require __DIR__ . '/config.php';

try {
    $pdo = new PDO(
        "mysql:host={$config['db']['host']};dbname={$config['db']['name']};charset=utf8mb4",
        $config['db']['user'],
        $config['db']['pass'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (Exception $e) {
    die('DB Error: ' . $e->getMessage());
}

function is_logged_in() {
    return !empty($_SESSION['user']);
}

function current_user() {
    return $_SESSION['user'] ?? null;
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: auth_login.php');
        exit;
    }
}

function has_role($role_name) {
    $u = current_user();
    if (!$u) return false;
    return isset($u['role']) && $u['role'] == $role_name;
}

function log_action($pdo, $user_id, $action, $details = null) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? null;
    $stmt = $pdo->prepare('INSERT INTO logs (user_id, action, details, ip) VALUES (?, ?, ?, ?)');
    $stmt->execute([$user_id, $action, $details, $ip]);
}
