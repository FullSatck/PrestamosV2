<?php
date_default_timezone_set('America/Bogota');
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

    $sql_nombre = "SELECT nombre FROM usuarios WHERE id = ?";
    $stmt = $conexion->prepare($sql_nombre);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($fila = $resultado->fetch_assoc()) {
        $_SESSION["nombre_usuario"] = $fila["nombre"];
    }
    $stmt->close();

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

// Conectar a la base de datos
include("../../../../controllers/conexion.php");

  // Inicializar el total en 0
  $totalRecaudado = 0;
  $startDate = ""; // Inicializa las variables
  $endDate = "";

  // Procesar la solicitud POST cuando se envía el formulario
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén las fechas seleccionadas por el usuario desde los campos de entrada
    $startDate = $_POST["start-date"]; // Asegúrate de validar y limpiar los datos del usuario
    $endDate = $_POST["end-date"]; // Asegúrate de validar y limpiar los datos del usuario

    // Verificar si las fechas son válidas
    if ($startDate && $endDate) {
        // Consulta SQL con filtro de fechas
        $sql = "SELECT * FROM historial_pagos WHERE FechaPago >= ? AND FechaPago <= ? ORDER BY ID DESC";

        // Preparar la consulta
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $startDate, $endDate);

        // Ejecutar la consulta
        $stmt->execute();
        $result = $stmt->get_result();

        // Calcular el total recaudado para el rango de fechas seleccionado
        $totalRecaudado = 0; // Inicializa el total nuevamente
        while ($row = mysqli_fetch_assoc($result)) {
            $totalRecaudado += $row['MontoPagado'];
        }
    } else {
        // Las fechas no son válidas, muestra un mensaje de error o maneja la situación de acuerdo a tus necesidades
        echo "Por favor, seleccione fechas válidas.";
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recaudo</title>
    <link rel="stylesheet" href="/public/assets/css/recaudo_admin.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>

<body id="body">

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>

        <div class="nombre-usuario">
            <?php
            if (isset($_SESSION["nombre_usuario"])) {
                echo htmlspecialchars($_SESSION["nombre_usuario"]) . "<br>" . "<span> Administrator<span>";
            }
            ?>
        </div>
    </header>

    <div class="menu__side" id="menu_side">

        <div class="name__page">
            <img src="/public/assets/img/logo.png" class="img logo-image" alt="">
            <h4>Recaudo</h4>
        </div>

        <div class="options__menu">

            <a href="/controllers/cerrar_sesion.php">
                <div class="option">
                    <i class="fa-solid fa-right-to-bracket fa-rotate-180"></i>
                    <h4>Cerrar Sesion</h4>
                </div>
            </a>

            <a href="/resources/views/admin/inicio/inicio.php" class="selected">
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

           

            <a href="/resources/views/admin/retiros/retiros.php">
                <div class="option">
                    <i class="fa-solid fa-scale-balanced" title=""></i>
                    <h4>Retiros</h4>
                </div>
            </a>

            <a href="/resources/views/admin/cartera/lista_cartera.php">
                <div class="option">
                    <i class="fa-solid fa-scale-balanced" title=""></i>
                    <h4>Cobros</h4>
                </div>
            </a>

        </div>
    </div>



    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>
        <h1>Recaudos totales</h1>
        <?php
        $totalRecaudado = 0; // Inicializa la variable para almacenar el total recaudado

        // Consulta SQL para obtener la suma de MontoPagado en la tabla historial_pagos
        $sqlTotalRecaudado = "SELECT SUM(MontoPagado) AS TotalRecaudado FROM historial_pagos";
        $resultTotalRecaudado = mysqli_query($conexion, $sqlTotalRecaudado);

        if ($resultTotalRecaudado && $rowTotalRecaudado = mysqli_fetch_assoc($resultTotalRecaudado)) {
            $totalRecaudado = $rowTotalRecaudado['TotalRecaudado'];
        }
        ?>


        <div class="search-container">
            <input type="text" id="search-input" class="search-input" placeholder="Buscar...">
        </div>

        <div class="date-filter">
            <label for="start-date">Fecha de inicio:</label>
            <input type="date" id="start-date" name="start-date">

            <label for="end-date">Fecha de fin:</label>
            <input type="date" id="end-date" name="end-date">

            <button id="filter-button">Filtrar</button>
        </div>

        <div class="total-recaudado">
    <p>Total Recaudado <?php echo $startDate; ?>  <?php echo $endDate; ?>: $<?php echo number_format($totalRecaudado, 0, ',', '.'); ?></p>
</div>



        <?php
        // Incluye el archivo de conexión a la base de datos
        include("../../../../controllers/conexion.php");

        // Consulta SQL para obtener todos los campos de la tabla historial_pagos en orden descendente
        $sql = "SELECT * FROM historial_pagos ORDER BY ID DESC";

        // Ejecutar la consulta
        $result = mysqli_query($conexion, $sql);

        if ($result) {
            // Crear un arreglo para almacenar los nombres de los clientes
            $nombresClientes = array();

            echo "<table>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Nombre del Cliente</th>";
            echo "<th>FechaPago</th>";
            echo "<th>MontoPagado</th>";
            echo "</tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                // Almacena los IDs de cliente en el arreglo
                $clienteID = $row['IDCliente'];
                // Verifica si el nombre del cliente ya se obtuvo previamente
                if (!array_key_exists($clienteID, $nombresClientes)) {
                    // Si no se ha obtenido, realiza una consulta para obtener el nombre
                    $consultaCliente = "SELECT Nombre FROM clientes WHERE ID = $clienteID";
                    $resultCliente = mysqli_query($conexion, $consultaCliente);
                    if ($rowCliente = mysqli_fetch_assoc($resultCliente)) {
                        // Almacena el nombre del cliente en el arreglo
                        $nombresClientes[$clienteID] = $rowCliente['Nombre'];
                    }
                }
                // Muestra los resultados en la tabla con el formato de MontoPagado
                $nombreCliente = $nombresClientes[$clienteID];
                $montoPagado = number_format($row['MontoPagado'], 0, ',', '.'); // Formatea con puntos de mil
                echo "<tr>";
                echo "<td>" . "Recaudo REC-10" . $row['ID'] . "</td>";
                echo "<td>" . $nombreCliente . "</td>";
                echo "<td>" . $row['FechaPago'] . "</td>";
                echo "<td>" . $montoPagado . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Error en la consulta: " . mysqli_error($conexion);
        }

        // Cierra la conexión a la base de datos
        mysqli_close($conexion);
        ?>


    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("search-input");
            const rows = document.querySelectorAll("table tr");
            const filterButton = document.getElementById("filter-button");
            const startDateInput = document.getElementById("start-date");
            const endDateInput = document.getElementById("end-date");

            filterButton.addEventListener("click", function() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;

                rows.forEach(function(row, index) {
                    if (index === 0) {
                        // Salta la primera fila que contiene encabezados de la tabla
                        return;
                    }

                    const dateColumn = row.querySelector("td:nth-child(3)").textContent; // Suponiendo que la fecha está en la tercera columna (ajusta según tu estructura)

                    if (startDate && endDate) {
                        if (dateColumn >= startDate && dateColumn <= endDate) {
                            row.style.display = "";
                        } else {
                            row.style.display = "none";
                        }
                    } else {
                        row.style.display = "";
                    }
                });
            });
        });
    </script>


    <script>
        // Agregar un evento clic al botón
        document.getElementById("volverAtras").addEventListener("click", function() {
            window.history.back();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("search-input");
            const rows = document.querySelectorAll("table tr");

            searchInput.addEventListener("input", function() {
                const searchTerm = searchInput.value.trim().toLowerCase();

                rows.forEach(function(row, index) {
                    if (index === 0) {
                        // Salta la primera fila que contiene encabezados de la tabla
                        return;
                    }

                    const columns = row.querySelectorAll("td");
                    let found = false;

                    columns.forEach(function(column, columnIndex) {
                        const text = column.textContent.toLowerCase();
                        if (columnIndex === 0 && text.includes(searchTerm)) {
                            // Busca el término en la primera columna (ID)
                            found = true;
                        } else if (text.includes(searchTerm)) {
                            // Busca el término en otras columnas
                            found = true;
                        }
                    });

                    if (found) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });
    </script>

    <script src="/public/assets/js/MenuLate.js"></script>

</body>

</html>