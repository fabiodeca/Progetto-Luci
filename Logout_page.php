<?php
session_start();

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style_index.css">
    <title>Logout</title>
</head>
<body>
    <div class="login-container">
        <h2>Effettua il Logout</h2>
        <form action="test.php" method="post">
            <input type="email" id="email" name="email" placeholder="Inserisci la tua email" required>
            <input type="text" id="ID_Ospite" name="ID_Ospite" placeholder="Inserisci il tuo ID Ospite" required>
            <button type="submit">Fai il Logout</button>
        </form>
    </div>
</body>
</html>