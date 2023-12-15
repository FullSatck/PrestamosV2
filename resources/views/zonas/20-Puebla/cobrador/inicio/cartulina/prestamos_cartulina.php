<?php
// Obtener el ID del cliente desde la URL actual
$id_cliente = $_GET['id'];

// Verificar si se seleccionó un ID de préstamo
if (isset($_GET['id_prestamo'])) {
    $id_prestamo_seleccionado = $_GET['id_prestamo'];
    
    // Redirigir a perfil_cliente.php con los IDs del cliente y del préstamo
    header("Location: perfil_cliente.php?id=$id_cliente&id_prestamo=$id_prestamo_seleccionado");
    exit();
} else {
    // Si no se seleccionó un préstamo, redirigir solo con el ID del cliente
    header("Location: perfil_cliente.php?id=$id_cliente");
    exit();
}
?>
