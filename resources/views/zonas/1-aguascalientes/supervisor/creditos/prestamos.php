<?php
session_start();

// Validacion de rol para ingresar a la pagina 
require_once '../../../../../../controllers/conexion.php'; 

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location:../../../../../../index.php");
    exit();
} else {
    // El usuario está autenticado, obtén el ID del usuario de la sesión
    $usuario_id = $_SESSION["usuario_id"];
    
    // Preparar la consulta para obtener el rol del usuario
    $stmt = $conexion->prepare("SELECT roles.Nombre FROM usuarios INNER JOIN roles ON usuarios.RolID = roles.ID WHERE usuarios.ID = ?");
    $stmt->bind_param("i", $usuario_id);
    
    // Ejecutar la consulta
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();

    // Verifica si el resultado es nulo, lo que significaría que el usuario no tiene un rol válido
    if (!$fila) {
        // Redirige al usuario a una página de error o de inicio
        header("Location: /ruta_a_pagina_de_error_o_inicio.php");
        exit();
    }

    // Extrae el nombre del rol del resultado
    $rol_usuario = $fila['Nombre'];
    
    // Verifica si el rol del usuario corresponde al necesario para esta página
    if ($rol_usuario !== 'supervisor') {
        // El usuario no tiene el rol correcto, redirige a la página de error o de inicio
        header("Location: /ruta_a_pagina_de_error_o_inicio.php");
        exit();
    }
    
   
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://kit.fontawesome.com/9454e88444.js" crossorigin="anonymous"></script>
    <title>Solicitud de Préstamo</title>
    <!-- Agrega aquí tus estilos CSS si es necesario -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/public/assets/css/prestamo.css">
</head>

<body id="body"> 

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>
    </header>

    <div class="menu__side" id="menu_side">

        <div class="name__page">
            <img src="/public/assets/img/logo.png" class="img logo-image" alt="">
            <h4>Recaudo</h4>
        </div>

        <div class="options__menu">

            <a href="/resources/views/zonas//supervisor/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/2-baja_california/supervisor/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/2-baja_california/supervisor/usuarios/registrar.php">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/2-baja_california/supervisor/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/2-baja_california/supervisor/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/2-baja_california/supervisor/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/2-baja_california/supervisor/creditos/prestamos.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-file-invoice-dollar" title=""></i>
                    <h4>Registrar Prestamos</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/2-baja_california/supervisor/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/2-baja_california/supervisor/ruta/lista_super.php">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Ruta</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/2-baja_california/supervisor/abonos/abonos.php">
                <div class="option">
                    <i class="fa-solid fa-money-bill-trend-up" title=""></i>
                    <h4>Abonos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/2-baja_california/supervisor/retiros/retiros.php">
                <div class="option">
                    <i class="fa-solid fa-scale-balanced" title=""></i>
                    <h4>Retiros</h4>
                </div>
            </a>



        </div>

    </div>


    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>
        <h1>Solicitud de Préstamo</h1><br><br>
        <form action="/controllers/super/procesar_prestamo.php" method="POST" class="form-container">
            <?php
            // Incluir el archivo de conexión a la base de datos
            include("../../../../../../controllers/conexion.php");

            // Obtener la lista de clientes, monedas y zonas desde la base de datos
            $query_clientes = "SELECT ID, Nombre FROM Clientes WHERE ZonaAsignada = 'Aguascalientes'";
            $query_monedas = "SELECT ID, Nombre, Simbolo FROM Monedas";
            $query_zonas = "SELECT Nombre FROM Zonas WHERE Nombre = 'Aguascalientes'";

            $result_clientes = $conexion->query($query_clientes);
            $result_monedas = $conexion->query($query_monedas);
            $result_zonas = $conexion->query($query_zonas);
            ?>
            <label for="id_cliente">Cliente:</label>
            <select name="id_cliente" required>
                <?php
                while ($row = $result_clientes->fetch_assoc()) {
                    echo "<option value='" . $row['ID'] . "'>" . $row['Nombre'] . "</option>";
                }
                ?>
            </select><br>

            <label for="monto">Monto:</label>
            <input type="text" name="monto" id="monto" required><br>

            <label for="tasa_interes">Tasa de Interés (%):</label>
            <input type="text" name="TasaInteres" id="TasaInteres" required><br>

            <label for="frecuencia_pago">Frecuencia de Pago:</label>
            <select name="frecuencia_pago" id="frecuencia_pago" required onchange="calcularMontoPagar()">
                <option value="diario">Diario</option>
                <option value="semanal">Semanal</option>
                <option value="quincenal">Quincenal</option>
                <option value="mensual">Mensual</option>
            </select><br>


            <label for="plazo">Plazo:</label>
            <input type="text" name="plazo" id="plazo" required><br>

            <label for="moneda_id">Moneda:</label>
            <select name="moneda_id" id="moneda_id" required onchange="calcularMontoPagar()">
                <?php
                while ($row = $result_monedas->fetch_assoc()) {
                    // Agregar el símbolo de la moneda como un atributo data-*
                    echo "<option value='" . $row['ID'] . "' data-simbolo='" . $row['Simbolo'] . "'>" . $row['Nombre'] . "</option>";
                }
                ?>
            </select><br>

            <!-- Reemplaza el campo de fecha de inicio con un campo de texto readonly -->
            <label for="fecha_inicio">Fecha de Inicio:</label>

            <input type="text" name="fecha_inicio" id="fecha_inicio" value="<?php echo date('Y-m-d '); ?>" readonly><br>



            <label for="zona">Zona:</label>
            <select name="zona" required>
                <?php
                while ($row = $result_zonas->fetch_assoc()) {
                    echo "<option value='" . $row['Nombre'] . "'>" . $row['Nombre'] . "</option>";
                }
                ?>
            </select><br>

            <div class="result-container">
                <h2>Resultados</h2>
                <p>Monto Total a Pagar: <span id="monto_a_pagar">0.00</span></p>
                <p>Plazo: <span id="plazo_mostrado">0 días</span></p>
                <p>Frecuencia de Pago: <span id="frecuencia_pago_mostrada">Diario</span></p>
                <p>Cantidad a Pagar por Cuota: <span id="cantidad_por_cuota">0.00</span></p>
                <p>Moneda: <span id="moneda_simbolo">USD</span></p>
            </div>

            <input type="submit" value="Hacer préstamo" class="calcular-button">
        </form>
    </main> 

    <script>
    function calcularMontoPagar() {
        // Obtener los valores ingresados por el usuario
        var monto = parseFloat(document.getElementById('monto').value);
        var tasa_interes = parseFloat(document.getElementById('TasaInteres').value);
        var plazo = parseFloat(document.getElementById('plazo').value);
        var frecuencia_pago = document.getElementById('frecuencia_pago').value;
        var moneda_select = document.getElementById('moneda_id');
        var moneda_option = moneda_select.options[moneda_select.selectedIndex];
        var simbolo_moneda = moneda_option.getAttribute('data-simbolo');

        // Calcular el monto total, incluyendo el interés
        var monto_total = monto + (monto * (tasa_interes / 100));

        // Calcular la cantidad a pagar por cuota
        var cantidad_por_cuota = monto_total / plazo;

        // Actualizar los elementos HTML para mostrar los resultados en tiempo real
        document.getElementById('monto_a_pagar').textContent = monto_total.toFixed(2);
        document.getElementById('plazo_mostrado').textContent = plazo + ' ' + getPlazoText(frecuencia_pago);
        document.getElementById('frecuencia_pago_mostrada').textContent = frecuencia_pago;
        document.getElementById('cantidad_por_cuota').textContent = cantidad_por_cuota.toFixed(2);
        document.getElementById('moneda_simbolo').textContent = simbolo_moneda;
    }

    function getPlazoText(frecuencia_pago) {
        switch (frecuencia_pago) {
            case 'diario':
                return 'día(s)';
            case 'semanal':
                return 'semana(s)';
            case 'quincenal':
                return 'quincena(s)';
            case 'mensual':
                return 'mes(es)';
            default:
                return 'día(s)';
        }
    }
    </script>
    <script src="/public/assets/js/MenuLate.js"></script>
    

</body>

</html>