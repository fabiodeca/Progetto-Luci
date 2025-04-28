<?php
$servername = "localhost";
$username = "dec_fab_user_2";
$password = "1234";
$dbname = "dec_fab_db_2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$email = $_POST['email'];
$ID_Ospite = $_POST['ID_Ospite'];
$ingresso = date("Y-m-d H:i:s");
$uscita = date("Y-m-d H:i:s", strtotime("+1 hour"));


$sql = "SELECT * FROM Ospiti WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if (password_verify($ID_Ospite, $row['ID_Ospite'])) {
        $ID_Ospite_DB = $row['ID_Ospite'];

        $sql_ingresso = "INSERT INTO Visite (ingresso, uscita, ID_Ospite) VALUES (?, ?, ?)";
        $stmt_ingresso = $conn->prepare($sql_ingresso);
        $stmt_ingresso->bind_param("sss", $ingresso, $uscita, $ID_Ospite_DB);

        if ($stmt_ingresso->execute()) {
            header("Location: logged.html");
        } else {
            echo "Errore durante l'inserimento nella tabella Visite: " . $stmt_ingresso->error;
        }

        $stmt_ingresso->close();
    } else {
        header("Location: login_error.html");
    }
} else {
    header("Location: register.html");
}

$stmt->close();
$conn->close();
?>