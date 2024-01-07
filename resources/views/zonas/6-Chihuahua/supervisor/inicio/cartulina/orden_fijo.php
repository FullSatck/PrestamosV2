<!-- ORDEN FIJO -->

<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../index.php");
    exit();
}

include("../../../../../../../controllers/conexion.php");

$usuario_id = $_SESSION["usuario_id"];

$sql_nombre = "SELECT nombre FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql_nombre);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
if ($fila = $resultado->fetch_assoc()) {
    $_SESSION["nombre_usuario"] = $fila["nombre"];
}
$stmt->close();

// Consulta para obtener todos los clientes con préstamos pendientes
$sql = "SELECT c.ID, c.Nombre, c.Apellido, p.ID AS IDPrestamo
        FROM clientes c
        INNER JOIN prestamos p ON c.ID = p.IDCliente
        WHERE p.Estado = 'pendiente' 
        AND c.ZonaAsignada = 'Chihuahua'";

$stmt = $conexion->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['orden'])) {
    $orden = $_POST['orden'];
    file_put_contents('orden_fijo.txt', $orden);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruta fija</title>
    <link rel="stylesheet" href="/public/assets/css/abonosruta.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <style>
        #lista-pagos tbody tr {
            cursor: move;
        }
    </style>
</head>

<body>

    <?php
    function obtenerOrdenClientes()
    {
        $rutaArchivo = 'orden_fijo.txt'; // Asegúrate de que esta ruta sea correcta
        if (file_exists($rutaArchivo)) {
            $contenido = file_get_contents($rutaArchivo);
            return explode(',', $contenido);
        }
        return [];
    }

    function obtenerPrimerID($conexion)
    {
        $fecha_actual = date("Y-m-d");
        $ordenClientes = obtenerOrdenClientes();
        $primer_id = 0;

        $idEncontrado = 0;

        foreach ($ordenClientes as $idCliente) {
            // Consulta para verificar si este cliente ha pagado hoy
            $sql = "SELECT c.ID
                            FROM clientes c
                            LEFT JOIN historial_pagos hp ON c.ID = hp.IDCliente AND hp.FechaPago = ?
                            WHERE c.ID = ? AND hp.ID IS NULL
                            LIMIT 1";

            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("si", $fecha_actual, $idCliente);
            $stmt->execute();
            $stmt->bind_result($idEncontrado);
            if ($stmt->fetch()) {
                $primer_id = $idEncontrado;
                $stmt->close();
                break;
            }
            $stmt->close();
        }

        return $primer_id;
    }

    // Obtener el primer ID de cliente que no ha pagado hoy y está primero en el orden personalizado
    $primer_id = obtenerPrimerID($conexion);

    ?>

    <header>
    <a href="/resources/views/zonas/6-Chihuahua/supervisor/inicio/cartulina/perfil_abonos.php?id=<?= $primer_id ?>" class="back-link1">Volver</a>

        <a href="/resources/views/zonas/6-Chihuahua/supervisor/inicio/cartulina/orden_abonos.php" class="back-link1">Pendintes hoy</a>

        <div class="nombre-usuario">
            <?php
            if (isset($_SESSION["nombre_usuario"])) {
                echo htmlspecialchars($_SESSION["nombre_usuario"]) . "<br>" . "<span> Administrator<span>";
            }
            ?>
        </div>
    </header>

    <main>
        <h2>Orden de pagos</h2>

        <div id="aviso-guardado" class="aviso">
            Nuevo orden guardado.
        </div><br>

        <div class="table-scroll-container">
            <table id="lista-pagos">
                <thead>
                    <tr>
                        <th>ID Cliente</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>ID Préstamo</th>
                        <th>Ordenar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["ID"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Nombre"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Apellido"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["IDPrestamo"]) . "</td>";
                        echo "<td class='drag-handle'>|||</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            const listaPagos = $("#lista-pagos tbody");

            // Recuperar el orden almacenado en el localStorage, si existe
            const savedOrder = localStorage.getItem('sortableClientesOrder');
            if (savedOrder) {
                // Reordenar los elementos de la tabla según el orden guardado
                const idsOrdenados = savedOrder.split(',');
                idsOrdenados.forEach(id => {
                    const row = listaPagos.find('tr').filter(function() {
                        return $(this).find('td:first').text() === id;
                    });
                    listaPagos.append(row);
                });
            }

            // Habilitar la función de arrastrar en la tabla
            listaPagos.sortable({
                helper: 'clone',
                axis: 'y',
                opacity: 0.5,
                update: function(event, ui) {
                    guardarCambios();
                }
            });

            function guardarCambios() {
                // Capturar los IDs en el nuevo orden
                var idsOrdenados = listaPagos.find('tr').map(function() {
                    return $(this).find("td:first").text();
                }).get();

                // Guardar el nuevo orden en localStorage
                localStorage.setItem('sortableClientesOrder', idsOrdenados.join(','));

                // Enviar el nuevo orden al servidor
                $.ajax({
                    url: 'guardar_orden_fijo.php', // Asegúrate de que esta URL sea correcta
                    type: 'POST',
                    data: {
                        orden: idsOrdenados.join(',')
                    },
                    success: function(response) {
                        // Mostrar el mensaje de confirmación
                        $('#aviso-guardado').fadeIn().delay(3000).fadeOut();
                    }
                });
            }
        });
    </script>


</body>

</html>