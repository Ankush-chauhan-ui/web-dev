<?php
session_start();


$adminUser = 'admin';
$adminPass = 'Admin@123';


if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}


if (isset($_SESSION['admin'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === $adminUser && $password === $adminPass) {
        session_regenerate_id(true);
        $_SESSION['admin'] = $username;
        header('Location: dashboard.php');
        exit;
    }

    $error = 'Incorrect username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | TechNova</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f2f5f9;display:flex;justify-content:center;align-items:center;min-height:100vh;margin:0}
        .login{background:white;width:300px;padding:25px;border-radius:8px;box-shadow:0 2px 12px #0002}
        h2{text-align:center;color:#0b2a4a}
        input,button{width:100%;padding:11px;margin:8px 0;box-sizing:border-box}
        button{background:#0b2a4a;color:white;border:0;border-radius:4px;cursor:pointer}
        .error{color:#c62828;text-align:center;font-size:14px}
    </style>
</head>
<body>
    <form class="login" method="POST">
        <h2>TechNova Admin Login</h2>

        <?php if ($error !== ''): ?>
            <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
