<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "bd_pelotasensor";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$tipo = $_POST['tipo'] ?? '';
$valor = $_POST['valor'] ?? '';

if ($tipo !== '' && $valor !== '') {

    $stmt = $conn->prepare(
        "INSERT INTO registros (tipo, valor)
         VALUES (?, ?)"
    );

    $stmt->bind_param("si", $tipo, $valor);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

header("Location: datos.php");
exit;
?>
