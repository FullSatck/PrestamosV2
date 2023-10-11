<?php
session_start();
include("conexion.php"); // Asegúrate de que este archivo contiene tu conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    // Utiliza consultas preparadas para prevenir ataques de SQL injection
    $consulta = "SELECT ID, Email, Password, RolID, Nombre FROM usuarios WHERE Email = ?";
    $stmt = mysqli_prepare($conexion, $consulta);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $fila = mysqli_fetch_assoc($resultado);

        if ($fila) {
            // Verificar la contraseña con password_verify
            $hash_contrasena = $fila['Password'];
            if (password_verify($contrasena, $hash_contrasena)) {
                $_SESSION['logged_in'] = true;
                $_SESSION['IDrol'] = $fila['RolId']; // Leer rol de BD
                $_SESSION['Email'] = $fila['Email']; // Guardar el email del usuario
                $_SESSION['NombreUsuario'] = $fila['Nombre']; // Guardar el nombre del usuario

                switch ($fila['RolID']) {
                    case 1: // 1 podría representar el rol 'admin'
                        header("location: ../resources/views/admin/inicio/inicio.php");
                        break;
                    case 2: // 2 podría representar el rol 'supervisor'
                        header("location: ../resources/views/supervisor/inicio/inicio.php");
                        break;
                    case 3: // 3 podría representar el rol 'cobrador'
                        header("location: ../resources/views/cobrador/inicio/inicio.php");
                        break;
                    default:
                        header("location: pagina_error.php");
                        break;
                }
                

                exit();
            } else {
                // Contraseña incorrecta
                $_SESSION['logged_in'] = false;
                header("location: pagina_errorcontra.php1"); // Redirigir a página de error
                exit();
            }
        } else {
            // Usuario no encontrado
            $_SESSION['logged_in'] = false;
            header("location: pagina_erroruser.php2"); // Usuario no encontrado (página de error)
            exit();
        }
    } else {
        // Error de consulta preparada
        $_SESSION['logged_in'] = false;
        header("location: pagina_errorns.php"); // Error de consulta preparada (página de error)
        exit();
    }
}
?>
