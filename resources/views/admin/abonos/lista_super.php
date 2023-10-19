<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) { 
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

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
    <link rel="stylesheet" href="/public/assets/css/lista_super.css">
    <title>Abonos</title>
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
                    <ion-icon name="moon-outline"></ion-icon>
                    <span>Dark Mode</span>
                </div>
                <div class="switch">
                    <div class="base">
                        <div class="circulo">

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>  
        <!-- Botón para volver a la página anterior -->
    <h1 class="text-center">Listado de Supervisores</h1>

<div class="container-fluid"> 

        <!-- Resto del código de la tabla --> 
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th> 
                    <th scope="col">Zona</th>
                    <th scope="col">Rol</th> 
                    <th scope="col">Acciones</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                include("../../../../controllers/conexion.php");
                $sql = $conexion->prepare("SELECT Usuarios.ID, Usuarios.Nombre, Usuarios.Apellido, Usuarios.Email, Zonas.Nombre AS Zona, Roles.Nombre AS Rol FROM Usuarios JOIN Zonas ON Usuarios.Zona = Zonas.ID JOIN Roles ON Usuarios.RolID = Roles.ID WHERE Roles.ID = 2"); // Filtra por el ID del rol de supervisor (2)
                
                // Verificar si la preparación de la consulta fue exitosa
                if ($sql === false) {
                    die("La preparación de la consulta SQL falló: " . $conexion->error);
                }
                
                // Ejecutar la consulta
                if (!$sql->execute()) {
                    die("La ejecución de la consulta SQL falló: " . $sql->error);
                }

                $result = $sql->get_result();
                $rowCount = 0; // Contador de filas
                while ($datos = $result->fetch_object()) { 
                    $rowCount++; // Incrementar el contador de filas
                    ?>
                    <tr class="row<?= $rowCount ?>">
                        <td><?= "REC 100" .$datos->ID ?></td>
                        <td><?= $datos->Nombre ?></td>
                        <td><?= $datos->Apellido ?></td>
                        <td><?= $datos->Zona ?></td>
                        <td><?= $datos->Rol ?></td> 
                        <td>
                            <!-- Botón para ver los cobradores de la zona -->
                            <a href="ver_cobradores.php?zona=<?= urlencode($datos->Zona) ?>" class="btn btn-primary">Ver Cobradores</a>
                            <a href="ver_prestamos.php?zona=<?= urlencode($datos->Zona) ?>" class="btn btn-primary">Ver Prestamos</a>
                            <a href="ruta.php?zona=<?= urlencode($datos->Zona) ?>" class="btn btn-primary">Ruta</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div id="pagination" class="text-center">
        <ul class="pagination">
            <!-- Los botones de paginación se generarán aquí -->
        </ul>
    </div>
</div>
    </main>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="/menu/main.js"></script>

 