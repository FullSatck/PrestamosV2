<?php
function obtenerIndicesClienteActual($clientes, $id_cliente_actual) {
    $currentIndex = null;
    foreach ($clientes as $index => $cliente) {
        if ($cliente['id'] == $id_cliente_actual) {
            $currentIndex = $index;
            break;
        }
    }
    $prevIndex = ($currentIndex === null || $currentIndex === 0) ? count($clientes) - 1 : $currentIndex - 1;
    $nextIndex = ($currentIndex === null || $currentIndex === count($clientes) - 1) ? 0 : $currentIndex + 1;

    return [$prevIndex, $currentIndex, $nextIndex];
}


function obtenerClientes($conexion, $zonaAsignada = 'Quintana Roo') {
    $query = "SELECT id, Nombre, Apellido FROM clientes WHERE ZonaAsignada = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $zonaAsignada);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    $clientes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $clientes[] = [
            'id' => $row['id'],
            'nombre' => $row['Nombre'],
            'apellido' => $row['Apellido']
        ];
    }

    mysqli_free_result($result);
    return $clientes;
}

?>
