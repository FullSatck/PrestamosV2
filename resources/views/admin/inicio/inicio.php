<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/9454e88444.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
    <title>CRUD de Usuarios</title>
</head>
<body>
    <?php
    session_start();

    // Verificar si hay un mensaje en la variable de sesión
    if (isset($_SESSION["mensaje"])) {
        echo '<div class="alert alert-success">' . $_SESSION["mensaje"] . '</div>';

        // Limpiar el mensaje de la variable de sesión después de mostrarlo
        unset($_SESSION["mensaje"]);
    }
    ?>

    <!-- Navegacion bar -->
    <header class="header">
        <div class="logo">
            <a href="/index.html">
                <img src="/img/Logo.png" alt="logoImagen">
            </a>
        </div>
        <nav>
            <ul class="nav-links">
                <a href="/lognprin/admi/index.php" class="boton"><button>Inicio</button></a>
                <a href="/lognprin/admi/instructor/regist_instru/instructor.php"" class="boton"><button>Ingresar instructor</button></a>
            </ul>
        </nav>
    </header>

    <h1 class="text-center">Listado de Usuarios</h1>

    <div class="search-container">
        <div class="input-group">
            <input type="text" id="search-input" class="form-control" placeholder="Buscar...">
            <button type="button" id="search-button" class="btn btn-primary"><i class="fas fa-search"></i></button>
        </div>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Email</th>
                    <th scope="col">Zona</th>
                    <th scope="col">Moneda Preferida</th>
                    <th scope="col">Rol</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Borrar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "../../..//conexion/conexion.php";
                $sql = $conexion->query("SELECT u.ID, u.Nombre, u.Apellido, u.Email, z.Nombre AS Zona, m.Nombre AS MonedaPreferida, r.Nombre AS Rol
                                        FROM Usuarios u
                                        LEFT JOIN Monedas m ON u.MonedaPreferida = m.ID
                                        LEFT JOIN Roles r ON u.RolID = r.ID
                                        LEFT JOIN Zonas z ON u.ZonaID = z.ID");

                while ($datos = $sql->fetch_object()) { ?>
                    <tr>
                        <td><?= $datos->ID ?></td>
                        <td><?= $datos->Nombre ?></td>
                        <td><?= $datos->Apellido ?></td>
                        <td><?= $datos->Email ?></td>
                        <td><?= $datos->Zona ?></td>
                        <td><?= $datos->MonedaPreferida ?></td>
                        <td><?= $datos->Rol ?></td>
                        <td><a href="/lognprin/admi/instructor/modificar_instruc.php?id=<?= $datos->ID ?>"><i
                                    class="fas fa-user-pen fa-lg"></i></a>
                        </td>
                        <td><a href="/lognprin/admi/instructor/eliminar_instru.php?id=<?= $datos->ID ?>"
                                onclick="return confirm('¿Estás seguro de eliminar?')"><i class="fas fa-trash fa-lg"></i></a></td>
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
