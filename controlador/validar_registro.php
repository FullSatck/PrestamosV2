<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $zona = $_POST['zona'];
    $moneda = $_POST['moneda'];

    // Hashea la contraseña utilizando password_hash
    $contrasenaHasheada = password_hash($contrasena, PASSWORD_DEFAULT);

    // Incluye el archivo de conexión a la base de datos
    include("conexion.php");

    // Prepara la consulta SQL
    $sql = "INSERT INTO Usuarios (Nombre, Apellido, Email, Password, Zona, MonedaPreferida, RolID) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        // Asigna los valores a los marcadores de posición en la consulta preparada
        $stmt->bind_param("ssssssi", $nombre, $apellido, $email, $contrasenaHasheada, $zona, $moneda, $rolID);

        // Define el valor del rol (por ejemplo, 'admin')
        $rolID = 1;

        // Ejecuta la consulta
        if ($stmt->execute()) {
            echo "Usuario registrado con éxito.";
        } else {
            echo "Error al registrar el usuario: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error de consulta preparada: " . $conexion->error;
    }

    $conexion->close();
}
?>
