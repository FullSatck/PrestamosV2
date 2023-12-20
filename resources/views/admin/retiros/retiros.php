<?php
date_default_timezone_set('America/Bogota');
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../../../../../index.php");
    exit();
}

include("../../../../controllers/conexion.php");

$usuario_id = $_SESSION["usuario_id"];

    $sql_nombre = "SELECT nombre FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql_nombre);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
if ($fila = $resultado->fetch_assoc()) {
    $_SESSION["nombre_usuario"] = $fila["nombre"];
}
$stmt->close();

// Consulta SQL para obtener los datos
$sql = "SELECT * FROM saldo_admin";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $monto = $row["Monto"];
        $monto_neto = $row["Monto_Neto"]; // Este será el valor actualizado
    }
}



 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador Recaudo</title>
    <link rel="stylesheet" href="/public/assets/css/retiros.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>


        </div>
        <a href="/resources/views/admin/retiros/agregar_retiros.php" class="botonn">
            <i class="fa-solid fa-plus"></i>
            <span class="spann">Agregar retiro</span>
        </a>
        <div class="nombre-usuario">
            <?php
        if (isset($_SESSION["nombre_usuario"])) {
            echo htmlspecialchars($_SESSION["nombre_usuario"])."<br>" . "<span> Administrator<span>";
        }
        ?>
        </div>
    </header>

    <div class="menu__side" id="menu_side">



        <div class="name__page">
            <img src="/public/assets/img/logo.png" class="img logo-image" alt="">
            <h4>Recaudo</h4>
        </div>

        <div class="options__menu">

            <a href="/controllers/cerrar_sesion.php">
                <div class="option">
                    <i class="fa-solid fa-right-to-bracket fa-rotate-180"></i>
                    <h4>Cerrar Sesion</h4>
                </div>
            </a>

            <a href="/resources/views/admin/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href=" /resources/views/admin/admin_saldo/saldo_admin.php">
                <div class="option">
                    <i class="fa-solid fa-sack-dollar" title=""></i>
                    <h4>Saldo Inicial</h4>
                </div>
            </a>

            <a href="/resources/views/admin/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/admin/usuarios/registrar.php">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/admin/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/admin/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>
            <a href="/resources/views/admin/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a> 
            <a href="/resources/views/admin/cobros/cobros.php">
                <div class="option">
                    <i class="fa-solid fa-arrow-right-to-city" title=""></i>
                    <h4>Zonas de cobro</h4>
                </div>
            </a>

            <a href="/resources/views/admin/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a> 

            <a href="/resources/views/admin/ruta/ruta.php">
            <div class="option">
                <i class="fa-solid fa-map" title=""></i>
                <h4>Enrutar</h4>
            </div>
        </a>
 
            <a href="/resources/views/admin/retiros/retiros.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-scale-balanced" title=""></i>
                    <h4>Retiros</h4>
                </div>
            </a>
        </div>
    </div>

    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->
    <main>
        <h1>Lista de Retiros</h1>
        <div class="saldo-box">
            <div class="saldo-item">
                <h2>Saldo Inicial</h2>
                <p>$<?php echo number_format($monto, 2, '.', '.'); ?></p>
            </div>
            <div class="saldo-item">
                <h2>Monto Neto</h2>
                <p class="p">$<?php echo number_format($monto_neto, 2, '.', '.'); ?></p>
            </div>
        </div>

        <?php 

// Consulta SQL para obtener los datos de la tabla 'retiros'
$sql = "SELECT ID, IDUsuario, Fecha, Monto, descripcion FROM retiros";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    // Iniciar la tabla HTML con estilos
    echo "<div class='table-scroll-container'>";
    echo "<div class='table-container'>";
    echo "<table class='styled-table'>";
    echo "<thead>";
    echo "<tr><th>ID</th><th>ID Usuario</th><th>Fecha</th><th>Monto</th><th>Descripción</th><th>Editar</th></tr>";
    echo "</thead>";
    echo "<tbody>";

    // Recorrer los resultados y mostrar cada fila en la tabla
while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row["ID"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["IDUsuario"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["Fecha"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["Monto"]) . "</td>";
    // Imprimir la descripción
    $descripcion = !is_null($row['descripcion']) ? htmlspecialchars($row['descripcion']) : 'Sin descripción';
    echo "<td>" . $descripcion . "</td>"; // Asegúrate de imprimir la variable aquí
    // Agregar un enlace o botón para editar
    echo "<td><a href='editar_retiros.php?id=" . $row["ID"] . "'>Editar</a></td>"; // Reemplaza 'editar_retiro.php' con tu archivo de edición y asegúrate de pasar el ID del retiro
    echo "</tr>";
}
    // Finalizar la tabla
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
} else {
    echo "<p>No se encontraron resultados.</p>";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>

    </main>
    <script src="/public/assets/js/MenuLate.js"></script>

</body>

</html>