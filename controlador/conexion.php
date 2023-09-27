<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "prestamos2.0";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo "Error de conexion";
} else {
    echo "Conexion exitosa";
}
?>
