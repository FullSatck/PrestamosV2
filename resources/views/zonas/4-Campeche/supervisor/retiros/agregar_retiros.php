<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../../../index.php");
    exit();
}

// Incluye la configuración de conexión a la base de datos
include "../../../../../../controllers/conexion.php";

// Definir variables e inicializar con valores vacíos
$fecha = $monto = $descripcion = "";
$fecha_err = $monto_err = $descripcion_err = "";

// Procesar datos del formulario cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar la fecha
    $input_fecha = trim($_POST["fecha"]);
    if (empty($input_fecha)) {
        $fecha_err = "Por favor, ingrese la fecha.";
    } else {
        $fecha = date('Y-m-d H:i:s', strtotime($input_fecha));
    }

    // Validar el monto
    if (empty(trim($_POST["monto"]))) {
        $monto_err = "Por favor, ingrese el monto del retiro.";
    } elseif (!is_numeric($_POST["monto"])) {
        $monto_err = "Por favor, ingrese un valor numérico.";
    } else {
        $monto = trim($_POST["monto"]);
    }

    // Validar la descripción
    if (empty(trim($_POST["descripcion"]))) {
        $descripcion_err = "Por favor, ingrese una descripción.";
    } else {
        $descripcion = trim($_POST["descripcion"]);
    }

    // Verificar si no hay errores de validación antes de insertar en la base de datos
    if (empty($fecha_err) && empty($monto_err) && empty($descripcion_err)) {
        // Preparar la declaración de inserción
        $sql = "INSERT INTO Retiros (IDUsuario, Fecha, Monto, Descripcion) VALUES (?, ?, ?, ?)";

        if ($stmt = $conexion->prepare($sql)) {
            // Vincular las variables a la declaración preparada como parámetros
            $stmt->bind_param("isds", $_SESSION["usuario_id"], $fecha, $monto, $descripcion);

            // Intentar ejecutar la declaración preparada
            if ($stmt->execute()) {
                // Redirigir a la lista de retiros después de agregar uno nuevo
                header("location: retiros.php");
                exit();
            } else {
                echo "Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
            }

            // Cerrar la declaración
            $stmt->close();
        }
    }

    // Cerrar la conexión
    $conexion->close();
}
?>



 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/agregar_retiro.css">
    <title>Lista de Gastos</title>
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

        <a href="/resources/views/zonas/4-Campeche/supervisor/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/4-Campeche/supervisor/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/4-Campeche/supervisor/usuarios/registrar.php">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/4-Campeche/supervisor/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/4-Campeche/supervisor/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/4-Campeche/supervisor/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/4-Campeche/supervisor/creditos/prestamos.php">
                <div class="option">
                    <i class="fa-solid fa-file-invoice-dollar" title=""></i>
                    <h4>Registrar Prestamos</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/4-Campeche/supervisor/gastos/gastos.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/4-Campeche/supervisor/ruta/lista_super.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Ruta</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/4-Campeche/supervisor/abonos/abonos.php">
                <div class="option">
                    <i class="fa-solid fa-money-bill-trend-up" title=""></i>
                    <h4>Abonos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/4-Campeche/supervisor/retiros/retiros.php">
                <div class="option">
                    <i class="fa-solid fa-scale-balanced" title=""></i>
                    <h4>Retiros</h4>
                </div>
            </a>



        </div>

    </div>


    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main class="main2">
        <h1 class="h11">Agregar Retiro</h1>

        <div id="mensaje">
            <?php
            if (isset($_GET['mensaje'])) {
                echo htmlspecialchars($_GET['mensaje']);
            }
            ?>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="datetime-local" name="fecha" id="fecha" class="form-control" value="<?php echo $fecha; ?>">
                <span class="help-block"><?php echo $fecha_err; ?></span>
            </div>
            <div class="form-group">
                <label for="monto">Monto:</label>
                <input type="text" name="monto" id="monto" class="form-control" value="<?php echo $monto; ?>">
                <span class="help-block"><?php echo $monto_err; ?></span>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" class="form-control"><?php echo $descripcion; ?></textarea>
                <span class="help-block"><?php echo $descripcion_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Agregar Retiro">
                <a href="retiros.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </main>

    <script src="/public/assets/js/MenuLate.js"></script>

</body>

</html>