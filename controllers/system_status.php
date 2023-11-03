<?php
session_start();

// Conexión a la base de datos (ajusta los parámetros según sea necesario)
function connectToDB() {
    $host = 'localhost';
    $db   = 'prestamos';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

// Verificar el estado del sistema y el rol del usuario
function checkSystemStatusAndRole($userId) {
    $pdo = connectToDB();
    $stmt = $pdo->prepare("SELECT sistemaActivo FROM configuraciones WHERE id = 1");
    $stmt->execute();
    $systemStatus = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT RolID FROM usuarios WHERE ID = ?");
    $stmt->execute([$userId]);
    $userRole = $stmt->fetchColumn();

    return ['systemStatus' => $systemStatus, 'userRole' => $userRole];
}

// Obtener el ID del usuario de la sesión
$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : null;

// Si se realiza una solicitud GET, devolver el estado del sistema y el rol del usuario
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $userId) {
    echo json_encode(checkSystemStatusAndRole($userId));
    exit;
}

// Si se realiza una solicitud POST, cambiar el estado del sistema si el usuario es administrador
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $userId) {
    $statusAndRole = checkSystemStatusAndRole($userId);

    if ($statusAndRole['userRole'] == 1) { // 1 es el ID de rol para admin
        $newStatus = $_POST['newStatus'] ? 1 : 0;
        $pdo = connectToDB();
        $stmt = $pdo->prepare("UPDATE configuraciones SET sistemaActivo = ? WHERE id = 1");
        $stmt->execute([$newStatus]);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No autorizado']);
    }
    exit;
}
?>
