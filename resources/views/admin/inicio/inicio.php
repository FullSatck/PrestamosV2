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


// Incluye el archivo de conexión
include("../../../../controllers/conexion.php");

// COBROS
try {
    // Consulta SQL para obtener la suma de MontoAPagar
    $sqlCobros = "SELECT SUM(MontoAPagar) AS TotalMonto FROM prestamos";

    // Realizar la consulta
    $resultCobros = mysqli_query($conexion, $sqlCobros);

    if ($resultCobros) {
        $rowCobros = mysqli_fetch_assoc($resultCobros);

        // Obtener el total de cobros
        $totalMonto = $rowCobros['TotalMonto'];

        // Cierra la consulta de cobros
        mysqli_free_result($resultCobros);
    } else {
        echo "Error en la consulta de cobros: " . mysqli_error($conexion);
    }
} catch (Exception $e) {
    echo "Error de conexión a la base de datos (cobros): " . $e->getMessage();
}

// INGRESOS
try {
    // Consulta SQL para obtener la suma de MontoPagado
    $sqlIngresos = "SELECT SUM(MontoPagado) AS TotalIngresos FROM historial_pagos";

    // Realizar la consulta
    $resultIngresos = mysqli_query($conexion, $sqlIngresos);

    if ($resultIngresos) {
        $rowIngresos = mysqli_fetch_assoc($resultIngresos);

        // Obtener el total de ingresos
        $totalIngresos = $rowIngresos['TotalIngresos'];

        // Cierra la consulta de ingresos
        mysqli_free_result($resultIngresos);
    } else {
        echo "Error en la consulta de ingresos: " . mysqli_error($conexion);
    }
} catch (Exception $e) {
    echo "Error de conexión a la base de datos (ingresos): " . $e->getMessage();
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://kit.fontawesome.com/9454e88444.js" crossorigin="anonymous"></script>
    <title>Recaudo</title>
    <link rel="stylesheet" href="/public/assets/css/inicio.css">
</head>

<body>
    <div class="home">
    </div>

    <nav class="sidebar">
        <div class="sidebar-inner">
            <header class="sidebar-header">
                <button type="button" class="sidebar-burger" onclick="toggleSidebar()"><i
                        class="fa-solid fa-house-user fa-2xl"></i></button>
                <img src="/img/Inovatec.svg" class="sidebar-logo" />
            </header>
            <nav class="sidebar-menu">
                <button type="button" onclick="window.location.href = '/index.html'">
                    <i class="fa-solid fa-house fa-xl" style="color: #000000;"></i>
                    <span>Inicio</span>
                </button>

                <button type="button" onclick="window.location.href = '/index.html'" class="has-border">
                    <i class="fa-solid fa-gear fa-xl"></i>
                    <span>Configuracion</span>
                </button>

                <button type="button" onclick="window.location.href = '/lognprin/admi/horario/crud.php'">
                    <i class="fa-regular fa-calendar fa-xl" style="color: #000000;"></i>
                    <span>Agregar horarios</span>
                </button>

                <button type="button" onclick="window.location.href = '/lognprin/admi/estudiantes/crud.php'">
                    <i class="fa-solid fa-graduation-cap fa-xl" style="color: #000000;"></i>
                    <span>Estudiantes</span>
                </button>

                <button type="button" onclick="window.location.href = '/lognprin/admi/instructor/crud.php'">
                    <i class="fa-solid fa-user-tie fa-2xl" style="color: #000000;"></i>
                    <span>Instructores</span>
                </button>

                <button type="button" onclick="window.location.href = '/lognprin/admi/usuarios/crud.php'"
                    class="has-border">
                    <i class="fa-solid fa-users fa-xl" style="color: #000000;"></i>
                    <span>Usuarios</span>
                </button>

                <button type="button" onclick="window.location.href = '../../../Login_registro/login/cerrar_sesion.php'"
                    class="has-border">
                    <i class="fa-solid fa-right-from-bracket fa-xl" style="color: #000000;"></i>
                    <span>Log out</span>


                </button>
            </nav>
        </div>
    </nav>
   



    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>
        <h1>Inicio Administrador</h1>
        <div class="cuadros-container">
            <div class="cuadro cuadro-1">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/inicio/cobro_inicio.php" class="titulo">Cobros</a><br>
                    <p><?php echo "<strong>Total:</strong> <span class='cob'> $ $totalMonto </span>" ?></p>
                </div>
            </div>
            <div class="cuadro cuadro-3">
                <div class="cuadro-1-1">
                    <a href="/resources/views/admin/inicio/recuado_admin.php" class="titulo">Recaudos</a><br>
                    <p><?php echo "<strong>Total:</strong> <span class='ing'> $  $totalIngresos </span>" ?></p>
                </div>
            </div>
            <div class="cuadro cuadro-2">
                <div class="cuadro-1-1">
                    <a href="##" class="titulo">Contabilidad</a>
                </div>
            </div>
            <div class="cuadro cuadro-4">
                <div class="cuadro-1-1">
                    <a href="##" class="titulo">Comision</a>
                </div>
            </div>
        </div>
    </main>



    

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script type="text/javascript">
    const toggleSidebar = () => document.body.classList.toggle("open");

    function changeTheme() {
      const selectElement = document.getElementById("theme-select");
      const selectedTheme = selectElement.value;

      // Guardar el tema seleccionado en la sesión
      fetch('guardar_tema.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ theme: selectedTheme })
      })
        .then(response => response.json())
        .then(data => {
          // Actualizar el tema en el documento
          document.body.setAttribute("data-theme", data.theme);
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }
  </script>

</body>

</html>