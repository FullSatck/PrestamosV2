<?php
session_start();

// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
    exit();
}


// Verificar si se ha pasado un mensaje en la URL
$mensaje = "";
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}

// Obtener el nombre de la zona desde la URL
if (isset($_GET['zona'])) {
    $nombreZona = $_GET['zona'];

    // Conectar a la base de datos
    include("../../../../controllers/conexion.php");

    // Consulta para obtener los usuarios con rol 2 (supervisores) en la zona especificada
    $sql = $conexion->prepare("SELECT U.ID, U.Nombre, U.Apellido, U.Email, Zonas.Nombre AS Zona, Roles.Nombre AS Rol FROM Usuarios U JOIN Roles ON U.RolID = Roles.ID JOIN Zonas ON U.Zona = Zonas.ID WHERE U.RolID = 3 AND Zonas.Nombre = ?");
    $sql->bind_param("s", $nombreZona);
    $sql->execute();
    $result = $sql->get_result();

    // Verificar si se encontraron supervisores en la zona
    $supervisoresEnZona = $result->num_rows > 0;
} else {
    // Si no se proporciona un nombre de zona válido, establecer $supervisoresEnZona en falso
    $supervisoresEnZona = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="/public/assets/css/vercobradores.css">
    <title>Zona: <?= $nombreZona ?></title>
</head>

<body>
    <div class="menu">
        <ion-icon name="menu-outline"></ion-icon>
        <ion-icon name="close-circle-outline"></ion-icon>
    </div>
    <div class="barra-lateral">
        <div>
            <div class="nombre-pagina"> 
                <ion-icon id="cloud" name="wallet-outline"></ion-icon>
                <span>Recaudo</span>
            </div> 
            <button class="boton" id="volverAtras"> 
                <ion-icon name="arrow-undo-outline"></ion-icon>
                <span>&nbsp;Volver</span>
            </button>
        </div>
        <nav class="navegacion">
            <ul>
                <li>
                    <a href="/resources/views/admin/admin_saldo/saldo_admin.php">
                        <ion-icon name="push-outline"></ion-icon>
                        <span>Saldo Inicial</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/inicio/inicio.php">
                        <ion-icon name="home-outline"></ion-icon>
                        <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/usuarios/crudusuarios.php">
                        <ion-icon name="people-outline"></ion-icon>
                        <span>Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/usuarios/registrar.php">
                        <ion-icon name="person-add-outline"></ion-icon>
                        <span>Registrar Usuario</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/clientes/lista_clientes.php">
                        <ion-icon name="people-circle-outline"></ion-icon>
                        <span>Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/clientes/agregar_clientes.php">
                        <ion-icon name="person-circle-outline"></ion-icon>
                        <span>Registrar Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/creditos/crudPrestamos.php">
                        <ion-icon name="list-outline"></ion-icon>
                        <span>Prestamos</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/creditos/prestamos.php">
                        <ion-icon name="cloud-upload-outline"></ion-icon>
                        <span>Registrar Prestamos</span>
                    </a>
                </li> 
                <li>
                    <a href="/resources/views/admin/cobros/cobros.php">
                        <ion-icon name="planet-outline"></ion-icon>
                        <span>Zonas de cobro</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/gastos/gastos.php">
                        <ion-icon name="alert-circle-outline"></ion-icon>
                        <span>Gastos</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/abonos/lista_super.php" class="hola">
                        <ion-icon name="map-outline"></ion-icon>
                        <span>Ruta</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/abonos/abonos.php">
                        <ion-icon name="cloud-download-outline"></ion-icon>
                        <span>Abonos</span>
                    </a>
                </li>
                <li>
                    <a href="/resources/views/admin/retiros/retiros.php">
                        <ion-icon name="cloud-done-outline"></ion-icon>
                        <span>Retiros</span>
                    </a>
                </li> 
            </ul>
        </nav>

        <div>
            <div class="linea"></div>

            <div class="modo-oscuro">
            <div class="info">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    <a href="/controllers/cerrar_sesion.php"><span>Cerrar Sesion</span></a>
                </div> 
            </div>
        </div>

    </div>


    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>   
    <h1 class="text-center">Listado de Cobradores en Zona: <?= $nombreZona ?></h1>

<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-9">
            <?php
            if ($supervisoresEnZona) {
                // Mostrar la tabla solo si hay supervisores en la zona
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th> 
                            <th scope="col">Email</th>
                            <th scope="col">Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($datos = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?= "REC 100" . $datos['ID'] ?></td>
                                <td><?= $datos['Nombre'] ?></td>
                                <td><?= $datos['Apellido'] ?></td>
                                <td><?= $datos['Email'] ?></td>
                                <td><?= $datos['Rol'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php
            } else {
                // Mostrar un mensaje si no se encontraron supervisores en la zona
                echo "No se encontraron supervisores para la zona: " . $nombreZona;
            }
            ?>
        </div>
    </div>
</div>
    </main>

    <script>
        // Agregar un evento clic al botón
        document.getElementById("volverAtras").addEventListener("click", function() {
            window.history.back();
        });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="/menu/main.js"></script>

</body>

</html>







































<!DOCTYPE html>
<html lang="en">

<body>
    <!-- Botón para volver a la página anterior -->
     
</body>
</html>
