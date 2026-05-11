<?php

// CONEXIÓN A LA BASE DE DATOS
$conn = new mysqli("localhost","root","","bd_pelotasensor");

// VERIFICAR CONEXIÓN
if($conn->connect_error){
    die("Error de conexión: " . $conn->connect_error);
}

// VERIFICAR ENVÍO DEL FORMULARIO
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // OBTENER DATOS
    $tipo = $_POST['tipo'];
    $valor = $_POST['valor'];

    // INSERTAR EN LA BASE DE DATOS
    $sql = "INSERT INTO registros (tipo, valor) VALUES ('$tipo', '$valor')";

    if($conn->query($sql) === TRUE){

        // REDIRECCIONAR
        header("Location: datos.php");
        exit();

    } else {

        echo "Error al guardar datos";

    }

}

// CERRAR CONEXIÓN
$conn->close();

?>
