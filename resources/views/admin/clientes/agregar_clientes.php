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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/registrar_cliente.css">
    <title>Registro de Clientes</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
                    <a href="/resources/views/admin/inicio/inicio.php">
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
                    <a href="/resources/views/admin/clientes/agregar_clientes.php" class="hola">
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
                    <a href="/controllers/cerrar_sesion.php"><span>Cerrar Sesion</span></a>
                </div>
            </div>
        </div>

    </div>


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
                <textarea id="referencias" name "referencias" rows="4"></textarea>
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

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="/menu/main.js"></script>
    <script src="/public/assets/js/mensaje.js"></script>

</body>

</html>