<?php

$host = "localhost";
$db   = "u894818569_sistemas";
$user = "u894818569_murialdo";
$pass = "Ilm988vb";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8mb4");

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
