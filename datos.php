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

// DATOS DEL GRÁFICO
$tipos = [];
$valores = [];

$res = $conn->query(
    "SELECT tipo, valor
     FROM registros
     WHERE valor IS NOT NULL"
);

if ($res) {
    while ($row = $res->fetch_assoc()) {
        $tipos[] = $row['tipo'];
        $valores[] = $row['valor'];
    }
}

// ESTADÍSTICAS
$max = ["maximo" => 0];
$avg = ["promedio" => 0];
$count = ["total" => 0];

$maxQuery = $conn->query(
    "SELECT MAX(valor) AS maximo FROM registros"
);

if ($maxQuery) {
    $max = $maxQuery->fetch_assoc();
}

$avgQuery = $conn->query(
    "SELECT AVG(valor) AS promedio FROM registros"
);

if ($avgQuery) {
    $avg = $avgQuery->fetch_assoc();
}

$countQuery = $conn->query(
    "SELECT COUNT(valor) AS total FROM registros"
);

if ($countQuery) {
    $count = $countQuery->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>SmartBall - Estadísticas</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{
    margin:0;
    font-family:Arial, sans-serif;
    background:#07111f;
    color:white;
}

header{
    background:#0b1c2c;
    text-align:center;
    padding:25px;
    border-bottom:2px solid #4db8ff;
}

.container{
    max-width:1100px;
    margin:auto;
    padding:30px;
}

.card{
    background:#0b1c2c;
    border-radius:15px;
    padding:25px;
    margin-bottom:25px;
    box-shadow:0 0 20px rgba(77,184,255,0.1);
}

h2{
    color:#4db8ff;
}

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
}

.stat{
    background:#091521;
    border:1px solid #4db8ff;
    border-radius:10px;
    padding:20px;
    text-align:center;
}

.stat h3{
    color:#4db8ff;
}

input{
    width:100%;
    padding:12px;
    margin-top:10px;
    margin-bottom:15px;
    border:none;
    border-radius:8px;
    background:#091521;
    color:white;
}

button{
    padding:12px 25px;
    border:none;
    border-radius:8px;
    background:#4db8ff;
    cursor:pointer;
    font-weight:bold;
}

button:hover{
    opacity:0.9;
}

canvas{
    background:white;
    border-radius:10px;
    padding:10px;
}

.volver{
    display:inline-block;
    margin-top:20px;
    color:#4db8ff;
    text-decoration:none;
}

</style>

</head>

<body>

<header>

    <h1>⚽ SMARTBALL</h1>

    <p>Panel de estadísticas</p>

</header>

<div class="container">

    <div class="card">

        <h2>Ingresar medición</h2>

        <form action="guardar.php" method="POST">

            <input
            type="text"
            name="tipo"
            placeholder="Velocidad, Fuerza, Altura..."
            required>

            <input
            type="number"
            name="valor"
            placeholder="Valor"
            required>

            <button type="submit">
                Guardar dato
            </button>

        </form>

    </div>

    <div class="card">

        <h2>Estadísticas generales</h2>

        <div class="stats">

            <div class="stat">
                <h3>Máximo</h3>
                <p><?php echo $max['maximo'] ?? 0; ?></p>
            </div>

            <div class="stat">
                <h3>Promedio</h3>
                <p><?php echo round($avg['promedio'] ?? 0, 2); ?></p>
            </div>

            <div class="stat">
                <h3>Registros</h3>
                <p><?php echo $count['total'] ?? 0; ?></p>
            </div>

        </div>

    </div>

    <div class="card">

        <h2>Gráfico de mediciones</h2>

        <canvas id="grafico"></canvas>

    </div>

    <a class="volver" href="index.html">
        ⬅ Volver al inicio
    </a>

</div>

<script>

const ctx = document.getElementById('grafico');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: <?php echo json_encode($tipos); ?>,

        datasets: [{
            label: 'Valores registrados',
            data: <?php echo json_encode($valores); ?>,
            borderWidth: 1
        }]

    },

    options: {

        responsive:true,

        scales:{
            y:{
                beginAtZero:true
            }
        }

    }

});

</script>

</body>
</html>

<?php
$conn->close();
?>
