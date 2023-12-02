<?php
session_start();
date_default_timezone_set('America/Bogota');


// Verifica la autenticación del usuario
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../../../index.php");
    exit();
}

// Incluye la conexión a la base de datos
require_once '../../../../controllers/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se envió el formulario de edición

    if (isset($_POST["descripcion"], $_POST["valor"]) && !empty(trim($_POST["descripcion"])) && !empty(trim($_POST["valor"]))) {
        // Obtiene los valores del formulario
        $descripcion = trim($_POST["descripcion"]);
        $valor = trim($_POST["valor"]);

        // Obtiene el ID del gasto desde la URL
        $idGasto = $_GET['id'];

        // Realiza la actualización del gasto en la base de datos
        $sql = "UPDATE gastos SET Descripcion = ?, Valor = ? WHERE ID = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sdi", $descripcion, $valor, $idGasto);
            if ($stmt->execute()) {
                // Redirige después de actualizar el gasto
                header("Location: gastos.php");
                exit();
            } else {
                // Manejo de error si la actualización falla
                echo "Error al actualizar el gasto.";
            }
        }

        // Cierra la consulta
        $stmt->close();
    } else {
        // Manejo de error si los campos están vacíos
        echo "Por favor, completa todos los campos.";
    }
}

// Obtén los detalles del gasto a editar
$idGasto = $_GET['id'];
$sql = "SELECT * FROM gastos WHERE ID = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idGasto);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    // Obtiene los datos del gasto
    $gasto = $resultado->fetch_assoc();
} else {
    // Manejo de error si no se encuentra el gasto
    echo "Gasto no encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/editar_gastos.css">
    <title>Editar Gasto</title>
</head>

<body>
    <h1>Editar Gasto</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $idGasto); ?>" method="POST">
        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" value="<?php echo $gasto['Descripcion']; ?>">

        <label for="valor">Valor:</label>
        <input type="text" id="valor" name="valor" value="<?php echo $gasto['Valor']; ?>">

        <input type="submit" value="Guardar Cambios">
    </form>
</body>

</html>
