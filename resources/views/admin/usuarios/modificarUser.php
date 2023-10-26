<?php
session_start();
include("../../../../controllers/conexion.php");

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
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
        $nuevaContrasena = $_POST['contrasena'];

        // Verificar si se ha proporcionado una nueva contraseña
        if (!empty($nuevaContrasena)) {
            // Cifrar la nueva contraseña (puedes usar password_hash o tu algoritmo preferido)
            $contrasenaCifrada = password_hash($nuevaContrasena, PASSWORD_BCRYPT);
        }

        // Preparar la consulta SQL
        $sql = "UPDATE usuarios SET Nombre = ?, Apellido = ?, Email = ?, Zona = ?, RolID = ?";
        
        // Agregar la contraseña cifrada a la consulta si se proporcionó
        if (!empty($nuevaContrasena)) {
            $sql .= ", Password = ?";
        }
        
        $sql .= " WHERE ID = ?";
        
        $stmt = $conexion->prepare($sql);

        if (!$stmt) {
            // Error en la preparación de la consulta
            die("Error en la consulta SQL: " . $conexion->error);
        }

        // Vincular los parámetros y ejecutar la consulta
        if (!empty($nuevaContrasena)) {
            if (!$stmt->bind_param("sssssi", $nombre, $apellido, $email, $zona, $rolID, $usuario_id, $contrasenaCifrada)) {
                // Error en la vinculación de parámetros
                die("Error en la vinculación de parámetros: " . $stmt->error);
            }
        } else {
            if (!$stmt->bind_param("ssssi", $nombre, $apellido, $email, $zona, $rolID, $usuario_id)) {
                // Error en la vinculación de parámetros
                die("Error en la vinculación de parámetros: " . $stmt->error);
            }
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link rel="stylesheet" href="/public/assets/css/modificarUSER.css">
</head>

<body>
    <div class="menu">
        <ion-icon name="menu-outline"></ion-icon>
        <ion-icon name="close-circle-outline"></ion-icon>
    </div>
    <div class="barra-lateral">
        <div>
            <div class="nombre-pagina">
                <ion-icon id="cloud" name="wallet-outline"></ion-icon>
                <span>Recaudo</span>
            </div> 
        </div>
        <nav class="navegacion">
            <ul>
                <li>
                    <a href="/resources/views/admin/admin_saldo/saldo_admin.php">
                        <ion-icon name="push-outline"></ion-icon>
                        <span>Saldo Inicial</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/inicio/inicio.php" class="hola">
                        <ion-icon name="home-outline"></ion-icon>
                        <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/usuarios/crudusuarios.php">
                        <ion-icon name="people-outline"></ion-icon>
                        <span>Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/usuarios/registrar.php">
                        <ion-icon name="person-add-outline"></ion-icon>
                        <span>Registrar Usuario</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/clientes/lista_clientes.php">
                        <ion-icon name="people-circle-outline"></ion-icon>
                        <span>Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/clientes/agregar_clientes.php">
                        <ion-icon name="person-circle-outline"></ion-icon>
                        <span>Registrar Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/creditos/crudPrestamos.php">
                        <ion-icon name="list-outline"></ion-icon>
                        <span>Prestamos</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/creditos/prestamos.php">
                        <ion-icon name="cloud-upload-outline"></ion-icon>
                        <span>Registrar Prestamos</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/cobros/cobros.php">
                        <ion-icon name="planet-outline"></ion-icon>
                        <span>Zonas de cobro</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/gastos/gastos.php">
                        <ion-icon name="alert-circle-outline"></ion-icon>
                        <span>Gastos</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/abonos/lista_super.php">
                        <ion-icon name="map-outline"></ion-icon>
                        <span>Ruta</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/abonos/abonos.php">
                        <ion-icon name="cloud-download-outline"></ion-icon>
                        <span>Abonos</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/retiros/retiros.php">
                        <ion-icon name="cloud-done-outline"></ion-icon>
                        <span>Retiros</span>
                    </a>
                </li>
            </ul>
        </nav> 

        <div>

            <div class="linea"></div>

            <div class="modo-oscuro">
                <div class="info">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    <a href="/controllers/cerrar_sesion.php"><span class="hola">Cerrar Sesion</span></a>
                </div> 
            </div>
        </div>

    </div>


    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->
 
    <main>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/registrar_usuarios.css">
   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <label for="contrasena">Nueva Contraseña (dejar en blanco para no cambiar):</label>
            <input type="password" name="contrasena">
        </div>
        <div>
            <input type="submit" value="Guardar Cambios">
        </div>
    </form>
    </main>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="/menu/main.js"></script>

</body>

</html>