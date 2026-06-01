<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "bd_pelotasensor";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$nombre = $_POST['nombre'] ?? '';
$email  = $_POST['email'] ?? '';

if ($nombre !== '' && $email !== '') {

    $stmt = $conn->prepare(
        "INSERT INTO registros (nombre, email)
         VALUES (?, ?)"
    );

    $stmt->bind_param("ss", $nombre, $email);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Confirmación</title>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#0b1c2c;
    color:white;
}

header{
    background:#123b5a;
    padding:20px;
    text-align:center;
}

.container{
    max-width:800px;
    margin:auto;
    padding:40px;
    text-align:center;
}

.card{
    background:#123b5a;
    padding:30px;
    border-radius:15px;
}

a{
    display:inline-block;
    margin-top:20px;
    padding:10px 20px;
    background:#4db8ff;
    color:black;
    text-decoration:none;
    border-radius:5px;
}

</style>

</head>

<body>

<header>
    <h1>SMARTBALL</h1>
</header>

<div class="container">

    <div class="card">

        <h2>¡Solicitud enviada!</h2>

        <p>
            Gracias <strong><?php echo $nombre; ?></strong>
        </p>

        <p>
            Te contactaremos a:
            <strong><?php echo $email; ?></strong>
        </p>

        <a href="index.html">Volver al inicio</a>

    </div>

</div>

</body>
</html>
