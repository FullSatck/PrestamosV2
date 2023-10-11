<?php
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
<html>
<head>
    <title>Lista de Fechas de Pago</title>
    <link rel="stylesheet" href="/public/assets/css/ruta.css">
</head>
<body>
    <h1>Lista de Fechas de Pago</h1> 

    <div id="fechasPagoContainer">
        <!-- Aquí se mostrará la lista de fechas de pago en tiempo real -->
    </div>
    
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
</body>
</html>
