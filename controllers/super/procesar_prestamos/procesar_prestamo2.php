<?php
include '../../conexion.php'; // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $curp = $_POST["curp"];
    $domicilio = $_POST["domicilio"];
    $telefono = $_POST["telefono"];
    $historial = $_POST["historial"];
    $referencias = $_POST["referencias"];
    $moneda = $_POST["moneda"];
    $zona_id = $_POST["zona"]; // Recuperar el ID de la zona desde el formulario

    // Procesar la imagen del cliente
    if ($_FILES["imagen"]["error"] === 0) {
        $imagen_nombre = $_FILES["imagen"]["name"];
        $imagen_temporal = $_FILES["imagen"]["tmp_name"];
        $ruta_imagen = "../public/assets/img/imgclient/imgclient" . $imagen_nombre;
        move_uploaded_file($imagen_temporal, $ruta_imagen);
    } else {
        $ruta_imagen = "";
    }

    // Consulta SQL para obtener el nombre de la zona
    $consultaZona = "SELECT Nombre FROM zonas WHERE ID = $zona_id";
    $resultZona = mysqli_query($conexion, $consultaZona);

    if ($rowZona = mysqli_fetch_assoc($resultZona)) {
        $nombre_zona = $rowZona['Nombre'];

        // Insertar los datos en la tabla de clientes
        $sql = "INSERT INTO clientes (Nombre, Apellido, IdentificacionCURP, Domicilio, Telefono, HistorialCrediticio, ReferenciasPersonales, MonedaPreferida, ZonaAsignada, ImagenCliente)
                VALUES ('$nombre', '$apellido', '$curp', '$domicilio', '$telefono', '$historial', '$referencias', '$moneda', '$nombre_zona', '$ruta_imagen')";

        if (mysqli_query($conexion, $sql)) {
            // Redirige al usuario a la página de agregar zona con un mensaje de confirmación
            header('Location: ../../resources/views/zonas/1-aguascalientes/supervisor/clientes/lista_clientes.php?mensaje=Cliente guardado exitosamente');
            exit;
        } else {
            echo "Error al registrar el cliente: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al obtener el nombre de la zona.";
    }
    // Cerrar la conexión
    mysqli_close($conexion);
}
?>
