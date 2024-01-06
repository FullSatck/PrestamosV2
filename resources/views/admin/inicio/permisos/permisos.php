<?php
session_start();



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Permisos</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
    
</head>

<body>
    <div class="message-container">
        <?php
        // Mostrar el mensaje de error si existe
        if (isset($_SESSION['error_message'])) {
            echo "<div class='error-message'>" . $_SESSION['error_message'] . "</div>";
            unset($_SESSION['error_message']);
        }

        // Mostrar el mensaje de éxito si existe
        if (isset($_SESSION['message'])) {
            echo "<div class='success-message'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }
        ?>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Asignar Permisos a Usuarios</h1>
                    </div>
                    <div class="card-body">
                        <form method="post" action="assignPermissions.php">
                            <div class="form-group">
                                <label for="usuario_id">Selecciona un Usuario:</label>
                                <select class="form-control" name="usuario_id" id="usuario_id">
                                    <option value="">Seleccionar</option> <!-- Opción predeterminada para seleccionar -->
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
                                <label>Permisos Disponibles:</label>
                                <div id="permisos-list">
                                    <!-- Los permisos se cargarán aquí a través de Ajax -->
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Guardar Permisos</button>
                            </div>
                        </form>

                    </div>
                </div>


            </div>
        </div>
    </div>
   
    <script>
        // Esta función se ejecuta cuando se carga la página
        window.onload = function() {
            // Encuentra los elementos de mensaje
            var errorMessages = document.getElementsByClassName('error-message');
            var successMessages = document.getElementsByClassName('success-message');

            // Establece un temporizador para ocultar los mensajes de error
            setTimeout(function() {
                for (var i = 0; i < errorMessages.length; i++) {
                    if (errorMessages[i]) {
                        errorMessages[i].style.display = 'none';
                    }
                }
            }, 3000); // Oculta después de 3 segundos

            // Establece un temporizador para ocultar los mensajes de éxito
            setTimeout(function() {
                for (var i = 0; i < successMessages.length; i++) {
                    if (successMessages[i]) {
                        successMessages[i].style.display = 'none';
                    }
                }
            }, 3000); // Oculta después de 3 segundos
        };
    </script>
    <script>
        // Cargar permisos disponibles al seleccionar un usuario
        $("#usuario_id").on("change", function() {
            var usuario_id = $(this).val();
            $.ajax({
                url: "cargar_permisos.php", // Ruta a tu archivo PHP para cargar permisos
                method: "POST",
                data: {
                    usuario_id: usuario_id
                },
                success: function(data) {
                    $("#permisos-list").html(data);
                }
            });
        });
    </script>
</body>

</html>