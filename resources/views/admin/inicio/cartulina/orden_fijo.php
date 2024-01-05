
<!-- ORDEN FIJO -->

<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../index.php");
    exit();
}

include("../../../../../controllers/conexion.php");

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
$sql = "SELECT c.ID, c.Nombre, c.Apellido, p.ID as IDPrestamo
        FROM clientes c
        INNER JOIN prestamos p ON c.ID = p.IDCliente
        WHERE p.Estado = 'pendiente'";

$stmt = $conexion->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['orden'])) {
    $orden = $_POST['orden'];
    file_put_contents('orden_clientes.txt', $orden);
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
        #lista-clientes tbody tr {
            cursor: move;
        }
    </style>
</head>
<body>
    <table id="lista-clientes">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            const listaClientes = $("#lista-clientes tbody");

            listaClientes.sortable({
                helper: 'clone',
                axis: 'y',
                opacity: 0.5,
                update: function(event, ui) {
                    guardarCambios();
                }
            });

            function guardarCambios() {
                var idsOrdenados = listaClientes.find('tr').map(function() {
                    return $(this).find("td:first").text();
                }).get();

                $.ajax({
                    url: window.location.href, // Enviar al mismo archivo PHP
                    type: 'POST',
                    data: {
                        orden: idsOrdenados.join(',')
                    },
                    success: function(response) {
                        alert('Orden guardado');
                    }
                });
            }
        });
    </script>
</body>
</html>
