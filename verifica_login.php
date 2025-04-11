<?php
$servername = "localhost";
$username = "dec_fab_user_1";
$password = "1234";
$dbname = "dec_fab_db_2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$codice = $_POST['codice'];
$ora_registrazione = date("Y-m-d H:i:s");


$sql = "SELECT * FROM utenti WHERE codice = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $codice);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    $sql_insert = "INSERT INTO registrazioni (codice, ora_registrazione) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ss", $codice, $ora_registrazione);
    $stmt_insert->execute();
    $stmt_insert->close();

    echo "Accesso registrato con successo!";
} else {
    header("Location: login_error.html");
    exit();
}

$stmt->close();
$conn->close();
?>