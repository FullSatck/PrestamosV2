<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "prestamos2.0";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}s
?>
