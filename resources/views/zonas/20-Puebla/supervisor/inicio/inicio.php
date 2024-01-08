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


// Ruta de permisos
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

            <a href="/resources/views/zonas/20-Puebla/supervisor/inicio/inicio.php" class="selected">
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

            <a href="/resources/views/zonas/20-Puebla/supervisor/usuarios/registrar.php">
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

    <main>
        <h1>Inicio Supervisor</h1>
        <div class="cuadros-container">

            <!-- ULTIMO ID -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var enlaceAbonos = document.querySelector('.enlace-abonos');
                    if (enlaceAbonos) {
                        var ultimoID = localStorage.getItem('ultimoIDCliente');
                        var fechaUltimaVisita = localStorage.getItem('fechaUltimaVisita');
                        var fechaActual = new Date().toISOString().split('T')[0];

                        if (ultimoID && fechaUltimaVisita === fechaActual) {
                            enlaceAbonos.href = '/resources/views/zonas/20-Puebla/supervisor/inicio/cartulina/perfil_abonos.php?id=' + ultimoID;
                        }
                        // Si no hay un último ID o la fecha es diferente, se usa el primer ID de orden_fijo.txt
                    }
                });
            </script>

            <!-- TRAER EL PRIMER ID -->
            <?php
            function obtenerOrdenClientes()
            {
                $rutaArchivo = 'cartulina/orden_fijo.txt'; // Asegúrate de que esta ruta sea correcta
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
                            WHERE c.ID = ? AND hp.ID IS NULL
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
                        <a href="/resources/views/zonas/20-Puebla/supervisor/inicio/cartulina/perfil_abonos.php?id=<?= $primer_id ?>" class="titulo enlace-abonos">Abonos</a>
                        <p>Version beta</p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($tiene_permiso_prest_cancelados) : ?>
                <div class="cuadro cuadro-2">
                    <div class="cuadro-1-1">
                        <a href="/resources/views/zonas/20-Puebla/supervisor/inicio/Pcancelados/pcancelados.php" class="titulo">Prest Cancelados </a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($tiene_permiso_ver_filtros) : ?>
                <div class="cuadro cuadro-2">
                    <div class="cuadro-1-1">
                        <a href="/resources/views/zonas/20-Puebla/supervisor/inicio/prestadia/prestamos_del_dia.php" class="titulo">Filtros </a>
                        <p>Version beta</p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($tiene_permiso_desatrasar) : ?>
                <div class="cuadro cuadro-4">
                    <div class="cuadro-1-1">
                        <a href="/resources/views/zonas/20-Puebla/supervisor/desatrasar/agregar_clientes.php" class="titulo">Desatrasar</a><br>
                        <p>Version beta</p>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if ($tiene_permiso_comision) : ?>
                <div class="cuadro cuadro-4">
                    <div class="cuadro-1-1">
                        <a href="/resources/views/zonas/20-Puebla/supervisor/inicio/comision_inicio.php" class="titulo">Comision</a><br>
                        <p>Version beta</p>
                    </div>
                </div>

            <?php endif; ?>

            <?php if ($tiene_permiso_recaudos) : ?>
                <div class="cuadro cuadro-4">
                    <div class="cuadro-1-1">
                        <a href="/resources/views/zonas/20-Puebla/supervisor/recaudos/recuado_admin.php" class="titulo">Recaudos</a><br>
                        <p>Version beta</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>
   

    <script src="/public/assets/js/MenuLate.js"></script>
</body>

</html>