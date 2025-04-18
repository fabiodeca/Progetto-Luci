<?php
session_start();

if (!isset($_SESSION["email"])) {
    session_write_close();
    header("Location: login.php");
    exit();
}

unset($_SESSION["email"]);
unset($_SESSION["codice"]);
session_write_close();
header('Location: ./index.php');
exit;
?>
