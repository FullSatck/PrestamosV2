<?php
date_default_timezone_set('America/Bogota');
session_start();


// Validacion de rol para ingresar a la pagina 
require_once '../../../../controllers/conexion.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
    exit();
} else {
    // El usuario está autenticado, obtén el ID del usuario de la sesión
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
    if ($rol_usuario !== 'admin') {
        // El usuario no tiene el rol correcto, redirige a la página de error o de inicio
        header("Location: /ruta_a_pagina_de_error_o_inicio.php");
        exit();
    }
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

    <!-- ACA VA EL CONTENIDO DEL MENU -->


    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>

        <div class="nombre-usuario">
            <?php
            if (isset($_SESSION["nombre_usuario"])) {
                echo htmlspecialchars($_SESSION["nombre_usuario"]) . "<br>" . "<span> Administrator<span>";
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

            <a href="/resources/views/admin/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a> 

            <a href="/resources/views/admin/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/admin/usuarios/registrar.php">
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

            <a href="/resources/views/admin/clientes/agregar_clientes.php" class="selected">
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
            <a href="/resources/views/admin/cobros/cobros.php">
                <div class="option">
                    <i class="fa-solid fa-arrow-right-to-city" title=""></i>
                    <h4>Zonas de cobro</h4>
                </div>
            </a>

            <a href="/resources/views/admin/gastos/gastos.php">
                <div class="option">
                    <i class="fa-regular fa-address-book"></i>
                    <h4>Gastos</h4>
                </div>
            </a> 

            <a href="/resources/views/admin/retiros/retiros.php">
                <div class="option">
                    <i class="fa-solid fa-scale-balanced" title=""></i>
                    <h4>Retiros</h4>
                </div>
            </a>

            <a href="/resources/views/admin/cartera/lista_cartera.php">
                <div class="option">
                <i class="fa-solid fa-basket-shopping"></i> 
                    <h4>Cobros</h4>
                </div>
            </a>

        </div>

    </div>

    <main>

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
                    $consultaZonas = "SELECT ID, Nombre FROM zonas WHERE Nombre IN ('Puebla', 'Chihuahua', 'Quintana Roo','Tlaxcala')";
                    $resultZonas = mysqli_query($conexion, $consultaZonas);

                    // Inicializa un arreglo para almacenar las opciones
                    $zonasOptions = array();

                    // Genera las opciones del menú desplegable para Zona y almacénalas en el arreglo
                    while ($row = mysqli_fetch_assoc($resultZonas)) {
                        $zonasOptions[] = $row;
                    }

                    // Ordena el arreglo para que "Puebla" aparezca primero
                    usort($zonasOptions, function ($a, $b) {
                        if ($a['Nombre'] == 'Puebla') {
                            return -1;
                        } elseif ($b['Nombre'] == 'Puebla') {
                            return 1;
                        } else {
                            return strcmp($a['Nombre'], $b['Nombre']);
                        }
                    });

                    // Genera las opciones del menú desplegable en el orden actualizado
                    foreach ($zonasOptions as $option) {
                        echo '<option value="' . $option['ID'] . '">' . $option['Nombre'] . '</option>';
                    }
                    ?>
                </select>

            </div>

            <div class="input-container">
                <label for="ciudad">Ciudad:</label>
                <select id="ciudad" name="ciudad">
                    <?php
                    // Incluye el archivo de conexión a la base de datos
                    include("../../../../controllers/conexion.php");
                    // Consulta SQL para obtener las zonas
                    $consultaZonas = "SELECT * FROM ciudades";
                    $resultZonas = mysqli_query($conexion, $consultaZonas);
                    // Genera las opciones del menú desplegable para Zona
                    while ($row = mysqli_fetch_assoc($resultZonas)) {
                        echo '<option value="' . $row['ID'] . '">' . $row['Nombre'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="input-container">
                <label for="asentamiento">Asentamiento:</label>
                <input type="text" id="asentamiento" name="asentamiento" required>
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
                <input id="boton-registrar" class="btn-container" type="submit" value="Registrar">
            </div>
        </form>


    </main>

    <script>
        document.getElementById('zona').addEventListener('change', function() {
            var IDZona = this.value;
            var ciudadSelect = document.getElementById('ciudad');

            // Clear existing options
            ciudadSelect.innerHTML = '';

            if (IDZona) {
                // AJAX request to fetch cities
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'fetch_cities.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (this.status === 200) {
                        var cities = JSON.parse(this.responseText);
                        cities.forEach(function(city) {
                            var option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.nombre;
                            ciudadSelect.appendChild(option);
                        });
                    }
                };
                xhr.send('IDZona=' + IDZona);
            }
        });
    </script>


    <script>
        function verificarCliente() {
            const curp = document.getElementById("curp").value;
            const telefono = document.getElementById("telefono").value;
            const mensajeEmergente = document.getElementById("mensaje-emergente");
            const mensajeError = document.getElementById("mensaje-error");
            const enlacePerfil = document.getElementById("enlace-perfil");
            const botonRegistrar = document.getElementById("boton-registrar");

            if (curp || telefono) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "/controllers/verificar_cliente.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const respuesta = JSON.parse(xhr.responseText);

                        if (respuesta.existe) {
                            mensajeEmergente.style.display = "block";
                            mensajeError.textContent = "Este cliente ya existe. No se puede registrar.";
                            enlacePerfil.href = "../../../../controllers/perfil_cliente.php?id=" + respuesta.cliente_id;
                            botonRegistrar.style.display = "none"; // Ocultar el botón
                        } else {
                            mensajeEmergente.style.display = "none";
                            enlacePerfil.href = "";
                            botonRegistrar.style.display = "block"; // Mostrar el botón
                        }
                    }
                };

                xhr.send("curp=" + encodeURIComponent(curp) + "&telefono=" + encodeURIComponent(telefono));
            } else {
                mensajeEmergente.style.display = "none";
                enlacePerfil.href = "";
                botonRegistrar.style.display = "block"; // Mostrar el botón si ambos campos están vacíos
            }
        }

        document.getElementById("curp").addEventListener("input", verificarCliente);
        document.getElementById("telefono").addEventListener("input", verificarCliente);
    </script>


    <script src="/public/assets/js/MenuLate.js"></script>


    <script src="/public/assets/js/mensaje.js"></script>

</body>

</html>