<?php
date_default_timezone_set('America/Bogota');
require_once("conexion.php"); // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar el CURP del formulario
    $curp = $_POST["curp"];

    // Consultar si ya existe un cliente con el mismo CURP
    $sql_verificar_curp = "SELECT ID FROM clientes WHERE IdentificacionCURP = '$curp'";
    $resultado_verificar = mysqli_query($conexion, $sql_verificar_curp);

    if (mysqli_num_rows($resultado_verificar) > 0) {
        // El cliente ya existe, obtén su ID
        $row = mysqli_fetch_assoc($resultado_verificar);
        $cliente_id = $row['ID'];

        // Devuelve la respuesta en formato JSON
        $respuesta = array(
            "existe" => true,
            "cliente_id" => $cliente_id
        );

        echo json_encode($respuesta);
    } else {
        // El cliente no existe, devuelve una respuesta que indica que no existe
        $respuesta = array(
            "existe" => false
        ); 

        echo json_encode($respuesta);
    }
    // Cerrar la conexión
    mysqli_close($conexion);
}
?>
