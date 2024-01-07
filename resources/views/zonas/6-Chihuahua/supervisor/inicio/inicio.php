<?php
session_start();
date_default_timezone_set('America/Bogota');

// Validacion de rol para ingresar a la pagina 
require_once '../../../../../../controllers/conexion.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../../index.php");
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
        header("Location: /resource/views/zonas/6-chihuahua/inicio/inicio.php");
        exit();
    }

    // Extrae el nombre del rol del resultado
    $rol_usuario = $fila['Nombre'];

    // Verifica si el rol del usuario corresponde al necesario para esta página
    if ($rol_usuario !== 'supervisor') {
        // El usuario no tiene el rol correcto, redirige a la página de error o de inicio
        header("Location: /resource/views/zonas/6-chihuahua/inicio/inicio.php");
        exit();
    }
}



// verificancion de permisos 
include("../../../../../../controllers/verificar_permisos.php");
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

            <a href="/resources/views/zonas/6-Chihuahua/supervisor/inicio/inicio.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/supervisor/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/supervisor/usuarios/registrar.php">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/supervisor/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/supervisor/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/supervisor/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/supervisor/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/supervisor/ruta/ruta.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Enrutar</h4>
                </div>
            </a>
        </div>

    </div>

    <main>
        <h1>Inicio Supervisor</h1>
        <div class="cuadros-container">


            <?php
            function obtenerPrimerID($conexion)
            {
                $primer_id = 0;

                // Consulta para obtener el primer ID de cliente con ZonaAsignada 'Quintana Roo'
                $sql_primer_id = "SELECT ID
                      FROM clientes
                      WHERE ZonaAsignada = 'Chihuahua'
                      ORDER BY ID ASC
                      LIMIT 1";

                $stmt_primer_id = $conexion->prepare($sql_primer_id);
                $stmt_primer_id->execute();
                $stmt_primer_id->bind_result($primer_id);
                $stmt_primer_id->fetch();
                $stmt_primer_id->close();

                return $primer_id;
            }

            // Obtener el primer ID de cliente de la base de datos
            $primer_id = obtenerPrimerID($conexion);
            ?>
            <?php if ($tiene_permiso_abonos) : ?>
                <div class="cuadro cuadro-2">
                    <div class="cuadro-1-1">
                        <a href="/resources/views/zonas/6-Chihuahua/supervisor/inicio/cartulina/perfil_abonos.php?id=<?= $primer_id ?>" class="titulo">Abonos</a>
                        <p>Version beta</p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($tiene_permiso_prest_cancelados) : ?>
            <div class="cuadro cuadro-2">
                <div class="cuadro-1-1">
                    <a href="/resources/views/zonas/6-Chihuahua/supervisor/inicio/Pcancelados/pcancelados.php" class="titulo">Prest Cancelados </a>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($tiene_permiso_ver_filtros) : ?>
            <div class="cuadro cuadro-4">
                <div class="cuadro-1-1">
                    <a href="/resources/views/zonas/6-Chihuahua/supervisor/inicio/prestadia/prestamos_del_dia.php" class="titulo">Filtros</a><br>
                    <p>Version beta</p>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($tiene_permiso_desatrasar) : ?>
            <div class="cuadro cuadro-4">
                <div class="cuadro-1-1">
                    <a href="/resources/views/zonas/6-Chihuahua/supervisor/desatrasar/agregar_clientes.php" class="titulo">Desatrasar</a><br>
                    <p>Version beta</p>
                </div>
            </div>
            <?php endif; ?>


    </main>


    <script src="/public/assets/js/MenuLate.js"></script>
</body>

</html>