<?php
// Functie: classdefinitie User
// Auteur: Mehmet Kulaksiz 
require_once 'db.php';
 
class User {
 
    // Eigenschappen
    public $username;
    public $email;
    private $password;
 
    // Zet wachtwoord
    function SetPassword($password) {
        $this->password = $password;  // Dit wachtwoord wordt gehasht bij registratie
    }
 
    // Verkrijg wachtwoord
    function GetPassword() {
        return $this->password;
    }
 
    // Controleer of de username geldig is (tussen 3 en 50 tekens)
    function IsValidUsername($username) {
        return strlen($username) >= 3 && strlen($username) <= 50;
    }
 
    // Toon gebruikersinformatie
    public function ShowUser() {
        echo "<br>Username: $this->username<br>";
        echo "<br>Email: $this->email<br>";
    }
 
    // Registreer een nieuwe gebruiker
    public function RegisterUser() {
        $status = false;
        $errors = [];
 
        if (!$this->IsValidUsername($this->username)) {
            array_push($errors, "Gebruikersnaam moet tussen 3 en 50 tekens zijn.");
        }
 
        if (!empty($this->username) && !empty($this->password) && empty($errors)) {
            // Databaseverbinding
            $database = new Database();
            $db = $database->dbConnection();
 
            // Controleer of de username al bestaat
            $stmt = $db->prepare("SELECT username FROM users WHERE username = :username");
            $stmt->bindParam(":username", $this->username);
            $stmt->execute();
 
            if ($stmt->rowCount() > 0) {
                array_push($errors, "Username bestaat al.");
            } else {
                // Wachtwoord hashen voordat het wordt opgeslagen
                $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
 
                // Voeg nieuwe gebruiker toe met het gehashte wachtwoord
                $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
                $stmt->bindParam(":username", $this->username);
                $stmt->bindParam(":email", $this->email);
                $stmt->bindParam(":password", $hashedPassword);  // Gebruik gehashed wachtwoord
                $role = "user"; // standaard rol
                $stmt->bindParam(":role", $role);
 
                if ($stmt->execute()) {
                    $status = true;
                } else {
                    array_push($errors, "Er is iets misgegaan bij registratie.");
                }
            }
        } else {
            array_push($errors, "Gebruikersnaam en wachtwoord mogen niet leeg zijn.");
        }
 
        return $errors;
    }
 
    // Valideer gebruikersinvoer
    function ValidateUser() {
        $errors = [];
 
        if (!$this->IsValidUsername($this->username)) {
            array_push($errors, "Invalid username (moet tussen 3 en 50 tekens zijn).");
        }
 
        if (empty($this->password)) {
            array_push($errors, "Invalid password");
        }
 
        return $errors;
    }
 
    // Login van de gebruiker
    public function LoginUser() {
        // Databaseverbinding
        $database = new Database();
        $db = $database->dbConnection();
 
        // Zoek de gebruiker in de database
        $stmt = $db->prepare("SELECT id, username, password, email, role FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(":username", $this->username);
        $stmt->execute();
 
        // Als de gebruiker wordt gevonden
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
            // Vergelijk het ingevoerde wachtwoord met het gehashte wachtwoord
            if (password_verify($this->password, $row['password'])) {  // Vergelijk gehashed wachtwoord
                // Sessie starten en gebruikersgegevens opslaan
                session_start();
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['id'] = $row['id'];
 
                return true; // Inloggen succesvol
            }
        }
 
        return false; // Onjuiste inloggegevens
    }
 
    // Controleer of de gebruiker ingelogd is
    public function IsLoggedin() {
        return isset($_SESSION['username']);
    }
 
    // Haal gebruikersgegevens op
    public function GetUser($username) {
        $database = new Database();
        $db = $database->dbConnection();
 
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
 
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
 
        return null; // Geen gebruiker gevonden
    }
 
    // Logout de gebruiker
    public function Logout() {
        session_start();
        session_destroy();
        header('Location: login_form.php');
    }
}
?>