<?php
// Voeg de databaseconfiguratie toe vanuit een extern bestand
require "config.php"; // pas dit aan als het nodig is

// Start een nieuwe sessie of hervat de bestaande sessie
session_start();

// Controleer het inlogformulier
if (isset($_POST['inloggen'])) {
    try {
        // Maak een nieuwe databaseverbinding met behulp van PDO
        $db = new PDO($dsn, $user, $pass, $options);

        // Filter de gebruikersnaam om problemen te voorkomen
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);

        // Haal het wachtwoord direct uit de POST-array
        $password = $_POST['password'];

        // Bereid een SQL-query voor om een gebruiker te zoeken op gebruikersnaam
        $query = $db->prepare("SELECT * FROM gebruikers WHERE username = :user");

        // Voeg de ingevoerde gebruikersnaam toe aan de query
        $query->bindParam(":user", $username, PDO::PARAM_STR);

        // Voer de query uit
        $query->execute();

        // Controleer of er precies één gebruiker is gevonden
        if ($query->rowCount() == 1) {
            // Haal de gebruikersgegevens op
            $result = $query->fetch();
            
            // Controleer of het ingevoerde wachtwoord overeenkomt met het gehashte wachtwoord in de database
            if (password_verify($password, $result["password"])) {
                // Sla de gebruikersnaam op in een sessievariabele
                $_SESSION['gebruiker'] = $username;

                // Verwijs de gebruiker door naar de welkomstpagina
                header("Location: welkom.php");
                exit();
            } else {
                // Toon een foutmelding als het wachtwoord onjuist is
                echo "Onjuiste gegevens ingevoerd";
            }
        } else {
            // Toon een foutmelding als de gegevens niet zijn gevonden
            echo "Gegevens niet gevonden";
        }
    } catch(PDOException $e) {
        // Vang eventuele databaseverbindingsfouten op
        die("Error: " . $e->getMessage());
    }
}
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
<div class="header__bar">Gratis verzending vanaf €50</div>
    <nav class="section__container nav__container">
      <a href="Index.html" class="nav__logo">Biconomy</a>
      <ul class="nav__links">
        <li class="link"><a href="../Webshop/Index.html">Home</a></li>
        <li class="link"><a href="../Webshop/shop.html">Shop</a></li>
        <li class="link"><a href="../Webshop/blog.html">Blog</a></li>
        <li class="link"><a href="../Inlog/inloggen.php">Login</a></li>
      </ul>
      <div class="nav__icons">
        <span><a href="../Inlog/inloggen.php"><i class="ri-shield-user-line"></i></a></span>
        <span><i class="ri-search-line"></i></span>
        <span><i class="ri-shopping-bag-2-line"></i></span>
      </div>
    </nav>
<h2>Inloggen</h2>
    <form action="" method="post">
        <div>
            <label for="username">Gebruikersnaam:</label>
            <input type="text" id="username" name="username" required><br>
        </div>
        <div>   
            <label for="password">Wachtwoord:</label>
            <input type="text" id="password" name="password" required><br>
        </div>  
        <div>
        <input type="submit"  name="Inloggen" value="Inloggen">
        </div>
    </form>
    <br><a href="registreren.php">Registreren</a>

    <footer class="section__container footer__container">
      <div class="footer__col">
        <h4 class="footer__heading">Contact informatie</h4>
        <p>
          <i class="ri-map-pin-2-fill"></i> Jan Ligthartsstraat 250
          <br>3065 NR Rotterdam
          <br> Nederland
        </p>
        <p><i class="ri-mail-fill">Mehmet Kulaksiz</i> 9016885@student.tcrmbo.nl</p>
            <p><i class="ri-mail-fill">Sami Gülec</i> 9012676@student.tcrmbo.nl</p>
            <p><i class="ri-mail-fill">Wijayant Jagroep</i> 9021442@student.zadkine.nl</p>
            <p><i class="ri-phone-fill"></i> (+31) 3456 789</p>
      </div>
      <div class="footer__col">
        <h4 class="footer__heading">Company</h4>
        <p>Home</p>
        <p>Over ons</p>
        <p>Werk met ons</p>
        <p>Onze blog</p>
        <p>Algemene voorwaarden</p>
      </div>
      <div class="footer__col">
        <h4 class="footer__heading">Klantenservice</h4>
        <p>Help</p>
        <p>Track & Trace</p>
        <p>Telefoon</p>
        <p>Watches</p>
        <p>Oortjes</p>
      </div>
      </div>
    </footer>
 
    <hr />
 
    <div class="section__container footer__bar">
      <div class="copyright">
        Copyright © 2024 Biconomy. All rights reserved.
      </div>
      <div class="footer__form">
        <form>
          <input type="text" placeholder="Schrijf je hier in" />
          <button class="btn" type="submit">Inschrijven</button>
        </form>
      </div>
    </div>
</body>
</html>
