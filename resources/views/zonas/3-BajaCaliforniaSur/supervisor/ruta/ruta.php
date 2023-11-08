<?php
session_start();

// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
    exit();
}


  // Incluye tu archivo de conexión a la base de datos
  include("../../../../controllers/conexion.php");

  // Obtener el nombre de la zona desde la URL
  if (isset($_GET['zona'])) {
      $nombreZona = $_GET['zona'];
  }

  // Verifica si se ha proporcionado una zona válida
  if (isset($_GET['zona'])) {
      $nombreZona = $_GET['zona'];
  } else {
      // Maneja el caso donde no se proporcionó una zona válida
      echo "Zona no especificada.";
  }
  
  // Manejar la solicitud POST para actualizar el orden
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Obtener el nuevo orden desde la solicitud POST
      $nuevoOrden = $_POST["nuevoOrden"];
      
      // Actualizar el orden en la base de datos (debes adaptar esto a tu estructura)
      $sqlUpdate = "UPDATE nueva_lista_pagos SET Orden = ? WHERE Zona = ?";
      $stmt = $conexion->prepare($sqlUpdate);
      $stmt->bind_param("is", $nuevoOrden, $nombreZona);
      
      if ($stmt->execute()) {
          echo "Nuevo orden actualizado con éxito.";
      } else {
          echo "Error al actualizar el nuevo orden: " . $conexion->error;
      }
      
      $stmt->close();
  }
  $conexion->close();
?>

<!DOCTYPE html>
<html lang="en">

<html>

<head>
    <title>Lista de Fechas de Pago</title>
    <link rel="stylesheet" href="/public/assets/css/ruta.css">
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

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/usuarios/crudusuarios.php">
                <div class="option">
                    <i class="fa-solid fa-users" title=""></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/usuarios/registrar.php">
                <div class="option">
                    <i class="fa-solid fa-user-plus" title=""></i>
                    <h4>Registrar Usuario</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/creditos/prestamos.php">
                <div class="option">
                    <i class="fa-solid fa-file-invoice-dollar" title=""></i>
                    <h4>Registrar Prestamos</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/ruta/lista_super.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-map" title=""></i>
                    <h4>Ruta</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/abonos/abonos.php">
                <div class="option">
                    <i class="fa-solid fa-money-bill-trend-up" title=""></i>
                    <h4>Abonos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/1-aguascalientes/supervisor/retiros/retiros.php">
                <div class="option">
                    <i class="fa-solid fa-scale-balanced" title=""></i>
                    <h4>Retiros</h4>
                </div>
            </a>



        </div>

    </div>


    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>
        <div id="fechasPagoContainer">
            <!-- Aquí se mostrará la lista de fechas de pago en tiempo real -->
        </div>
    </main>

    <script>
        // Agregar un evento clic al botón
        document.getElementById("volverAtras").addEventListener("click", function() {
            window.history.back();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    // Función para cargar y mostrar las fechas de pago en tiempo real
    function cargarFechasDePago() {
        $.ajax({
            url: 'cargar_fechas_pago.php?zona=<?php echo $nombreZona; ?>',
            method: 'GET',
            success: function(data) {
                $('#fechasPagoContainer').html(data);
            }
        });
    }

    // Cargar las fechas de pago al cargar la página
    cargarFechasDePago();

    // Actualizar las fechas de pago cada 30 segundos
    setInterval(cargarFechasDePago, 30000); // 30,000 milisegundos = 30 segundos
    </script>
     <script src="/public/assets/js/MenuLate.js"></script>

</body>

</html>