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
    <link rel="stylesheet" href="/public/assets/css/perfil_cliente.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <!-- Asegúrate de incluir tu hoja de estilos CSS -->
    <title>Perfil del Cliente</title>
    <style>
        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
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
            echo "<h2>Lista de Clientes:</h2>";
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
























            <!-- BOTON DE PAGAR -->

            <!-- El botón para abrir el modal -->
    <button id="openModal">Abrir Modal</button>

<!-- El modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <?php
        // Contenido generado por PHP
        $mensaje = "¡Hola desde PHP!";
        echo "<h2>$mensaje</h2>";
        ?>
        <!-- Campo para ingresar una cantidad -->
        <h2>Ingrese una Cantidad</h2>
        <input type="number" id="cantidadInput">
        <button id="confirmBtn">Confirmar</button>
    </div>
</div>

<script>
// JavaScript para controlar el modal
var modalBtn = document.getElementById("openModal");
var modal = document.getElementById("myModal");
var closeBtn = document.getElementsByClassName("close")[0];

// Función para abrir el modal
modalBtn.onclick = function() {
    modal.style.display = "block";
}

// Función para cerrar el modal
closeBtn.onclick = function() {
    modal.style.display = "none";
}

// Función para cerrar el modal si se hace clic fuera de él
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>



























            <div class="info-cliente">
                <div class="columna">
                    <p><strong>Plazo:</strong> <?= htmlspecialchars($info_prestamo['Plazo']); ?></p>
                    <p><strong>Estado:</strong> <?= htmlspecialchars($info_prestamo['Estado']); ?></p>
                    <p><strong>Inicio:</strong> <?= htmlspecialchars($info_prestamo['FechaInicio']); ?></p>
                </div>
                <div class="columna">
                    <p><strong>Cuota:</strong> <?= htmlspecialchars($info_prestamo['Cuota']); ?></p>
                    <p><strong>Total:</strong> <?= htmlspecialchars(number_format($total_prestamo, 2)); ?>
                    <p><strong>Fin:</strong> <?= htmlspecialchars($info_prestamo['FechaVencimiento']); ?></p>
                    </p>
                </div>
            </div>

            <!-- Agregar una sección para mostrar los préstamos del cliente -->
            <div class="profile-loans">
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
        </main>

        
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