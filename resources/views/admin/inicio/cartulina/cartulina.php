<?php
date_default_timezone_set('America/Bogota');
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
require_once("../../../../../controllers/conexion.php");

// Obtén el ID del cliente de la URL
$id_cliente = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Inicializa las variables para evitar errores si la consulta no devuelve resultados
$info_prestamo = null;
$total_prestamo = 0;

// Consulta para obtener información del préstamo basado en el ID del cliente obtenido de la URL
$sql_prestamo = "SELECT p.ID, p.Monto, p.TasaInteres, p.Cuota, c.Nombre, c.Telefono 
                 FROM prestamos p 
                 INNER JOIN clientes c ON p.IDCliente = c.ID 
                 WHERE p.IDCliente = ?";
$stmt_prestamo = $conexion->prepare($sql_prestamo);
$stmt_prestamo->bind_param("i", $id_cliente);
$stmt_prestamo->execute();
$resultado_prestamo = $stmt_prestamo->get_result();

if ($resultado_prestamo->num_rows > 0) {
    $info_prestamo = $resultado_prestamo->fetch_assoc();
    $total_prestamo = $info_prestamo['Monto'] + ($info_prestamo['Monto'] * $info_prestamo['TasaInteres'] / 100);
} else {
    echo "No se encontró información del préstamo";
}
$stmt_prestamo->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/cartulina.css"> 
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <title>Registro de Pagos</title>
</head>

<body id="body">
    <header>
    <a href="perfil_cliente.php?id=<?= $id_cliente ?>" class="back-link">Volver Atrás</a>

        <div class="nombre-usuario">
            <?php
            if (isset($_SESSION["nombre_usuario"], $_SESSION["nombre"])) {
                echo htmlspecialchars($_SESSION["nombre_usuario"]) . "<br>" . "<span>" . htmlspecialchars($_SESSION["nombre"]) . "</span>";
            }
            ?>
        </div>
    </header>
    <main>
        <?php if ($info_prestamo): ?>
            <h1>Registro</h1>
            <div class="info-cliente">
                <div class="columna">
                    <p><strong>Cliente:</strong> <?= htmlspecialchars($info_prestamo['Nombre']); ?></p>
                    <p><strong>Teléfono:</strong> <?= htmlspecialchars($info_prestamo['Telefono']); ?></p>
                </div>
                <div class="columna">
                    <p><strong>Cuota Diaria:</strong> <?= htmlspecialchars($info_prestamo['Cuota']); ?></p>
                    <p><strong>Total del Préstamo:</strong> <?= htmlspecialchars(number_format($total_prestamo, 2)); ?></p>
                </div>
            </div>

            <div class='table-scroll-container' id='profile-loans'>
                <?php
               $sql = "SELECT id, fecha, monto_pagado, (monto - monto_pagado) AS resta FROM facturas WHERE cliente_id = ?";
               $stmt = $conexion->prepare($sql);
               $stmt->bind_param("i", $id_cliente); // Usar $id_cliente en lugar de $id
               $stmt->execute();
               $resultado = $stmt->get_result();
                
                $fila_counter = 0;
                $num_rows = $resultado->num_rows;
                if ($num_rows > 0) {
                    echo "<table id='tabla-prestamos'>";
                    echo "<tr><th>Fecha</th><th>Abono</th><th>Resta</th><th>Editar</th></tr>";
                    while ($fila = $resultado->fetch_assoc()) {
                        $fila_counter++;
                        $color_clase = ($fila_counter % 2 == 0) ? 'color-claro' : 'color-oscuro';
                        echo "<tr class='$color_clase'>";
                        echo "<td>" . htmlspecialchars($fila['fecha']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['monto_pagado']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['resta']) . "</td>";
                        // Mostrar "Editar" solo en la última fila
                        if ($fila_counter === $num_rows) {
                            echo "<td><a href='editar_pago.php?id=" . $fila['id'] . "'>Editar</a></td>";
                        } else {
                            echo "<td></td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No se encontraron pagos para este cliente.</p>";
                }
                
                $stmt->close();
                ?>
            </div>
        <?php else: ?>
            <p>No se encontró información de préstamos para este usuario.</p>
        <?php endif; ?>
    </main>
</body>

</html>
<?php
$conexion->close();
?>
