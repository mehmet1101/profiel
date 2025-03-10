<?php
session_start();
require_once("db.php");

if(isset($_POST['login-btn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Ongeldige gebruikersnaam of wachtwoord.'); window.location = 'login_form.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
</head>
<body>
    <h3>Inloggen</h3>
    <form action="" method="POST">
        <label>Gebruikersnaam</label>
        <input type="text" name="username" required />
        <br>
        <label>Wachtwoord</label>
        <input type="password" name="password" required />
        <br>
        <button type="submit" name="login-btn">Inloggen</button>
    </form>
    <p>Nog geen account? <a href="register_form.php">Registreer hier</a></p>
</body>
</html>
