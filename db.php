<?php
// Databaseverbinding met PDO
$host = "localhost";
$dbname = "login_db"; // Pas aan als je een andere naam gebruikt
$username = "root"; // Pas aan als je een wachtwoord hebt ingesteld
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbindingsfout: " . $e->getMessage());
}
?>
