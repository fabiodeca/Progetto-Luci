<?php
session_start();

if (isset($_SESSION['email'])) {
    $stmt = $conn->prepare("UPDATE Ospiti SET uscita = NOW()");
    $stmt->execute();
    $stmt->close();
}

session_unset();
session_destroy();

unset($_SESSION["email"]);
unset($_SESSION["codice"]);

header("Location: login.php");
exit();
?>
