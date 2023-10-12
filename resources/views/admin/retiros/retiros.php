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
        <?php
        // Realizar consulta SQL para obtener los datos de los retiros y el nombre de la zona
        $sql = "SELECT retiros.ID, zonas.Nombre AS NombreZona, retiros.Fecha, retiros.Valor FROM retiros INNER JOIN zonas ON retiros.IDZona = zonas.ID";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><a href='editar_retiro.php?id=" . $row["ID"] . "'>" . $row["NombreZona"] . "</a></td>";
                echo "<td>" . $row["Fecha"] . "</td>";
                echo "<td>" . $row["Valor"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No se encontraron retiros.</td></tr>";
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
