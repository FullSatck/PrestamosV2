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
    <div class="return-button">
        <a href="javascript:history.go(-1)" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
    </div>

    <!-- Navegacion bar -->
    <h1 class="text-center">Listado de Usuarios</h1>

    <!-- Barra de búsqueda a la derecha -->
    <div class="search-container">
        <div class="search-input">
            <input type="text" id="search-input" class="form-control" placeholder="Buscar...">
            <button type="button" id="search-button" class="btn btn-primary"><i class="fas fa-search"></i></button>
        </div>
    </div>

    <div class="table-container">
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
                $sql = $conexion->query("SELECT Usuarios.ID, Usuarios.Nombre, Usuarios.Apellido, Usuarios.Email, Zonas.Nombre AS Zona, Roles.Nombre AS Rol FROM Usuarios JOIN Zonas ON Usuarios.Zona = Zonas.ID JOIN Roles ON Usuarios.RolID = Roles.ID");
                while ($datos = $sql->fetch_object()) { ?>
                    <tr>
                        <td><?= $datos->ID ?></td>
                        <td><?= $datos->Nombre ?></td>
                        <td><?= $datos->Apellido ?></td>
                        <td><?= $datos->Email ?></td>
                        <td><?= $datos->Zona ?></td>
                        <td><?= $datos->Rol ?></td>
                        <td><a href="/lognprin/admi/instructor/modificar_instruc.php?id=<?= $datos->ID ?>"><i class="fas fa-user-pen fa-lg"></i></a></td>
                        <td><a href="/lognprin/admi/instructor/eliminar_instru.php?id=<?= $datos->ID ?>" onclick="return confirm('¿Estás seguro de eliminar?')"><i class="fas fa-trash fa-lg"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var searchInput = document.getElementById("search-input");
            searchInput.addEventListener("input", function () {
                var searchTerm = searchInput.value.toLowerCase();
                var tableRows = document.getElementsByTagName("tr");

                for (var i = 1; i < tableRows.length; i++) {
                    var row = tableRows[i];
                    var rowData = row.innerText.toLowerCase();

                    if (rowData.includes(searchTerm)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                }
            });
        });
    </script>
</body>
</html>
