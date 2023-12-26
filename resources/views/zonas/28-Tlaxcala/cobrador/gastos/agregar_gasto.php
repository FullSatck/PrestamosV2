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

// Definir variables e inicializar con valores vacíos
$id_zona = $ciudad = $asentamiento = $fecha = $descripcion = $valor = "";
$id_zona_err = $ciudad_err = $asentamiento_err = $fecha_err = $descripcion_err = $valor_err = "";

// Procesar datos del formulario cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar la ID de Zona
    if (empty(trim($_POST["id_zona"]))) {
        $id_zona_err = "Por favor, seleccione una zona.";
    } else {
        $id_zona = trim($_POST["id_zona"]);
    }

    // Validar la ciudad
    if (empty(trim($_POST["ciudad"]))) {
        $ciudad_err = "Por favor, seleccione una ciudad.";
    } else {
        $ciudad = trim($_POST["ciudad"]);
    }

    // Validar el asentamiento
    if (empty(trim($_POST["asentamiento"]))) {
        $asentamiento_err = "Por favor, ingrese un asentamiento.";
    } else {
        $asentamiento = trim($_POST["asentamiento"]);
    }

    // Validar la fecha
    $input_fecha = trim($_POST["fecha"]);
    if (empty($input_fecha)) {
        $fecha_err = "Por favor, ingrese la fecha.";
    } else {
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
    if (empty($id_zona_err) && empty($ciudad_err) && empty($asentamiento_err) && empty($fecha_err) && empty($descripcion_err) && empty($valor_err)) {
        // Preparar la declaración de inserción
        $sql = "INSERT INTO gastos (idZona, ciudad, asentamiento, fecha, descripcion, valor) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = $conexion->prepare($sql)) {
            // Vincular las variables a la declaración preparada como parámetros
            $stmt->bind_param("issssd", $param_id_zona, $param_ciudad, $param_asentamiento, $param_fecha, $param_descripcion, $param_valor);

            // Establecer los parámetros
            $param_id_zona = $id_zona;
            $param_ciudad = $ciudad;
            $param_asentamiento = $asentamiento;
            $param_fecha = $fecha;
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

            <a href="/resources/views/zonas/28-Tlaxcala/cobrador/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/28-Tlaxcala/cobrador/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/28-Tlaxcala/cobrador/usuarios/registrar.php">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/28-Tlaxcala/cobrador/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/28-Tlaxcala/cobrador/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/28-Tlaxcala/cobrador/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/28-Tlaxcala/cobrador/gastos/gastos.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/28-Tlaxcala/cobrador/ruta/ruta.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Enrutar</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/28-Tlaxcala/cobrador/cartera/lista_cartera.php">
                <div class="option">
                    <i class="fa-regular fa-address-book"></i>
                    <h4>Cobros</h4>
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
                <label for="id_zona">Estado:</label>
                <select name="id_zona" id="id_zona" class="zona">
                    <option value="" <?php echo (!empty($id_zona_err)) ? 'selected' : ''; ?>>Seleccionar Estado</option>
                    <!-- Aquí deberías cargar las opciones de zona desde tu base de datos -->
                    <?php
                $sql_zonas = "SELECT * FROM zonas WHERE nombre = 'Quintana Roo'";
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

            <div class="input-container">
                <label for="ciudad">Municipio:</label>
                <select id="ciudad" name="ciudad" class="zona" required>
                    <option value="">Seleccionar Municipio</option>
                    <?php
    $consultaCiudades = "SELECT Nombre FROM ciudades WHERE IDZona = 22";
    $resultadoCiudades = mysqli_query($conexion, $consultaCiudades);
    while ($fila = mysqli_fetch_assoc($resultadoCiudades)) {
        echo '<option value="' . $fila['Nombre'] . '">' . $fila['Nombre'] . '</option>';
    }
    ?>
                </select>

            </div>

            <div class="input-container">
                <label for="asentamiento">Colonia:</label>
                <input type="text" id="asentamiento" name="asentamiento" placeholder="Por favor ingrese el asentamiento"
                    required>
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