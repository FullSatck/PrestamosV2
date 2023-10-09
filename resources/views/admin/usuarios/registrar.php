

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Asegúrate de incluir esta línea para hacer tu sitio web responsive -->
    <title>Registro de Usuario</title>
    <link rel="stylesheet" type="text/css" href="/public/assets/css/registrar_usuarios.css">
</head>

<body>
    <!-- Código para mostrar el mensaje emergente -->
   

    <div class="registro-container">
        <h2>Registro de Usuario</h2>
        <form action="/controllers/validar_registro.php" method="post">
            <div class="input-container">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Por favor ingrese su nombre" required>
            </div>
            <div class="input-container">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" placeholder="Por favor ingrese su apellido" required>
            </div>
            <div class="input-container">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" placeholder="Por favor ingrese su correo" required>
            </div>
            <div class="input-container">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="Por favor ingrese su clave"
                    required>
            </div>
            <div class="input-container">
                <label for="zona">Zona:</label>
                <select id="zona" name="zona" placeholder="Por favor ingrese la zona" required>
                    <?php
                    // Incluye el archivo de conexión a la base de datos
                    include("../../../../controllers/conexion.php");
                    // Consulta SQL para obtener las zonas
                    $consultaZonas = "SELECT ID, Nombre FROM zonas";
                    $resultZonas = mysqli_query($conexion, $consultaZonas);
                    // Genera las opciones del menú desplegable para Zona
                    while ($row = mysqli_fetch_assoc($resultZonas)) {
                        echo '<option value="' . $row['ID'] . '">' . $row['Nombre'] . '</option>';
                    }
                    ?>
                </select>
            </div>
        
            <div class="input-container">
                <label for="rol">Rol:</label>
                <select id="rol" name="rol" required>
                    <?php
                    // Consulta SQL para obtener las opciones de roles
                    $consultaRoles = "SELECT ID, Nombre FROM Roles";
                    $resultRoles = mysqli_query($conexion, $consultaRoles);
                    // Genera las opciones del menú desplegable para Rol
                    while ($row = mysqli_fetch_assoc($resultRoles)) {
                        echo '<option value="' . $row['ID'] . '">' . $row['Nombre'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="btn-container">
                <button type="submit">Registrar</button>
                <a href="/resources/views/admin/inicio/inicio.php" class="a">Volver</a>
            </div>
        </form>
    </div>

    <!-- Resto de tu código HTML y JavaScript aquí -->

    <script>
        // JavaScript para mostrar el mensaje emergente
        window.onload = function() {
            var mensajeEmergente = document.getElementById('mensaje-emergente');
            if (mensajeEmergente.innerHTML !== "") {
                mensajeEmergente.style.display = 'block';
                setTimeout(function() {
                    mensajeEmergente.style.display = 'none';
                }, 5000); // El mensaje se ocultará después de 5 segundos (puedes ajustar el tiempo)
            }
        };
    </script> 
</body>

</html>
