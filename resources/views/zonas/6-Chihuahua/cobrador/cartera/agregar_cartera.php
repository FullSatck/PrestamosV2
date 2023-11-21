<?php
// Archivo: agregar_cartera.php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
     // Incluye la configuración de conexión a la base de datos
 require_once '../../../../../../controllers/conexion.php'; 

    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $idZona = $_POST["zona"];

    // Preparar la consulta para insertar una nueva cartera
    $stmt = $conexion->prepare("INSERT INTO carteras (nombre, zona) VALUES (?, ?)");
    $stmt->bind_param("si", $nombre, $idZona);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a la página de la lista de carteras después de agregar exitosamente
        header("Location: lista_cartera.php");
        exit();
    } else {
        echo "Error al agregar la cartera: " . $conexion->error;
    }

    $stmt->close();
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/agregar_cartera.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <title>Agregar Cartera</title>
</head>

<body>

    <body id="body">

        <header>
            <div class="icon__menu">
                <i class="fas fa-bars" id="btn_open"></i>
            </div>
            <a href="agregar_cartera.php">
                <span>Agregar Cartera</span>
            </a>
        </header>

        <div class="menu__side" id="menu_side">

            <div class="name__page">
                <img src="/public/assets/img/logo.png" class="img logo-image" alt="">
                <h4>Recaudo</h4>
            </div>

            <div class="options__menu">

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

         

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/creditos/prestamos.php">
                <div class="option">
                    <i class="fa-solid fa-file-invoice-dollar" title=""></i>
                    <h4>Registrar Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/ruta/ruta.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Enrutada</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/cartera/lista_cartera.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Cobros</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/abonos/abonos.php">
                <div class="option">
                    <i class="fa-solid fa-money-bill-trend-up" title=""></i>
                    <h4>Abonos</h4>
                </div>
            </a>

            </div>
        </div>

 
        <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

        <main class="main2">

        <h2 class="h11">Agregar Nueva Cartera</h2>

        <form method="post" action="agregar_cartera.php">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre"><br><br>

        <label for="zona">Estado:</label>
        <select id="zona" name="zona" placeholder="Por favor ingrese la zona" required>
            <?php
                // Incluye el archivo de conexión a la base de datos
                include("../../../../../../controllers/conexion.php");
                // Consulta SQL para obtener las zonas
                $consultaZonas = "SELECT iD, nombre FROM zonas WHERE iD = 6";
                $resultZonas = mysqli_query($conexion, $consultaZonas);
                // Genera las opciones del menú desplegable para Zona
                while ($row = mysqli_fetch_assoc($resultZonas)) {
                    echo '<option value="' . $row['iD'] . '">' . $row['nombre'] . '</option>';
                }
                ?>
        </select><br><br>

        <input type="submit" value="Agregar">
    </form>
        </main>

        <script src="/public/assets/js/MenuLate.js"></script>
    </body>

    </html>

 