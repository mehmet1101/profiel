<?php
require 'config.php';

session_start();

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $query = $db->query("SELECT username FROM gebruikers"); // De juiste kolomnaam gebruiken om gebruikers op te halen
    $gebruikers = $query->fetchAll(PDO::FETCH_ASSOC); // Alle gebruikers ophalen
} catch(PDOException $e) {
    die("Error!" . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wachtwoord wijzigen</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css"  rel="stylesheet"/>
    <link rel="stylesheet" href="../Webshop/style.css" />
</head>
<body>
    <h2>De wachtwoorden van de gebruikers wijzigen</h2>
    <form action="verwerkingwachtwoord.php" method="post">
        <div>
            <label for="username">Selecteer hier de gebruiker:</label>
            <select name="username" id="username" required>
                <?php foreach($gebruikers as $gebruiker): ?>
                    <option value="<?= htmlspecialchars($gebruiker['username']) ?>"><?= htmlspecialchars($gebruiker['username']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="newPassword">Nieuw wachtwoord</label><br>
            <input type="password" id="newPassword" name="newPassword" required> <!-- Name attribuut toegevoegd voor verzending -->
        </div>
        <div>
            <input type="submit" value="Wachtwoord wijzigen" name="submit"> <!-- Name attribuut toegevoegd voor verzending -->
        </div>
    </form>
</body>
</html>
