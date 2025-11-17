<?php
require '../config/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT u.*, r.name as role FROM users u JOIN roles r ON u.role_id=r.id WHERE username=?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($pass, $user['password'])) {
        $error = 'Login gagal.';
    } else {
        unset($user['password']);
        $_SESSION['user'] = $user;
        header('Location: ../documents.php');
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="./../style.css">
</head>
<body>
<h2>Login</h2>

<?php if (!empty($error)) echo '<p class="error">'.htmlspecialchars($error)."</p>"; ?>

<form method="post">
    <label>Username<br><input name="username"></label><br>
    <label>Password<br><input type="password" name="password"></label><br>
    <button>Masuk</button>
</form>

<p><a href="auth_register.php">Daftar akun</a></p>
</body>
</html>
