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
    
    <!-- Enlaza jQuery y jQuery UI (asegúrate de usar las URL correctas) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <!-- Enlaza los estilos de jQuery UI para darle formato al calendario -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <style>
        /* Estilos CSS personalizados */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 40px;
        }

        h1 {
            background-color: #70aee9;
            color: #000000;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px; 
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button[type="submit"] {
            padding: 12px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
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
            <select name="id_zona" id="id_zona" class="form-control">
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
            <input type="text" name="descripcion" id="descripcion" class="form-control" value="<?php echo $descripcion; ?>">
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

    <!-- JavaScript para inicializar el Datepicker -->
    <script>
        $(function () {
            $("#fecha").datepicker({
                dateFormat: "dd/mm/yy", // Formato de fecha deseado
                showButtonPanel: true, // Muestra botones de "Hoy" y "Limpiar"
            });
        });
    </script> 
</body>
</html>
