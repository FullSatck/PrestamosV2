<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // El usuario no ha iniciado sesión, redirigir al inicio de sesión
    header("location: ../../../../index.php");
    exit();
}

// Incluye la configuración de conexión a la base de datos
include "../../../../controllers/conexion.php"; // Asegúrate de que la ruta sea correcta

// Obtener todos los clientes de la base de datos
$sql = "SELECT * FROM clientes";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $clientes = $resultado->fetch_all(MYSQLI_ASSOC);
    // Liberar el resultado
    $resultado->free();
} else {
    // No se encontraron clientes en la base de datos, puedes manejar esto de acuerdo a tus necesidades
    echo "No se encontraron clientes en la base de datos.";
    exit();
}

// Obtener el cliente actual
$clienteActual = 0;

if (isset($_GET['cliente_id']) && is_numeric($_GET['cliente_id'])) {
    $clienteID = $_GET['cliente_id'];

    // Buscar el índice del cliente en el array
    $clienteIndex = array_search($clienteID, array_column($clientes, 'ID'));

    if ($clienteIndex !== false) {
        $clienteActual = $clienteIndex;
    } else {
        // El cliente no se encontró en el array, puedes manejar esto de acuerdo a tus necesidades
        echo "Cliente no encontrado.";
    }
}

// Obtener el cliente actual
$cliente = $clientes[$clienteActual];

// Obtener Plazo y Cuota de la tabla Prestamos
$sqlPrestamo = "SELECT Plazo, Cuota FROM Prestamos WHERE IDCliente = {$cliente['ID']}";
$resultadoPrestamo = $conexion->query($sqlPrestamo);

if ($resultadoPrestamo->num_rows > 0) {
    $prestamo = $resultadoPrestamo->fetch_assoc();
    // Liberar el resultado
    $resultadoPrestamo->free();
} else {
    // No se encontraron datos de préstamo para este cliente, puedes manejar esto de acuerdo a tus necesidades
    echo "No se encontraron datos de préstamo para este cliente.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abonos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/assets/css/abonos.css">
</head>
<body>
    <!-- Barra de navegación -->
    <div class="navbar">
        <button id="fecha-izquierda" class="boton-flecha">&larr;</button> <!-- Flecha hacia la izquierda -->
        <button id="menu" class="boton-menu" onclick="redireccionar()">&#8801;</button> <!-- Menu -->
        <button id="fecha-derecha" class="boton-flecha">&rarr;</button> <!-- Flecha hacia la derecha -->
    </div><br>

    <div class="cobro-bar">
        <span class="cobro-text">Cobro</span>
    </div>

    <!-- Recuadro para campos en dos columnas -->
    <div class="field-container">
        <!-- Columna 1: Nombre y Apellido del Cliente -->
        <div class="column">
            <label for="nombre" style="color: blue;">Nombre: </label> <br>
            <span id="nombre"><?php echo $cliente['Nombre']; ?></span>
        </div>

        <!-- Columna 2: Domicilio, Tel/Cel, Fecha y Plazo -->
        <div class="column">
            <label for="domicilio" style="color: blue;">Domicilio: </label> <br>
            <span id="domicilio"><?php echo $cliente['Domicilio']; ?></span>
        </div>

        <div class="column">
            <label for="tel_cel" style="color: blue;">Tel/Cel: </label> <br>
            <span id="tel_cel"><?php echo $cliente['Telefono']; ?></span>
        </div>

        <div class="column">
            <label for="cuota" style="color: blue;">Cuota: </label> 
            <span id="cuota"><?php echo $prestamo['Cuota']; ?></span>
        </div>

        <div class="column">
            <label for="plazo" style="color: blue;">Plazo: </label> <br>
            <span id="plazo"><?php echo $prestamo['Plazo']; ?></span>
        </div>
    </div>

    <div class="field-container">
        <!-- Fila 3: Pagar y Cuota -->
        <div class="column">
            <label for="pagar" style="color: blue;">Pagar: </label>
            <input type="text" id="pagar" placeholder="Ingrese la cantidad a pagar">
        </div>

        <div class="column" style="position: relative;">
            <label for="fecha" style="color: blue;">Fecha: </label>
            <input type="text" id="fecha" placeholder="28/09/2023 6:52 p.m">
            <button id="calendarioBtn" onclick="mostrarCalendario()">Calendario</button>
        </div>
    </div>

    <!-- Botón de guardar -->
    <button class="btn-guardar">Guardar</button>

    <script>
        // Datos de los clientes
        var clientes = <?php echo json_encode($clientes); ?>;

        // Índice del cliente actual
        var clienteActual = <?php echo $clienteActual; ?>;

        // Mostrar cliente actual
        function mostrarCliente(clienteIndex) {
            var cliente = clientes[clienteIndex];
            document.getElementById("nombre").textContent = cliente.Nombre;
            document.getElementById("domicilio").textContent = cliente.Domicilio;
            document.getElementById("tel_cel").textContent = cliente.Telefono;
            document.getElementById("plazo").textContent = cliente.Plazo;
            document.getElementById("pagar").value = ""; // Limpia el campo de pagar
            document.getElementById("cuota").textContent = cliente.Cuota;
        }

        mostrarCliente(clienteActual);

        // Función para actualizar el plazo y la cuota según el cliente actual
        function actualizarPlazoYCuota(clienteIndex) {
            var cliente = clientes[clienteIndex];
            document.getElementById("plazo").textContent = cliente.Plazo;
            document.getElementById("cuota").textContent = cliente.Cuota;
        }

        document.getElementById("fecha-izquierda").addEventListener("click", function () {
            if (clienteActual > 0) {
                clienteActual--;
                mostrarCliente(clienteActual);
                actualizarPlazoYCuota(clienteActual); // Llama a la función para actualizar plazo y cuota
            }
        });

        document.getElementById("fecha-derecha").addEventListener("click", function () {
            if (clienteActual < clientes.length - 1) {
                clienteActual++;
                mostrarCliente(clienteActual);
                actualizarPlazoYCuota(clienteActual); // Llama a la función para actualizar plazo y cuota
            }
        });

        function mostrarCalendario() {
            $("#fecha").datepicker({
                dateFormat: "dd/mm/yy hh:mm tt", // Formato de fecha y hora deseado
                showTimepicker: true, // Permite seleccionar la hora
                timeFormat: "hh:mm tt", // Formato de hora
                position: 'right' // Muestra el calendario al lado derecho de la casilla
            });
        }

        function redireccionar() {
            // Aquí debes proporcionar la URL del archivo al que deseas redirigir
            var nuevaURL = "../clientes/lista_clientes.php";
        
            // Redirige a la nueva URL
            window.location.href = nuevaURL;
        }
    </script>
</body>
</html>
