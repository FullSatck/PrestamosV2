<?php
date_default_timezone_set('America/Bogota');
session_start();

// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
    exit();
}

// Verificar si se ha pasado un ID válido como parámetro GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirigir a una página de error o a la lista de clientes
    header("location: dias_pagos.php");
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
    $ruta_volver = "/resources/views/admin/inicio/inicio.php";
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
        $ruta_volver = "/resources/views/zonas/6-Chihuahua/cobrador/inicio/inicio.php";
    } elseif ($_SESSION['user_zone'] === '20') {
        $ruta_volver = "/resources/views/zonas/20-Puebla/cobrador/inicio/inicio.php";
    } elseif ($_SESSION['user_zone'] === '22') {
        $ruta_volver = "/resources/views/zonas/22-QuintanaRoo/cobrador/inicio/inicio.php";
    } else {
        // Si no coincide con ninguna zona válida para cobrador, redirigir a un dashboard predeterminado
        $ruta_volver = "/default_dashboard.php";
    }
} else {
    // Si no hay un rol válido, redirigir a una página predeterminada
    $ruta_volver = "/default_dashboard.php";
}



// Consulta SQL para obtener los préstamos del cliente
$sql_prestamos = "SELECT * FROM prestamos WHERE IDCliente = $id_cliente";
$resultado_prestamos = $conexion->query($sql_prestamos);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/perfil_cliente.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <!-- Asegúrate de incluir tu hoja de estilos CSS -->
    <title>Perfil del Cliente</title>
<<<<<<< HEAD
=======

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
    .contenedor {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .formulario {
        width: 70%;
        /* Ancho ajustable */
        max-width: 400px;
        /* Ancho máximo */
        text-align: center;
    }

    input[type="text"] {
        width: calc(33.33% - 10px);
        /* Un tercio del ancho con un pequeño margen entre ellos */
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        display: inline-block;
        /* Mostrar en línea para colocar horizontalmente */
        box-sizing: border-box;
        /* Incluir el padding y border en el ancho total */
        vertical-align: top;
    }
    </style>
>>>>>>> 924e8125e7a41c2f63ee2024602c0fa9a0ae91de
</head>

<body>

    <body id="body">

        <header>

        <a href="<?= $ruta_volver ?>" class="back-link">Ir al Inicio</a>

            <div class="nombre-usuario">
                <?php
    if (isset($_SESSION["nombre_usuario"], $_SESSION["nombre"])) {
        echo htmlspecialchars($_SESSION["nombre_usuario"]) . "<br>" . "<span>" . htmlspecialchars($_SESSION["nombre"]) . "</span>";
    }
    ?>
            </div>



        </header>

        <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

        <main>
            <div class="profile-container">
                <div class="profile-image"><br><br><br>
                    <!-- Mostrar la foto del cliente -->
                    <img src="<?= $imagen_cliente ?>" alt="Foto del Cliente">
                </div>
                <div class="profile-details">
                    <!-- Mostrar los datos del cliente -->
                    <h1><strong><?= $fila["Nombre"] ?></strong></h1>
                    <p>Apellido: <strong><?= $fila["Apellido"] ?></strong></p>
                    <p>Curp: <strong><?= $fila["IdentificacionCURP"] ?></strong></p>
                    <p>Domicilio: <strong><?= $fila["Domicilio"] ?></strong></p>
                    <p>Teléfono: <strong><?= $fila["Telefono"] ?></strong> </p>
                    <p>Moneda Preferida: <strong><?= $fila["MonedaNombre"] ?></strong></p> <!-- Nombre de la moneda -->
                    <p>Estado: <strong><?= $fila["ZonaAsignada"] ?></strong></p>
                    <p>Municipio: <strong><?= $fila["CiudadNombre"] ?></strong></p>
                    <p>Cononia: <strong><?= $fila["asentamiento"] ?></strong></p>
                </div>
            </div>

<<<<<<< HEAD
            <!-- Agregar una sección para mostrar los préstamos del cliente -->
            <div class="profile-loans">
                <h2>Préstamos del Cliente</h2>
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
                            <td><a href="cartulina.php?id=<?= $id_cliente ?>">Pagos</a></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>

=======
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

            <!-- CARULINA -->
            <div class="info-cliente">
                <div class="columna">
                    <p><strong>Plazo:</strong> <?= htmlspecialchars($info_prestamo['Plazo']); ?></p>
                    <p><strong>Cuota:</strong> <?= htmlspecialchars(number_format($info_prestamo['Cuota'])); ?></p>
                    <p><strong>Total:</strong> <?= htmlspecialchars(number_format($total_prestamo)); ?>
                </div>
                <div class="columna">
                    <p><strong>Estado:</strong> <?= htmlspecialchars($info_prestamo['Estado']); ?></p>
                    <p><strong>Inicio:</strong> <?= htmlspecialchars($info_prestamo['FechaInicio']); ?></p>
                    <p><strong>Fin:</strong> <?= htmlspecialchars($info_prestamo['FechaVencimiento']); ?></p>
                    </p>
                </div>
            </div>


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

    // Verificar si la inserción fue exitosa
    if ($stmt_insert_factura && $stmt_update_prestamo) {
        // Inserción y actualización exitosas
        // Realizar alguna acción o redireccionar a una página de éxito
        header("Location: perfil_cliente.php?id=$id_cliente");
        exit();
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

<form method="post">
    <input type="text" id="cuota" name="cuota" placeholder="Cuota">
    <input type="text" id="campo2" name="campo2" placeholder="Resta">
    <input type="text" id="variable" placeholder="Deuda" value="<?= htmlspecialchars($montoAPagar-$info_prestamo['Cuota']); ?>" readonly>
    <input type="submit" value="Pagar">
</form>



            <!-- CARTULINA -->

            <!-- Agregar una sección para mostrar los préstamos del cliente -->
            <div class="profile-loans">
                <?php

               $sql = "SELECT id, fecha, monto_pagado, monto_deuda FROM facturas WHERE cliente_id = ?";
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
                        echo "<td>" . htmlspecialchars($fila['monto_deuda']) . "</td>";
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
        </main>


>>>>>>> 924e8125e7a41c2f63ee2024602c0fa9a0ae91de
        <script>
        // Agregar un evento clic al botón
        document.getElementById("volverAtras").addEventListener("click", function() {
            window.history.back();
        });
        </script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileImage = document.querySelector('.profile-image img');

            // Agrega un controlador de eventos para hacer clic en la imagen
            profileImage.addEventListener('click', function() {
                profileImage.classList.toggle('zoomed'); // Alterna la clase 'zoomed'
            });
        });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
        </script>
    </body>

</html>