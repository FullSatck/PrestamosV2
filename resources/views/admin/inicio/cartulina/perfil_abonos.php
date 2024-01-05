
<!-- PAGINA PRINCIPAL DE ABONOS -->

<?php
date_default_timezone_set('America/Bogota');
session_start();

// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../../index.php");
    exit();
}

// ID DE URL
if (!isset($_GET['id']) || $_GET['id'] === '' || !is_numeric($_GET['id'])) {
    // SI EL ID NO ES VALIDO IR A
    header("location: ../../../../../index.php");
    exit();
}

// CONEXION
include("../../../../../controllers/conexion.php");

$usuario_id = $_SESSION["usuario_id"];

// NOMBRE Y ROL 
$sql_nombre = "SELECT usuarios.nombre, roles.nombre FROM usuarios INNER JOIN roles ON usuarios.rolID = roles.id WHERE usuarios.id = ?";
$stmt = $conexion->prepare($sql_nombre);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($fila = $resultado->fetch_assoc()) {
    $_SESSION["nombre_usuario"] = $fila["nombre"];
    $_SESSION["nombre"] = $fila["nombre"];
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

$sql_prestamo = "SELECT p.ID, p.Monto, p.TasaInteres, p.Plazo, p.Estado, p.EstadoP, p.FechaInicio, p.FechaVencimiento, p.MontoAPagar, p.Cuota, p.CuotasVencidas, c.Nombre, c.Telefono
                 FROM prestamos p 
                 INNER JOIN clientes c ON p.IDCliente = c.ID 
                 WHERE p.IDCliente = ? AND p.Estado = 'pendiente'
                 ORDER BY p.FechaInicio ASC
                 LIMIT 1";
$stmt_prestamo = $conexion->prepare($sql_prestamo);
$stmt_prestamo->bind_param("i", $id_cliente);
$stmt_prestamo->execute();
$resultado_prestamo = $stmt_prestamo->get_result();

$mostrarMensajeAgregarPrestamo = true;

if ($resultado_prestamo->num_rows > 0) {
    // Cliente tiene al menos un préstamo pendiente
    $info_prestamo = $resultado_prestamo->fetch_assoc();
    $total_prestamo = $info_prestamo['Monto'] + ($info_prestamo['Monto'] * $info_prestamo['TasaInteres'] / 100);
    $mostrarMensajeAgregarPrestamo = false; // Hay préstamos pendientes, no mostrar el mensaje
}

if ($mostrarMensajeAgregarPrestamo) {
    echo "<p class='no-prestamo-mensaje'>Este cliente no tiene préstamos activos o están completamente pagados.</p>";
    echo "<a href='../../creditos/prestamos.php?cliente_id=" . $id_cliente . "' class='back-link3'>Agregar Préstamo</a>";
} else {
    // Procesamiento normal si el cliente tiene un préstamo activo
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.3/js/select2.min.js"></script>
    <title>Perfil del Cliente</title>

    <style>
        /* Estilo del Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>


<body>

    <body id="body">

        <!-- EMCABEZADO -->
        <header>

            <a href="<?= $ruta_volver ?>" class="back-link1">Inicio</a>

            <a href="<?= $ruta_filtro ?>" class="back-link2">Filtros</a>

            <a href="<?= $ruta_cliente ?>" class="back-link3">R Clientes</a>

            <a href="orden_abonos.php" class="back-link1">Enrutar</a>

        </header>

        <main>

            <!-- CARTULINAAAAAAAAA -->

            <div class="info-cliente">
                <div class="columna">
                    <p><strong>Nombre: </strong><a href="/controllers/perfil_cliente.php?id=<?= $fila["ID"] ?>"><?= $fila["Nombre"] ?></a></p>
                    <p><strong>Apellido: </strong><?= $fila["Apellido"] ?> </p>
                    <p><strong>Curp: </strong><?= $fila["IdentificacionCURP"] ?> </p>
                    <p><strong>Domicilio: </strong><?= $fila["Domicilio"] ?> </p>
                    <p><strong>Teléfono: </strong><?= $fila["Telefono"] ?> </p>

                    <?php if (!$mostrarMensajeAgregarPrestamo) : ?>
                        <p><strong>Cuota:</strong> <?= htmlspecialchars($info_prestamo['Cuota']); ?></p>
                    <?php else : ?>
                        <p><strong>Cuota:</strong> No hay préstamo</p>
                    <?php endif; ?>

                    <p><strong>Total:</strong> <?= htmlspecialchars(number_format($total_prestamo)); ?>
                </div>
                <div class="columna">
                    <p><strong>Estado: </strong><?= $fila["ZonaAsignada"] ?> </p>
                    <p><strong>Municipio: </strong><?= $fila["CiudadNombre"] ?> </p>
                    <p><strong>Colonia: </strong><?= $fila["asentamiento"] ?> </p>
                    <?php if (!$mostrarMensajeAgregarPrestamo) : ?>
                        <p><strong>Plazo:</strong> <?= htmlspecialchars($info_prestamo['Plazo']); ?></p>
                        <p><strong>Estado:</strong> <?= htmlspecialchars($info_prestamo['Estado']); ?></p>
                        <p><strong>Inicio:</strong> <?= htmlspecialchars($info_prestamo['FechaInicio']); ?></p>
                        <p><strong>Fin:</strong> <?= htmlspecialchars($info_prestamo['FechaVencimiento']); ?></p>
                        <p><strong>Deuda:</strong> <?= htmlspecialchars($info_prestamo['MontoAPagar']); ?></p>
                    <?php else : ?>
                        <p><strong>Plazo:</strong> No hay préstamo</p>
                        <p><strong>Estado:</strong> No hay préstamo</p>
                        <p><strong>Inicio:</strong> No hay préstamo</p>
                        <p><strong>Fin:</strong> No hay préstamo</p>
                        <p><strong>Deuda:</strong> No hay préstamo</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="info-cliente">
                <div class="columna">
                    <p><strong>Clavo: </strong>
                    </p>
                </div>
                <div class="columna">
                    <?php
                    if (!function_exists('obtenerOrdenClientes')) {
                        function obtenerOrdenClientes()
                        {
                            $rutaArchivo = __DIR__ . '/orden_clientes.txt'; // Asegúrate de que esta ruta sea correcta
                            if (file_exists($rutaArchivo)) {
                                $contenido = file_get_contents($rutaArchivo);
                                return explode(',', $contenido);
                            }
                            return [];
                        }
                    }

                    $fecha_actual = date("Y-m-d");
                    $ordenClientes = obtenerOrdenClientes();

                    // Filtrar solo los clientes con préstamos pendientes que no han pagado hoy
                    $clientesPendientes = array_filter($ordenClientes, function ($idCliente) use ($conexion, $fecha_actual) {
                        $sql = "SELECT c.ID
                FROM clientes c
                INNER JOIN prestamos p ON c.ID = p.IDCliente
                LEFT JOIN historial_pagos hp ON p.ID = hp.IDPrestamo AND hp.FechaPago = ?
                WHERE c.ID = ? AND p.Estado = 'pendiente' AND hp.ID IS NULL";
                        $stmt = $conexion->prepare($sql);
                        $stmt->bind_param("si", $fecha_actual, $idCliente);
                        $stmt->execute();
                        $stmt->store_result();
                        $existe = $stmt->num_rows > 0;
                        $stmt->close();
                        return $existe;
                    });

                    // Contar el total de clientes pendientes y determinar la posición actual
                    $total_clientes = count($clientesPendientes);
                    $posicion_actual = array_search($id_cliente, $clientesPendientes) + 1; // +1 para ajustar el índice base 0
                    ?>
                    <p><strong>Cliente: </strong><?= $posicion_actual . "/" . $total_clientes; ?></p>
                </div>

            </div>

            <!-- CARTULINA DE FACTURAS -->

            <div class="profile-loans">
                <!-- TABLA DE VER MENOS -->
                <?php
                if (isset($_GET['show_all']) && $_GET['show_all'] === 'true') {
                    // Si se solicita mostrar todas las filas
                    $sql = "SELECT f.id, f.fecha, f.monto_pagado, f.monto_deuda 
                FROM facturas f
                JOIN prestamos p ON f.id_prestamos = p.ID
                WHERE f.cliente_id = ? AND p.estado != 'pagado'";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param("i", $id_cliente);
                    $stmt->execute();
                    $resultado = $stmt->get_result();

                    $num_rows = $resultado->num_rows;

                    if ($num_rows > 0) {
                        echo "<table id='tabla-prestamos'>";
                        echo "<tr><th>No. cuota</th><th>Fecha</th><th>Abono</th><th>Resta</th></tr>";
                        $last_row = null;
                        $contador_cuota = 1; // Iniciar el contador de cuotas

                        while ($fila = $resultado->fetch_assoc()) {
                            // Mostrar el número de cuota como "cuota actual / plazo total"
                            echo "<tr>";
                            echo "<td>" . $contador_cuota . "/" . $info_prestamo['Plazo'] . "</td>";
                            echo "<td>" . htmlspecialchars($fila['fecha']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['monto_pagado']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['monto_deuda']) . "</td>";
                            echo "</tr>";

                            $contador_cuota++; // Incrementar el contador de cuotas
                            $last_row = $fila; // Actualizar la última fila en cada iteración
                        }

                        echo "</table>";

                        // Mostrar el enlace de "Editar" solo para la última fila
                        if ($last_row) {
                            echo "<div class='edit-button'>";
                            echo "<button onclick='showLess()'>Ver menos</button>"; // Botón para mostrar menos
                            echo "<a href='editar_pago.php?id=" . $last_row['id'] . "'>Editar último pago</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No se encontraron pagos para este cliente.</p>";
                    }

                    $stmt->close();
                }
                //  TABLA DE VER MAS  
                else {
                    // Mantén la consulta original sin cambios, mostrará todas las cuotas sin importar su monto.
                    $sql = "SELECT f.id, f.fecha, f.monto_pagado, f.monto_deuda 
                FROM facturas f
                JOIN prestamos p ON f.id_prestamos = p.ID
                WHERE f.cliente_id = ? AND p.estado != 'pagado'";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param("i", $id_cliente);
                    $stmt->execute();
                    $resultado = $stmt->get_result();

                    $num_rows = $resultado->num_rows;
                    if ($num_rows > 0) {
                        echo "<table id='tabla-prestamos'>";
                        echo "<tr><th>No. cuota</th><th>Fecha</th><th>Abono</th><th>Resta</th></tr>";
                        $last_row = null;
                        $contador_cuota = 0;

                        while ($fila = $resultado->fetch_assoc()) {
                            $last_row = $fila; // Actualizar la última fila en cada iteración
                            $contador_cuota++; // Incrementar el contador de cuotas
                        }

                        // Mostrar solo la última fila
                        if ($last_row) {
                            echo "<tr>";
                            echo "<td>" . $contador_cuota . "/" . $info_prestamo['Plazo'] . "</td>";
                            echo "<td>" . htmlspecialchars($last_row['fecha']) . "</td>";
                            echo "<td>" . htmlspecialchars($last_row['monto_pagado']) . "</td>";
                            echo "<td>" . htmlspecialchars($last_row['monto_deuda']) . "</td>";
                            echo "</tr>";
                        }

                        echo "</table>";

                        // Mostrar el enlace de "Editar" solo para la última fila
                        if ($last_row) {
                            echo "<div class='edit-button'>";
                            echo "<button onclick='showMore()' class='edit-button'>Ver más</button>";
                            echo "<a href='editar_pago.php?id=" . $last_row['id'] . "'>Editar último pago</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No se encontraron pagos para este cliente.</p>";
                    }

                    $stmt->close();
                }
                ?>
            </div>

            <!-- VER MAS O VER MENOS -->
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
                <div class="busqueda-container">
                    <input type="text" id="filtroBusqueda" placeholder="Buscar cliente" class="input-busqueda">

                    <div id="resultadosBusqueda" class="resultados-busqueda">
                        <!-- Los resultados de la búsqueda se mostrarán aquí -->
                    </div><br>

                    <div class="navegacion-container">
                        <input type='hidden' id='selectedClientId' name='cliente'>
                        <a href='#' onclick='navigate("prev"); return false;' class='boton4'>Anterior</a>
                        <a href='#' onclick='navigate("next"); return false;' class='boton4'>Siguiente</a>
                    </div>
                    <br>

            </form>

            <script>
                $(document).ready(function() {
                    $('#filtroBusqueda').on('input', function() {
                        var busqueda = $(this).val();
                        if (busqueda.length > 2) {
                            $.ajax({
                                url: 'buscar_clientes.php',
                                type: 'GET',
                                data: {
                                    'busqueda': busqueda
                                },
                                success: function(data) {
                                    var clientes = JSON.parse(data);
                                    var html = '<ul>';
                                    for (var i = 0; i < clientes.length; i++) {
                                        html += '<li onclick="seleccionarCliente(' + clientes[i].id + ')">' +
                                            clientes[i].Nombre + ' ' + clientes[i].Apellido + ' - ' + clientes[i].Telefono +
                                            '</li>';
                                    }
                                    html += '</ul>';
                                    $('#resultadosBusqueda').html(html);
                                }
                            });
                        } else {
                            $('#resultadosBusqueda').html('');
                        }
                    });
                });

                function seleccionarCliente(clienteId) {
                    window.location.href = 'perfil_abonos.php?id=' + clienteId;
                }

                function navigate(direction) {
                    var selectedClientId = direction === "prev" ? <?= $clientes[$prevIndex]['id'] ?> : <?= $clientes[$nextIndex]['id'] ?>;
                    $('#selectedClientId').val(selectedClientId);
                    $('#clienteForm').submit();
                }
            </script>

            <!-- BOTONES DE PAGO -->

            <?php
            $sql_monto_pagar = "SELECT MontoAPagar FROM prestamos WHERE IDCliente = ? AND estado = 'pendiente' ORDER BY FechaInicio ASC LIMIT 1";
            $stmt_monto_pagar = $conexion->prepare($sql_monto_pagar);
            $stmt_monto_pagar->bind_param("i", $id_cliente);
            $stmt_monto_pagar->execute();
            $stmt_monto_pagar->bind_result($montoAPagar);

            // Verificar si se encontró el MontoAPagar
            if ($stmt_monto_pagar->fetch()) {
                // Si se encontró, asignar el valor a la variable $montoAPagar
            } else {
                // Si no se encontró, asignar un valor predeterminado o mostrar un mensaje de error
                $montoAPagar = 'No encontrado';
            }

            $stmt_monto_pagar->close();

            ?>

            <!-- Formulario de Pago -->
            <form method="post" action="process_payment.php" id="formPago">
                <input type="hidden" name="id_cliente" value="<?= htmlspecialchars($id_cliente ?? ''); ?>">
                <input type="hidden" name="id_prestamo" value="<?= htmlspecialchars($info_prestamo['idPrestamo'] ?? ''); ?>">

                <!-- Campos para el pago -->
                <input type="text" id="cuota" name="cuota" placeholder="Cuota">
                <input type="text" id="campo2" name="campo2" placeholder="Resta">
                <input type="text" id="variable" placeholder="Deuda" readonly>

                <!-- Botones para las acciones -->
                <input type="submit" name="action" value="Pagar" class="boton1">
                <input type="submit" name="action" value="No pago" class="boton2" id="noPago">
                <input type="submit" name="action" value="Mas tarde" class="boton3" id="masTarde">

                <!-- Campos ocultos para pasar valores a JavaScript -->
                <input type="hidden" id="montoAPagar" value="<?= htmlspecialchars($montoAPagar ?? '0'); ?>">
            </form>

            <!-- Incluir el archivo JavaScript -->
            <script>
                window.onload = function() {
                    var formPago = document.getElementById('formPago');
                    var campoCuota = document.getElementById('cuota');
                    var campoResta = document.getElementById('campo2');
                    var campoDeuda = document.getElementById('variable');
                    var botonPagar = formPago.querySelector('input[name="action"][value="Pagar"]');
                    var montoAPagar = parseFloat(document.getElementById('montoAPagar').value);

                    campoCuota.addEventListener('input', function() {
                        actualizarDeudaYResta();
                        validarCuota();
                        actualizarVisibilidadBotonPagar();
                    });

                    campoResta.addEventListener('input', function() {
                        validarResta();
                        actualizarVisibilidadBotonPagar();
                    });

                    function actualizarDeudaYResta() {
                        var cuotaIngresada = parseFloat(campoCuota.value) || 0;
                        var nuevaDeuda = montoAPagar - cuotaIngresada;
                        campoDeuda.value = nuevaDeuda.toFixed(2);
                        campoResta.value = nuevaDeuda.toFixed(2);
                        validarResta();
                    }

                    function validarResta() {
                        var valorResta = parseFloat(campoResta.value) || 0;
                        var deudaActual = parseFloat(campoDeuda.value) || 0;
                        campoResta.style.backgroundColor = (valorResta === deudaActual) ? 'green' : 'red';
                    }

                    function validarCuota() {
                        var cuotaIngresada = parseFloat(campoCuota.value) || 0;
                        campoCuota.style.backgroundColor = (cuotaIngresada <= montoAPagar) ? '' : 'red';
                    }

                    function actualizarVisibilidadBotonPagar() {
                        var esCuotaInvalida = campoCuota.style.backgroundColor === 'red';
                        var esRestaInvalida = campoResta.style.backgroundColor === 'red';
                        botonPagar.style.display = (esCuotaInvalida || esRestaInvalida) ? 'none' : '';
                    }

                    formPago.addEventListener('submit', function(event) {
                        var accion = formPago.querySelector('input[name="action"]:checked').value;
                        var cuotaIngresada = parseFloat(campoCuota.value) || 0;
                        var valorResta = parseFloat(campoResta.value) || 0;
                        var deudaActual = parseFloat(campoDeuda.value) || 0;

                        // Verificar si el campo de cuota está en rojo
                        var esCuotaInvalida = campoCuota.style.backgroundColor === 'red';

                        if (accion === 'Pagar') {
                            if (esCuotaInvalida || cuotaIngresada > montoAPagar || valorResta !== deudaActual) {
                                event.preventDefault();
                                alert('Revisa los valores ingresados. La cuota no puede ser mayor al monto a pagar, no debe estar en rojo, y el valor en "Resta" debe ser igual al valor en "Deuda".');
                            }
                        }
                    });
                };
            </script>

            <?php
            // Consulta SQL para obtener los préstamos del cliente
            $sql_prestamos = "SELECT * FROM prestamos WHERE IDCliente = $id_cliente";
            $resultado_prestamos = $conexion->query($sql_prestamos);

            ?>

            <div class="profile-loans">
                <h2>Préstamos del Cliente</h2>
                <div class="table-scroll-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID del Préstamo</th>
                                <th>Deuda</th>
                                <th>Plazo</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de Vencimiento</th>
                                <th>Estado</th>
                                <th>Pagos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($fila_prestamo = $resultado_prestamos->fetch_assoc()) : ?>
                                <tr>
                                    <td><?= "REC 100" . $fila_prestamo["ID"] ?></a></td>
                                    <td><?= $fila_prestamo["MontoAPagar"] ?></td>
                                    <td><?= $fila_prestamo["Plazo"] ?></td>
                                    <td><?= $fila_prestamo["FechaInicio"] ?></td>
                                    <td><?= $fila_prestamo["FechaVencimiento"] ?></td>
                                    <td><?= $fila_prestamo["Estado"] ?></td>
                                    <td><a href="dias_pago.php?id=<?= $fila_prestamo["ID"] ?>">Pagos</a></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>


        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
        </script>

    </body>

</html>