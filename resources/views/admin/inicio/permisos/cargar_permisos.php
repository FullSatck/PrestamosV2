<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../../../../../controllers/conexion.php';

    $usuario_id = $_POST["usuario_id"];

    // Consulta para cargar los permisos disponibles
    $sql_permisos = "SELECT ID, nombre, descripcion FROM permisos";
    $result_permisos = $conexion->query($sql_permisos);

    // Consulta para obtener los permisos asignados al usuario
    $sql_asignados = "SELECT permiso_id FROM usuarios_permisos WHERE usuario_id = ?";
    $stmt = $conexion->prepare($sql_asignados);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result_asignados = $stmt->get_result();

    $permisos_asignados = [];
    while ($row = $result_asignados->fetch_assoc()) {
        $permisos_asignados[] = $row["permiso_id"];
    }

    // Generar la lista de permisos disponibles y asignados
    $html = "";
    while ($row = $result_permisos->fetch_assoc()) {
        $permiso_id = $row["ID"];
        $nombre = $row["nombre"];
        $descripcion = $row["descripcion"];
        $checked = in_array($permiso_id, $permisos_asignados) ? "checked" : "";

        $html .= "<input type='checkbox' name='permisos[]' value='$permiso_id' $checked>";
        $html .= "<strong>$nombre</strong>: $descripcion";
        
        if (in_array($permiso_id, $permisos_asignados)) {
            $html .= " <strong><span class='asignado'>(Asignado)</span></strong>";
        }
        
        $html .= "<br>";
        
    }

    echo $html;
}
?>
