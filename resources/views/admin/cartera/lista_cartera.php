<?php
session_start();

 // Verifica si el usuario está autenticado
 if (!isset($_SESSION["usuario_id"])) {
     header("Location: ../../../../../../index.php");
     exit();
 }
 
 // Incluye la configuración de conexión a la base de datos
 require_once '../../../../controllers/conexion.php'; 
 
 // El usuario está autenticado, obtén el ID del usuario de la sesión
 $usuario_id = $_SESSION["usuario_id"];
 
 // Preparar la consulta para obtener el rol del usuario
 $stmt = $conexion->prepare("SELECT roles.Nombre FROM usuarios INNER JOIN roles ON usuarios.RolID = roles.ID WHERE usuarios.ID = ?");
 $stmt->bind_param("i", $usuario_id);
 
 // Ejecutar la consulta
 $stmt->execute();
 $resultado = $stmt->get_result();
 $fila = $resultado->fetch_assoc();
 
 $stmt->close();
 
 // Verifica si el resultado es nulo o si el rol del usuario no es 'admin'
 if (!$fila || $fila['Nombre'] !== 'admin') {
     header("Location: /ruta_a_pagina_de_error_o_inicio.php");
     exit();
 }

// Consulta SQL para obtener las carteras
$sql = "SELECT id, nombre, IDZona FROM cartera";
$result = $conexion->query($sql);
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/lista_super.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <title>Lista de Carteras</title>
</head>

<body>

    <body id="body">

        <header>
            <div class="icon__menu">
                <i class="fas fa-bars" id="btn_open"></i>
            </div>
            <a href="agregar_cartera.php">
                <span>Agregar Cartera</span>
            </a>
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
                        <h4>Saldo Incial</h4>
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

                <a href="/resources/views/admin/abonos/lista_super.php" class="selected">
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
            <!-- Botón para volver a la página anterior -->
            <h1 class="text-center">Lista de Carteras</h1>

            <div class="container-fluid">

                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                    </tr>
                    <?php
        // Mostrar los resultados en la tabla
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td><a href='tu_pagina.php?id=" . $row["id"] . "'>" . $row["nombre"] . "</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No se encontraron resultados</td></tr>";
        }
        ?>
                </table>

            </div>


        </main>

        <script src="/public/assets/js/MenuLate.js"></script>




    </body>

    </html>





















































 

    <?php
// Cerrar la conexión con la base de datos
$conexion->close();
?>