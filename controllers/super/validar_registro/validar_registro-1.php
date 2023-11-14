<?php
// Incluye el archivo de conexión a la base de datos
include("../../../conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registrar_usuario"])) {
    // Recoge los datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    $zona = $_POST["zona"];
    $rol = $_POST["RolID"];
    $saldoInicial = isset($_POST["saldo-inicial"]) ? $_POST["saldo-inicial"] : 0.00;

    // Validación de datos
    if (empty($nombre) || empty($apellido) || empty($email) || empty($contrasena)) {
        header("Location: ../../../resources/views/zonas/1-aguascalientes/supervisor/usuarios/crudusuarios.php?mensaje=Por favor, complete todos los campos.");
        exit();
    } else {
        // Realiza la inserción en la base de datos
        $insertQuery = "INSERT INTO usuarios (Nombre, Apellido, Email, Password, Zona, RolID) 
                        VALUES ('$nombre', '$apellido', '$email', '$contrasena', '$zona', $rol)";
        
        if (mysqli_query($conexion, $insertQuery)) {
            $ultimoID = mysqli_insert_id($conexion); // Obtiene el ID del último usuario insertado

            // Si el rol es supervisor, inserta el saldo inicial en la tabla retiros
            if ($rol == 3) {
                $fechaActual = date("Y-m-d H:i:s");
                $insertSaldoInicial = "INSERT INTO retiros (IDUsuario, Monto, Fecha) 
                                       VALUES ($ultimoID, $saldoInicial, '$fechaActual')";
                mysqli_query($conexion, $insertSaldoInicial);
            }
            header("Location: ../../../resources/views/zonas/1-aguascalientes/supervisor/usuarios/crudusuarios.php?mensaje=Usuario registrado con éxito.");
            exit();
        } else {
            header("Location: ../../../resources/views/zonas/1-aguascalientes/supervisor/usuarios/crudusuarios.php?mensaje=Error al registrar el usuario: " . mysqli_error($conexion));
            exit();
        }
    }
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>
