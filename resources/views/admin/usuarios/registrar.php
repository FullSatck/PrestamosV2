<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include("../../../../controllers/conexion.php");

// Consulta SQL para obtener la lista de zonas
$sqlZonas = "SELECT ID, Nombre FROM zonas";
$resultadoZonas = $conexion->query($sqlZonas);

if ($resultadoZonas === false) {
    die("Error en la consulta de zonas: " . $conexion->error);
}

// Variable para el mensaje de éxito
$exito = "";

// Verificar si se ha enviado el formulario de registro
if (isset($_POST['registrar_usuario'])) {
    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $idZona = $_POST['zona'];
    $rolID = $_POST['RolID'];
    $saldoInicial = isset($_POST['saldo-inicial']) ? $_POST['saldo-inicial'] : null;

    // Insertar usuario en la tabla 'usuarios'
    $sqlInsertUsuario = "INSERT INTO usuarios (Nombre, Apellido, Email, Contrasena, ZonaID, RolID) VALUES ('$nombre', '$apellido', '$email', '$contrasena', $idZona, $rolID)";
    
    if ($conexion->query($sqlInsertUsuario) === TRUE) {
        $exito = "Usuario registrado con éxito";

        // Verificar si el rol es Supervisor (supongamos que el valor del rol de Supervisor es 2)
        if ($rolID == 2 && !is_null($saldoInicial)) {
            // Obtener el ID del usuario que se acaba de registrar
            $idUsuario = $conexion->insert_id;
            
            // Insertar saldo inicial en la tabla 'registros_saldo'
            $sqlInsertSaldo = "INSERT INTO registros_saldo (IDUsuario, SaldoInicial) VALUES ($idUsuario, $saldoInicial)";
            if ($conexion->query($sqlInsertSaldo) !== TRUE) {
                $error = "Error al insertar el saldo inicial: " . $conexion->error;
            }
        }

        // Redireccionar a la lista de usuarios después de 2 segundos
        header("refresh:2; url=lista_usuarios.php");
    } else {
        $error = "Error al registrar el usuario: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="/public/assets/css/registrar_usuarios.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="registro-container">
        <h2>Registro de Usuario</h2>
        <form action="/controllers/registrar_usuario.php" method="post">
            <div class="input-container">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Por favor ingrese su nombre" required>
            </div>
            <div class="input-container">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" placeholder="Por favor ingrese su apellido" required>
            </div>
            <div class="input-container">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" placeholder="Por favor ingrese su correo" required>
            </div>
            <div class="input-container">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="Por favor ingrese su clave" required>
            </div>
            <div class="input-container">
                <label for="zona">Zona:</label>
                <select id="zona" name="zona" placeholder="Por favor ingrese la zona" required>
                    <?php
                    // Genera las opciones del menú desplegable con las zonas
                    while ($row = $resultadoZonas->fetch_assoc()) {
                        echo '<option value="' . $row['ID'] . '">' . $row['Nombre'] . '</option>';
                    }
                    ?>
                </select>
            </div>
        
            <div class="input-container">
                <label for="RolID">Rol:</label>
                <select id="RolID" name="RolID" required>
                    <?php
                    // Consulta SQL para obtener las opciones de roles
                    $consultaRoles = "SELECT ID, Nombre FROM Roles";
                    $resultRoles = $conexion->query($consultaRoles);

                    while ($row = $resultRoles->fetch_assoc()) {
                        echo '<option value="' . $row['ID'] . '">' . $row['Nombre'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="input-container" id="saldo-inicial-container" style="display: none;">
                <label for="saldo-inicial">Saldo Inicial:</label>
                <input type="text" id="saldo-inicial" name="saldo-inicial" placeholder="Por favor ingrese el saldo inicial">
            </div>

            <div class="btn-container">
                <button type="submit" name="registrar_usuario">Registrar</button>
                <a href="/resources/views/admin/inicio/inicio.php" class="a">Volver</a>
            </div>
        </form>
    </div>

    <script>
        // Agrega un evento para detectar cambios en la selección del rol
        $(document).ready(function() {
            $("#RolID").on("change", function() {
                var selectedRole = $(this).val();
                var saldoInicialContainer = $("#saldo-inicial-container");
                if (selectedRole === "2") {
                    saldoInicialContainer.show();
                } else {
                    saldoInicialContainer.hide();
                }
            });
        });
    </script>
</body>
</html>
