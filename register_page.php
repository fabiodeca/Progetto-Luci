<?php
$servername = "localhost";
$username = "dec_fab_user_1";
$password = "1234";
$dbname = "dec_fab_db_2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$email = $_POST['email'];
$tipo_visita = $_POST['tipo_visita'];
$azienda = $_POST['azienda'];
$professione = $_POST['professione'];

$sql = "INSERT INTO utenti (nome, cognome, email, tipo_visita, azienda, professione) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $nome, $cognome, $email, $tipo_visita, $azienda, $professione);

if ($stmt->execute()) {
    header("Location: index.html");
} else {
    echo "Errore durante la registrazione: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>