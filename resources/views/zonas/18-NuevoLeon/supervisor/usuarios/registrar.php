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
    </header>

    <div class="menu__side" id="menu_side">

        <div class="name__page">
            <img src="/public/assets/img/logo.png" class="img logo-image" alt="">
            <h4>Recaudo</h4>
        </div>

        <div class="options__menu">

            <a href="/resources/views/zonas/18-NuevoLeon/supervisor/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/18-NuevoLeon/supervisor/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/18-NuevoLeon/supervisor/usuarios/registrar.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/18-NuevoLeon/supervisor/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/18-NuevoLeon/supervisor/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/18-NuevoLeon/supervisor/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/18-NuevoLeon/supervisor/creditos/prestamos.php">
                <div class="option">
                    <i class="fa-solid fa-file-invoice-dollar" title=""></i>
                    <h4>Registrar Prestamos</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/18-NuevoLeon/supervisor/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/18-NuevoLeon/supervisor/ruta/lista_super.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Ruta</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/18-NuevoLeon/supervisor/abonos/abonos.php">
                <div class="option">
                    <i class="fa-solid fa-money-bill-trend-up" title=""></i>
                    <h4>Abonos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/18-NuevoLeon/supervisor/retiros/retiros.php">
                <div class="option">
                    <i class="fa-solid fa-scale-balanced" title=""></i>
                    <h4>Retiros</h4>
                </div>
            </a>



        </div>

    </div>
    
    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->
    
        <!-- Contenido principal -->
        <main>
            <h2>Registro de Usuario</h2><br>
            <form action="/controllers/super/validar_registro.php" method="post">
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
                    <label for="zona">Zona:</label>
                    <select id="zona" name="zona" required>
                        <?php
                        // Incluye el archivo de conexión a la base de datos
                        include("../../../../../../controllers/conexion.php");
                        // Consulta SQL para obtener las zonas
                        $consultaZonas = "SELECT ID, Nombre FROM zonas WHERE Nombre = 'Aguascalientes'";
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
                        $consultaRoles = "SELECT ID, Nombre FROM Roles WHERE ID = 3";
                        $resultRoles = mysqli_query($conexion, $consultaRoles);
                        // Genera las opciones del menú desplegable para Rol
                        while ($row = mysqli_fetch_assoc($resultRoles)) {
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
