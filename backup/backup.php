<?php
// Configuración de la base de datos
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$nombre_bd = 'prestamos';

// Conexión a la base de datos
$conexion = new mysqli($host, $usuario, $contrasena, $nombre_bd);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Nombre del archivo de respaldo
$fecha = date("Y-m-d-H-i-s");
$nombre_backup = 'backup_' . $nombre_bd . '_' . $fecha . '.sql';

// Comando para respaldar la base de datos
$comando = "mysqldump -u{$usuario} -p{$contrasena} {$nombre_bd} > {$nombre_backup}";

// Ejecutar el comando para crear la copia de seguridad
exec($comando);

// Verificar si se creó la copia de seguridad
if (file_exists($nombre_backup)) {
    echo "Copia de seguridad creada correctamente como: {$nombre_backup}";
} else {
    echo "Error al crear la copia de seguridad.";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
