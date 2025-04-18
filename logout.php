<?php
session_start();

if (isset($_SESSION['accesso_id'])) {
    $stmt = $conn->prepare("UPDATE Ospiti SET uscita = NOW() WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['accesso_id']);
    $stmt->execute();
    $stmt->close();
}

session_unset();
session_destroy();

header("Location: login.php");
exit();
?>
