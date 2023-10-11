<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recopila los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $zona = $_POST['zona'];
    $RolID = $_POST['RolID']; // Asegúrate de que el valor de RolID sea válido

    // Validación básica de datos
    if (empty($nombre) || empty($apellido) || empty($email) || empty($contrasena) || empty($zona) || empty($RolID)) {
        echo "Todos los campos son obligatorios. Por favor, complete el formulario.";
    } else {
        // Conexión a la base de datos
        include("conexion.php");

        // Verifica si el correo electrónico ya está registrado
        $consultaEmail = "SELECT ID FROM usuarios WHERE Email = ?";
        $stmtEmail = $conexion->prepare($consultaEmail);

        if ($stmtEmail) {
            $stmtEmail->bind_param("s", $email);
            $stmtEmail->execute();
            $stmtEmail->store_result();

            if ($stmtEmail->num_rows > 0) {
                echo "El correo electrónico ya está registrado. Por favor, utilice otro.";
                $stmtEmail->close();
                $conexion->close();
                exit();
            }

            $stmtEmail->close();
        } else {
            echo "Error de consulta preparada para verificar correo electrónico: " . $conexion->error;
            $conexion->close();
            exit();
        }

        // Hashea la contraseña
        $contrasenaHasheada = password_hash($contrasena, PASSWORD_DEFAULT);

        // Inserta el nuevo usuario en la base de datos
        $sqlUsuarios = "INSERT INTO usuarios (Nombre, Apellido, Email, Password, Zona, RolID) 
                        VALUES (?, ?, ?, ?, ?, ?)";

        $stmtUsuarios = $conexion->prepare($sqlUsuarios);

        if ($stmtUsuarios) {
            $stmtUsuarios->bind_param("ssssss", $nombre, $apellido, $email, $contrasenaHasheada, $zona, $RolID);

            if ($stmtUsuarios->execute()) {
                header("Location: ../resources/views/admin/usuarios/crudusuarios.php");
                exit();
            } else {
                echo "Error al registrar el usuario: " . $stmtUsuarios->error;
            }

            $stmtUsuarios->close();
        } else {
            echo "Error de consulta preparada para usuarios: " . $conexion->error;
        }

        $conexion->close();
    }
} else {
    echo "Acceso no autorizado.";
}
