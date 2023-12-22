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

// mesaje de boorado 
if (isset($_SESSION["mensaje_borrado"])) {
    echo "<p id='mensaje-exito' class='mensaje-exito'>" . $_SESSION["mensaje_borrado"] . "</p>";
    unset($_SESSION["mensaje_borrado"]);
}
// El usuario ha iniciado sesión, mostrar el contenido de la página aquí
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Prestamos</title>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+J/T4Aj4Or5M5L6f4dOMu1zC5z5OIn5S/4ro5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z5D02F5z" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/9454e88444.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/public/assets/css/crudpresta.css">
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





    <!-- ACA VA EL CONTENIDO DE LA PAGINA -->

    <main>
        <!-- Botón para volver a la página anterior -->
        <h1 class="text-center">Listado de préstamos</h1>

        <?php
        if (isset($_GET['mensaje'])) {
            $claseMensaje = strpos($_GET['mensaje'], 'Error') !== false ? 'mensaje-error' : 'mensaje-exito';
            echo "<p class='mensaje $claseMensaje'>" . $_GET['mensaje'] . "</p>";
        }
        ?>
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
                <a href="/resources/views/admin/creditos/crudPrestamos.php" class="selected">
                    <div class="option">
                        <i class="fa-solid fa-hand-holding-dollar" title=""></i>
                        <h4>Prestamos</h4>
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

                <a href="/resources/views/admin/ruta/ruta.php">
                    <div class="option">
                        <i class="fa-solid fa-map" title=""></i>
                        <h4>Enrutar</h4>
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

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Barra de búsqueda y botón de registro -->
                    <div class="search-container">
                        <input type="text" id="search-input" class="search-input" placeholder="Buscar...">
                        <button><a href="prestamosDesactivados.php" class="btn btn-primary">Desactivados</a></button>

                    </div>


                    <!-- Tabla de préstamos en un contenedor con scroll horizontal -->
                    <div class="table-container">
                        <div class="table-scroll">
                            <table class="table table-responsive">
                                <!-- Clase 'table-responsive' para hacerla responsive -->
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Monto</th>
                                        <th scope="col">Interés</th>
                                        <th scope="col">Plazo</th>
                                        <th scope="col">Moneda</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Zona</th>
                                        <th scope="col">Deuda</th>
                                        <th scope="col">Frecuencia</th>
                                        <th scope="col">Cuota</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Dec/Act</th>
                                        <th scope="col">Editar</th>
                                        <th scope="col">Borrar</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include("../../../../controllers/conexion.php");
                                    // Modificar la consulta para ordenar los resultados en orden descendente por ID
                                    $sql = $conexion->query("SELECT prestamos.ID, clientes.Nombre AS NombreCliente, prestamos.Monto, prestamos.TasaInteres, prestamos.Plazo, prestamos.MonedaID, prestamos.FechaInicio, prestamos.FechaVencimiento, prestamos.Estado, prestamos.CobradorAsignado, prestamos.Zona, prestamos.MontoAPagar, prestamos.FrecuenciaPago, prestamos.MontoCuota, prestamos.Cuota, prestamos.EstadoP FROM prestamos JOIN clientes ON prestamos.IDCliente = clientes.ID WHERE clientes.Estado = 1 AND prestamos.EstadoP = 1 ORDER BY prestamos.ID DESC");

                                    while ($datos = $sql->fetch_object()) { ?>
                                        <tr>
                                            <td><?= "10" . $datos->ID ?></td>
                                            <td><?= $datos->NombreCliente ?></td>
                                            <td><?= number_format($datos->Monto, 0, '.', '.') ?></td>
                                            <td><?= number_format($datos->TasaInteres, 0, '.', '.') . "%" ?></td>
                                            <td><?= $datos->Plazo ?></td>
                                            <td><?= $datos->MonedaID ?></td>
                                            <td class="estado"><?= $datos->Estado ?></td>
                                            <td><?= $datos->Zona ?></td>
                                            <td><?= number_format($datos->MontoAPagar, 0, '.', '.') ?></td>
                                            <td class="frecuencia-pago"><?= $datos->FrecuenciaPago ?></td>
                                            <td><?= number_format($datos->MontoCuota, 0, '.', '.') ?></td>
                                            <td class="estado"><?= $datos->EstadoP == 1 ? 'Activado' : 'Desactivado' ?></td>

                                            <td class="icon-td">
                                                <a href="cambiarEstado.php?id=<?= $datos->ID ?>&estado=<?= $datos->EstadoP ?>">
                                                    <i class="fas <?= $datos->EstadoP == 1 ? 'fa-toggle-on' : 'fa-toggle-off' ?>"></i>
                                                    <?= $datos->EstadoP == 1 ? ' Desactivar' : ' Activar' ?>
                                                </a>
                                            </td>

                                            <td class="icon-td">
                                                <a href="editar_prestamo.php?prestamo_id=<?= $datos->ID ?>" class="edit-btn">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                            </td>
                                            <td class="icon-td">
                                                <a href="#" class="delete-btn" data-id="<?= $datos->ID ?>">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>


                                            </td>


                                        <?php } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal de Confirmación -->
        <div id="confirmModal" class="modal-custom">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <h2>Confirmar Borrado</h2>
                <p>¿Estás seguro de que quieres borrar este préstamo?</p>
                <button id="confirmDelete">Borrar</button>
                <button id="cancelDelete">Cancelar</button>
            </div>
        </div>


    </main>

    <script src="/public/assets/js/MenuLate.js"></script>

    <script>
        //MODAL 
        document.addEventListener("DOMContentLoaded", function() {
            // Obtener el modal
            var modal = document.getElementById("confirmModal");

            // Obtener todos los botones que abren el modal
            var deleteButtons = document.querySelectorAll(".delete-btn");

            // Obtener el elemento <span> que cierra el modal
            var span = document.querySelector(".close-button");

            // Obtener el botón de confirmar borrado
            var confirmDelete = document.getElementById("confirmDelete");

            // Obtener el botón de cancelar borrado
            var cancelDelete = document.getElementById("cancelDelete");

            // Variable para almacenar el ID del préstamo a borrar
            var prestamoId;

            // Agregar evento click a cada botón de borrar
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    modal.classList.add("modal-visible"); // Hace visible el modal
                    prestamoId = this.getAttribute("data-id");
                });
            });

            // Función para cerrar el modal
            function closeModal() {
                modal.classList.remove("modal-visible");
            }

            // Evento para cerrar el modal al hacer clic en <span> (x)
            span.addEventListener('click', closeModal);

            // Evento para cerrar el modal al hacer clic en el botón de cancelar
            cancelDelete.addEventListener('click', closeModal);

            // Evento para realizar la acción de borrado y cerrar el modal
            confirmDelete.addEventListener('click', function() {
                window.location.href = 'borrar_prestamo.php?id=' + prestamoId;
            });

            // Evento para cerrar el modal al hacer clic fuera de él
            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    closeModal();
                }
            });
        });

        //DESACTIVAR Y ACTIVAR PRESTAMO 
        $(document).ready(function() {
            $('#search-input').on('input', function() {
                var searchTerm = $(this).val().toLowerCase();
                $('tbody tr').each(function() {
                    var rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(searchTerm) !== -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
        //MESAJE 
        document.addEventListener("DOMContentLoaded", function() {
            // Verifica si el mensaje existe
            var mensajeExito = document.getElementById('mensaje-exito');
            if (mensajeExito) {
                // Oculta el mensaje después de 5 segundos (5000 milisegundos)
                setTimeout(function() {
                    mensajeExito.style.display = 'none';
                }, 2000);
            }
        });
    </script>




</body>

</html>