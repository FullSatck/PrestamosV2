<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abonos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/assets/css/abonos.css">
</head>

<body>
    <!-- Barra de navegación -->
    <div class="navbar">
        <button id="fecha-izquierda" class="boton-flecha" onclick="cambiarCliente(-1)">&larr;</button>
        <!-- Flecha hacia la izquierda -->
        <button id="menu" class="boton-menu" onclick="redireccionar()">&#8801;</button>
        <!-- Menu -->
        <button id="fecha-derecha" class="boton-flecha" onclick="cambiarCliente(1)">&rarr;</button>
        <!-- Flecha hacia la derecha -->
    </div><br>

    <div class="cobro-bar">
        <span class="cobro-text">Cobro</span>
    </div>

    <!-- Recuadro para campos en dos columnas -->
    <div class="field-container">
        <!-- Columna 1: Nombre y Apellido del Cliente -->
        <div class="column">
            <label for="nombre" style="color: blue;">Nombre: </label> <br>
            <span id="nombre"></span>
        </div>

        <!-- Columna 2: Domicilio, Tel/Cel, Plazo y Cuota -->
        <div class="column">
            <label for="domicilio" style="color: blue;">Domicilio: </label> <br>
            <span id="domicilio"></span>
        </div>

        <!-- Agrega elementos <span> para mostrar el teléfono y el monto a pagar -->
        <div class="column">
            <label for="tel_cel" style="color: blue;">Tel/Cel: </label> <br>
            <span id="tel_cel"></span>
        </div>

        <!-- Agrega un elemento <span> para mostrar el monto -->
        <div class="column">
            <label for="monto" style="color: blue;">Monto: </label> <br>
            <span id="monto"></span>
        </div>



        <div class="column">
            <label for="curp" style="color: blue;">CURP: </label> <br>
            <span id="curp"></span>
        </div>

        <div class="column">
            <label for="plazo" style="color: blue;">Plazo: </label> <br>
            <span id="plazo"></span>
        </div>

        <div class="column">
            <label for="cuota" style="color: blue;">Cuota: </label> <br>
            <span id="cuota"></span>
        </div>
    </div>

    <div class="field-container">
        <!-- Fila 3: Pagar y Fecha -->
        <div class="column">
            <label for="pagar" style="color: blue;">Pagar: </label>
            <input type="text" id="pagar" placeholder="Ingrese la cantidad a pagar">
        </div>

        <div class="column" style="position: relative;">
            <label for="fecha" style="color: blue;">Fecha: </label>
            <div id="fecha-actual" style="border: 1px solid #ccc; padding: 4px;"></div>
        </div>



    </div>


    <!-- Agrega un botón o formulario para registrar el pago -->
    <button id="registrarPago" class="btn-guardar">Registrar Pago</button>





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
                $("#nombre").text(data.Nombre);
                $("#domicilio").text(data.Domicilio);
                $("#curp").text(data.IdentificacionCURP);
                $("#tel_cel").text(data.Telefono); // Mostrar teléfono
                $("#plazo").text(data.Plazo);
                $("#monto").text(data.Monto); // Mostrar monto
                $("#cuota").text(data.Cuota); // Mostrar cuota
            },
            error: function() {
                alert("Error al cargar los datos del cliente.");
            }
        });
    }


    // Función para cambiar al cliente anterior
    function cambiarClienteAnterior() {
        clienteActualId--; // Disminuir el ID en 1 (cambia al cliente anterior)
        cargarDatosCliente(clienteActualId);
    }

    // Función para cambiar al cliente siguiente
    function cambiarClienteSiguiente() {
        clienteActualId++; // Aumentar el ID en 1 (cambia al cliente siguiente)
        cargarDatosCliente(clienteActualId);
    }

    // Llama a la función para cargar los datos del cliente inicial
    cargarDatosCliente(clienteActualId);

    // Manejar los eventos de los botones para cambiar de cliente
    $("#fecha-izquierda").click(cambiarClienteAnterior);
    $("#fecha-derecha").click(cambiarClienteSiguiente);
    // Función para redireccionar al CRUD de clientes
    function redireccionarCrudClientes() {
        // Cambia 'crud_clientes.html' por la URL de tu página de CRUD de clientes
        window.location.href = '/resources/views/admin/clientes/lista_clientes.php';
    }

    // Asocia la función al evento de clic en el botón "Menu"
    $("#menu").click(redireccionarCrudClientes);
    // Función para registrar un pago
    function registrarPago() {
        // Obtener el monto a pagar y otros datos necesarios
        var monto = parseFloat($("#pagar").val());
        var fechaPago = $("#fecha").val();

        // Realizar una solicitud AJAX para registrar el pago
        $.ajax({
            type: "POST",
            url: "/resources/views/admin/abonos/registrar_pago.php",
            data: {
                clienteId: clienteActualId, // ID del cliente actual
                monto: monto,
                fechaPago: fechaPago
            },
            success: function(response) {
                // Actualizar la página o mostrar un mensaje de éxito
                alert("Pago registrado con éxito");
                // Puedes agregar aquí código adicional para actualizar la interfaz si es necesario
            },
            error: function() {
                alert("Error al registrar el pago");
            }
        });
    }

    // Asocia la función al evento de clic en el botón "Registrar Pago"
    $("#registrarPago").click(registrarPago);

    // Función para obtener la fecha actual en formato deseado (dd/mm/yyyy hh:mm a)
    function obtenerFechaActual() {
        var fecha = new Date();
        var dia = fecha.getDate().toString().padStart(2, '0');
        var mes = (fecha.getMonth() + 1).toString().padStart(2, '0'); // Los meses son base 0
        var anio = fecha.getFullYear();
        var horas = fecha.getHours().toString().padStart(2, '0');
        var minutos = fecha.getMinutes().toString().padStart(2, '0');
        var ampm = horas >= 12 ? 'p.m.' : 'a.m.';
        horas = horas % 12;
        horas = horas ? horas : 12; // Las 12:00 p.m. y las 12:00 a.m. se muestran como 12:00
        var formatoFecha = dia + '/' + mes + '/' + anio + ' ' + horas + ':' + minutos + ' ' + ampm;
        return formatoFecha;
    }

    // Función para mostrar la fecha actual en el div en tiempo real
    function mostrarFechaActualEnTiempoReal() {
        var fechaDiv = document.getElementById("fecha-actual");

        function actualizarFecha() {
            var fechaActual = obtenerFechaActual();
            fechaDiv.textContent = fechaActual;
        }

        // Actualizar la fecha cada segundo (1000 milisegundos)
        setInterval(actualizarFecha, 1000);

        // Llamar a la función inicialmente para mostrar la fecha inmediatamente
        actualizarFecha();
    }

    // Llama a la función para mostrar la fecha en tiempo real cuando se carga la página
    mostrarFechaActualEnTiempoReal();
    </script>

</body>

</html>