<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['cliente'])) {
    $cliente_id = $_POST['cliente'];
    header("Location: perfil_abonos.php?id=$cliente_id");
    exit();
} elseif ($_SERVER["REQUEST_METHOD"] === "POST" && (isset($_POST['prev']) || isset($_POST['next']))) {
    $cliente_id_actual = $_POST['cliente'];
    $currentIndex = array_search($cliente_id_actual, array_column($clientes, 'id'));

    if ($currentIndex !== false) {
        if (isset($_POST['prev'])) {
            $currentIndex = ($currentIndex === 0) ? count($clientes) - 1 : $currentIndex - 1;
        } elseif (isset($_POST['next'])) {
            $currentIndex = ($currentIndex === count($clientes) - 1) ? 0 : $currentIndex + 1;
        }

        $nuevo_cliente_id = $clientes[$currentIndex]['id'];

        header("Location: perfil_abonos.php?id=$nuevo_cliente_id");
        exit();
    }
} else {
    // Manejar un caso donde no se envió ningún cliente o navegación
    // Esto podría incluir redirigir a una página de error o realizar una acción alternativa
}
?>
