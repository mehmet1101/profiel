<?php
class User {
    public $username;
    public $email;
    private $password;
    private $conn;

    public function __construct() {
        // Databaseverbinding instellen (Pas dit aan naar jouw database-instellingen)
        $this->conn = new PDO("mysql:host=localhost;dbname=login_db", "root", "");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function SetPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT); // Veilige hashing
    }

    public function RegisterUser() {
        $errors = [];
        
        if (empty($this->username) || empty($this->password)) {
            $errors[] = "Gebruikersnaam en wachtwoord mogen niet leeg zijn.";
            return $errors;
        }
        
        // Controleer of de gebruiker al bestaat
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute([$this->username]);
        if ($stmt->rowCount() > 0) {
            $errors[] = "Gebruikersnaam bestaat al.";
        } else {
            // Gebruiker opslaan in de database
            $stmt = $this->conn->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
            $stmt->execute([$this->username, $this->password]);
        }

        return $errors;
    }
}

// Register_form.php aanpassen
if(isset($_POST['register-btn'])){
    require_once('classes/user.php');
    $user = new User();
    $errors = [];

    $user->username = trim($_POST['username']);
    $user->SetPassword(trim($_POST['password']));

    // Registratieproces
    $errors = $user->RegisterUser();
    
    if(count($errors) > 0){
        $message = implode("\\n", $errors);
        echo "<script>alert('$message'); window.location = 'register_form.php';</script>";
    } else {
        echo "<script>alert('Registratie geslaagd!'); window.location = 'login_form.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
</head>
<body>
    <h3>PHP - PDO Login en Registratie</h3>
    <hr/>
    <form action="" method="POST">
        <h4>Registreer hier...</h4>
        <hr>
        <label>Gebruikersnaam</label>
        <input type="text" name="username" required />
        <br>
        <label>Wachtwoord</label>
        <input type="password" name="password" required />
        <br>
        <button type="submit" name="register-btn">Registreren</button>
    </form>
</body>
</html>
