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

// Conectar a la base de datos
include("../../../../controllers/conexion.php");

// Consulta SQL para obtener los préstamos de la zona especificada con el nombre del cliente
$sql = $conexion->prepare("SELECT P.ID, C.Nombre AS NombreCliente, P.Zona, P.Monto FROM prestamos P INNER JOIN clientes C ON P.IDCliente = C.ID ORDER BY ID DESC");
$sql->execute();

// Verificar si la consulta se realizó con éxito
if ($sql === false) {
    die("Error en la consulta SQL: " . $conexion->error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recaudo</title>
    <link rel="stylesheet" href="/public/assets/css/cobro_inicio.css">
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
                    <a href="/resources/views/admin/inicio/inicio.php" class="hola">
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
                    <a href="/resources/views/admin/abonos/lista_super.php">
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
        <h1>Cobros totales</h1>

        <div class="search-container">
            <input type="text" id="search-input" class="search-input" placeholder="Buscar...">
        </div>

        <div class="container-fluid">
            <div class="row">

                <div class="col-md-9">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID del Préstamo</th>
                                <th scope="col">Nombre del Cliente</th>
                                <th scope="col">Zona</th>
                                <th scope="col">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$result = $sql->get_result();
$rowCount = 0; // Contador de filas
while ($datos = $result->fetch_assoc()) { 
    $rowCount++; // Incrementar el contador de filas
    $montoFormateado = number_format($datos['Monto'], 0, '.', '.'); // Formatear Monto
    ?>
                            <tr class="row<?= $rowCount ?>">
                                <td><?= "Cobro REC-10" . $datos['ID'] ?></td>
                                <td><?= $datos['NombreCliente'] ?></td>
                                <td><?= $datos['Zona'] ?></td>
                                <td><?= $montoFormateado ?></td> <!-- Mostrar Monto formateado -->
                            </tr>
                            <?php } 
// Cerrar la consulta y la conexión a la base de datos
$sql->close();
$conexion->close();
?>

                        </tbody>
                    </table>
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
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("search-input");
        const rows = document.querySelectorAll(".table tbody tr");

        searchInput.addEventListener("input", function() {
            const searchTerm = searchInput.value.trim().toLowerCase();

            rows.forEach(function(row) {
                const columns = row.querySelectorAll("td");
                let found = false;

                columns.forEach(function(column, index) {
                    const text = column.textContent.toLowerCase();
                    if (index === 0 && text.includes(searchTerm)) {
                        found = true; // Search only in the first (ID) column
                    } else if (index !== 0 && text.includes(searchTerm)) {
                        found = true; // Search in other columns
                    }
                });

                if (found) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });
    </script>



    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="/menu/main.js"></script>

</body>

</html>