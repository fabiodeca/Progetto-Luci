<?php
$servername = "localhost";
$username = "dec_fab_user_2";
$password = "1234";
$dbname = "dec_fab_db_2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Recupera i dati dalla tabella Visite
$sql = "SELECT v.ID_Visita, o.nome, o.cognome, o.azienda, v.ingresso, v.uscita
        FROM Visite v
        JOIN Ospiti o ON v.ID_Ospite = o.ID_Ospite";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Restituisci i dati in formato JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>