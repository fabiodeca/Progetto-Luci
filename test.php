<?php
session_start();

$servername = "localhost";
$username = "dec_fab_user_2";
$password = "1234";
$dbname = "dec_fab_db_2";

date_default_timezone_set('Europe/Rome');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Recupero dei dati dal modulo
$email = isset($_POST['email']) ? $_POST['email'] : '';
$ID_Ospite = isset($_POST['ID_Ospite']) ? $_POST['ID_Ospite'] : '';

// Debug: verifica se i dati sono stati ricevuti
if (empty($email) || empty($ID_Ospite)) {
    echo "Errore: Dati mancanti. Email: $email, ID_Ospite: $ID_Ospite";
    exit();
}

// Recupera l'ID_Ospite dal database
$sql = "SELECT * FROM Ospiti WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Controlla se l'utente esiste nel database
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if (password_verify($ID_Ospite, $row['ID_Ospite'])) {
        $ID_Ospite_DB = $row['ID_Ospite'];

        // Aggiorna l'ora di uscita nella tabella Visite
        $uscita = date("Y-m-d H:i:s");
        $sql_uscita = "UPDATE Visite SET uscita = ? WHERE ID_Ospite = ? AND uscita IS NULL";
        $stmt_uscita = $conn->prepare($sql_uscita);
        $stmt_uscita->bind_param("ss", $uscita, $ID_Ospite_DB);

        if ($stmt_uscita->execute()) {
            // Distruggi la sessione e reindirizza a Logout.php
            session_destroy();
            header("Location: Logout.php");
            exit();
        } else {
            echo "Errore durante l'aggiornamento della tabella Visite: " . $stmt_uscita->error;
        }

        $stmt_uscita->close();
    } else {
        echo "Errore: ID_Ospite non valido.";
        exit();
    }
} else {
    // Messaggio di debug per capire perché l'utente non viene trovato
    echo "Errore: Utente non trovato nel database.<br>";
    echo "Email ricevuta: $email<br>";
    echo "ID_Ospite ricevuto: $ID_Ospite<br>";
    echo "Verifica che l'email e l'ID_Ospite siano corretti e corrispondano ai dati nel database.";
    exit();
}

$stmt->close();
$conn->close();
?>