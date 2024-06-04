<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css"  rel="stylesheet"/>
    <link rel="stylesheet" href="../Webshop/style.css" />
</head>
<body>
<h2>Gebruiker registreren</h2>
    <form action="#" method="post">
        <div>
            <label for="username">Gebruikersnaam:</label>
            <input type="text" id="username" name="username" required><br>
        </div>
        <div>
            <label for="password">Wachtwoord:</label>
            <input type="text" id="password" name="password" required><br>
        </div>  
        <div>
        <input type="submit"  name="Registreer" value="Registreer">
        </div>
    </form>
<?php


if(isset($_POST['registreer'])) {
    include 'config.php';

    try{
        $db = new PDO ("mysql:host=$host;dbname=$dbname", $user, $pass);
        
        $query = $db-> prepare("INSERT INTO gebruiker (username, password) VALUES(:username, :password)");

        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $query->bindParam(':username', $username);
        $query->bindParam(':password', $password);

        if($query->execute()) {
            echo "U bent succesvol ingelogd!";
        } else {
            echo "Er is een fout opgetreden bij het inloggen!";
        }
    } catch(PDOException $e) {
        
        die("Error!!:". $e->getMessage());
    }
}
?>
<br><br><br>
<a href="inloggen.php">Ga terug naar de inlog pagina</a>
</body>
</html>