<?php
require '../config/init.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$username = trim(
$_POST['username'] ?? ''
);
$pass = $_POST['password'] ?? '';
$fullname = $_POST['full_name'] ?? null;
if (!$username || !$pass) {
$error = 'Username dan password diperlukan.';
} else {
$hash = password_hash($pass, PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO users (username, password, full_name, role_id) VALUES (?, ?, ?, ?)');

$stmt->execute([$username, $hash, $fullname, 3]);
header('Location: auth_login.php');
exit;
}
}
?>
<!doctype html>
<html><head><title>Register</title><link rel="stylesheet" href="./../style.css"></head><body>
<h2>Register</h2>
<?php if(!empty($error)) echo '<p class="error">'.htmlspecialchars($error)."</p>"; ?>
<form method="post">
<label>Username<br><input name="username"></label><br>
<label>Password<br><input type="password" name="password"></label><br>
<label>Nama Lengkap<br><input name="full_name"></label><br>
<button>Daftar</button>
</form>
</body></html>