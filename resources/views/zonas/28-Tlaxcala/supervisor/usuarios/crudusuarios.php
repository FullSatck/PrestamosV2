<?php
session_start();
include("../../../../../../controllers/conexion.php");

// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
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

// Verificar si se ha pasado un mensaje en la URL
$mensaje = "";
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Usuarios</title>

    <link rel="stylesheet" href="/public/assets/css/lista_usuarios.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>

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

            <a href="/resources/views/zonas/28-Tlaxcala/supervisor/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/28-Tlaxcala/supervisor/usuarios/crudusuarios.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/28-Tlaxcala/supervisor/usuarios/registrar.php">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/28-Tlaxcala/supervisor/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/28-Tlaxcala/supervisor/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/28-Tlaxcala/supervisor/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/28-Tlaxcala/supervisor/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/28-Tlaxcala/supervisor/ruta/lista_super.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Enrutar</h4>
                </div>
            </a>
        </div>

    </div>

    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>
        <h1>Listado de Usuarios</h1>

        <div class="search-container">
            <input type="text" id="search-input" class="search-input" placeholder="Buscar...">
        </div>

        <div class="table-scroll-container">
            <table class="table-container">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Zona</th>
                    <th>Rol</th>
                </tr>
                <?php
                 // Ajustamos la consulta SQL para incluir los nombres de la zona y el rol
                 $sql = $conexion->query("SELECT u.ID, u.Nombre, u.Apellido, u.Email, z.Nombre AS NombreZona, r.Nombre AS NombreRol 
                                          FROM usuarios u
                                          LEFT JOIN zonas z ON u.Zona = z.ID
                                          LEFT JOIN roles r ON u.RolID = r.ID
                                          WHERE u.RolID = 3 AND u.Zona = 22
                                          ORDER BY u.ID DESC");

                 // Verificar si la consulta se realizó con éxito
                 if ($sql === false) {
                     die("Error en la consulta SQL: " . $conexion->error);
                 }

                 // Verificar si la consulta devolvió resultados
                 if ($sql->num_rows > 0) {
                     $rowCount = 0; // Contador de filas
                     while ($datos = $sql->fetch_object()) { 
                         $rowCount++; // Incrementar el contador de filas
                         ?>
                <tr class="row<?= $rowCount ?>">
                    <td><?= "REC 100" . $datos->ID ?></td>
                    <td><?= $datos->Nombre ?></td>
                    <td><?= $datos->Apellido ?></td>
                    <td><?= $datos->Email ?></td>
                    <td><?= $datos->NombreZona // Cambiado para mostrar el nombre de la zona ?></td>
                    <td><?= $datos->NombreRol // Cambiado para mostrar el nombre del rol ?></td>
                </tr>
                <?php } 
                 } else {
                     echo "No se encontraron resultados.";
                 }
                 ?>
            </table>
        </div>
    </main>

    <script>
    // JavaScript para la búsqueda en tiempo real
    const searchInput = document.getElementById('search-input');
    const table = document.querySelector('table');
    const rows = table.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value.toLowerCase();

        rows.forEach((row) => {
            const rowData = Array.from(row.children)
                .map((cell) => cell.textContent.toLowerCase())
                .join('');

            if (rowData.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>

    <script src="/public/assets/js/MenuLate.js"></script>

</body>

</html>