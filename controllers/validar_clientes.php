<?php
require_once("conexion.php"); // Incluye el archivo de conexión

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
    $zona = $_POST["zona"];

    // Procesar la imagen del cliente
    if ($_FILES["imagen"]["error"] === 0) {
        $imagen_nombre = $_FILES["imagen"]["name"];
        $imagen_temporal = $_FILES["imagen"]["tmp_name"];
        $ruta_imagen = "../public/assets/img/imgclient" . $imagen_nombre;
        move_uploaded_file($imagen_temporal, $ruta_imagen);
    } else {
        $ruta_imagen = "";
    }

    // Insertar los datos en la tabla de clientes
    $sql = "INSERT INTO clientes (Nombre, Apellido, IdentificacionCURP, Domicilio, Telefono, HistorialCrediticio, ReferenciasPersonales, MonedaPreferida, ZonaAsignada, ImagenCliente)
            VALUES ('$nombre', '$apellido', '$curp', '$domicilio', '$telefono', '$historial', '$referencias', '$moneda', '$zona', '$ruta_imagen')";

    if (mysqli_query($conexion, $sql)) {
        echo "Registro exitoso.";
    } else {
        echo "Error al registrar el cliente: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}
?>
