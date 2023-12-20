<?php
session_start();

// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../../../index.php");
    exit();
}

include "../../../../../../controllers/conexion.php";

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


// El usuario ha iniciado sesión, mostrar el contenido de la página aquí
?>
 
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://kit.fontawesome.com/9454e88444.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/public/assets/css/gastos.css">
    <title>Lista de Gastos</title> 
</head>

<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>
        <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/gastos/agregar_gasto.php" class="botonn">
            <i class="fa-solid fa-plus-minus"></i>
            <span class="spann">Agregar Gasto</span>
        </a>

        <div class="nombre-usuario">
            <?php
        if (isset($_SESSION["nombre_usuario"])) {
            echo htmlspecialchars($_SESSION["nombre_usuario"])."<br>" . "<span> Supervisor<span>";
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

        <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/usuarios/registrar.php">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/gastos/gastos.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/22-QuintanaRoo/supervisor/ruta/lista_super.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Enrutar</h4>
                </div>
            </a>
        </div>

    </div>


    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>
        <h1>Lista de Gastos</h1>
        <div class="table-scroll-container">
            <?php
        // Incluye la configuración de conexión a la base de datos
        include "../../../../../../controllers/conexion.php"; // Asegúrate de que la ruta sea correcta

        // Realiza la consulta para obtener los gastos con el nombre de la zona
        $sql = "SELECT g.ID, z.Nombre AS nombreZona, g.Ciudad, g.Asentamiento, g.Fecha, g.Descripcion, g.Valor
                FROM gastos g
                INNER JOIN zonas z ON g.IDZona = z.ID
                WHERE g.IDZona = 22
                ORDER BY g.ID DESC";
        $resultado = $conexion->query($sql);

        // Crear una tabla HTML para mostrar las columnas de las filas
        echo '<table>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Estado</th>';
        echo '<th>Municipio</th>';
        echo '<th>Colonia</th>';
        echo '<th>Fecha</th>';
        echo '<th>Descripción</th>';
        echo '<th>Valor</th>';
        echo '</tr>';

        // Verifica si hay gastos en la base de datos
        if ($resultado->num_rows > 0) {
            // Si hay gastos, itera a través de los resultados y muestra cada gasto
            while ($fila = $resultado->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $fila['ID'] . '</td>';
                echo '<td>' . $fila['nombreZona'] . '</td>';
                echo '<td>' . $fila['Ciudad'] . '</td>'; // Asegúrate de que 'Ciudad' corresponda al nombre de la columna
                echo '<td>' . $fila['Asentamiento'] . '</td>'; // Asegúrate de que 'Asentamiento' corresponda al nombre de la columna
                echo '<td>' . $fila['Fecha'] . '</td>';
                echo '<td>' . $fila['Descripcion'] . '</td>'; 
                echo "<td>" . number_format($fila['Valor'], 0, '.', '.') . "</td>"; // Formatear el monto
                echo '</tr>';
            }
        } else {
            // Si no hay gastos, muestra una fila con celdas vacías
            echo '<tr>';
            echo '<td colspan="7">No se encontraron gastos en la base de datos.</td>';
            echo '</tr>';
        }

        echo '</table>';

        // Cierra la conexión a la base de datos
        $conexion->close();
        ?>
        </div>
    </main>




    <script src="/public/assets/js/MenuLate.js"></script>

</body>

</html>