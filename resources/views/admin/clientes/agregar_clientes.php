<?php
session_start();

// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
    exit();
}


// El usuario ha iniciado sesión, mostrar el contenido de la página aquí
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Clientes</title>
    <link rel="stylesheet" href="/public/assets/css/registrar_cliente.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
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

            <a href="/resources/views/admin/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href=" /resources/views/admin/admin_saldo/saldo_admin.php">
                <div class="option">
                    <i class="fa-solid fa-sack-dollar" title=""></i>
                    <h4>Saldo Incial</h4>
                </div>
            </a>

            <a href="/resources/views/admin/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/admin/usuarios/registrar.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/admin/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/admin/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>
            <a href="/resources/views/admin/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>
            <a href="/resources/views/admin/creditos/prestamos.php">
                <div class="option">
                    <i class="fa-solid fa-file-invoice-dollar" title=""></i>
                    <h4>Registrar Prestamos</h4>
                </div>
            </a>
            <a href="/resources/views/admin/cobros/cobros.php">
                <div class="option">
                    <i class="fa-solid fa-arrow-right-to-city" title=""></i>
                    <h4>Zonas de cobro</h4>
                </div>
            </a>

            <a href="/resources/views/admin/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/admin/ruta/lista_super.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Ruta</h4>
                </div>
            </a>

            <a href="/resources/views/admin/abonos/abonos.php">
                <div class="option">
                    <i class="fa-solid fa-money-bill-trend-up" title=""></i>
                    <h4>Abonos</h4>
                </div>
            </a>
            <a href="/resources/views/admin/retiros/retiros.php">
                <div class="option">
                    <i class="fa-solid fa-scale-balanced" title=""></i>
                    <h4>Retiros</h4>
                </div>
            </a>

        </div>

    </div>
    <script src="/public/assets/js/MenuLate.js"></script>


    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>
        <div id="mensaje-emergente" style="display: none;">
            <p id="mensaje-error">Este cliente ya existe. No se puede registrar.</p>
            <a href="" id="enlace-perfil">Ir al perfil</a>
        </div>

        <h1>Registro de Clientes</h1>
        <form action="/controllers/validar_clientes.php" method="POST" enctype="multipart/form-data">
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
                <label for="historial">Historial Crediticio:</label>
                <textarea id="historial" name="historial" rows="4"></textarea>
            </div>

            <div class="input-container">
                <label for="referencias">Referencias Personales:</label>
                <textarea id="referencias" name="referencias" rows="4"></textarea>
            </div>

            <div class="input-container">
                <label for="moneda">Moneda Preferida:</label>
                <select id="moneda" name="moneda">
                    <?php
                require_once("../../../../controllers/conexion.php");

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
                <label for="zona">Zona:</label>
                <select id="zona" name="zona" placeholder="Por favor ingrese la zona" required>
                    <?php
                // Incluye el archivo de conexión a la base de datos
                include("../../../../controllers/conexion.php");
                // Consulta SQL para obtener las zonas
                $consultaZonas = "SELECT ID, Nombre FROM Zonas";
                $resultZonas = mysqli_query($conexion, $consultaZonas);
                // Genera las opciones del menú desplegable para Zona
                while ($row = mysqli_fetch_assoc($resultZonas)) {
                    echo '<option value="' . $row['ID'] . '">' . $row['Nombre'] . '</option>';
                }
                ?>
                </select>
            </div>

            <div class="input-container">
                <label for="imagen">Imagen del Cliente:</label>
                <input type="file" id="imagen" name="imagen">
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
                        enlacePerfil.href = "../../../../controllers/perfil_cliente.php?id=" + respuesta.cliente_id;
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

   
    <script src="/public/assets/js/mensaje.js"></script>

</body>

</html>