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
    <title>Navbar 12</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="/css/inicio.css" />
  </head>
  <body>

  <!-- nava bar  -->
    <nav class="navbar">
      <div class="logo">
      
        <h2>Recaudos v2.1</h2>
      </div>
      <div class="links">
        <div class="dropdown">
          <a href="#"
            >Zonas
            <img src="/img/incio/chevron.png" />
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
            <img src="/img/incio/chevron.png" />
          </a>
          <div class="menu">
            <a href="#"> clientes </a>
            <a href="#"> codeudores</a>
            <a href="#"> cobros </a>
            <a href="#"> restiros </a>
            <a href="#"> gasdtos </a>
            <a href="#"> deudas </a>
            <a href="#"> abonos </a>
            <a href="#"> loteria </a>
          </div>
        </div>
        <div class="dropdown">
          <a href="#"
            >Reportes
            <img src="/img/incio/chevron.png" />
          </a>
          <div class="menu">
            <a href="#"> Suma saldo</a>
            <a href="#"> contabilida </a>
            <a href="#"> Contabilida empresa </a>
            <a href="#"> Canceladas </a>
           
          </div>
        </div>
        <div class="dropdown">
          <a href="#"
            >Cerrar sesion
            <img src="/img/incio/chevron.png" />
          </a>
          <div class="menu">
            <a href="/controlador/cerrar_sesion.php"> salir </a>
           
          </div>
        </div>
      </div>
    </nav><br><br><br>

    <!-- Inicio pagina  -->
    <h1 >Bienvenido  <?php echo $_SESSION ['Nombre']; ?></h1>
    
  </body>
</html>
