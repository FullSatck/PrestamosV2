<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $Password = $_POST['contrasena'];

    $consulta = "SELECT ID, Email, Password, Zona, RolID, Nombre FROM usuarios WHERE Email = ?";
    $stmt = mysqli_prepare($conexion, $consulta);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $fila = mysqli_fetch_assoc($resultado);

        if ($fila) {
            $hash_Password = $fila['Password'];

            if (password_verify($Password, $hash_Password)) {
                $_SESSION['logged_in'] = true;
                $_SESSION['IDrol'] = $fila['RolID'];
                $_SESSION['Zona'] = $fila['Zona'];
                $_SESSION['Email'] = $fila['Email'];
                $_SESSION['NombreUsuario'] = $fila['Nombre'];

                switch ($fila['RolID']) {
                    case 1: // rol 'admin'
                        header("location: ../resources/views/admin/inicio/inicio.php");
                        break;
                    case 2: // rol 'supervisor'
                        header("location: ../resources/views/supervisor/inicio/inicio.php");
                        break;
                    case 3: // rol 'cobrador'
                        header("location: ../resources/views/cobrador/inicio/inicio.php");
                        break;
                    default:
                        // Agregar mensaje de registro para identificar el valor inesperado
                        error_log("Valor inesperado en RolID: " . $fila['RolID']);
                        header("location: pagina_error.php");
                        break;
                }

                exit();
            } else {
                // Contraseña incorrecta
                $_SESSION['logged_in'] = false;
                // Agregar mensaje de registro para identificar problemas con la contraseña
                error_log("Contraseña incorrecta para el usuario: " . $email); 
                header("location: pagina_errorcontra.php");
                exit();
            }
        } else {
            // Usuario no encontrado
            $_SESSION['logged_in'] = false;
            // Agregar mensaje de registro para usuarios no encontrados
            error_log("Usuario no encontrado para el correo: " . $email);
            header("location: pagina_erroruser.php");
            exit();
        }
    } else {
        // Error de consulta preparada
        $_SESSION['logged_in'] = false;
        // Agregar mensaje de registro para identificar errores de consulta preparada
        error_log("Error de consulta preparada");
        header("location: pagina_errorns.php");
        exit();
    }
}
?>
