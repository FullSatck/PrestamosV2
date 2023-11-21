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


// Incluye la configuración de conexión a la base de datos
include "../../../../../../controllers/conexion.php";

// Definir variables e inicializar con valores vacíos
$id_zona = $fecha = $descripcion = $valor = "";
$id_zona_err = $fecha_err = $descripcion_err = $valor_err = "";

// Procesar datos del formulario cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar la ID de Zona
    if (empty(trim($_POST["id_zona"]))) {
        $id_zona_err = "Por favor, seleccione una zona.";
    } else {
        $id_zona = trim($_POST["id_zona"]);
    }

    // Validar la fecha
    $input_fecha = trim($_POST["fecha"]);
    if (empty($input_fecha)) {
        $fecha_err = "Por favor, ingrese la fecha.";
    } else {
        // Convertir la fecha al formato 'YYYY-MM-DD'
        $fecha = date('Y-m-d', strtotime($input_fecha));
    }

    // Validar la descripción
    if (empty(trim($_POST["descripcion"]))) {
        $descripcion_err = "Por favor, ingrese una descripción.";
    } else {
        $descripcion = trim($_POST["descripcion"]);
    }

    // Validar el valor
    if (empty(trim($_POST["valor"]))) {
        $valor_err = "Por favor, ingrese el valor del gasto.";
    } else {
        $valor = trim($_POST["valor"]);
    }

    // Verificar si no hay errores de validación antes de insertar en la base de datos
    if (empty($id_zona_err) && empty($descripcion_err) && empty($valor_err)) {
        // Preparar la declaración de inserción
        $sql = "INSERT INTO gastos (iDZona, fecha, descripcion, valor) VALUES (?, ?, ?, ?)";

        if ($stmt = $conexion->prepare($sql)) {
            // Vincular las variables a la declaración preparada como parámetros
            $stmt->bind_param("sssd", $param_id_zona, $param_fecha, $param_descripcion, $param_valor);

            // Establecer los parámetros
            $param_id_zona = $id_zona;
            $param_fecha = $fecha; // Fecha formateada correctamente
            $param_descripcion = $descripcion;
            $param_valor = $valor;

            // Intentar ejecutar la declaración preparada
            if ($stmt->execute()) {
                // Redirigir a la lista de gastos después de agregar uno nuevo
                header("location: gastos.php");
                exit();
            } else {
                echo "Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
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
    <link rel="stylesheet" href="/public/assets/css/agregar_gasto.css">
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

        <a href="/resources/views/zonas/6-Chihuahua/cobrador/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/usuarios/registrar.php">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
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

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/gastos/gastos.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/ruta/ruta.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Enrutar</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/cartera/lista_cartera.php">
                <div class="option">
                    <i class="fa-regular fa-address-book"></i>
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
        <h1 class="h11">Agregar Gasto</h1>

        <div id="mensaje">
            <?php
            if (isset($_GET['mensaje'])) {
                echo htmlspecialchars($_GET['mensaje']);
            }
            ?>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="id_zona">Zona:</label>
                <select name="id_zona" id="id_zona" class="zona">
                    <option value="" <?php echo (!empty($id_zona_err)) ? 'selected' : ''; ?>>Seleccionar Zona</option>
                    <!-- Aquí deberías cargar las opciones de zona desde tu base de datos -->
                    <?php
                $sql_zonas = "SELECT * FROM zonas WHERE nombre = 'Chihuahua'";
                $result_zonas = $conexion->query($sql_zonas);

                if ($result_zonas->num_rows > 0) {
                    while ($row = $result_zonas->fetch_assoc()) {
                        $selected = ($id_zona == $row['ID']) ? 'selected' : '';
                        echo "<option value='" . $row['ID'] . "' $selected>" . $row['Nombre'] . "</option>";
                    }
                }
                ?>
                </select>
                <span class="help-block"><?php echo $id_zona_err; ?></span>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo $fecha; ?>">
                <span class="help-block"><?php echo $fecha_err; ?></span>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control"
                    value="<?php echo $descripcion; ?>">
                <span class="help-block"><?php echo $descripcion_err; ?></span>
            </div>
            <div class="form-group">
                <label for="valor">Valor:</label>
                <input type="number" name="valor" id="valor" class="form-control" value="<?php echo $valor; ?>">
                <span class="help-block"><?php echo $valor_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Agregar Gasto">
                <a href="gastos.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </main>

    <script src="/public/assets/js/MenuLate.js"></script>

</body>

</html>