<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// Incluye la configuración de conexión a la base de datos
include "../../../../controllers/conexion.php";

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
        $sql = "INSERT INTO Gastos (IDZona, Fecha, Descripcion, Valor) VALUES (?, ?, ?, ?)";

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
    <title>Agregar Gasto</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
            <button class="boton" id="volverAtras">
                <ion-icon name="arrow-undo-outline"></ion-icon>
                <span>&nbsp;Volver</span>
            </button>
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
                    <a href="/resources/views/admin/clientes/agregar_clientes.php">
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
                    <a href="/resources/views/admin/gastos/gastos.php" class="hola">
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
        <h1>Agregar Gasto</h1>

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
                $sql_zonas = "SELECT * FROM Zonas";
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
                <input type="text" name="fecha" id="fecha" class="form-control" value="<?php echo $fecha; ?>">
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

    <script>
    // Agregar un evento clic al botón
    document.getElementById("volverAtras").addEventListener("click", function() {
        window.history.back();
    });
    </script>

    <script>
    $(function() {
        $("#fecha").datepicker({
            dateFormat: "dd/mm/yy", // Formato de fecha deseado
            showButtonPanel: true, // Muestra botones de "Hoy" y "Limpiar"
        });
    });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="/menu/main.js"></script>

</body>

</html>