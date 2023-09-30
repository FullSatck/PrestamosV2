<?php
session_start();
if (!$_SESSION['logged_in']) {
  header("location: ../../../../controllers/validar_login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Abonos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/public/assets/css/abonos.css" />
</head>
<body>

<!-- Barra de navegación -->
<div class="navbar">
    <button>&larr;</button> <!-- Flecha hacia la izquierda -->
    <button>&#8801;</button> <!-- Tres líneas horizontales -->
    <button>&rarr;</button> <!-- Flecha hacia la derecha -->
    <button class="separated-button">Añadir prestamo</button>
</div><br>

<div class="cobro-bar">
    <span class="cobro-text">Cobro</span>
</div>

<!-- Recuadro para campos en dos columnas -->
<div class="field-container">
    <!-- Columna 1: CURP/CED y Nombre -->
    <div class="column">
        <label for="curp_ced">1. CURP/CED</label>
        <input type="text" id="curp_ced" placeholder="Ingrese CURP/CED">
    </div>

    <!-- Columna 2: Domicilio, Tel/Cel, Fecha y Plazo -->
    <div class="column">
        <label for="domicilio">3. Domicilio</label>
        <input type="text" id="domicilio" placeholder="Ingrese el domicilio">
    </div>

    <div class="column">
        <label for="tel_cel">4. Tel/Cel</label>
        <input type="text" id="tel_cel" placeholder="Ingrese el teléfono o celular">
    </div>

    <div class="column">
        <label for="fecha">5. Fecha</label>
        <input type="text" id="fecha" placeholder="28/09/2023 6:52 p.m">
        <button id="calendarioBtn" onclick="mostrarCalendario()">Calendario</button>
    </div>

    <div class="column">
        <label for="plazo">6. Plazo</label>
        <input type="text" id="plazo" placeholder="Ingrese el plazo">
    </div>
</div>

<div class="field-container">
    <!-- Fila 3: Valor, Pagar y Cuota -->
    <div class="column">
        <label for="valor">7. Valor</label>
        <input type="text" id="valor" placeholder="Ingrese el valor">
    </div>

    <div class="column">
        <label for="pagar">8. Pagar</label>
        <input type="text" id="pagar" placeholder="Ingrese la cantidad a pagar">
    </div>

    <div class="column">
        <label for="cuota">9. Cuota</label>
        <input type="text" id="cuota" placeholder="Ingrese la cuota">
    </div>
</div>

<!-- Botón de guardar -->
<button class="btn-guardar">Guardar</button>


<div class="table-container">
    <table>
<thead>
        <tr>
            <th>Fecha Servidor</th>
            <th>Fecha Móvil</th>
            <th>Abono</th>
            <th>Saldo</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>01/01/2023</td>
            <td>02/01/2023</td>
            <td>100.00</td>
            <td>500.00</td>
        </tr>
        <tr>
            <td>02/01/2023</td>
            <td>03/01/2023</td>
            <td>150.00</td>
            <td>350.00</td>
        </tr>
        <tr>
            <td>03/01/2023</td>
            <td>04/01/2023</td>
            <td>75.00</td>
            <td>275.00</td>
        </tr>
        <!-- Puedes agregar más filas según sea necesario -->
    </tbody>

</table>


<script>
    $(function() {
        $("#fecha").datepicker({
            dateFormat: "dd/mm/yy hh:mm tt", // Formato de fecha y hora deseado
            showTimepicker: true, // Permite seleccionar la hora
            timeFormat: "hh:mm tt", // Formato de hora
        });
    });

    function mostrarCalendario() {
        $("#fecha").datepicker("show");
    }
</script>

</body>
</html>
