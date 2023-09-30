<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los valores del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $historial_crediticio = $_POST['historial_crediticio'];
    $referencias_personales = $_POST['referencias_personales'];
    $moneda_preferida_nombre = $_POST['moneda_preferida']; // Cambio: Ahora capturamos el nombre de la moneda preferida
    $zona_asignada = $_POST['zona_asignada'];

    // Validación básica (campos no vacíos)
    if (empty($nombre) || empty($apellido) || empty($direccion) || empty($telefono) || empty($moneda_preferida_nombre) || empty($zona_asignada)) {
        echo "Todos los campos son obligatorios. Por favor, complete el formulario.";
    } else {
        // Incluye el archivo de conexión a la base de datos
        include("conexion.php");

        // Verifica que el nombre de la moneda preferida exista en la tabla de monedas
        $consultaMoneda = "SELECT ID FROM Monedas WHERE Nombre = ?";
        $stmt = $conexion->prepare($consultaMoneda);

        if ($stmt) {
            $stmt->bind_param("s", $moneda_preferida_nombre);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                echo "La moneda preferida no existe en la tabla de monedas.";
            } else {
                // Obtiene el ID de la moneda preferida
                $row = $result->fetch_assoc();
                $moneda_preferida_id = $row['ID'];

                // Prepara la consulta SQL para insertar el cliente
                $sql = "INSERT INTO Clientes (Nombre, Apellido, Direccion, Telefono, HistorialCrediticio, ReferenciasPersonales, MonedaPreferida, ZonaAsignada) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $conexion->prepare($sql);

                if ($stmt) {
                    // Asigna los valores a los marcadores de posición en la consulta preparada
                    $stmt->bind_param("ssssssss", $nombre, $apellido, $direccion, $telefono, $historial_crediticio, $referencias_personales, $moneda_preferida_id, $zona_asignada);

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
            }
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
