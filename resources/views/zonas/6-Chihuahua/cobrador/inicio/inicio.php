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


// Incluye el archivo de conexión
include("../../../../../../controllers/conexion.php");

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

date_default_timezone_set('America/Bogota');

// Ruta a permisos 
include("../../../../../..//controllers/verificar_permisos.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://kit.fontawesome.com/9454e88444.js" crossorigin="anonymous"></script>
    <title>Recaudo</title>
    <link rel="stylesheet" href="/public/assets/css/inicio.css">
</head>

<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>
        <div class="nombre-usuario">
            <?php
            if (isset($_SESSION["nombre_usuario"])) {
                echo htmlspecialchars($_SESSION["nombre_usuario"]) . "<br>" . "<span> Cobrador<span>";
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

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/inicio/inicio.php" class="selected">
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

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/ruta/ruta.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Ruta</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/cartera/lista_cartera.php">
                <div class="option">
                    <i class="fa-regular fa-address-book"></i>
                    <h4>Cobros</h4>
                </div>
            </a>





        </div>

    </div>

    <main>
        <h1>Inicio cobrador de Chihuahua</h1>
        <div class="cuadros-container">


            <!-- TRAER EL PRIMER ID -->
            <?php
            function obtenerOrdenClientes()
            {
                $rutaArchivo = 'cartulina/orden_clientes.txt'; // Asegúrate de que esta ruta sea correcta
                if (file_exists($rutaArchivo)) {
                    $contenido = file_get_contents($rutaArchivo);
                    return explode(',', $contenido);
                }
                return [];
            }

            function obtenerPrimerID($conexion)
            {
                $fecha_actual = date("Y-m-d");
                $ordenClientes = obtenerOrdenClientes();
                $primer_id = 0;

                $idEncontrado = 0;

                foreach ($ordenClientes as $idCliente) {
                    // Consulta para verificar si este cliente ha pagado hoy
                    $sql = "SELECT c.ID
        FROM clientes c
        LEFT JOIN historial_pagos hp ON c.ID = hp.IDCliente AND hp.FechaPago = ?
        WHERE c.ID = ? AND c.ZonaAsignada = 'Chihuahua' AND hp.ID IS NULL
        LIMIT 1";

                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param("si", $fecha_actual, $idCliente);
                    $stmt->execute();
                    $stmt->bind_result($idEncontrado);
                    if ($stmt->fetch()) {
                        $primer_id = $idEncontrado;
                        $stmt->close();
                        break;
                    }
                    $stmt->close();
                }

                return $primer_id;
            }

            // Obtener el primer ID de cliente que no ha pagado hoy y está primero en el orden personalizado
            $primer_id = obtenerPrimerID($conexion);

            ?>
            <?php if ($tiene_permiso_abonos) : ?>
                <div class="cuadro cuadro-2">
                    <div class="cuadro-1-1">
                        <a href="/resources/views/zonas/6-Chihuahua/cobrador/inicio/cartulina/perfil_abonos.php?id=<?= $primer_id ?>" class="titulo">Abonos</a>
                        <p>Version beta</p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($tiene_permiso_prest_cancelados) : ?>
            <div class="cuadro cuadro-2">
                <div class="cuadro-1-1">
                    <a href="/resources/views/zonas/6-Chihuahua/cobrador/inicio/Pcancelados/pcancelados.php" class="titulo">Prest Cancelados </a>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($tiene_permiso_ver_filtros) : ?>
                <div class="cuadro cuadro-2">
                    <div class="cuadro-1-1">
                        <a href="/resources/views/zonas/6-Chihuahua/cobrador/inicio/prestadia/prestamos_del_dia.php" class="titulo">Filtros</a>
                        <p>Version beta</p>
                    </div>
                </div>
            <?php endif; ?>


        </div>
    </main>


    <script src="/public/assets/js/MenuLate.js"></script>
</body>

</html>