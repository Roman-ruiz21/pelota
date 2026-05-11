<?php

$conn = new mysqli("localhost","root","","bd_pelotasensor");

// DATOS DEL GRÁFICO
$tipos = [];
$valores = [];

$res = $conn->query("SELECT tipo, valor FROM registros WHERE valor IS NOT NULL");

while($row = $res->fetch_assoc()){
    $tipos[] = $row['tipo'];
    $valores[] = $row['valor'];
}

// ESTADÍSTICAS
$maxQuery = $conn->query("SELECT MAX(valor) as maximo FROM registros");
$avgQuery = $conn->query("SELECT AVG(valor) as promedio FROM registros");
$countQuery = $conn->query("SELECT COUNT(valor) as total FROM registros");

$max = $maxQuery->fetch_assoc();
$avg = $avgQuery->fetch_assoc();
$count = $countQuery->fetch_assoc();

?>

<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos SmartBall</title>

```
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
        padding:40px;
        max-width:1000px;
        margin:auto;
    }

    .card{
        background:#123b5a;
        padding:25px;
        border-radius:15px;
        margin-bottom:30px;
    }

    input{
        padding:10px;
        margin:10px;
        border:none;
        border-radius:5px;
    }

    button{
        padding:10px 20px;
        background:#4db8ff;
        border:none;
        border-radius:5px;
        cursor:pointer;
    }

    .stats{
        display:grid;
        grid-template-columns:repeat(3,1fr);
        gap:15px;
    }

    .stat{
        background:#091521;
        padding:20px;
        border-radius:10px;
        text-align:center;
        border:1px solid #4db8ff;
    }

    canvas{
        background:white;
        border-radius:10px;
        padding:10px;
    }

    a{
        color:#4db8ff;
        text-decoration:none;
    }

</style>
```

</head>

<body>

<header>
    <h1>SMARTBALL</h1>
    <p>Panel de estadísticas</p>
</header>

<div class="container">

```
<!-- FORMULARIO -->
<div class="card">

    <h2>Ingresar medición</h2>

    <form action="guardar.php" method="POST">

        <input type="text" name="tipo" placeholder="Tipo (Velocidad, Fuerza...)" required><br>

        <input type="number" name="valor" placeholder="Valor" required><br>

        <button type="submit">Guardar dato</button>

    </form>

</div>

<!-- ESTADÍSTICAS -->
<div class="card">

    <h2>Estadísticas</h2>

    <div class="stats">

        <div class="stat">
            <h3>Máximo</h3>
            <?php echo $max['maximo'] ?? 0; ?>
        </div>

        <div class="stat">
            <h3>Promedio</h3>
            <?php echo round($avg['promedio'],2) ?? 0; ?>
        </div>

        <div class="stat">
            <h3>Registros</h3>
            <?php echo $count['total'] ?? 0; ?>
        </div>

    </div>

</div>

<!-- GRÁFICO -->
<div class="card">

    <h2>Gráfico</h2>

    <canvas id="grafico"></canvas>

</div>

<a href="index.html">⬅ Volver al inicio</a>
```

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
        scales: {
            y: {
                beginAtZero:true
            }
        }
    }

});

</script>

</body>
</html>
