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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/9454e88444.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/public/assets/css/cruduser.css">
    <title>CRUD de Usuarios</title>
  
</head>
<body>
    <!-- Botón para volver a la página anterior -->
    <h1 class="text-center">Listado de Usuarios</h1>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Barra de búsqueda a la izquierda -->
                <div class="search-container">
                    <div class="search-input">
                        <input type="text" id="search-input" class="form-control" placeholder="Buscar...">
                        <button type="button" id="search-button" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <!-- Botón para registrar trabajadores -->
                <div class="register-button">
                    <a href="registrar.php" class="btn btn-success"><i class="fas fa-user-plus"></i> Registrar Trabajador</a>
                </div>
            </div>
            <div class="col-md-9">
                <!-- Botón para volver a la página anterior -->
                <div class="return-button">
                    <a href="javascript:history.go(-1)" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
                </div>

                <div class="table-container">
                    <!-- Código para mostrar el mensaje emergente -->
                    <?php if (!empty($mensaje)) : ?>
                        <div class="alert alert-success">
                            <?php echo htmlspecialchars($mensaje); ?>
                        </div>
                    <?php endif; ?>
                    <!-- Fin del código para mostrar el mensaje emergente -->

                    <!-- Resto del código de la tabla -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Email</th>
                                <th scope="col">Zona</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Editar</th>
                                <th scope="col">Borrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include("../../../../controllers/conexion.php");
                            $sql = $conexion->query("SELECT Usuarios.ID, Usuarios.Nombre, Usuarios.Apellido, Usuarios.Email, ZonaID.Nombre AS Zona, Roles.Nombre AS Rol FROM Usuarios JOIN Zona ON Usuarios.Zona = Zonas.ID JOIN Roles ON Usuarios.RolID = Roles.ID");
                            $rowCount = 0; // Contador de filas
                            while ($datos = $sql->fetch_object()) { 
                                $rowCount++; // Incrementar el contador de filas
                                ?>
                                <tr class="row<?= $rowCount ?>">
                                    <td><?= "REC 100" .$datos->ID ?></td>
                                    <td><?= $datos->Nombre ?></td>
                                    <td><?= $datos->Apellido ?></td>
                                    <td><?= $datos->Email ?></td>
                                    <td><?= $datos->Zona ?></td>
                                    <td><?= $datos->Rol ?></td>
                                    <td><a href="/resources/views/admin/usuarios/modificarUser.php?id=<?= $datos->ID ?>"><i class="fas fa-user-pen fa-lg"></i></a></td>
                                    <td><a href="/lognprin/admi/instructor/eliminar_instru.php?id=<?= $datos->ID ?>" onclick="return confirm('¿Estás seguro de eliminar?')"><i class="fas fa-trash fa-lg"></i></a></td>
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
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var searchInput = document.getElementById("search-input");
            var tableRows = document.getElementsByTagName("tr");
            var itemsPerPage = 10; // Número de elementos por página
            var currentPage = 1;

            // Función para mostrar los elementos de la página actual
            function showPage(page) {
                for (var i = 1; i < tableRows.length; i++) {
                    if (i >= (page - 1) * itemsPerPage + 1 && i <= page * itemsPerPage) {
                        tableRows[i].style.display = "";
                    } else {
                        tableRows[i].style.display = "none";
                    }
                }
            }

            // Función para generar los botones de paginación
            function generatePagination() {
                var totalPages = Math.ceil((tableRows.length - 1) / itemsPerPage);
                var paginationElement = document.getElementById("pagination");
                paginationElement.innerHTML = "";

                for (var i = 1; i <= totalPages; i++) {
                    var li = document.createElement("li");
                    var a = document.createElement("a");
                    a.href = "#";
                    a.textContent = i;

                    a.addEventListener("click", function (event) {
                        currentPage = parseInt(event.target.textContent);
                        showPage(currentPage);
                    });

                    li.appendChild(a);
                    paginationElement.children[0].appendChild(li);
                }
            }

            // Mostrar la página 1 al cargar la página
            showPage(currentPage);
            // Generar botones de paginación
            generatePagination();

            // Evento para manejar la búsqueda
            searchInput.addEventListener("input", function () {
                var searchTerm = searchInput.value.toLowerCase();
                currentPage = 1; // Reiniciar a la página 1 después de la búsqueda

                for (var i = 1; i < tableRows.length; i++) {
                    var row = tableRows[i];
                    var rowData = row.innerText.toLowerCase();

                    if (rowData.includes(searchTerm)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                }

                // Regenerar botones de paginación
                generatePagination();
                // Mostrar la página 1 después de la búsqueda
                showPage(currentPage);
            });
        });
    </script> 
</body>
</html>
