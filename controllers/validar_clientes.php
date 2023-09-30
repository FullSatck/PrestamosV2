<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $historial_crediticio = $_POST['historial_crediticio'];
    $referencias_personales = $_POST['referencias_personales'];
    $moneda_preferida = $_POST['moneda_preferida'];
    $zona_asignada = $_POST['zona_asignada'];

    // Validación básica (campos no vacíos)
    if (empty($nombre) || empty($apellido) || empty($direccion) || empty($telefono) || empty($moneda_preferida) || empty($zona_asignada)) {
        echo "Todos los campos son obligatorios. Por favor, complete el formulario.";
    } else {
        // Incluye el archivo de conexión a la base de datos
        include("conexion.php");

        // Prepara la consulta SQL para insertar el cliente
        $sql = "INSERT INTO Clientes (Nombre, Apellido, Direccion, Telefono, HistorialCrediticio, ReferenciasPersonales, MonedaPreferida, ZonaAsignada) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);

        if ($stmt) {
            // Asigna los valores a los marcadores de posición en la consulta preparada
            $stmt->bind_param("ssssssss", $nombre, $apellido, $direccion, $telefono, $historial_crediticio, $referencias_personales, $moneda_preferida, $zona_asignada);

            // Ejecuta la consulta
            if ($stmt->execute()) {
                // Redirige al usuario a una página de éxito o muestra un mensaje
                header("Location: ../resources/views/admin/inicio/inicio.php");
                exit();
            } else {
                echo "Error al registrar el cliente: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error de consulta preparada: " . $conexion->error;
        }

        $conexion->close();
    }
} else {
    // Redirecciona o muestra un mensaje de error si se accede directamente a este archivo sin enviar el formulario.
    echo "Acceso no autorizado.";
}
?>
