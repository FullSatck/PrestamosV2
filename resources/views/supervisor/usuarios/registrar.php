<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" type="text/css" href="/public/assets/css/registrar_usuarios.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="registro-container">
        <h2>Registro de Usuario</h2>
        <form action="/controllers_USU/validar_registro.php" method="post">
            <div class="input-container">
                <label for="nombre"><Strong>Nombre:</Strong></label>
                <input type="text" id="nombre" name="nombre" placeholder="Por favor ingrese su nombre" required>
            </div>
            <div class="input-container">
                <label for="apellido"><Strong>Apellido:</Strong></label>
                <input type="text" id="apellido" name="apellido" placeholder="Por favor ingrese su apellido" required>
            </div>
            <div class="input-container">
                <label for="email"><Strong>Correo Electrónico:</Strong></label>
                <input type="email" id="email" name="email" placeholder="Por favor ingrese su correo" required>
            </div>
            <div class="input-container">
                <label for="contrasena"><Strong>Contraseña:</Strong></label>
                <input type="password" id="contrasena" name="contrasena" placeholder="Por favor ingrese su clave" required>
            </div>
            <div class="input-container">
                <label for="zona"><Strong>Zona:</Strong></label>
                <select id="zona" name="zona" required>
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
                <label for="RolID"><Strong>Rol:</Strong></label>
                <?php
                // Consulta SQL para obtener el nombre del rol
                $consultaRol = "SELECT Nombre FROM Roles WHERE ID = 3";
                $resultRol = mysqli_query($conexion, $consultaRol);
    
                if ($row = mysqli_fetch_assoc($resultRol)) {
                    // Imprime el nombre del rol
                    echo $row['Nombre'];
                } else {
                    echo "Rol no encontrado"; // Puedes mostrar un mensaje si el rol no se encuentra
                }
                ?>
            </div>


            <div class="input-container" id="saldo-inicial-container" style="display: none;">
                <label for="saldo-inicial">Saldo Inicial:</label>
                <input type="text" id="saldo-inicial" name="saldo-inicial" placeholder="Por favor ingrese el saldo inicial">
            </div>

            <div class="btn-container">
                <button type="submit" name="registrar_usuario">Registrar</button>
                <a href="/resources/views/admin/inicio/inicio.php" class="a">Volver</a>
            </div>
        </form>
    </div>

    <script>
        // Agrega un evento para detectar cambios en la selección del rol
        $(document).ready(function() {
            $("#RolID").on("change", function() {
                var selectedRole = $(this).val();
                var saldoInicialContainer = $("#saldo-inicial-container");
                if (selectedRole === "2") {
                    saldoInicialContainer.show();
                } else {
                    saldoInicialContainer.hide();
                }
            });
        });
    </script>
</body>
</html>
