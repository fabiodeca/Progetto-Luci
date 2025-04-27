<?php
$servername = "localhost";
$username = "dec_fab_user_2";
$password = "1234";
$dbname = "dec_fab_db_2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$email = $_POST['email'];
$ID_Ospite = $_POST['ID_Ospite'];
$azienda = $_POST['azienda'];

$hashed_ID_Ospite = password_hash($ID_Ospite, PASSWORD_DEFAULT);


$sql = "INSERT INTO Ospiti (nome, cognome, email, ID_Ospite, azienda) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nome, $cognome, $email, $hashed_ID_Ospite, $azienda);

if ($stmt->execute()) {
    header("Location: index.html");
} else {
    echo "Errore durante la registrazione: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>