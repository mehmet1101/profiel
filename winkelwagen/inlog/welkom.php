<?php
session_start(); //Start of restart de sessie

// Controleer of de sessievariabele voor de gebruiker bestaat 
if (!isset($_SESSION['gebruiker'])) {
    // Als dat niet overeen komt, terug sturen naar een andere pagina
    header("Location: inloggen.php");
    exit();
}

// Mocht de sessie wel bestaan verwelkom
$gebruikersnaam = $_SESSION['gebruiker'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Comatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css"  rel="stylesheet"/>
    <link rel="stylesheet" href="../Webshop/style.css" />
</head>
<body>
<h1>Welkom, <?php echo htmlspecialchars($gebruikersnaam); ?>!</h1>
    <!-- Optioneel <p>Je bent succesvol ingelogd</p> -->
    <?php
    if ($gebruikersnaam == 'admin') {
        echo "<p></p><a href='Wachtwoordwijzigen.php'>Alleen admin kan alle wachwoorden wijzigen</a></p>";
    }
    ?>
    <br><a href="logout.php">Uitloggen</a>

</body>
</html>