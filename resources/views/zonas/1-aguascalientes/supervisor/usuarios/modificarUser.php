<?php
session_start();

// Validacion de rol para ingresar a la pagina 
require_once '../../../../../../controllers/conexion.php'; 

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../../../index.php");
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
    if ($rol_usuario !== 'supervisor') {
        // El usuario no tiene el rol correcto, redirige a la página de error o de inicio
        header("Location: /ruta_a_pagina_de_error_o_inicio.php");
        exit();
    }
    
   
}


// Verificar si se ha proporcionado un ID de usuario para modificar
if (isset($_GET['id'])) {
    $usuario_id = $_GET['id'];

    // Verificar si se ha enviado un formulario de modificación
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recuperar los datos del formulario
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $zona = $_POST['zona'];
        $rolID = $_POST['rolID'];
        $nuevaContrasena = $_POST['Password'];

        // Preparar la consulta SQL
        $sql = "UPDATE usuarios SET Nombre = ?, Apellido = ?, Email = ?, Zona = ?, RolID = ?";
        $params = "ssssi";
        $values = array($nombre, $apellido, $email, $zona, $rolID);

        // Verificar si se ha proporcionado una nueva contraseña
        if (!empty($nuevaContrasena)) {
            // Cifrar la nueva contraseña (puedes usar password_hash o tu algoritmo preferido)
            $contrasenaCifrada = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
            $sql .= ", Password = ?";
            $params .= "s";
            $values[] = $contrasenaCifrada;
        }

        $sql .= " WHERE ID = ?";
        $params .= "i";
        $values[] = $usuario_id;

        $stmt = $conexion->prepare($sql);

        if (!$stmt) {
            // Error en la preparación de la consulta
            die("Error en la consulta SQL: " . $conexion->error);
        }

        // Vincular los parámetros y ejecutar la consulta
        if (!$stmt->bind_param($params, ...$values)) {
            // Error en la vinculación de parámetros
            die("Error en la vinculación de parámetros: " . $stmt->error);
        }

        if ($stmt->execute()) {
            // Redirigir de regreso a la lista de usuarios con un mensaje de éxito
            header("location: crudusuarios.php?mensaje=Usuario modificado con éxito");
            exit();
        } else {
            // Error en la ejecución de la consulta
            die("Error en la ejecución de la consulta: " . $stmt->error);
        }
    } else {
        // Consultar la información del usuario para mostrarla en el formulario de modificación
        $sql = "SELECT * FROM usuarios WHERE ID = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
        } else {
            // Usuario no encontrado, redirigir a la lista de usuarios
            header("location: crudusuarios.php?mensaje=Usuario no encontrado");
            exit();
        }
    }
} else {
    // ID de usuario no proporcionado, redirigir a la lista de usuarios
    header("location: crudusuarios.php?mensaje=ID de usuario no proporcionado");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link rel="stylesheet" href="/public/assets/css-Super/modificarUSER.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>
        <button class="volver" id="volverAtras">
            <i class="fa-solid fa-right-to-bracket"></i>
            <span>&nbsp;Volver</span>
        </button>
    </header>

    <div class="menu__side" id="menu_side">

        <div class="name__page">
            <img src="/public/assets/img/logo.png" class="img logo-image" alt="">
            <h4>Recaudo</h4>
        </div>

        <div class="options__menu">

            <a href="/resources/views/supervisor/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href="/resources/views/supervisor/usuarios/crudusuarios.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/supervisor/usuarios/registrar.php">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/supervisor/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/supervisor/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/supervisor/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/supervisor/creditos/prestamos.php">
                <div class="option">
                    <i class="fa-solid fa-file-invoice-dollar" title=""></i>
                    <h4>Registrar Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/supervisor/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/supervisor/ruta/lista_super.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Ruta</h4>
                </div>
            </a>

            <a href="/resources/views/supervisor/abonos/abonos.php">
                <div class="option">
                    <i class="fa-solid fa-money-bill-trend-up" title=""></i>
                    <h4>Abonos</h4>
                </div>
            </a>

            <a href="/resources/views/supervisor/retiros/retiros.php">
                <div class="option">
                    <i class="fa-solid fa-scale-balanced" title=""></i>
                    <h4>Retiros</h4>
                </div>
            </a>



        </div>

    </div>

    <main>
        <h1>Modificar Usuario</h1>

        <!-- Muestra un mensaje de error si hay alguno -->
        <?php if (isset($mensaje)) { echo "<p>$mensaje</p>"; } ?>

        <form method="post">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" value="<?= $usuario['Nombre'] ?>" required>
            </div>
            <div>
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" value="<?= $usuario['Apellido'] ?>" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?= $usuario['Email'] ?>" required>
            </div>
            <div>
                <label for="zona">Zona:</label>
                <input type="text" name="zona" value="<?= $usuario['Zona'] ?>" required>
            </div>
            <div>
                <label for="rolID">Rol:</label>
                <input type="text" name="rolID" value="<?= $usuario['RolID'] ?>" required>
            </div>
            <div>
                <label for="contrasena">Nueva Contraseña: <br><p class="pp">(dejar en blanco para no cambiar)</p></label>
                <input type="password" name="contrasena">
            </div>
            <div>
                <input type="submit" value="Guardar Cambios">
            </div>
        </form>
    </main>

    <script>
    // Agregar un evento clic al botón
    document.getElementById("volverAtras").addEventListener("click", function() {
        window.history.back();
    });
    </script>
    <script src="/public/assets/js/MenuLate.js"></script>
</body>

</html>