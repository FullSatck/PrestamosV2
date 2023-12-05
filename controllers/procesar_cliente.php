<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cliente'])) {
    $cliente_id = $_POST['cliente'];
    header("Location: perfil_cliente.php?id=$cliente_id");
    exit();
} else {
    // Manejo de error o redirección alternativa si no se ha seleccionado un cliente
}
?>
