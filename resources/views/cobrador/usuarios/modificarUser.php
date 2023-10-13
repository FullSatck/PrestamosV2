<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// El usuario ha iniciado sesión, mostrar el contenido de la página aquí
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link rel="stylesheet" type="text/css" href="/public/assets/css/registrar_usuarios.css">
</head>

<body>
    <div class="registro-container">
        <h2>Modificar Usuario</h2>
        <?php
        // Verifica si se ha pasado un ID de usuario a modificar por GET
        if (isset($_GET['id'])) {
            // Incluye el archivo de conexión a la base de datos
            include("../../../../controllers/conexion.php");
            // Obtiene el ID del usuario a modificar
            $usuario_id = $_GET['id'];
            // Consulta SQL para obtener los datos del usuario por su ID
            $consultaUsuario = "SELECT * FROM usuarios WHERE ID = $usuario_id";
            $resultUsuario = mysqli_query($conexion, $consultaUsuario);
            // Verifica si se encontró el usuario
            if ($row = mysqli_fetch_assoc($resultUsuario)) {
                // Rellena el formulario con los datos actuales del usuario
                ?>
                <form action="/controllers/validar_modificacion.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $usuario_id; ?>">
                    <div class="input-container">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo $row['Nombre']; ?>" required>
                    </div>
                    <div class="input-container">
                        <label for="apellido">Apellido:</label>
                        <input type="text" id="apellido" name="apellido" value="<?php echo $row['Apellido']; ?>" required>
                    </div>
                    <div class="input-container">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" id="email" name="email" value="<?php echo $row['Email']; ?>" required>
                    </div>
                    <div class="input-container">
                        <label for="contrasena">Contraseña:</label>
                        <input type="password" id="contrasena" name="contrasena" placeholder="Nueva contraseña">
                    </div>
                    <div class="input-container">
                        <label for="zona">Zona:</label>
                        <select id="zona" name="zona" required>
                            <?php
                            // Consulta SQL para obtener las zonas
                            $consultaZonas = "SELECT ID, Nombre FROM Zonas";
                            $resultZonas = mysqli_query($conexion, $consultaZonas);
                            // Genera las opciones del menú desplegable para Zona
                            while ($zona = mysqli_fetch_assoc($resultZonas)) {
                                $selected = ($zona['ID'] == $row['ZonaID']) ? 'selected' : '';
                                echo '<option value="' . $zona['ID'] . '" ' . $selected . '>' . $zona['Nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-container">
                        <label for="rol">Rol:</label>
                        <select id="rol" name="rol" required>
                            <?php
                            // Consulta SQL para obtener las opciones de roles
                            $consultaRoles = "SELECT ID, Nombre FROM Roles";
                            $resultRoles = mysqli_query($conexion, $consultaRoles);
                            // Genera las opciones del menú desplegable para Rol
                            while ($rol = mysqli_fetch_assoc($resultRoles)) {
                                $selected = ($rol['ID'] == $row['RolID']) ? 'selected' : '';
                                echo '<option value="' . $rol['ID'] . '" ' . $selected . '>' . $rol['Nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Otros campos de usuario -->
                    <!-- ... -->
                    <div class="btn-container">
                        <button type="submit">Guardar Cambios</button>
                    </div>
                </form>
                <?php
            } else {
                echo "Usuario no encontrado.";
            }
        } else {
            echo "Falta el ID del usuario a modificar.";
        }
        ?>
    </div> 
</body>

</html>
