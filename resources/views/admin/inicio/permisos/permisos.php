<!DOCTYPE html>
<html>
<head>
    <title>Asignar Permisos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .asignado {
            font-weight: bold;
            color: green; /* Cambiamos el color a verde */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center">Asignar Permisos a Usuarios</h1>
                    </div>
                    <div class="card-body">
                        <form method="post" action="assignPermissions.php"> <!-- El formulario se envía a sí mismo -->
                            <div class="form-group">
                                <label for="usuario_id">Selecciona un Usuario:</label>
                                <select class="form-control" name="usuario_id" id="usuario_id">
                                    <!-- Aquí debes cargar la lista de usuarios desde la base de datos -->
                                    <!-- Por ejemplo, podrías usar un bucle PHP para generar las opciones -->
                                    <?php
                                       include "../../../../../controllers/conexion.php"; 

                                    $sql = "SELECT ID, nombre FROM usuarios";
                                    $result = $conexion->query($sql);

                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['ID'] . "'>" . $row['nombre'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Permisos Disponibles:</label><br>
                                <div id="permisos-list">
                                    <!-- Los permisos se cargarán aquí a través de Ajax -->
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-primary" value="Guardar Permisos">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Cargar permisos disponibles al seleccionar un usuario
        $("#usuario_id").on("change", function () {
            var usuario_id = $(this).val();
            $.ajax({
                url: "cargar_permisos.php", // Ruta a tu archivo PHP para cargar permisos
                method: "POST",
                data: { usuario_id: usuario_id },
                success: function (data) {
                    $("#permisos-list").html(data);
                }
            });
        });
    </script>
</body>
</html>
