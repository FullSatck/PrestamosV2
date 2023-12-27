<?php
date_default_timezone_set('America/Bogota');
session_start();

// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../index.php");
    exit();
}

// Verificar si se ha pasado un ID válido como parámetro GET
if (!isset($_GET['id']) || $_GET['id'] === '' || !is_numeric($_GET['id'])) {
    // Redirigir a una página de error o a una página predeterminada
    header("location: ../index.php"); // Reemplaza 'error_page.php' con la página de error correspondiente
    exit();
}


// Incluir el archivo de conexión a la base de datos
include("conexion.php");

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
    } elseif ($_SESSION["rol"] == 2) {
        // Ruta para el rol 3 (cobrador) en base a la zona
        if ($_SESSION['user_zone'] === '6') {
            $ruta_volver = "/resources/views/zonas/6-Chihuahua/supervisor/inicio/inicio.php";
            $ruta_filtro = "/resources/views/zonas/6-Chihuahua/supervisor/inicio/prestadia/prestamos_del_dia.php";
            $ruta_cliente = "/resources/views/zonas/6-Chihuahua/supervisor/clientes/agregar_clientes.php";
        } elseif ($_SESSION['user_zone'] === '20') {
            $ruta_volver = "/resources/views/zonas/20-Puebla/supervisor/inicio/inicio.php";
            $ruta_filtro = "/resources/views/zonas/20-Puebla/supervisor/inicio/prestadia/prestamos_del_dia.php";
            $ruta_cliente = "/resources/views/zonas/20-Puebla/supervisor/clientes/agregar_clientes.php";
        } elseif ($_SESSION['user_zone'] === '22') {
            $ruta_volver = "/resources/views/zonas/22-QuintanaRoo/supervisor/inicio/inicio.php";
            $ruta_filtro = "/resources/views/zonas/22-QuintanaRoo/supervisor/inicio/prestadia/prestamos_del_dia.php";
            $ruta_cliente = "/resources/views/zonas/22-QuintanaRoo/supervisor/clientes/agregar_clientes.php";
        } else {
            // Si no coincide con ninguna zona válida para cobrador, redirigir a un dashboard predeterminado
            $ruta_volver = "index.php";
            $ruta_filtro = "index.php";
            $ruta_cliente = "index.php";
        }
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

$mostrarMensajeAgregarPrestamo = true; // Inicialmente asume que no hay préstamos pendientes

if ($resultado_prestamo->num_rows > 0) {
    // Cliente tiene al menos un préstamo pendiente
    $info_prestamo = $resultado_prestamo->fetch_assoc();
    $total_prestamo = $info_prestamo['Monto'] + ($info_prestamo['Monto'] * $info_prestamo['TasaInteres'] / 100);
    $mostrarMensajeAgregarPrestamo = false; // Hay préstamos pendientes, no mostrar el mensaje
}

if ($mostrarMensajeAgregarPrestamo) {
    echo "<p class='no-prestamo-mensaje'>Este cliente no tiene préstamos activos o están completamente pagados.</p>";
    echo "<a href='../resources/views/admin/creditos/prestamos.php?cliente_id=" . $id_cliente . "' class='back-link3'>Agregar Préstamo</a>";
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
                    $sql_total_clientes = "SELECT COUNT(*) AS TotalClientes FROM clientes";
                    $resultado_total = $conexion->query($sql_total_clientes);
                    $fila_total = $resultado_total->fetch_assoc();
                    $total_clientes = $fila_total['TotalClientes'];

                    $sql_posicion_cliente = "SELECT COUNT(*) AS Posicion FROM clientes WHERE ID <= ?";
                    $stmt_posicion = $conexion->prepare($sql_posicion_cliente);
                    $stmt_posicion->bind_param("i", $id_cliente);
                    $stmt_posicion->execute();
                    $stmt_posicion->bind_result($posicion_cliente);
                    $stmt_posicion->fetch();
                    $stmt_posicion->close();
                    ?>
                    <p><strong>Cliente: </strong><?= $posicion_cliente . "/" . $total_clientes; ?></p>
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
                <input type="hidden" name="id_cliente" value="<?= $id_cliente; ?>">
                <input type="hidden" name="id_prestamo" value="<?= $idPrestamo; ?>">

                <!-- Campos para el pago -->
                <input type="text" id="cuota" name="cuota" placeholder="Cuota">
                <input type="text" id="campo2" name="campo2" placeholder="Resta">
                <input type="text" id="variable" placeholder="Deuda" value="<?= htmlspecialchars(($montoAPagar - $info_prestamo['Cuota'] < 0) ? 0 : $montoAPagar - $info_prestamo['Cuota']); ?>" readonly>

                <!-- Botones para las acciones -->
                <input type="submit" name="action" value="Pagar" class="boton1">
                <input type="submit" name="action" value="No pago" class="boton2" id="noPago">
                <input type="submit" name="action" value="Mas tarde" class="boton3" id="masTarde">

            </form>

            <!-- Luego, en tu HTML, reemplaza el valor de $total_prestamo por $montoAPagar -->

            <script>
                var cuotaEsperada = <?= json_encode($info_prestamo['Cuota']); ?>;
                var montoAPagar = <?= json_encode($montoAPagar); ?>;
                console.log("Cuota esperada:", cuotaEsperada); // Para depuración
                console.log("Monto a pagar:", montoAPagar); // Para depuración

                window.onload = function() {
                    var formPago = document.getElementById('formPago');
                    var campoCuota = document.getElementById('cuota');
                    var campoResta = document.getElementById('campo2');
                    var campoDeuda = document.getElementById('variable');

                    campoResta.addEventListener('input', function() {
                        var valorResta = parseFloat(campoResta.value.replace(',', '.'));
                        var deudaActual = parseFloat(campoDeuda.value.replace(',', '.'));
                        campoResta.style.backgroundColor = valorResta === deudaActual ? 'green' : 'red';
                    });

                    formPago.addEventListener('submit', function(event) {
                        // Verificar si la acción es "Pagar"
                        var accion = formPago.querySelector('input[name="action"]:checked').value;
                        if (accion === 'Pagar') {
                            var cuotaIngresada = parseFloat(campoCuota.value.replace(',', '.'));
                            var valorResta = parseFloat(campoResta.value.replace(',', '.'));
                            var deudaActual = parseFloat(campoDeuda.value.replace(',', '.'));
                            var tolerancia = 0.01;

                            if (deudaActual === 0 && valorResta === 0) {
                                if (Math.abs(cuotaIngresada - montoAPagar) > tolerancia) {
                                    event.preventDefault();
                                    alert('La cuota ingresada debe ser igual al monto total a pagar.');
                                    return;
                                }
                            } else {
                                if (Math.abs(cuotaIngresada - cuotaEsperada) > tolerancia) {
                                    event.preventDefault();
                                    alert('La cuota ingresada no es correcta.');
                                    return;
                                }
                                if (valorResta !== deudaActual) {
                                    event.preventDefault();
                                    alert('El saldo que resta que se ingresó no es correcto.');
                                    return;
                                }
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