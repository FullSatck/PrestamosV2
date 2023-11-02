<?php
require 'conexion.php';

function esAdmin($userID) {
     global $pdo; // Aseguramos que la conexión a la base de datos esté disponible globalmente
 
     $stmt = $pdo->prepare("SELECT RolID FROM usuarios WHERE ID = :userID");
     $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
     $stmt->execute();
     
     $user = $stmt->fetch();
     
     // Si el usuario existe y tiene el RolID de administrador (por ejemplo, 1), entonces es administrador
     if ($user && $user['RolID'] == 1) {
         return true;
     }
     return false;
 }

 $userID = $_SESSION['userID']; // Suponiendo que estés usando sesiones y hayas guardado el ID del usuario en 'userID'
if (esAdmin($userID)) {
    echo "El usuario es administrador";
} else {
    echo "El usuario no es administrador";
}


function cerrarSistema($userID) {
    global $pdo;
    if (esAdmin($userID)) {
        $stmt = $pdo->prepare("UPDATE configuraciones SET sistemaActivo = FALSE WHERE id = 1");
        $stmt->execute();
    }
}

function reactivarSistema($userID) {
    global $pdo;
    if (esAdmin($userID)) {
        $stmt = $pdo->prepare("UPDATE configuraciones SET sistemaActivo = TRUE WHERE id = 1");
        $stmt->execute();
    }
}

function sistemaActivo() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT sistemaActivo FROM configuraciones WHERE id = 1");
    $stmt->execute();
    $row = $stmt->fetch();
    return $row['sistemaActivo'];
}
?>

