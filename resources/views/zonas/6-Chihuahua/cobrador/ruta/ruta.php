<?php
session_start();


// Verifica si el usuario está autenticado
if (isset($_SESSION["usuario_id"])) {
    // El usuario está autenticado, puede acceder a esta página
} else {
    // El usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: ../../../../../../index.php");
    exit();
}


// Incluye el archivo de conexión
include("../../../../../../controllers/conexion.php");

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js">
    </script>
    <title>Lista de Pagos Pendientes para Hoy</title>
    <link rel="stylesheet" href="/public/assets/css/abonosruta.css">
    <style>
    /* Agrega estilos específicos si es necesario */
    #lista-pagos tbody tr {
        cursor: move;
    }
    </style>
</head>

<body>

    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>
        
        <div class="nombre-usuario">
            <?php
        if (isset($_SESSION["nombre_usuario"])) {
            echo htmlspecialchars($_SESSION["nombre_usuario"])."<br>" . "<span> Cobrador<span>";
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

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/inicio/inicio.php">
                <div class="option">
                    <i class="fa-solid fa-landmark" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>


            <a href="/resources/views/zonas/6-Chihuahua/cobrador/clientes/lista_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-people-group" title=""></i>
                    <h4>Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/clientes/agregar_clientes.php">
                <div class="option">
                    <i class="fa-solid fa-user-tag" title=""></i>
                    <h4>Registrar Clientes</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/creditos/crudPrestamos.php">
                <div class="option">
                    <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                    <h4>Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/creditos/prestamos.php">
                <div class="option">
                    <i class="fa-solid fa-file-invoice-dollar" title=""></i>
                    <h4>Registrar Prestamos</h4>
                </div>
            </a>

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/gastos/gastos.php">
                <div class="option">
                    <i class="fa-solid fa-sack-xmark" title=""></i>
                    <h4>Gastos</h4>
                </div>
            </a> 

            <a href="/resources/views/zonas/6-Chihuahua/cobrador/cartera/lista_cartera.php">
                <div class="option">
                    <i class="fa-regular fa-address-book"></i>
                    <h4>Cobros</h4>
                </div>
            </a>

            
        </div>
    </div>

    <script src="/public/assets/js/MenuLate.js"></script>

    <main>
        <h2>Orden de pagos</h2>

        <!-- <button onclick="guardarCambios()">Guardar Cambios</button> -->

        <div id="aviso-guardado" class="aviso">
            Nuevo orden guardado.
        </div><br>

        <div class="table-scroll-container">
            <table id="lista-pagos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Fecha de Pago</th>
                        <th>Enrutar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
            include "../../../../../../controllers/conexion.php";

            $fecha_actual = date("Y-m-d");

            $sql = "SELECT fechas_pago.ID, fechas_pago.FechaPago, clientes.Nombre, clientes.Apellido
                    FROM fechas_pago 
                    INNER JOIN prestamos ON fechas_pago.IDPrestamo = prestamos.ID 
                    INNER JOIN clientes ON prestamos.IDCliente = clientes.ID 
                    WHERE fechas_pago.FechaPago = ? AND fechas_pago.Zona = 'Chihuhua'";

            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("s", $fecha_actual);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ID"] . "</td>";
                    echo "<td>" . $row["Nombre"] . "</td>";
                    echo "<td>" . $row["Apellido"] . "</td>";
                    echo "<td>" . $row["FechaPago"] . "</td>";
                    echo "<td class='drag-handle'>|||</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay pagos pendientes para hoy.</td></tr>";
            }

            $stmt->close();
            $conexion->close();
            ?>
                </tbody>
            </table>
        </div>

    </main>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js">
    </script>

    <script>
    $(document).ready(function() {
        const listaPagos = $("#lista-pagos tbody");

        // Recuperar el orden almacenado en el localStorage, si existe
        const savedOrder = localStorage.getItem('sortableTableOrder');
        if (savedOrder) {
            listaPagos.html(savedOrder);
        }

        // Habilitar la función de arrastrar en la tabla
        listaPagos.sortable({
            helper: 'clone',
            axis: 'y',
            opacity: 0.5,
            update: function(event, ui) {
                guardarCambios();
            }
        });
    });

    function guardarCambios() {
        const currentOrder = $('#lista-pagos tbody').html();
        localStorage.setItem('sortableTableOrder', currentOrder);

        // Mostrar el mensaje de confirmación
        $('#aviso-guardado').fadeIn().delay(3000).fadeOut(); // Mostrar por 2 segundos y luego ocultar
    }
    </script>


</body>

</html>