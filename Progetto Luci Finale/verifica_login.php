<?php
$servername = "localhost";
$username = "dec_fab_user_2";
$password = "1234";
$dbname = "dec_fab_db_2";

date_default_timezone_set('Europe/Rome');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$email = $_POST['email'];
$ID_Ospite = $_POST['ID_Ospite'];

// Verifica se l'utente è l'admin
if ($email === "admin@admin.com" && $ID_Ospite === "1") {
    header("Location: collegamento-admin.html");
    exit();
}

$sql = "SELECT * FROM Ospiti WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    if (password_verify($ID_Ospite, $row['ID_Ospite'])) {
        $ID_Ospite_DB = $row['ID_Ospite'];

        $sql_check_visite = "SELECT * FROM Visite WHERE ID_Ospite = ? AND uscita IS NULL";
        $stmt_check_visite = $conn->prepare($sql_check_visite);
        $stmt_check_visite->bind_param("s", $ID_Ospite_DB);
        $stmt_check_visite->execute();
        $result_check_visite = $stmt_check_visite->get_result();

        if ($result_check_visite->num_rows > 0) {
            header("Location: Logout_page.php");
        } else {
            $ingresso = date("Y-m-d H:i:s");
            $sql_ingresso = "INSERT INTO Visite (ingresso, ID_Ospite) VALUES (?, ?)";
            $stmt_ingresso = $conn->prepare($sql_ingresso);
            $stmt_ingresso->bind_param("ss", $ingresso, $ID_Ospite_DB);

            if ($stmt_ingresso->execute()) {
                header("Location: logged.html");
            } else {
                echo "Errore durante l'inserimento nella tabella Visite: " . $stmt_ingresso->error;
            }

            $stmt_ingresso->close();
        }

        $stmt_check_visite->close();
    } else {
        header("Location: login_error.html");
    }
} else {
    header("Location: register.html");
}

$stmt->close();
$conn->close();
?>