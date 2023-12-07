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

// Consulta SQL para obtener los detalles del cliente con el nombre de la moneda
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
    header("location: ../resources/views/admin/clientes/lista_clientes.php");
    exit();
}

// Obtener la zona y rol del usuario desde la sesión
$user_zone = $_SESSION['user_zone'];
$user_role = $_SESSION['rol'];

// Si el rol es 1 (administrador)
if ($_SESSION["rol"] == 1) {
    $ruta_volver = "/resources/views/admin/inicio/prestadia/prestamos_del_dia.php";
} elseif ($_SESSION["rol"] == 2) {
    // Ruta para el rol 2 (supervisor) en base a la zona
    if ($_SESSION['user_zone'] === '6') {
        $ruta_volver = "/resources/views/zonas/6-Chihuahua/supervisor/inicio/inicio.php";
    } elseif ($_SESSION['user_zone'] === '20') {
        $ruta_volver = "/resources/views/zonas/20-Puebla/supervisor/inicio/inicio.php";
    } elseif ($_SESSION['user_zone'] === '22') {
        $ruta_volver = "/resources/views/zonas/22-QuintanaRoo/supervisor/inicio/inicio.php";
    } else {
        // Si no coincide con ninguna zona válida para supervisor, redirigir a un dashboard predeterminado
        $ruta_volver = "/default_dashboard.php";
    }
} elseif ($_SESSION["rol"] == 3) {
    // Ruta para el rol 3 (cobrador) en base a la zona
    if ($_SESSION['user_zone'] === '6') {
        $ruta_volver = "/resources/views/zonas/6-Chihuahua/cobrador/inicio/prestadia/prestamos_del_dia.php";
    } elseif ($_SESSION['user_zone'] === '20') {
        $ruta_volver = "/resources/views/zonas/20-Puebla/cobrador/inicio/prestadia/prestamos_del_dia.php";
    } elseif ($_SESSION['user_zone'] === '22') {
        $ruta_volver = "/resources/views/zonas/22-QuintanaRoo/cobrador/inicio/prestadia/prestamos_del_dia.php";
    } else {
        // Si no coincide con ninguna zona válida para cobrador, redirigir a un dashboard predeterminado
        $ruta_volver = "/default_dashboard.php";
    }
} else {
    // Si no hay un rol válido, redirigir a una página predeterminada
    $ruta_volver = "/default_dashboard.php";
}


// Variables para prevenir errores
$info_prestamo = [
    'Nombre' => '',
    'Telefono' => '',
    'Cuota' => '',
];

$total_prestamo = 0.00;

// Consulta SQL para obtener la información del préstamo
$sql_prestamo = "SELECT p.ID, p.Monto, p.TasaInteres, p.Plazo, p.Estado, p.FechaInicio, p.FechaVencimiento, p.Cuota, c.Nombre, c.Telefono 
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
    <!-- Asegúrate de incluir tu hoja de estilos CSS -->
    <title>Perfil del Cliente</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>

    </style>
</head>

<body>

    <body id="body">
        <header>
            <a href="<?= $ruta_volver ?>" class="back-link">Salir</a>
            <div class="nombre-usuario">
                <?php
                if (isset($_SESSION["nombre_usuario"], $_SESSION["nombre"])) {
                    echo htmlspecialchars($_SESSION["nombre_usuario"]) . "<br>" . "<span>" . htmlspecialchars($_SESSION["nombre"]) . "</span>";
                }
                ?>
            </div>
        </header>

        <main>

            <!-- PERFIL DE CLIENTE -->

            <?php
            // Consulta SQL para obtener los detalles del cliente con el nombre de la moneda
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
    header("location: ../resources/views/admin/clientes/lista_clientes.php");
    exit();
}
?>
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
    include("conexion.php");

    if (isset($_GET['show_all']) && $_GET['show_all'] === 'true') {
        // Si se solicita mostrar todas las filas
        $sql = "SELECT id, fecha, monto_pagado, monto_deuda FROM facturas WHERE cliente_id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $num_rows = $resultado->num_rows;
        if ($num_rows > 0) {
            echo "<table id='tabla-prestamos'>";
            echo "<tr><th>Fecha</th><th>Abono</th><th>Resta</th><th>Editar</th></tr>";
            $last_row = null;
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($fila['fecha']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['monto_pagado']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['monto_deuda']) . "</td>";
                $last_row = $fila; // Actualizar la última fila en cada iteración
                echo "</tr>";
            }

            // Mostrar el enlace de "Editar" solo para la última fila
            echo "<tr>";
            echo "<td>" . htmlspecialchars($last_row['fecha']) . "</td>";
            echo "<td>" . htmlspecialchars($last_row['monto_pagado']) . "</td>";
            echo "<td>" . htmlspecialchars($last_row['monto_deuda']) . "</td>";
            echo "<td><a href='editar_pago.php?id=" . $last_row['id'] . "'>Editar</a></td>";
            echo "</tr>";

            echo "</table>";
            echo "<button onclick='showLess()'>Ver menos</button>"; // Botón para mostrar menos
        } else {
            echo "<p>No se encontraron pagos para este cliente.</p>";
        }

        $stmt->close();
    } else {
        // Mostrar solo la última fila inicialmente
        $sql = "SELECT id, fecha, monto_pagado, monto_deuda FROM facturas WHERE cliente_id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $num_rows = $resultado->num_rows;
        if ($num_rows > 0) {
            echo "<table id='tabla-prestamos'>";
            echo "<tr><th>Fecha</th><th>Abono</th><th>Resta</th><th>Editar</th></tr>";
            $last_row = null;
            while ($fila = $resultado->fetch_assoc()) {
                $last_row = $fila; // Actualizar la última fila en cada iteración
            }

            // Mostrar solo la última fila
            echo "<tr>";
            echo "<td>" . htmlspecialchars($last_row['fecha']) . "</td>";
            echo "<td>" . htmlspecialchars($last_row['monto_pagado']) . "</td>";
            echo "<td>" . htmlspecialchars($last_row['monto_deuda']) . "</td>";
            echo "<td><a href='editar_pago.php?id=" . $last_row['id'] . "'>Editar</a></td>";
            echo "</tr>";

            echo "</table>";

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


            <!-- BUSCADOR DE CLIENTES -->
            <?php
            // Incluir el archivo de conexión a la base de datos
            include("conexion.php");

            // Consulta para obtener la lista de clientes
            $query = "SELECT id, Nombre, Apellido FROM clientes";
            $result = mysqli_query($conexion, $query);

            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conexion));
            }

            // Iniciar el menú desplegable
            echo "<h2>Clientes:</h2>";
            echo "<form action='procesar_cliente.php' method='post'>"; // Reemplaza 'procesar_cliente.php' por tu archivo de procesamiento real
            echo "<select name='cliente'>";

            // Agregar opciones al menú desplegable
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $nombre = $row['Nombre'];
                $apellido = $row['Apellido'];
                echo "<option value='$id'>$nombre $apellido</option>";
            }

            echo "</select>";
            echo "<input type='submit' value='Seleccionar'>";
            echo "</form>";

            mysqli_free_result($result); 
            ?>

            <!-- BUSCADOR DE PRESTAMOS -->

            <?php
// Incluir el archivo de conexión a la base de datos
include("conexion.php");

// Verificar si se proporcionó el ID del cliente en la variable PHP $id_cliente
if (isset($id_cliente)) {
    // Consulta para obtener la lista de préstamos asociados al cliente
    $query = "SELECT id, MontoAPagar FROM prestamos WHERE IDCliente = $id_cliente";
    $result = mysqli_query($conexion, $query);

    if (!$result) {
        die("Error en la consulta de préstamos: " . mysqli_error($conexion));
    }

    // Crear un formulario con un menú desplegable de préstamos del cliente
    echo "<h2>Prestamo:</h2>";
    echo "<form action='prestamos_cartulina.php' method='get'>"; // Reemplaza 'tuarchivo.php' por tu nombre de archivo PHP
    echo "<select name='id_prestamo'>";
    while ($row = mysqli_fetch_assoc($result)) {
        $id_prestamo = $row['id'];
        $montoAPagar = number_format($row['MontoAPagar']); // Formatear MontoAPagar
        echo "<option value='$id_prestamo'>ID: $id_prestamo - Valor: $montoAPagar</option>";
    }
    echo "</select>";
    // echo "<input type='submit' value='Seleccionar'>";
    echo "</form>";

    mysqli_free_result($result);
} else {
    echo "No se proporcionó el ID del cliente.";
}
?>

















            <!-- BOTONES DE PAGO -->

            <?php
// Obtener el MontoAPagar de la tabla de préstamos
$sql_monto_pagar = "SELECT MontoAPagar FROM prestamos WHERE IDCliente = ?";
$stmt_monto_pagar = $conexion->prepare($sql_monto_pagar);
$stmt_monto_pagar->bind_param("i", $id_cliente);
$stmt_monto_pagar->execute();
$stmt_monto_pagar->bind_result($montoAPagar);

// Verificar si se encontró el MontoAPagar
if ($stmt_monto_pagar->fetch()) {
    // Si se encontró, asigna el valor a la variable $montoAPagar
    $montoAPagar = $montoAPagar; // Ajustar el formato según sea necesario
} else {
    // Si no se encontró, asigna un valor predeterminado o muestra un mensaje de error
    $montoAPagar = 'No encontrado';
}

$stmt_monto_pagar->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores ingresados
    $cuota_ingresada = $_POST['cuota'];
    $monto_deuda = $montoAPagar - $cuota_ingresada; // Calcular el monto de deuda

    // Actualizar MontoAPagar en la tabla "prestamos"
    $sql_update_prestamo = "UPDATE prestamos SET MontoAPagar = ? WHERE IDCliente = ?";
    $stmt_update_prestamo = $conexion->prepare($sql_update_prestamo);
    $stmt_update_prestamo->bind_param("di", $monto_deuda, $id_cliente);
    $stmt_update_prestamo->execute();

    // Insertar datos en la tabla "facturas"
    $fecha_actual = date('Y-m-d');
    $sql_insert_factura = "INSERT INTO facturas (cliente_id, monto, fecha, monto_pagado, monto_deuda) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert_factura = $conexion->prepare($sql_insert_factura);
    $stmt_insert_factura->bind_param("idsss", $id_cliente, $total_prestamo, $fecha_actual, $cuota_ingresada, $monto_deuda);
    $stmt_insert_factura->execute();

    function obtenerSiguienteClienteId($conexion, $id_cliente_actual) {
        $sql_siguiente_cliente = "SELECT ID FROM clientes WHERE ID > ? ORDER BY ID ASC LIMIT 1";
        $stmt_siguiente_cliente = $conexion->prepare($sql_siguiente_cliente);
        $stmt_siguiente_cliente->bind_param("i", $id_cliente_actual);
        $stmt_siguiente_cliente->execute();
        $stmt_siguiente_cliente->bind_result($siguiente_cliente_id);
        $stmt_siguiente_cliente->fetch();
        $stmt_siguiente_cliente->close();

        return $siguiente_cliente_id;
    }

    // Obtener el siguiente ID de cliente (cambia esta lógica según la manera en que tengas los clientes ordenados)
    $siguiente_cliente_id = obtenerSiguienteClienteId($conexion, $id_cliente);

    // Definir $es_ultimo_cliente fuera del bloque condicional POST
    $es_ultimo_cliente = false;

    // Verificar si la inserción fue exitosa
    if ($stmt_insert_factura && $stmt_update_prestamo) {
        // Inserción y actualización exitosas

        // Verificar si es el último cliente
        $es_ultimo_cliente = ($siguiente_cliente_id === null);

        // Mostrar mensaje si es el último cliente
        if ($es_ultimo_cliente) {
            echo '<p>Este es el último cliente.</p>';
        }

        if ($siguiente_cliente_id !== null) {
            // Redirigir al perfil del siguiente cliente si hay más clientes
            header("Location: perfil_abonos.php?id=$siguiente_cliente_id");
            exit();
        } else {
            // Mostrar el modal ya que no hay más clientes
            echo '<script>
                    window.onload = function() {
                        alert("No hay más clientes");
                    };
                  </script>';
        }
    } else {
        // Alguna inserción o actualización fallida
        // Manejar el error apropiadamente
        echo "Error al realizar el pago.";
    }

    $stmt_insert_factura->close();
    $stmt_update_prestamo->close();
}
?>

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

<form method="post" class="pagos">
    <input type="text" id="cuota" name="cuota" placeholder="Cuota">
    <input type="text" id="campo2" name="campo2" placeholder="Resta">
    <input type="text" id="variable" placeholder="Deuda"
        value="<?= htmlspecialchars($montoAPagar-$info_prestamo['Cuota']); ?>" readonly>
     
    <input type="submit" value="Pagar">
</form>





        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
        </script>
      
    </body>

</html>