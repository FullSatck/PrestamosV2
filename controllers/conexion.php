<?php 
//conexion al servidor con usuario y contraseña y base de datos 
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$dbnombre = "prestamos";

//crear la conexion

$conexion = new mysqli($servidor, $usuario, $contrasena, $dbnombre);

// // //comprobar la conexion 

//    if ($conexion->connect_error) {
//        echo" error de conexion";
//    }
//     else { 
//         echo" conexion efectiva ";
//    }

