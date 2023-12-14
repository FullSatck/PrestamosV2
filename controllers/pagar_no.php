<?php
include("conexion.php");
            ob_start();

            function obtenerSiguienteClienteId($conexion, $id_cliente_actual)
            {
                $siguiente_cliente_id = 0;
                $sql_siguiente_cliente = "SELECT ID FROM clientes WHERE ID > ? ORDER BY ID ASC LIMIT 1";
                $stmt_siguiente_cliente = $conexion->prepare($sql_siguiente_cliente);
                $stmt_siguiente_cliente->bind_param("i", $id_cliente_actual);
                $stmt_siguiente_cliente->execute();
                $stmt_siguiente_cliente->bind_result($siguiente_cliente_id);
                $stmt_siguiente_cliente->fetch();
                $stmt_siguiente_cliente->close();
            
                return $siguiente_cliente_id;
            }
 
            // Verificar si se proporcionó el ID del cliente en la variable PHP $id_cliente
            if (isset($id_cliente))

                // Obtener el MontoAPagar de la tabla de préstamos
                $sql_monto_pagar = "SELECT MontoAPagar FROM prestamos WHERE IDCliente = ?";
            $stmt_monto_pagar = $conexion->prepare($sql_monto_pagar);
            $stmt_monto_pagar->bind_param("i", $id_cliente);
            $stmt_monto_pagar->execute();
            $stmt_monto_pagar->bind_result($montoAPagar);

            // Verificar si se encontró el MontoAPagar
            if ($stmt_monto_pagar->fetch()) {
                // Si se encontró, asignar el valor a la variable $montoAPagar
                // Ajustar el formato según sea necesario
            } else {
                // Si no se encontró, asignar un valor predeterminado o mostrar un mensaje de error
                $montoAPagar = 'No encontrado';
            }

            $stmt_monto_pagar->close();

            // PAGO

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
                $accion = $_POST['action'];

                if ($accion === 'Pagar') {
                    $sql_reset = "UPDATE prestamos SET Pospuesto = 0, mas_tarde = 0 WHERE IDCliente = ?";
                    $stmt_reset = $conexion->prepare($sql_reset);
                    $stmt_reset->bind_param("i", $id_cliente);

                    if ($stmt_reset->execute()) {
    // Obtener el siguiente ID de cliente
    $siguiente_cliente_id = obtenerSiguienteClienteId($conexion, $id_cliente);

    if ($siguiente_cliente_id !== null) {
        // Redirigir al perfil del siguiente cliente
        header("Location: perfil_abonos.php?id=$siguiente_cliente_id");
        exit();
    } else {
        // Mostrar el mensaje ya que no hay más clientes
        echo '<script>
              window.onload = function() {
                  alert("No hay más clientes");
              };
              </script>';
    }
} else {
    echo "Error al actualizar los campos 'Pospuesto' y 'mas_tarde': " . $stmt_reset->error;
}

                    $stmt_reset->close();
                }
            } else {
                echo "  ";
            }

            // NO PAGO Y MAS TARDE

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
                $accion = $_POST['action'];

                if ($accion === 'No pago' || $accion === 'Mas tarde') {
                    $campo_actualizar = ($accion === 'No pago') ? 'Pospuesto' : 'mas_tarde';

                    $sql_update = "UPDATE prestamos SET $campo_actualizar = 1 WHERE $campo_actualizar = 0 AND IDCliente = ?";
                    $stmt_update = $conexion->prepare($sql_update);
                    $stmt_update->bind_param("i", $id_cliente);

                    if ($stmt_update->execute()) {
                        echo "Acción '$accion' realizada: campo '$campo_actualizar' actualizado a 1";
                    } else {
                        echo "Error al actualizar el campo '$campo_actualizar': " . $stmt_update->error;
                    }

                    $stmt_update->close();
                }
            } else {
                echo "  ";
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Obtener los valores ingresados
                $cuota_ingresada = $_POST['cuota'];
                $monto_deuda = (float)$montoAPagar - (float)$cuota_ingresada; // Calcular el monto de deuda

                // Validar el monto ingresado para monto_pagado
                $monto_pagado = floatval($cuota_ingresada); // Convertir a decimal

                // Actualizar MontoAPagar en la tabla "prestamos"
                $sql_update_prestamo = "UPDATE prestamos SET MontoAPagar = ? WHERE IDCliente = ?";
                $stmt_update_prestamo = $conexion->prepare($sql_update_prestamo);
                $stmt_update_prestamo->bind_param("di", $monto_deuda, $id_cliente);
                $stmt_update_prestamo->execute();

                // Insertar datos en la tabla "facturas"


                // Obtener el ID del préstamo del cliente desde la tabla prestamos
                $sql_id_prestamo = "SELECT ID FROM prestamos WHERE IDCliente = ?";
                $stmt_id_prestamo = $conexion->prepare($sql_id_prestamo);
                $stmt_id_prestamo->bind_param("i", $id_cliente);
                $stmt_id_prestamo->execute();
                $stmt_id_prestamo->bind_result($id_prestamo);
                $stmt_id_prestamo->fetch();
                $stmt_id_prestamo->close();

                $fecha_pago = date('Y-m-d'); // Fecha actual
                $monto_pagado_historial = $_POST['cuota']; // Obtener el monto pagado del formulario

                // Insertar datos en la tabla "historial_pagos"
                if ($_POST['action'] === 'Pagar') {
                    // Solo si la acción es 'Pagar', se realiza la inserción en las tablas 'facturas' y 'historial_pagos'
                    $stmt_update_prestamo->execute();

                    // Insertar datos en la tabla "facturas" solo si es acción 'Pagar'
                    $fecha_actual = date('Y-m-d');
                    $sql_insert_factura = "INSERT INTO facturas (cliente_id, monto, fecha, monto_pagado, monto_deuda) VALUES (?, ?, ?, ?, ?)";
                    $stmt_insert_factura = $conexion->prepare($sql_insert_factura);
                    $stmt_insert_factura->bind_param("idsss", $id_cliente, $montoAPagar, $fecha_actual, $monto_pagado, $monto_deuda);
                    $stmt_insert_factura->execute();

                    // Insertar datos en la tabla "historial_pagos" solo si es acción 'Pagar'
                    $fecha_pago = date('Y-m-d'); // Fecha actual
                    $monto_pagado_historial = $_POST['cuota']; // Obtener el monto pagado del formulario

                    $sql_insert_historial = "INSERT INTO historial_pagos (IDCliente, FechaPago, MontoPagado, IDPrestamo) VALUES (?, ?, ?, ?)";
                    $stmt_insert_historial = $conexion->prepare($sql_insert_historial);
                    $stmt_insert_historial->bind_param("ssdi", $id_cliente, $fecha_pago, $monto_pagado_historial, $id_prestamo);
                    $stmt_insert_historial->execute();
                }


                function obtenerSiguienteClienteId($conexion, $id_cliente_actual)
                {
                    $siguiente_cliente_id = 0;
                    $sql_siguiente_cliente = "SELECT ID FROM clientes WHERE ID > ? ORDER BY ID ASC LIMIT 1";
                    $stmt_siguiente_cliente = $conexion->prepare($sql_siguiente_cliente);
                    $stmt_siguiente_cliente->bind_param("i", $id_cliente_actual);
                    $stmt_siguiente_cliente->execute();
                    $stmt_siguiente_cliente->bind_result($siguiente_cliente_id);
                    $stmt_siguiente_cliente->fetch();
                    $stmt_siguiente_cliente->close();

                    return $siguiente_cliente_id;
                }

                // Obtener el siguiente ID de cliente (cambia esta lógica según la manera en que tengas los clientes ordenados)
                $siguiente_cliente_id = obtenerSiguienteClienteId($conexion, $id_cliente);

                // Definir $es_ultimo_cliente fuera del bloque condicional POST
                $es_ultimo_cliente = false;

                // Verificar si la inserción fue exitosa
                if ($stmt_insert_factura && $stmt_update_prestamo) {
                    // Inserción y actualización exitosas

                    // Verificar si es el último cliente
                    $es_ultimo_cliente = ($siguiente_cliente_id === null);

                    // Mostrar mensaje si es el último cliente
                    if ($es_ultimo_cliente) {
                        echo '<p>Este es el último cliente.</p>';
                    }

                    if ($siguiente_cliente_id !== null) {
                        // Redirigir al perfil del siguiente cliente si hay más clientes
                        header("Location: perfil_abonos.php?id=$siguiente_cliente_id");
                        exit();
                    } else {
                        // Mostrar el modal ya que no hay más clientes
                        echo '<script>
                    window.onload = function() {
                        alert("No hay más clientes");
                    };
                  </script>';
                    }
                } else {
                    // Alguna inserción o actualización fallida
                    // Manejar el error apropiadamente
                    echo "Error al realizar el pago.";
                }

                $stmt_insert_factura->close();
                $stmt_update_prestamo->close();
            }

            ob_end_flush();
            ?>