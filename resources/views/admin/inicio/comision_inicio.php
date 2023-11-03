<?php
// Funciones PHP al inicio del archivo
function connectToDB() {
    // Aquí debes reemplazar con tus propios detalles de conexión a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'prestamos');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function getTotalCommissions() {
    $conn = connectToDB();
    $sql = "SELECT SUM(Comision) AS totalCommissions FROM prestamos";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['totalCommissions'];
    } else {
        return 0;
    }
    $conn->close();
}

// Si se realiza una solicitud GET a este archivo, devuelve el total de comisiones
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo getTotalCommissions();
    exit; // Finaliza la ejecución del script para no renderizar HTML
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Comisiones</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div id="commissionsModule">
        <h2>Comisiones Totales: <span id="totalCommissions">Cargando...</span></h2>
    </div>

    <script>
        $(document).ready(function() {
            // La solicitud GET se realiza al mismo archivo
            $.get('', function(data) {
                $('#totalCommissions').text(data);
            });
        });
    </script>
</body>
</html>
