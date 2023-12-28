<?php
// Incluye el archivo de conexión a la base de datos
require_once("../../../../controllers/conexion.php");

$clienteId = 0;
$cliente = null;
$zonaSeleccionada = '';

// Verifica si el ID del cliente está en la URL y es numérico
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $clienteId = $_GET['id'];

    // Consulta para obtener los datos del cliente
    $sql = "SELECT * FROM clientes WHERE ID = $clienteId";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $cliente = mysqli_fetch_assoc($resultado);
        $zonaSeleccionada = $cliente['ZonaAsignada'] ?? '';
    } else {
        die("Cliente no encontrado.");
    }
} else {
    die("ID de cliente no válido.");
}

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $curp = $_POST['curp'];
    $domicilio = $_POST['domicilio'];
    $telefono = $_POST['telefono'];
    $moneda = $_POST['moneda'];
    $zona = $_POST['zona'];
    $ciudad = $_POST['ciudad'];
    $asentamiento = $_POST['asentamiento'];

    // Prepara la consulta SQL para actualizar los datos
    $sql = "UPDATE clientes SET Nombre = '$nombre', Apellido = '$apellido', IdentificacionCURP = '$curp', Domicilio = '$domicilio', Telefono = '$telefono', MonedaPreferida = '$moneda', ZonaAsignada = (SELECT Nombre FROM zonas WHERE ID = '$zona'), Ciudad = '$ciudad', Asentamiento = '$asentamiento' WHERE ID = $clienteId";

    // Ejecuta la consulta
    if (mysqli_query($conexion, $sql)) {
        header("Location: lista_clientes.php");
    } else {
        echo "Error al actualizar los datos: " . mysqli_error($conexion);
    }
}

// Consulta para obtener las zonas
$consultaZonas = "SELECT ID, Nombre FROM zonas";
$resultZonas = mysqli_query($conexion, $consultaZonas);

// Consulta para obtener las ciudades basadas en la zona seleccionada
$consultaCiudades = "SELECT * FROM ciudades WHERE IDZona = (SELECT ID FROM zonas WHERE Nombre = '$zonaSeleccionada')";
$resultCiudades = mysqli_query($conexion, $consultaCiudades);
// Consulta para obtener todas las ciudades
$consultaCiudades = "SELECT * FROM ciudades";
$resultCiudades = mysqli_query($conexion, $consultaCiudades);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+J/T4Aj4Or5M5L6f4dOMu1zC5z5OIn5S/4ro5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/9454e88444.js" crossorigin="anonymous"></script>
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="/public/assets/css/editar_clientes.css">
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $clienteId); ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="cliente_id" value="<?php echo $cliente['ID']; ?>">

        <div class="input-container">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required value="<?php echo $cliente['Nombre']; ?>">
        </div>

        <div class="input-container">
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required value="<?php echo $cliente['Apellido']; ?>">
        </div>

        <div class="input-container">
            <label for="curp">Identificación CURP:</label>
            <input type="text" id="curp" name="curp" required value="<?php echo $cliente['IdentificacionCURP']; ?>">
        </div>

        <div class="input-container">
            <label for="domicilio">Domicilio:</label>
            <input type="text" id="domicilio" name="domicilio" required value="<?php echo $cliente['Domicilio']; ?>">
        </div>

        <div class="input-container">
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required value="<?php echo $cliente['Telefono']; ?>">
        </div>

        <div class="input-container">
            <label for="moneda">Moneda Preferida:</label>
            <select id="moneda" name="moneda">
                <?php
                $query = "SELECT * FROM monedas";
                $result = mysqli_query($conexion, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $selected = ($row['ID'] == $cliente['Moneda']) ? 'selected' : '';
                    echo "<option value='" . $row['ID'] . "' $selected>" . $row['Nombre'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="input-container">
            <label for="zona">Zona:</label>
            <select id="zona" name="zona">
                <?php
                $consultaZonas = "SELECT ID, Nombre FROM zonas";
                $resultZonas = mysqli_query($conexion, $consultaZonas);

                while ($row = mysqli_fetch_assoc($resultZonas)) {
                    $selected = ($row['Nombre'] == $zonaSeleccionada) ? 'selected' : '';
                    echo '<option value="' . $row['ID'] . '" ' . $selected . '>' . $row['Nombre'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="input-container">
            <label for="ciudad">Ciudad:</label>
            <select id="ciudad" name="ciudad">
                <?php
                // Verifica si $zonaSeleccionada no está vacío
                if (!empty($zonaSeleccionada)) {
                    $consultaCiudades = "SELECT * FROM ciudades WHERE IDZona = (SELECT ID FROM zonas WHERE Nombre = '$zonaSeleccionada')";
                    $resultCiudades = mysqli_query($conexion, $consultaCiudades);

                    while ($row = mysqli_fetch_assoc($resultCiudades)) {
                        $selected = ($row['ID'] == $cliente['Ciudad']) ? 'selected' : '';
                        echo '<option value="' . $row['ID'] . '" ' . $selected . '>' . $row['Nombre'] . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="input-container">
            <label for="asentamiento">Asentamiento:</label>
            <input type="text" id="asentamiento" name="asentamiento" required value="<?php echo $cliente['asentamiento'] ?? ''; ?>">

        </div>

        <div class="btn-container">
            <input id="boton-registrar" class="btn-container" type="submit" value="Actualizar">
        </div>
    </form>
</body>

</html>