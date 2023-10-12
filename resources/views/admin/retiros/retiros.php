<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include("../../../../controllers/conexion.php");
 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Retiros</title>
    <link rel="stylesheet" href="/public/assets/css/retiros.css">
</head>
<body>
    <h1>Lista de Retiros</h1>
    <div class="saldo-box">
        <div class="saldo-item">
            <h2>Saldo Inicial</h2>
            <p>$500.00</p> <!-- Reemplaza esto con el valor real -->
        </div>
        <div class="saldo-item">
            <h2>Saldo Total</h2>
            <p>$700.00</p> <!-- Reemplaza esto con el valor real -->
        </div>
        <div class="saldo-item">
            <h2>Saldo Sumado</h2>
            <p>$200.00</p> <!-- Reemplaza esto con el valor real -->
        </div>
    </div>
    <table> 
    <input type="text" id="busqueda" placeholder="Buscar en la lista" onkeyup="buscarRetiros()">
    <a href="/resources/views/admin/retiros/agregar_retiros.php" class="button">Agregar Retiro</a>
    <a href="/resources/views/admin/inicio/inicio.php" class="button">Volver</a>
        <tr>
            <th>Nombre de la Zona</th>
            <th>Fecha</th>
            <th>Valor</th>
        </tr>
       
    </table>
    <script>
function buscarRetiros() {
    var input = document.getElementById("busqueda"); 
    var filtro = input.value.toLowerCase();
    var tabla = document.querySelector("table");
    var filas = tabla.getElementsByTagName("tr");

    for (var i = 1; i < filas.length; i++) { // Empezamos desde 1 para omitir la fila de encabezados
        var celdas = filas[i].getElementsByTagName("td");
        var filaCoincide = false;

        for (var j = 0; j < celdas.length; j++) {
            var celda = celdas[j];
            if (celda) {
                var textoCelda = celda.textContent || celda.innerText;
                if (textoCelda.toLowerCase().indexOf(filtro) > -1) {
                    filaCoincide = true;
                    break;
                }
            }
        }

        if (filaCoincide) {
            filas[i].style.display = "";
        } else {
            filas[i].style.display = "none";
        }
    }
}
</script>
</body>
</html>
