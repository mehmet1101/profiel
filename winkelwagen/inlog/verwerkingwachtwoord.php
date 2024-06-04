<?php
require "config.php";

session_start();

if (isset($_POST['username']) && isset($_POST['newPassword'])) {
    $username = $_POST['username'];
    $newPassword = password_hash($_POST['username'], PASSWORD_DEFAULT); 

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $query = $db->prepare("UPDATE gebruikers SET password = :newPassword WHERE username = :username");
        $query->bindParam(':newPassword', $newPassword);
        $query->bindParam(':username', $username);

        if ($query->execute()) {
            echo "Het wachtwoord voor $username is succesvol gewijzigd. </br><a href='inloggen.php'>Ga terug</a>";
        } else {
            echo "Er is een fout opgetreden bij het wijzigen van de gegevens.";
        }
    } catch(PDOException $_e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo "Vul alle velden in!!";
}
?>
