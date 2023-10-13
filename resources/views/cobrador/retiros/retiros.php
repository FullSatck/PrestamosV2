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

// Consulta SQL para obtener el saldo inicial y el saldo neto del administrador
$sqlSaldoAdmin = "SELECT Monto, Monto_Neto FROM saldo_admin LIMIT 1";
$resultadoSaldoAdmin = $conexion->query($sqlSaldoAdmin);
$saldoAdmin = 0; // Valor por defecto si no se encuentra el saldo
$montoNetoAdmin = 0; // Valor por defecto si no se encuentra el saldo neto

if ($resultadoSaldoAdmin && $resultadoSaldoAdmin->num_rows > 0) {
    $filaSaldoAdmin = $resultadoSaldoAdmin->fetch_assoc();
    $saldoAdmin = $filaSaldoAdmin['Monto'];
    $montoNetoAdmin = $filaSaldoAdmin['Monto_Neto'];
}

// Consulta SQL para obtener la lista de retiros con nombre de usuario, zona y monto
$sqlRetiros = "SELECT u.Nombre AS UsuarioNombre, u.Zona, r.Monto
              FROM retiros AS r
              INNER JOIN usuarios AS u ON r.IDUsuario = u.ID";

$resultadoRetiros = $conexion->query($sqlRetiros);

// Calcular el monto total de los retiros
$sqlMontoTotalRetiros = "SELECT SUM(Monto) AS MontoTotal FROM retiros";
$resultadoMontoTotalRetiros = $conexion->query($sqlMontoTotalRetiros);
$montoTotalRetiros = 0;

if ($resultadoMontoTotalRetiros && $resultadoMontoTotalRetiros->num_rows > 0) {
    $filaMontoTotalRetiros = $resultadoMontoTotalRetiros->fetch_assoc();
    $montoTotalRetiros = $filaMontoTotalRetiros['MontoTotal'];
}

// Calcular el saldo total
$saldoTotal = $montoNetoAdmin - $montoTotalRetiros;

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
            <h2>Saldo Inicial del Administrador</h2>
            <p>$<?php echo $saldoAdmin; ?></p>
        </div>
        <div class="saldo-item">
            <h2>Monto Neto del Administrador</h2>
            <p>$<?php echo $montoNetoAdmin; ?></p>
        </div>
         
    </div>
    <table> 
        <input type="text" id="busqueda" placeholder="Buscar en la lista" onkeyup="buscarRetiros()"> 
        <a href="/resources/views/admin/inicio/inicio.php" class="button">Volver</a>
        <tr>
            <th>Nombre del Usuario</th>
            <th>Zona</th>
            <th>Monto</th>
        </tr>
        <?php
        if ($resultadoRetiros) {
            while ($fila = $resultadoRetiros->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $fila['UsuarioNombre'] . "</td>";
                echo "<td>" . $fila['Zona'] . "</td>";
                echo "<td>" . $fila['Monto'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "Error en la consulta de retiros: " . $conexion->error;
        }
        ?>
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
