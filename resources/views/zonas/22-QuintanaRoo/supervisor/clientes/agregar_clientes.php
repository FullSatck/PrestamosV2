<?php
session_start();

// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../../../index.php");
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

// El usuario ha iniciado sesión, mostrar el contenido de la página aquí
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://kit.fontawesome.com/9454e88444.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/public/assets/css/registrar_cliente.css">
    <title>Registro de Clientes</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>
        <div class="nombre-usuario">
            <?php
            if (isset($_SESSION["nombre_usuario"])) {
                echo htmlspecialchars($_SESSION["nombre_usuario"]) . "<br>" . "<span> Supervisor<span>";
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

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/usuarios/registrar.php">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/clientes/agregar_clientes.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/ruta/lista_super.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Enrutar</h4>
                </div>
            </a>
        </div>

    </div>


    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>

        <h1>Registro de Clientes</h1>
        <form action="/controllers/super/validar_clientes/validar_clientes22.php" method="POST" enctype="multipart/form-data">
            <div class="input-container">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="input-container">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
            </div>

            <div class="input-container">
                <label for="curp">Identificación CURP:</label>
                <input type="text" id="curp" name="curp" required>
            </div>

            <div class="input-container">
                <label for="domicilio">Domicilio:</label>
                <input type="text" id="domicilio" name="domicilio" required>
            </div>

            <div class="input-container">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" required>
            </div>



            <div class="input-container">
                <label for="moneda">Moneda Preferida:</label>
                <select id="moneda" name="moneda">
                    <?php
                    require_once("../../../../../../controllers/conexion.php");

                    $query = "SELECT * FROM monedas";
                    $result = mysqli_query($conexion, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['ID'] . "'>" . $row['Nombre'] . "</option>";
                    }

                    mysqli_close($conexion);
                    ?>
                </select>
            </div>

            <div class="input-container">
                <label for="zona">Estado:</label>
                <select id="zona" name="zona" placeholder="Por favor ingrese la zona" required>
                    <?php
                    // Incluye el archivo de conexión a la base de datos
                    include("../../../../../../controllers/conexion.php");
                    // Consulta SQL para obtener las zonas
                    $consultaZonas = "SELECT iD, nombre FROM zonas WHERE nombre = 'Quintana Roo'";
                    $resultZonas = mysqli_query($conexion, $consultaZonas);
                    // Genera las opciones del menú desplegable para Zona
                    while ($row = mysqli_fetch_assoc($resultZonas)) {
                        echo '<option value="' . $row['iD'] . '">' . $row['nombre'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="input-container">
                <label for="ciudad">Municipio:</label>
                <select id="ciudad" name="ciudad" required>
                    <?php
                    // Incluye el archivo de conexión a la base de datos
                    include("../../../../../../controllers/conexion.php");
                    // Consulta SQL para obtener las zonas
                    $consultaZonas = "SELECT * FROM ciudades WHERE iDZona = 22";
                    $resultZonas = mysqli_query($conexion, $consultaZonas);
                    // Genera las opciones del menú desplegable para Zona
                    while ($row = mysqli_fetch_assoc($resultZonas)) {
                        echo '<option value="' . $row['ID'] . '">' . $row['Nombre'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="input-container">
                <label for="asentamiento">Colonia:</label>
                <input type="text" id="asentamiento" name="asentamiento" placeholder="Por favor ingrese el asentamiento" required>
            </div>

            <div class="input-container">
                <label for="imagen">Imagen del Cliente:</label>
                <input type="file" id="imagen" name="imagen">
            </div>

            <div id="mensaje-emergente" style="display: none;">
                <p id="mensaje-error">Este cliente ya existe. No se puede registrar.</p>
                <a href="" id="enlace-perfil">Ir al perfil</a>
            </div>

            <div class="btn-container">
                <input class="btn-container" type="submit" value="Registrar">
            </div>
        </form>


    </main>

    <script>
        document.getElementById("curp").addEventListener("input", function() {
            const curp = this.value;
            const mensajeEmergente = document.getElementById("mensaje-emergente");
            const mensajeError = document.getElementById("mensaje-error");
            const enlacePerfil = document.getElementById("enlace-perfil");

            if (curp) {
                // Crear una nueva solicitud AJAX
                const xhr = new XMLHttpRequest();

                // Definir el método y la URL del archivo PHP
                xhr.open("POST", "/controllers/verificar_cliente.php", true);

                // Establecer el encabezado necesario para el envío de datos POST
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                // Definir la función de respuesta
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const respuesta = JSON.parse(xhr.responseText);

                        if (respuesta.existe) {
                            // Si el cliente ya existe, muestra un mensaje de error
                            mensajeEmergente.style.display = "block";
                            mensajeError.textContent = "Este cliente ya existe. No se puede registrar.";
                            // Configura el enlace para ir al perfil con el ID
                            enlacePerfil.href = "../../../../controllers/perfil_cliente.php?id=" + respuesta
                                .cliente_id;
                        } else {
                            // Si el cliente no existe, oculta el mensaje de error y restablece el enlace
                            mensajeEmergente.style.display = "none";
                            enlacePerfil.href = "";
                        }
                    }
                };

                // Enviar la solicitud con el CURP como datos POST
                xhr.send("curp=" + curp);
            } else {
                // Si el campo CURP está vacío, oculta el mensaje de error y restablece el enlace
                mensajeEmergente.style.display = "none";
                enlacePerfil.href = "";
            }
        });
    </script>

    <script src="/public/assets/js/MenuLate.js"></script>
    <script src="/public/assets/js/mensaje.js"></script>

</body>

</html>