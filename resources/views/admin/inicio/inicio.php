<?php
date_default_timezone_set('America/Bogota');
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../../../../../index.php");
    exit();
}

// Incluye la configuración de conexión a la base de datos
require_once '../../../../controllers/conexion.php';

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

$stmt->close();

// Verifica si el resultado es nulo o si el rol del usuario no es 'admin'
if (!$fila || $fila['Nombre'] !== 'admin') {
    header("Location: /ruta_a_pagina_de_error_o_inicio.php");
    exit();
}


// Función para obtener la suma de una columna de una tabla
function obtenerSuma($conexion, $tabla, $columna)
{
    $sql = "SELECT SUM($columna) AS Total FROM $tabla";
    $resultado = mysqli_query($conexion, $sql);
    if ($resultado) {
        $fila = mysqli_fetch_assoc($resultado);
        mysqli_free_result($resultado);
        return $fila['Total'] ?? 0; // Devuelve 0 si es null
    } else {
        echo "Error en la consulta: " . mysqli_error($conexion);
        return 0;
    }
}

// Obtener los totales
$totalMonto = obtenerSuma($conexion, "prestamos", "MontoAPagar");
$totalIngresos = obtenerSuma($conexion, "historial_pagos", "MontoPagado");
$totalComisiones = obtenerSuma($conexion, "prestamos", "Comision");

// OBTENER EL TOTAL DE PRESTAMOS 
$sql_total_prestamos = "SELECT COUNT(*) AS total FROM prestamos";
$resultado = $conexion->query($sql_total_prestamos);
$fila = $resultado->fetch_assoc();
$total_prestamos = $fila['total'];

//OBTENER EL TOTAL CLIENTES 
$sql_total_clientes = "SELECT COUNT(*) AS total FROM clientes";
$resultado = $conexion->query($sql_total_clientes);
$fila = $resultado->fetch_assoc();
$total_clientes = $fila['total'];


date_default_timezone_set('America/Bogota');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Admin</title>

    <link rel="stylesheet" href="/public/assets/css/inicio.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>

</head>

<body id="body">

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

            <a href="" class="selected">
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
        <h1>Inicio Administrador</h1>
        <div class="cuadros-container">

            <div class="cuadro cuadro-2">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/desatrasar/agregar_clientes.php" class="titulo">Desatrasar</a>
                    <p>Mantenimiento</p>
                </div>
            </div>

            <div class="cuadro cuadro-2">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/inicio/prestadia/prestamos_del_dia.php" class="titulo">Filtros </a>
                    <p>Version beta v2</p>
                </div>
            </div>

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

            <div class="cuadro cuadro-2">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/inicio/cartulina/perfil_abonos.php?id=<?= $primer_id ?>" class="titulo">Abonos</a>
                    <p>Version beta</p>
                </div>
            </div>

            <div class="cuadro cuadro-2">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/creditos/crudPrestamos.php" class="titulo">List De Prestamos</a>

                    <p>Total de Préstamos: <?= $total_prestamos ?></p>
                </div>
            </div>


            <div class="cuadro cuadro-2">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/clientes/lista_clientes.php" class="titulo">List De Clientes</a>

                    <p>Total de Clientes: <?= $total_clientes ?></p>
                </div>
            </div>



            <!-- <div class="cuadro cuadro-1">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/inicio/cobro_inicio.php" class="titulo">Prestamos</a><br>
                    <p><?php echo "<strong>Total:</strong> <span class='cob'>$ " . number_format($totalMonto, 0, '.', '.') . "</span>"; ?>
                    </p>
                </div>
            </div> -->
            <div class="cuadro cuadro-3">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/inicio/recaudos/recuado_admin.php" class="titulo">Recaudos</a><br>
                    <p><?php echo "<strong>Total:</strong> <span class='ing'> $ " . number_format($totalIngresos, 0, '.', '.') . "</span>" ?>
                    </p>
                </div>
            </div>
            <div class="cuadro cuadro-2">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/contabilidad/contabilidad.php" class="titulo">Contabilidad </a>
                    <p>Version Beta v1</p>
                </div>
            </div>
            <div class="cuadro cuadro-4">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/inicio/comision_inicio.php" class="titulo">Comision</a><br>
                    <p><?php echo "<strong>Total:</strong> <span class='com'>$ " . number_format($totalComisiones, 0, '.', '.') . "</span>"; ?>
                    </p>
                </div>
            </div>

            <div class="cuadro cuadro-2">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/inicio/apagarSis/apagarSist.php" class="titulo">Apagar Sistema </a>
                </div>
            </div>

            <div class="cuadro cuadro-2">
                <div class="cuadro-1-1">
                    <a href="/controllers/ListaClavos.php" class="titulo">Lista Clavos </a>
                    <p>Mantenimiento</p>
                </div>
            </div>

            <?php
            // Incluye tu archivo de conexión a la base de datos
            include("../../../../controllers/conexion.php");

            // Consulta para verificar si la tabla saldo_admin tiene datos
            $sql = "SELECT COUNT(*) FROM saldo_admin";
            $result = $conexion->query($sql);
            $row = $result->fetch_row();
            $count = $row[0];

            // Si la tabla está vacía (count es 0), muestra el cuadro
            if ($count == 0) {
            ?>
                <div class="cuadro cuadro-2">
                    <div class="cuadro-1-1">
                        <a href="/resources/views/admin/admin_saldo/saldo_admin.php" class="titulo">Saldo inicial</a>
                    </div>
                </div>
            <?php
            }

            // Cierra la conexión a la base de datos
            $conexion->close();
            ?>






        </div>


        </div>
        </div>


    </main>




    <script src="/public/assets/js/MenuLate.js"></script>

</body>

</html>