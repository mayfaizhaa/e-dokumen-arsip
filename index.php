<?php
require './config/init.php';

if (is_logged_in()) {
    header('Location: documents.php');
    exit;
}
?>

<!doctype html>
<html>
<head>
    <title>E-Arsip Kampus</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>📁 E-Arsip Dokumen Kampus</h1>
    <p>Silakan login untuk mengakses arsip dokumen.</p>
    <a href="./auth/auth_login.php" style="padding:10px 16px; background:#007bff; color:#fff; text-decoration:none; border-radius:6px;">Login</a>
    <a href="./auth/auth_register.php" style="padding:10px 16px; background:#28a745; color:#fff; text-decoration:none; border-radius:6px;">Register</a>
</body>
</html>
