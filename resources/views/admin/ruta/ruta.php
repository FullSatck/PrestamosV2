<?php
session_start();

// Validacion de rol para ingresar a la pagina 
require_once '../../../../controllers/conexion.php'; 

// Verifica si el usuario está autenticado
if (!isset($_SESSION["usuario_id"])) {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../index.php");
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
    if ($rol_usuario !== 'admin') {
        // El usuario no tiene el rol correcto, redirige a la página de error o de inicio
        header("Location: /ruta_a_pagina_de_error_o_inicio.php");
        exit();
    }
    
   
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
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Fechas de Pago</title>
    <link rel="stylesheet" href="/public/assets/css/ruta.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script> 
</head>

<body>
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

        <a href="/resources/views/admin/inicio/inicio.php">
            <div class="option">
                <i class="fa-solid fa-landmark" title="Inicio"></i>
                <h4>Inicio</h4>
            </div>
        </a>

        <a href=" /resources/views/admin/admin_saldo/saldo_admin.php">
            <div class="option">
                <i class="fa-solid fa-sack-dollar" title=""></i>
                <h4>Saldo Inicial</h4>
            </div>
        </a>

        <a href="/resources/views/admin/usuarios/crudusuarios.php">
            <div class="option">
                <i class="fa-solid fa-users" title=""></i>
                <h4>Usuarios</h4>
            </div>
        </a>

        <a href="/resources/views/admin/usuarios/registrar.php">
            <div class="option">
                <i class="fa-solid fa-user-plus" title=""></i>
                <h4>Registrar Usuario</h4>
            </div>
        </a>

        <a href="/resources/views/admin/clientes/lista_clientes.php">
            <div class="option">
                <i class="fa-solid fa-people-group" title=""></i>
                <h4>Clientes</h4>
            </div>
        </a>

        <a href="/resources/views/admin/clientes/agregar_clientes.php">
            <div class="option">
                <i class="fa-solid fa-user-tag" title=""></i>
                <h4>Registrar Clientes</h4>
            </div>
        </a>
        <a href="/resources/views/admin/creditos/crudPrestamos.php">
            <div class="option">
                <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                <h4>Prestamos</h4>
            </div>
        </a>
        <a href="/resources/views/admin/creditos/prestamos.php">
            <div class="option">
                <i class="fa-solid fa-file-invoice-dollar" title=""></i>
                <h4>Registrar Prestamos</h4>
            </div>
        </a>
        <a href="/resources/views/admin/cobros/cobros.php">
            <div class="option">
                <i class="fa-solid fa-arrow-right-to-city" title=""></i>
                <h4>Zonas de cobro</h4>
            </div>
        </a>

        <a href="/resources/views/admin/gastos/gastos.php">
            <div class="option">
                <i class="fa-solid fa-sack-xmark" title=""></i>
                <h4>Gastos</h4>
            </div>
        </a>

        <a href="/resources/views/admin/ruta/lista_super.php" class="selected">
            <div class="option">
                <i class="fa-solid fa-map" title=""></i>
                <h4>Ruta</h4>
            </div>
        </a>

        <a href="/resources/views/admin/abonos/abonos.php">
            <div class="option">
                <i class="fa-solid fa-money-bill-trend-up" title=""></i>
                <h4>Abonos</h4>
            </div>
        </a>
        <a href="/resources/views/admin/retiros/retiros.php">
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