<?php
session_start();
if (!$_SESSION['logged_in']) {
  header("location: ../controlador/validar_login.php");
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

    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="/views/assets/css/abonos.css" />
  </head>
  <body>

  <!-- nava bar  -->
    <nav class="navbar">
      <div class="logo">
    <h1 >Bienvenido  <?php echo $_SESSION ['NombreUsuario']; ?></h1>
        <h2> a Recaudos v2.1</h2>
      </div>
      <div class="links">
        <div class="dropdown">
          <a href="#"
            >Zonas
            <img src="/views/assets/img/inicio/chevron.png" />
          </a>
          <div class="menu">
            <a href="#"> Puebla </a>
            <a href="#"> ciudad de mexico</a>
            <a href="#"> guadalajara </a>
            <a href="#"> zacatecas</a>
            <a href="#"> tijuana</a>
            <a href="#"> jalisco</a>
            <a href="#"> campeche</a>
            <a href="#"> veracruz</a>
          </div>
        </div>
        <div class="dropdown">
          <a href="#"
            >Menu
            <img src="/views/assets/img/inicio/chevron.png" />
          </a>
          <div class="menu">
            <a href="#"> clientes </a>
            <a href="#"> codeudores</a>
            <a href="#"> cobros </a>
            <a href="#"> retiros </a>
            <a href="#"> gastos </a>
            <a href="#"> deudas </a>
            <a href="#"> abonos </a>
            <a href="#"> loteria </a>
          </div>
        </div>
        <div class="dropdown">
          <a href="#"
            >Reportes
            <img src="/views/assets/img/inicio/chevron.png" />
          </a>
          <div class="menu">
            <a href="#"> Suma saldo</a>
            <a href="#"> Contabilidad </a>
            <a href="#"> Contabilidad empresa </a>
            <a href="#"> Canceladas </a>
           
          </div>
        </div>
        <div class="dropdown">
          <a href="#"
            >Cerrar sesion
            <img src="/views/assets/img/inicio/chevron.png" />
          </a>
          <div class="menu">
            <a href="/controlador/cerrar_sesion.php"> Salir </a>
           
          </div>
        </div>
      </div>
    </nav><br><br><br>

    <div class="second-toolbar">
    <!-- Botones y campos en forma de cuadrícula aquí -->
    <button class="grid-button">Botón 1</button>
    <button class="grid-button">Botón 2</button>
    <button class="grid-button">Botón 3</button>
    <input type="text" class="grid-input" placeholder="Campo de texto">
    <!-- Puedes agregar más elementos aquí según sea necesario -->
</div>

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
