<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "bd_pelotasensor";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$nombre    = $_POST['nombre'] ?? '';
$email     = $_POST['email'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$ciudad    = $_POST['ciudad'] ?? '';
$cp        = $_POST['cp'] ?? '';

if ($nombre !== '') {

    $stmt = $conn->prepare(
        "INSERT INTO registros
        (nombre, email, direccion, ciudad, cp, tipo, valor)
        VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    $tipo = "Compra SmartBall";
    $valor = 129999;

    $stmt->bind_param(
        "ssssssi",
        $nombre,
        $email,
        $direccion,
        $ciudad,
        $cp,
        $tipo,
        $valor
    );

    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">

<title>Compra realizada</title>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#07111f;
    color:white;
}

/* CONTENEDOR */

.container{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:40px;
}

/* CARD */

.card{
    width:100%;
    max-width:750px;

    background:#0b1c2c;

    border-radius:25px;

    padding:50px;

    box-shadow:
    0 0 40px rgba(77,184,255,0.2);

    animation:fade 0.5s ease;
}

h1{
    color:#4db8ff;
    font-size:42px;
    margin-bottom:15px;
}

.subtitle{
    color:#c7d5e0;
    margin-bottom:35px;
    font-size:18px;
}

/* INFO */

.info{
    background:#091521;
    border-radius:20px;
    padding:30px;
    line-height:2;
    font-size:18px;
}

.label{
    color:#4db8ff;
    font-weight:bold;
}

/* BOTÓN */

a{
    display:inline-block;

    margin-top:35px;

    padding:14px 28px;

    background:#4db8ff;

    color:black;

    text-decoration:none;

    border-radius:10px;

    transition:0.3s;
}

a:hover{
    transform:scale(1.05);
}

/* ANIMACIÓN */

@keyframes fade{

    from{
        opacity:0;
        transform:translateY(20px);
    }

    to{
        opacity:1;
        transform:translateY(0px);
    }

}

</style>

</head>

<body>

<div class="container">

    <div class="card">

        <h1>
            ¡Compra realizada!
        </h1>

        <p class="subtitle">
            Gracias por comprar tu SmartBall ⚽
        </p>

        <div class="info">

            <span class="label">
                Nombre:
            </span>

            <?php echo $nombre; ?>

            <br>

            <span class="label">
                Email:
            </span>

            <?php echo $email; ?>

            <br>

            <span class="label">
                Dirección:
            </span>

            <?php echo $direccion; ?>

            <br>

            <span class="label">
                Ciudad:
            </span>

            <?php echo $ciudad; ?>

            <br>

            <span class="label">
                Código postal:
            </span>

            <?php echo $cp; ?>

            <br>

            <span class="label">
                Producto:
            </span>

            SmartBall

            <br>

            <span class="label">
                Total:
            </span>

            $129.999
            <hr style="margin:25px 0; border:1px solid #1b344d;">

<h2 style="color:#4db8ff;">
    Método de pago
</h2>

<p style="margin-top:15px; line-height:1.8;">

    Realizá la transferencia al siguiente alias:

    <br><br>

    <strong style="
    font-size:24px;
    color:#4db8ff;
    ">
        smartball-arg.mp
    </strong>

    <br><br>

    Luego enviá el comprobante junto con tu nombre.
    <!-- MÉTODOS -->

<div style="
margin-top:35px;
display:flex;
align-items:center;
gap:20px;
flex-wrap:wrap;
justify-content:center;
">

    <div style="
    background:white;
    color:#009ee3;
    font-weight:bold;
    padding:12px 22px;
    border-radius:12px;
    font-size:20px;
    box-shadow:0 0 20px rgba(0,0,0,0.2);
    ">
        Mercado Pago
    </div>

    <div style="
    width:170px;
    height:170px;
    background:
    repeating-linear-gradient(
        0deg,
        #000,
        #000 8px,
        #fff 8px,
        #fff 16px
    ),
    repeating-linear-gradient(
        90deg,
        #000,
        #000 8px,
        #fff 8px,
        #fff 16px
    );

    border:10px solid white;
    border-radius:12px;
    box-shadow:0 0 25px rgba(77,184,255,0.2);
    ">
    </div>

</div>

<p style="
margin-top:20px;
color:#8ca3b5;
font-size:14px;
text-align:center;
">
QR ilustrativo para demostración.
</p>

</p>

        </div>

        <a href="index.html">
            Volver al inicio
        </a>

    </div>

</div>

</body>
</html>
