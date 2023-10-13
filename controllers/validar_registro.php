<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recopila los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $zona = $_POST['zona'];
    $RolID = $_POST['RolID']; // Asegúrate de que el valor de RolID sea válido
    $saldoInicial = isset($_POST['saldo-inicial']) ? floatval($_POST['saldo-inicial']) : 0.0; // Asegúrate de que el saldo inicial sea un valor válido

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
                // Obtener el ID del usuario que se acaba de registrar
                $idUsuario = $stmtUsuarios->insert_id;

                // Verificar si el rol es Supervisor (supongamos que el valor del rol de Supervisor es 2)
                if ($RolID == 2 && $saldoInicial > 0.0) {
                    // Actualizar el Monto_Neto en la tabla 'saldo_admin'
                    $sqlActualizarMontoNeto = "UPDATE saldo_admin SET Monto_Neto = Monto_Neto - ? LIMIT 1";
                    $stmtActualizarMontoNeto = $conexion->prepare($sqlActualizarMontoNeto);

                    if ($stmtActualizarMontoNeto) {
                        $stmtActualizarMontoNeto->bind_param("d", $saldoInicial);
                        if ($stmtActualizarMontoNeto->execute()) {
                            // Éxito al actualizar el Monto_Neto

                            // Insertar el saldo inicial en la tabla 'retiros'
                            $sqlInsertarSaldoInicial = "INSERT INTO retiros (IDUsuario, Monto) VALUES (?, ?)";
                            $stmtInsertarSaldoInicial = $conexion->prepare($sqlInsertarSaldoInicial);

                            if ($stmtInsertarSaldoInicial) {
                                $stmtInsertarSaldoInicial->bind_param("sd", $idUsuario, $saldoInicial);
                                if ($stmtInsertarSaldoInicial->execute()) {
                                    // Éxito al insertar el saldo inicial
                                } else {
                                    echo "Error al insertar el saldo inicial: " . $stmtInsertarSaldoInicial->error;
                                }

                                $stmtInsertarSaldoInicial->close();
                            } else {
                                echo "Error de consulta preparada para insertar saldo inicial: " . $conexion->error;
                            }
                        } else {
                            echo "Error al actualizar el Monto_Neto: " . $stmtActualizarMontoNeto->error;
                        }

                        $stmtActualizarMontoNeto->close();
                    } else {
                        echo "Error de consulta preparada para actualizar Monto_Neto: " . $conexion->error;
                    }
                }

                // Redireccionar a la lista de usuarios después de 2 segundos
                header("refresh:2; url=../resources/views/admin/usuarios/crudusuarios.php");
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
?>
