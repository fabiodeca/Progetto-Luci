<?php
$servername = "localhost";
$username = "dec_fab_user_1";
$password = "1234";
$dbname = "dec_fab_db_2";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}


$sql = "SELECT * FROM tua_tabella";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ospiti</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Azienda</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>".$row["id"]."</td>
                    <td>".$row["nome"]."</td>
                    <td>".$row["cognome"]."</td>
                    <td>".$row["azienda"]."</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nessun risultato trovato</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>