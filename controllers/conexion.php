<?php
// Conexión al servidor con usuario, contraseña y base de datos
$servidor = "localhost";
$usuario = "u673362221_root";
$contrasena = "Cass123*";
$dbnombre = "u673362221_prestamos";

// Crear la conexión
$conexion = new mysqli($servidor, $usuario, $contrasena, $dbnombre);

// Comprobar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
// Puedes descomentar las siguientes líneas para confirmar que la conexión es efectiva

// else {
//     echo "Conexión efectiva";
// }

?>
