<?php
date_default_timezone_set('America/Bogota');
session_start();

// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../../../../index.php");
    exit();
}

// Verificar si se ha pasado un ID válido como parámetro GET
if (!isset($_GET['id']) || $_GET['id'] === '' || !is_numeric($_GET['id'])) {
    // Redirigir a una página de error o a una página predeterminada
    header("location: ../../../../../../../index.php"); // Reemplaza 'error_page.php' con la página de error correspondiente
    exit();
}


// Incluir el archivo de conexión a la base de datos
include("../../../../../../../controllers/conexion.php");

$usuario_id = $_SESSION["usuario_id"];

// Asumiendo que la tabla de roles se llama 'roles' y tiene las columnas 'id' y 'nombre_rol'
$sql_nombre = "SELECT usuarios.nombre, roles.nombre FROM usuarios INNER JOIN roles ON usuarios.rolID = roles.id WHERE usuarios.id = ?";
$stmt = $conexion->prepare($sql_nombre);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($fila = $resultado->fetch_assoc()) {
    $_SESSION["nombre_usuario"] = $fila["nombre"];
    $_SESSION["nombre"] = $fila["nombre"]; // Guarda el nombre del rol en la sesión
}
$stmt->close();



// Obtener el ID del cliente desde el parámetro GET
$id_cliente = $_GET['id'];

// Consulta SQL para obtener los detalles del cliente con la moneda y la fecha de hoy en historial_pagos
$sql = "SELECT c.*, m.Nombre AS MonedaNombre, ciu.Nombre AS CiudadNombre
        FROM clientes c
        LEFT JOIN monedas m ON c.MonedaPreferida = m.ID
        LEFT JOIN ciudades ciu ON c.id = ciu.ID
        WHERE c.ID = $id_cliente";




$resultado = $conexion->query($sql);

if ($resultado->num_rows === 1) {
    // Mostrar los detalles del cliente aquí
    $fila = $resultado->fetch_assoc();

    // Obtener la ruta de la imagen del cliente desde la base de datos
    $imagen_cliente = $fila["ImagenCliente"];

    // Si no hay imagen cargada, usar una imagen de reemplazo
    if (empty($imagen_cliente)) {
        $imagen_cliente = "../public/assets/img/perfil.png"; // Reemplaza con tu imagen por defecto
    }
} else {
    // Cliente no encontrado en la base de datos, redirigir a una página de error o a la lista de clientes
    header("location: /resources/views/admin/inicio/prestadia/prestamos_del_dia.php");
    exit();
}

// Obtener la zona y rol del usuario desde la sesión
$user_zone = $_SESSION['user_zone'];
$user_role = $_SESSION['rol'];

// Si el rol es 1 (administrador)
if ($_SESSION["rol"] == 1) {
    $ruta_volver = "/resources/views/admin/inicio/inicio.php";
    $ruta_filtro = "/resources/views/admin/inicio/prestadia/prestamos_del_dia.php";
    $ruta_cliente = "/resources/views/admin/clientes/agregar_clientes.php";
} elseif ($_SESSION["rol"] == 3) {
    // Ruta para el rol 3 (cobrador) en base a la zona
    if ($_SESSION['user_zone'] === '6') {
        $ruta_volver = "/resources/views/zonas/6-Chihuahua/cobrador/inicio/inicio.php";
        $ruta_filtro = "/resources/views/zonas/6-Chihuahua/cobrador/inicio/prestadia/prestamos_del_dia.php";
        $ruta_cliente = "/resources/views/zonas/6-Chihuahua/cobrador/clientes/agregar_clientes.php";
    } elseif ($_SESSION['user_zone'] === '20') {
        $ruta_volver = "/resources/views/zonas/20-Puebla/cobrador/inicio/inicio.php";
        $ruta_filtro = "/resources/views/zonas/20-Puebla/cobrador/inicio/prestadia/prestamos_del_dia.php";
        $ruta_cliente = "/resources/views/zonas/20-Puebla/cobrador/clientes/agregar_clientes.php";
    } elseif ($_SESSION['user_zone'] === '22') {
        $ruta_volver = "/resources/views/zonas/22-QuintanaRoo/cobrador/inicio/inicio.php";
        $ruta_filtro = "/resources/views/zonas/22-QuintanaRoo/cobrador/inicio/prestadia/prestamos_del_dia.php";
        $ruta_cliente = "/resources/views/zonas/22-QuintanaRoo/cobrador/clientes/agregar_clientes.php";
    } else {
        // Si no coincide con ninguna zona válida para cobrador, redirigir a un dashboard predeterminado
        $ruta_volver = "index.php";
        $ruta_filtro = "index.php";
        $ruta_cliente = "index.php";
    }
} else {
    // Si no hay un rol válido, redirigir a una página predeterminada
    $ruta_filtro = "/default_dashboard.php";
}


// Variables para prevenir errores
$info_prestamo = [
    'Nombre' => '',
    'Telefono' => '',
    'Cuota' => '',
];

$total_prestamo = 0.00;
$fecha_actual = date('Y-m-d');

// Consulta SQL para obtener la información del préstamo
$sql_prestamo = "SELECT p.ID, p.Monto, p.TasaInteres, p.Plazo, p.Estado, p.FechaInicio, p.FechaVencimiento, p.Cuota, c.Nombre, c.Telefono 
                 FROM prestamos p 
                 INNER JOIN clientes c ON p.IDCliente = c.ID 
                 WHERE p.IDCliente = ?
                 ";
$stmt_prestamo = $conexion->prepare($sql_prestamo);
$stmt_prestamo->bind_param("i", $id_cliente);
$stmt_prestamo->execute();
$resultado_prestamo = $stmt_prestamo->get_result();

if ($resultado_prestamo->num_rows > 0) {
    $info_prestamo = $resultado_prestamo->fetch_assoc();
    $total_prestamo = $info_prestamo['Monto'] + ($info_prestamo['Monto'] * $info_prestamo['TasaInteres'] / 100);
} else {
    // Manejar el caso donde no se encuentra información del préstamo
    // Puedes asignar valores predeterminados o mostrar un mensaje de error
    // Aquí se asignan valores vacíos o predeterminados para evitar los errores de acceso a índices inexistentes
    $info_prestamo = [
        'Plazo' => 'No encontrado',
        'Telefono' => 'No encontrado',
        'Cuota' => 'No encontrado',
    ];
    $total_prestamo = 0.00;
}
$stmt_prestamo->close();


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/perfil_abonos.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.3/js/select2.min.js"></script>

    <title>Perfil del Cliente</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>

    </style>
</head>

<body>

    <body id="body">

        <!-- EMCABEZADO -->
        <header>

            <a href="<?= $ruta_volver ?>" class="back-link1">Inicio</a>

            <a href="<?= $ruta_filtro ?>" class="back-link2">Filtros</a>

            <a href="<?= $ruta_cliente ?>" class="back-link3">R Clientes</a>

            <div class="nombre-usuario">
                <?php
                if (isset($_SESSION["nombre_usuario"], $_SESSION["nombre"])) {
                    echo htmlspecialchars($_SESSION["nombre_usuario"]) . "<br>" . "<span>" . htmlspecialchars($_SESSION["nombre"]) . "</span>";
                }
                ?>
            </div>
        </header>

        <main>

            <!-- CARTULINAAAAAAAAA -->

            <div class="info-cliente">
                <div class="columna">
                    <p><strong>Nombre: </strong><?= $fila["Nombre"] ?></p>
                    <p><strong>Apellido: </strong><?= $fila["Apellido"] ?> </p>
                    <p><strong>Curp: </strong><?= $fila["IdentificacionCURP"] ?> </p>
                    <p><strong>Domicilio: </strong><?= $fila["Domicilio"] ?> </p>
                    <p><strong>Teléfono: </strong><?= $fila["Telefono"] ?> </p>
                    <p><strong>Cuota:</strong> <?= htmlspecialchars(number_format($info_prestamo['Cuota'])); ?></p>
                    <p><strong>Total:</strong> <?= htmlspecialchars(number_format($total_prestamo)); ?>
                </div>
                <div class="columna">
                    <p><strong>Estado: </strong><?= $fila["ZonaAsignada"] ?> </p>
                    <p><strong>Municipio: </strong><?= $fila["CiudadNombre"] ?> </p>
                    <p><strong>Colonia: </strong><?= $fila["asentamiento"] ?> </p>
                    <p><strong>Plazo:</strong> <?= htmlspecialchars($info_prestamo['Plazo']); ?></p>
                    <p><strong>Estado:</strong> <?= htmlspecialchars($info_prestamo['Estado']); ?></p>
                    <p><strong>Inicio:</strong> <?= htmlspecialchars($info_prestamo['FechaInicio']); ?></p>
                    <p><strong>Fin:</strong> <?= htmlspecialchars($info_prestamo['FechaVencimiento']); ?></p>
                    </p>
                </div>
            </div>

            <div class="profile-loans">
                <?php
                if (isset($_GET['show_all']) && $_GET['show_all'] === 'true') {
                    // Si se solicita mostrar todas las filas
                    $sql = "SELECT id, fecha, monto_pagado, monto_deuda 
        FROM facturas 
        WHERE cliente_id = ? AND monto_pagado != 0";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param("i", $id_cliente);
                    $stmt->execute();
                    $resultado = $stmt->get_result();

                    $num_rows = $resultado->num_rows;

                    if ($num_rows > 0) {
                        echo "<table id='tabla-prestamos'>";
                        echo "<tr><th>Fecha</th><th>Abono</th><th>Resta</th></tr>";
                        $last_row = null;
                        while ($fila = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($fila['fecha']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['monto_pagado']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['monto_deuda']) . "</td>";
                            $last_row = $fila; // Actualizar la última fila en cada iteración
                            echo "</tr>";
                        }

                        echo "</table>";

                        // Mostrar el enlace de "Editar" solo para la última fila
                        if ($last_row) {
                            echo "<div class='edit-button'>";
                            echo "<a href='editar_pago.php?id=" . $last_row['id'] . "'>Editar último pago</a>";
                            echo "</div>";
                        }

                        echo "<button onclick='showLess()'>Ver menos</button>"; // Botón para mostrar menos
                    } else {
                        echo "<p>No se encontraron pagos para este cliente.</p>";
                    }

                    $stmt->close();
                } else {
                    $sql = "SELECT id, fecha, monto_pagado, monto_deuda 
        FROM facturas 
        WHERE cliente_id = ?";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param("i", $id_cliente);
                    $stmt->execute();
                    $resultado = $stmt->get_result();

                    $num_rows = $resultado->num_rows;
                    if ($num_rows > 0) {
                        echo "<table id='tabla-prestamos'>";
                        echo "<tr><th>Fecha</th><th>Abono</th><th>Resta</th></tr>";
                        $last_row = null;
                        while ($fila = $resultado->fetch_assoc()) {
                            $last_row = $fila; // Actualizar la última fila en cada iteración
                        }

                        // Mostrar solo la última fila
                        if ($last_row) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($last_row['fecha']) . "</td>";
                            echo "<td>" . htmlspecialchars($last_row['monto_pagado']) . "</td>";
                            echo "<td>" . htmlspecialchars($last_row['monto_deuda']) . "</td>";
                            echo "</tr>";
                        }

                        echo "</table>";

                        // Mostrar el enlace de "Editar" solo para la última fila
                        if ($last_row) {
                            echo "<div class='edit-button'>";
                            echo "<a href='editar_pago.php?id=" . $last_row['id'] . "'>Editar último pago</a>";
                            echo "</div>";
                        }

                        echo "<button onclick='showMore()'>Ver más</button>";
                    } else {
                        echo "<p>No se encontraron pagos para este cliente.</p>";
                    }

                    $stmt->close();
                }
                ?>
            </div>

            <script>
                function showMore() {
                    window.location.href = '?id=<?= $id_cliente ?>&show_all=true';
                }

                function showLess() {
                    window.location.href = '?id=<?= $id_cliente ?>&show_all=false';
                }
            </script>


            <!--LISTA CLIENTES -->
            <?php
            include 'load_clients.php';
            $id_cliente = isset($_GET['id']) ? $_GET['id'] : null;
            $clientes = obtenerClientes($conexion);
            list($prevIndex, $currentIndex, $nextIndex) = obtenerIndicesClienteActual($clientes, $id_cliente);
            ?>

            <h2>Clientes:</h2>
            <form action='procesar_cliente.php' method='post' id='clienteForm'>
                <input type='hidden' id='selectedClientId' name='cliente' value='<?= $id_cliente ?>'>
                <a href='perfil_abonos.php?id=<?= $clientes[$prevIndex]['id'] ?>' class='boton4'>Anterior</a>
                <a href='perfil_abonos.php?id=<?= $clientes[$nextIndex]['id'] ?>' class='boton4'>Siguiente</a>
                <input type="text" id="filtroBusqueda" placeholder="Buscar cliente" onkeyup="filtrarClientes()">
                <select name='cliente' id='listaClientes'>
                    <option value="">Seleccionar Cliente</option>
                    <?php foreach ($clientes as $cliente) : ?>
                        <option value='<?= $cliente['id'] ?>'>
                            <?= htmlspecialchars($cliente['nombre'] . " " . $cliente['apellido']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <script>
                $(document).ready(function() {
                    $('#listaClientes').select2({
                        placeholder: "Buscar cliente",
                        allowClear: true
                    });
                });
            </script>



            <script>
                function selectClient() {
                    var form = document.getElementById('clienteForm');
                    form.submit();
                }
            </script>


            <!-- BOTONES DE PAGO -->

            <?php
            // Verificar si se proporcionó el ID del cliente en la variable PHP $id_cliente
            if (isset($id_cliente))

                // Obtener el MontoAPagar de la tabla de préstamos
                $sql_monto_pagar = "SELECT MontoAPagar FROM prestamos WHERE IDCliente = ?";
            $stmt_monto_pagar = $conexion->prepare($sql_monto_pagar);
            $stmt_monto_pagar->bind_param("i", $id_cliente);
            $stmt_monto_pagar->execute();
            $stmt_monto_pagar->bind_result($montoAPagar);

            // Verificar si se encontró el MontoAPagar
            if ($stmt_monto_pagar->fetch()) {
                // Si se encontró, asignar el valor a la variable $montoAPagar
                // Ajustar el formato según sea necesario
            } else {
                // Si no se encontró, asignar un valor predeterminado o mostrar un mensaje de error
                $montoAPagar = 'No encontrado';
            }

            $stmt_monto_pagar->close();

            ?>

            <!-- Formulario de Pago -->
            <form method="post" action="process_payment.php">
                <input type="hidden" name="id_cliente" value="<?= $id_cliente; ?>">
                <!-- Asegúrate de definir $id_cliente -->
                <input type="text" id="cuota" name="cuota" placeholder="Cuota" required>
                <input type="text" id="campo2" name="campo2" placeholder="Resta" required>
                <input type="text" id="variable" placeholder="Deuda" value="<?= htmlspecialchars($montoAPagar - $info_prestamo['Cuota']); ?>" readonly>
                <input type="submit" name="action" value="Pagar" class="boton1">
            </form>

            <!-- Formulario de No Pago y Mas Tarde -->
            <form method="post" action="process_payment.php">
                <input type="hidden" name="id_cliente" value="<?= $id_cliente; ?>">
                <!-- Asegúrate de definir $id_cliente -->
                <input type="submit" name="action" value="No pago" class="boton2">
                <input type="submit" name="action" value="Mas tarde" class="boton3">
            </form>



            <!-- Luego, en tu HTML, reemplaza el valor de $total_prestamo por $montoAPagar -->
            <script>
                window.onload = function() {
                    var campoResta = document.getElementById('campo2');
                    campoResta.addEventListener('input', function() {
                        var cuota = <?= $info_prestamo['Cuota']; ?>;
                        var montoAPagar = <?= $montoAPagar; ?>;
                        var valorResta = parseFloat(campoResta.value.replace(',', '.')); // Manejar decimales
                        var resultadoResta = montoAPagar - valorResta;

                        if (resultadoResta === cuota) {
                            campoResta.style.backgroundColor = 'green';
                        } else {
                            campoResta.style.backgroundColor = 'red';
                        }
                    });
                };
            </script>

        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
        </script>

    </body>

</html>