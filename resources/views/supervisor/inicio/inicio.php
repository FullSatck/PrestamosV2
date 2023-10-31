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
    <link rel="stylesheet" href="/public/assets/css-Super/inicio.css">
</head>

<body>
    <div class="home">
    </div>

    <nav class="sidebar">
        <div class="sidebar-inner">
            <header class="sidebar-header">
                <button type="button" class="sidebar-burger" onclick="toggleSidebar()"><i
                        class="fa-solid fa-house-user fa-2xl"></i></button>

            </header>
            <nav class="sidebar-menu">

                <button type="button" onclick="window.location.href = '/resources/views/supervisor/inicio/inicio.php'">
                    <ion-icon name="home-outline" class="icon"></ion-icon>
                    <span>Inicio</span>
                </button>

                <button type="button"
                    onclick="window.location.href = '/resources/views/supervisor/usuarios/crudusuarios.php'">
                    <ion-icon name="people-outline"></ion-icon>
                    <span>Lista Usuarios</span>
                </button>

                <button type="button"
                    onclick="window.location.href = '/resources/views/supervisor/usuarios/registrar.php'">
                    <ion-icon name="person-add-outline"></ion-icon>
                    <span>Registrar Usuarios</span>
                </button>

                <button type="button"
                    onclick="window.location.href = '/resources/views/supervisor/clientes/lista_clientes.php'">
                    <ion-icon name="people-circle-outline"></ion-icon>
                    <span>Lista Clientes</span>
                </button>

                <button type="button"
                    onclick="window.location.href = '/resources/views/supervisor/clientes/agregar_clientes.php'"
                    class="has-border">
                    <ion-icon name="person-circle-outline"></ion-icon>
                    <span>Registrar Clientes</span>
                </button>

                <button type="button"
                    onclick="window.location.href = '/resources/views/supervisor/creditos/crudPrestamos.php'">
                    <ion-icon name="list-outline"></ion-icon>
                    <span>Lista Prestamos</span>
                </button>

                <button type="button" onclick="window.location.href = '/resources/views/supervisor/creditos/prestamos.php'" class="has-border">
                    <ion-icon name="cloud-upload-outline"></ion-icon>
                    <span>Registrar Prestamo</span>
                </button>

                <button type="button"
                    onclick="window.location.href = '/resources/views/supervisor/cobros/cobros.php'">
                    <ion-icon name="list-outline"></ion-icon>
                    <span>Lista Prestamos</span>
                </button>

                <button type="button" onclick="window.location.href = '/resources/views/supervisor/creditos/prestamos.php'" class="has-border">
                    <ion-icon name="cloud-upload-outline"></ion-icon>
                    <span>Registrar Prestamo</span>
                </button>

                <button type="button" onclick="window.location.href = '/controllers/cerrar_sesion.php'"
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
                body: JSON.stringify({
                    theme: selectedTheme
                })
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