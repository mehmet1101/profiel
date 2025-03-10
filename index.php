<?php
session_start();
if (isset($_SESSION['username'])) {
    echo "<h2>Welkom, " . $_SESSION['username'] . "!</h2>";
    echo "<a href='logout.php'>Uitloggen</a>";
} else {
    header("Location: login_form.php");
    exit();
}
?>
