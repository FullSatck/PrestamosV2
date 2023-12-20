<?php
session_start();
include("../../../../../../controllers/conexion.php");

// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
    exit();
}

include "../../../../../../controllers/conexion.php";

$usuario_id = $_SESSION["usuario_id"];

$sql_nombre = "SELECT nombre FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql_nombre);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
if ($fila = $resultado->fetch_assoc()) {
    $_SESSION["nombre_usuario"] = $fila["nombre"];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>

    <link rel="stylesheet" href="/public/assets/css/registrar_usuarios.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body id="body"> 

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>

        <div class="nombre-usuario">
            <?php
        if (isset($_SESSION["nombre_usuario"])) {
            echo htmlspecialchars($_SESSION["nombre_usuario"])."<br>" . "<span> Supervisor<span>";
        }
        ?>
        </div>
    </header>

    <div class="menu__side" id="menu_side">

        <div class="name__page">
            <img src="/public/assets/img/logo.png" class="img logo-image" alt="">
            <h4>Recaudo</h4>
        </div>

        <div class="options__menu">

        <a href="/controllers/cerrar_sesion.php">
                <div class="option">
                    <i class="fa-solid fa-right-to-bracket fa-rotate-180"></i>
                    <h4>Cerrar Sesion</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/20-Puebla/supervisor/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/20-Puebla/supervisor/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/20-Puebla/supervisor/usuarios/registrar.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/20-Puebla/supervisor/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/20-Puebla/supervisor/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/20-Puebla/supervisor/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>  

            <a href="/resources/views/zonas/20-Puebla/supervisor/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/20-Puebla/supervisor/ruta/lista_super.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Enrutada</h4>
                </div>
            </a>
        </div>

    </div>
    
    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->
    
        <!-- Contenido principal -->
        <main>
            <h2>Registro de Usuario</h2><br>
            <form action="/controllers/super/validar_registro/validar_registro-20.php" method="post">
                <div class="input-container">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Por favor ingrese su nombre" required>
                </div>
                <div class="input-container">
                    <label for "apellido">Apellido:</label>
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
                    <label for="zona">Estado:</label>
                    <select id="zona" name="zona" required>
                        <?php
                        // Incluye el archivo de conexión a la base de datos
                        include("../../../../../../controllers/conexion.php");
                        // Consulta SQL para obtener las zonas
                        $consultaZonas = "SELECT ID, Nombre FROM zonas WHERE Nombre = 'Puebla'";
                        $resultZonas = mysqli_query($conexion, $consultaZonas);
                        // Genera las opciones del menú desplegable para Zona
                        while ($row = mysqli_fetch_assoc($resultZonas)) {
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
                        $consultaRoles = "SELECT iD, nombre FROM roles WHERE iD = 3";
                        $resultRoles = mysqli_query($conexion, $consultaRoles);
                        // Genera las opciones del menú desplegable para Rol
                        while ($row = mysqli_fetch_assoc($resultRoles)) {
                            echo '<option value="' . $row['iD'] . '">' . $row['nombre'] . '</option>';
                        }
                        ?>
                    </select>
                </div> 

                <div class="btn-container">
                    <button type="submit" name="registrar_usuario">Registrar</button>
                </div>
            </form>
        </main>

   

    <script>
   $(document).ready(function() {
    $("#saldo-inicial-container").show(); // Muestra siempre el campo de saldo inicial
});
    </script>

<script src="/public/assets/js/MenuLate.js"></script>


</body>

</html>
