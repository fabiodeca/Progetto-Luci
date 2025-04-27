<?php
$servername = "localhost";
$username = "dec_fab_user_2";
$password = "1234";
$dbname = "dec_fab_db_2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$email = $_POST['email'];
$ID_Ospite = $_POST['ID_Ospite'];
$ingresso = date("Y-m-d H:i:s");

$sql = "SELECT * FROM Ospiti WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$sql_insert = "INSERT INTO Visite (ingresso) VALUES ( ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("s", $ingresso);
    $stmt_insert->close();


    if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
        if (password_verify($ID_Ospite, $row['ID_Ospite'])) {
            header("Location: logged.html");
        } else {
            header("Location: login_error.html");
        }
        } else {
        header("Location: register.html");
    }
}

$stmt->close();
$conn->close();
?>