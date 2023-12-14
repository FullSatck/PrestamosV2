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
            echo htmlspecialchars($_SESSION["nombre_usuario"])."<br>" . "<span> Cobrador<span>";
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

            <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/inicio/inicio.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>



            <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/creditos/prestamos.php">
                <div class="option">
                    <i class="fa-solid fa-file-invoice-dollar" title=""></i>
                    <h4>Registrar Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/ruta/ruta.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Enrutada</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/cartera/lista_cartera.php">
                <div class="option">
                    <i class="fa-regular fa-address-book"></i>
                    <h4>Cobros</h4>
                </div>
            </a> 

        </div>

    </div>

    <main>
        <h1>Inicio cobrador de Puebla</h1>
        <div class="cuadros-container">
            <div class="cuadro cuadro-1">
                <div class="cuadro-1-1">
                    <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/inicio/cobro_inicio.php"
                        class="titulo">Prestamos</a><br>
                    <p>Mantenimiento
                    </p>
                </div>
            </div>

            <!-- TRAER EL PRIMER ID -->

            <?php 
            function obtenerPrimerID($conexion) {
                $primer_id = 0;

                // Consulta para obtener el primer ID de préstamo
                $sql_primer_id = "SELECT ID
                                  FROM clientes
                                  ORDER BY ID ASC
                                  LIMIT 1";

               $stmt_primer_id = $conexion->prepare($sql_primer_id);
                $stmt_primer_id->execute();
                $stmt_primer_id->bind_result($primer_id);
                $stmt_primer_id->fetch();
                $stmt_primer_id->close();

                return $primer_id;
            }

            // Obtener el primer ID de préstamo de la base de datos
            $primer_id = obtenerPrimerID($conexion);
            ?>


            <div class="cuadro cuadro-2">
                <div class="cuadro-1-1">
                    <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/inicio/cartulina/perfil_abonos.php?id=<?= $primer_id ?>" class="titulo">Abonos</a>
                    <p>Version beta</p>
                </div>
            </div>  

            <div class="cuadro cuadro-2">
                <div class="cuadro-1-1">
                      <a href="/resources/views/zonas/22-QuintanaRoo/cobrador/inicio/prestadia/prestamos_del_dia.php" class="titulo">Prestamos del dia </a>
                    <p>Version beta</p>
                </div>
            </div>

            <div class="cuadro cuadro-4">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/inicio/comision_inicio.php" class="titulo">Comision</a><br>
                    <p>Mantenimiento
                    </p>
                </div>
            </div>
        </div>
    </main>


    <script src="/public/assets/js/MenuLate.js"></script>
</body>

</html>