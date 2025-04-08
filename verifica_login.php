<?php
$servername = "localhost";
$username = "dec_fab_user_1";
$password = "1234";
$dbname = "dec_fab_db_2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$email = $_POST['email'];
$azienda_di_provenienza = $_POST['azienda_di_provenienza'];
$ora_registrazione = $_POST['ora_registrazione'];

// Verifica se l'utente esiste
$sql = "SELECT * FROM utenti WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    $sql_insert = "INSERT INTO registrazioni (email, azienda_di_provenienza, ora_registrazione) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sss", $email, $azienda_di_provenienza, $ora_registrazione);
    $stmt_insert->execute();
    $stmt_insert->close();

    echo "Registrazione completata con successo!";
} else {
    header("Location: register.html");
}

$stmt->close();
$conn->close();
?>