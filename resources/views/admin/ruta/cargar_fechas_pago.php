<?php
date_default_timezone_set('America/Bogota');
session_start();


// Validacion de rol para ingresar a la pagina 
require_once '../../../../controllers/conexion.php'; 

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
    exit();
} else {
    // El usuario está autenticado, obtén el ID del usuario de la sesión
    $usuario_id = $_SESSION["usuario_id"];
    
    // Preparar la consulta para obtener el rol del usuario
    $stmt = $conexion->prepare("SELECT roles.Nombre FROM usuarios INNER JOIN roles ON usuarios.RolID = roles.ID WHERE usuarios.ID = ?");
    $stmt->bind_param("i", $usuario_id);
    
    // Ejecutar la consulta
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();

    // Verifica si el resultado es nulo, lo que significaría que el usuario no tiene un rol válido
    if (!$fila) {
        // Redirige al usuario a una página de error o de inicio
        header("Location: /ruta_a_pagina_de_error_o_inicio.php");
        exit();
    }

    // Extrae el nombre del rol del resultado
    $rol_usuario = $fila['Nombre'];
    
    // Verifica si el rol del usuario corresponde al necesario para esta página
    if ($rol_usuario !== 'admin') {
        // El usuario no tiene el rol correcto, redirige a la página de error o de inicio
        header("Location: /ruta_a_pagina_de_error_o_inicio.php");
        exit();
    }
    
   
}

// Incluye tu archivo de conexión a la base de datos
include("../../../../controllers/conexion.php");

// Obtener la fecha actual en el formato de tu base de datos (por ejemplo, 'Y-m-d')
$fecha_actual = date('Y-m-d');

// Verificar si se ha proporcionado una zona válida desde la URL
if (isset($_GET['zona'])) {
    $nombreZona = $_GET['zona'];

    // Consulta SQL para seleccionar las filas de la tabla fechas_pago solo para la zona especificada y la fecha actual
    $sql = "SELECT * FROM fechas_pago WHERE Zona = '$nombreZona' AND fechaPago = '$fecha_actual' ORDER BY IDPrestamo";
    $resultado = $conexion->query($sql);

    $fechas_pago = array();

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $fechas_pago[] = $row;
        }
    } else {
        // Maneja el caso donde no se encontraron filas
        echo "No se encontraron filas para esta zona y fecha.";
    }
} else {
    // Maneja el caso donde no se proporcionó una zona válida
    echo "Zona no especificada.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Fechas de Pago</title>
    <link rel="stylesheet" href="/public/assets/css/abonosruta.css">
</head>
</head>
<body>
    <h1>Lista de Fechas de Pago para la Zona: <?= $nombreZona ?></h1>
    <button onclick="guardarCambios()">Guardar Cambios</button>
    <table id="lista-pagos">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID del Préstamo</th>
                <th>Fecha de Pago</th>
                <th></th> <!-- Espacio para el arrastre -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fechas_pago as $fecha) : ?>
                <tr data-id="<?= $fecha['IDPrestamo'] ?>">
                    <td><?= $fecha['ID'] ?></td>
                    <td><?= $fecha['IDPrestamo'] ?></td>
                    <td><?= $fecha['FechaPago'] ?></td>
                    <td class="drag-handle">|||</td> 
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        // Variable para almacenar el orden actual de la lista
        var ordenActual = [];

        // Agrega el arrastre y suelte a las filas
        $(document).ready(function() {
            $("#lista-pagos tbody").sortable({
                handle: ".drag-handle", // El elemento de arrastre
                cursor: "move", // El cursor se convierte en una mano
                update: function(event, ui) {
                    // Actualiza el orden actual al reordenar
                    ordenActual = obtenerNuevoOrden();
                }
            });
        });

        function guardarCambios() {
            // Guarda el orden actual en el almacenamiento local del navegador
            localStorage.setItem('orden_' + '<?= $nombreZona ?>', JSON.stringify(ordenActual));
            alert("Cambios guardados con éxito.");
        }

        function obtenerNuevoOrden() {
            var nuevoOrden = $("#lista-pagos tbody tr").map(function() {
                return $(this).data("id");
            }).get();
            return nuevoOrden;
        }

        // Cargar el orden almacenado al cargar la página
        var ordenAlmacenado = localStorage.getItem('orden_' + '<?= $nombreZona ?>');
        if (ordenAlmacenado) {
            ordenActual = JSON.parse(ordenAlmacenado);
            // Aplicar el orden almacenado a la lista
            var $tbody = $("#lista-pagos tbody");
            var rows = $tbody.find("tr").get();
            $tbody.html(""); // Vacía el tbody
            for (var i = 0; i < ordenActual.length; i++) {
                var idPrestamo = ordenActual[i];
                var $row = rows.find(function(row) {
                    return $(row).data("id") == idPrestamo;
                });
                $tbody.append($row);
            }
        }
    </script> 
</body>
</html>
