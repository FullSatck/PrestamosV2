<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Pago de Préstamos</title>
    <!-- Agrega aquí tus enlaces a las bibliotecas CSS y JavaScript necesarias -->
    <!-- Por ejemplo, jQuery y Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/public/assets/css/abonos.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Formulario de Pago de Préstamos</h1>

        <div class="botone">
            <a href="">mas tarde</a>
        </div>
        
        <!-- Información del cliente -->
        <div id="cliente-info" class="mt-4">
            <h2>Información del Cliente</h2>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cliente-id">ID del Cliente:</label>
                    <span id="cliente-id"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="cliente-nombre">Nombre:</label>
                    <span id="cliente-nombre"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="cliente-apellido">Apellido:</label>
                    <span id="cliente-apellido"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="cliente-domicilio">Domicilio:</label>
                    <span id="cliente-domicilio"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="cliente-telefono">Teléfono:</label>
                    <span id="cliente-telefono"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="cliente-curp">Identificación CURP:</label>
                    <span id="cliente-curp"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="cliente-zona">Zona Asignada:</label>
                    <span id="cliente-zona"></span>
                </div>
            </div>
        </div>
        
        <!-- Información del préstamo -->
        <div id="prestamo-info" class="mt-4">
            <h2>Información del Préstamo</h2>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="prestamo-id">ID de Préstamo:</label>
                    <span id="prestamo-id"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="prestamo-tasa">Tasa de Interés:</label>
                    <span id="prestamo-tasa"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="prestamo-fecha-inicio">Fecha de Inicio:</label>
                    <span id="prestamo-fecha-inicio"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="prestamo-fecha-vencimiento">Fecha de Vencimiento:</label>
                    <span id="prestamo-fecha-vencimiento"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="prestamo-zona">Zona:</label>
                    <span id="prestamo-zona"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="prestamo-monto-pagar">Deuda:</label>
                    <span id="prestamo-monto-pagar"></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="prestamo-cuota">Cuota:</label>
                    <span id="prestamo-cuota"></span>
                </div>
            </div>
        </div>
        
        <!-- Formulario de pago -->
        <div id="pago-form" class="mt-4">
            <h2>Registrar Pago</h2>
            <form id="formulario-pago">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="cantidad-pago">Cantidad a Pagar:</label>
                        <input type="text" id="cantidad-pago" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fecha-pago">Fecha del Pago:</label>
                        <input type="date" id="fecha-pago" class="form-control">
                    </div>
                </div>
                <button type="button" id="registrarPago" class="btn btn-primary">Registrar Pago</button>
            </form>
        </div>
        
        <!-- Botones para navegar entre clientes -->
        <div class="mt-4">
            <button id="anteriorCliente" class="btn btn-secondary mr-2">Anterior</button>
            <button id="siguienteCliente" class="btn btn-secondary">Siguiente</button>
        </div>
    </div>
    <script>
        // Variables globales para llevar un registro del ID del cliente actual
        var clienteActualId = 1; // Empieza con el primer cliente (puedes cambiarlo si deseas)
    
        // Función para cargar los datos del cliente
        function cargarDatosCliente(clienteId) {
            $.ajax({
                url: "consulta.php?clienteId=" + clienteId,
                dataType: "json",
                success: function(data) {
                    // Rellenar los campos con los datos obtenidos
                    $("#cliente-id").text(data.ID);
                    $("#cliente-nombre").text(data.Nombre);
                    $("#cliente-apellido").text(data.Apellido);
                    $("#cliente-domicilio").text(data.Domicilio);
                    $("#cliente-telefono").text(data.Telefono);
                    $("#cliente-curp").text(data.IdentificacionCURP);
                    $("#cliente-zona").text(data.ZonaAsignada);
    
                    $("#prestamo-id").text(data.IDPrestamo);
                    $("#prestamo-tasa").text(data.TasaInteres);
                    $("#prestamo-fecha-inicio").text(data.FechaInicio);
                    $("#prestamo-fecha-vencimiento").text(data.FechaVencimiento);
                    $("#prestamo-zona").text(data.Zona);
                    $("#prestamo-monto-pagar").text(data.MontoAPagar);
                    $("#prestamo-cuota").text(data.Cuota);
                },
                error: function() {
                    alert("No hay más clientes que mostrar");
                }
            });
        }
    
        // Función para registrar el pago
        function registrarPago() {
            var cantidadPago = $("#cantidad-pago").val();
            var fechaPago = $("#fecha-pago").val();
            $.ajax({
                url: "registrar_pago.php",
                method: "POST",
                data: {
                    clienteId: $("#cliente-id").text(),
                    cantidadPago: cantidadPago,
                    fechaPago: fechaPago
                },
                success: function(response) {
                    // Actualiza el monto a pagar en la página
                    $("#prestamo-monto-pagar").text(response);
                    alert("Pago registrado exitosamente");
                    // Limpiar los campos de cantidad de pago y fecha del pago
                    $("#cantidad-pago").val("");
                    $("#fecha-pago").val("");
                    // Cambiar automáticamente al siguiente cliente
                    cambiarCliente(1);
                },
                error: function() {
                    alert("Error al registrar el pago");
                }
            });
        }
    
        // Función para cambiar al cliente anterior o siguiente
        function cambiarCliente(delta) {
            clienteActualId += delta;
            cargarDatosCliente(clienteActualId);
        }
    
        // Llama a la función para cargar los datos del cliente actual al cargar la página
        cargarDatosCliente(clienteActualId);
    
        // Asocia el evento click del botón "Registrar Pago" a la función para registrar el pago
        $("#registrarPago").click(registrarPago);
        
        // Asocia el evento clic a los botones de navegación
        $("#anteriorCliente").click(function() {
            cambiarCliente(-1); // Cambiar al cliente anterior
        });
        
        $("#siguienteCliente").click(function() {
            cambiarCliente(1); // Cambiar al siguiente cliente
        });
    </script>
</body>
</html>
