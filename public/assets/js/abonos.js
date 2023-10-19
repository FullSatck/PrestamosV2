// Variables globales para llevar un registro del ID del cliente actual
var clienteIds = [];
var clienteActualIndex = 0;

// Variable para mantener un registro de si se ha ingresado la cantidad de pago
var cantidadPagoIngresada = false;

// Variable global para la cantidad de pago
var cantidadPago;

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
    if (cantidadPagoIngresada) {
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

                // Limpiar los campos de cantidad de pago
                $("#cantidad-pago").val("");
                // Cierra el modal de confirmación
                $("#confirmarPagoModal").modal("hide");
                // Abre el modal de pago confirmado
                $("#pagoConfirmadoModal").modal("show");
            },
            error: function() {
                alert("Error al registrar el pago");
            }
        });
    } else {
        alert("Por favor, ingrese la cantidad de pago antes de registrarlo.");
    }
}

// Función para cambiar al cliente anterior o siguiente
function cambiarCliente(delta) {
    clienteActualIndex += delta;
    if (clienteActualIndex < 0) {
        clienteActualIndex = 0;
    } else if (clienteActualIndex >= clienteIds.length) {
        clienteActualIndex = clienteIds.length - 1;
    }
    cargarDatosCliente(clienteIds[clienteActualIndex]);
}

// Asocia el evento click del botón "Registrar Pago" a la función que muestra el modal de confirmación
$("#registrarPago").click(function() {
    // Verifica si se ha ingresado una cantidad de pago
    if ($("#cantidad-pago").val() !== "") {
        cantidadPagoIngresada = true;
        // Asigna el valor de la cantidad de pago a la variable global
        cantidadPago = $("#cantidad-pago").val();
        // Abre el modal de confirmación
        $("#confirmarPagoModal").modal("show");
    } else {
        alert("Por favor, ingrese la cantidad de pago antes de registrarlo.");
    }
});

// Asocia el evento click del botón "Confirmar" en el modal de confirmación a la función para registrar el pago
$("#confirmarPago").click(function() {
    registrarPago(); // Registra el pago
});

// Asocia el evento clic a los botones de navegación
$("#anteriorCliente").click(function() {
    cambiarCliente(-1); // Cambiar al cliente anterior
});

$("#siguienteCliente").click(function() {
    cambiarCliente(1); // Cambiar al siguiente cliente
});

// Función para cargar la lista de IDs de clientes desde el servidor
function cargarListaDeClientes() {
    $.ajax({
        url: "obtener_lista_clientes.php",
        dataType: "json",
        success: function(data) {
            clienteIds = data;
            if (clienteIds.length > 0) {
                cargarDatosCliente(clienteIds[0]);
            } else {
                alert("No hay clientes en la base de datos.");
            }
        },
        error: function() {
            alert("Error al cargar la lista de clientes.");
        }
    });
}

// Asocia el evento click del botón "Generar Factura" al enlace a la página de facturación
$("#generarFacturaButton").click(function() {
    // Obtener los datos necesarios para la factura
    var clienteId = $("#cliente-id").text();
    var clienteNombre = $("#cliente-nombre").text();
    var clienteApellido = $("#cliente-apellido").text();
    var prestamoId = $("#prestamo-id").text();

    // Redireccionar a la página de facturación con los parámetros necesarios, incluyendo la cantidad de pago
    window.location.href = "facturacionAbonos.php?clienteId=" + clienteId + "&clienteNombre=" + clienteNombre + "&clienteApellido=" + clienteApellido + "&prestamoId=" + prestamoId + "&cantidadPago=" + cantidadPago;
});

// Llama a la función para cargar la lista de IDs de clientes al cargar la página
cargarListaDeClientes();

// Asociar la función de generación de factura al botón "Generar Factura"
$("#generarFacturaButton").click(function() {
    generarFactura(); // Generar factura

    // Agregar un enlace de compartir por WhatsApp
    var whatsappLink = "whatsapp://send?text=¡Mira esta factura! Puedes descargarla aquí: [URL_DEL_PDF]";
    $("#compartirPorWhatsAppButton").attr("href", whatsappLink).show();
});

// Función para generar la factura en PDF
function generarFactura() {
    var doc = new jsPDF();
    var clienteNombre = $("#cliente-nombre").text();
    var clienteApellido = $("#cliente-apellido").text();
    var prestamoId = $("#prestamo-id").text();
    var cantidadPago = $("#cantidad-pago").val();

    // Agregar contenido a la factura
    doc.text("Factura de Pago", 10, 10);
    doc.text("Cliente: " + clienteNombre + " " + clienteApellido, 10, 20);
    doc.text("ID de Préstamo: " + prestamoId, 10, 30);
    doc.text("Cantidad Pagada: $" + cantidadPago, 10, 40);

    // Obtener la representación en base64 del PDF generado
    var pdfOutput = doc.output('datauristring');

    // Agregar el enlace para descargar el PDF
    $("#descargarPDFButton").attr("href", pdfOutput).show();
}

// Asociar la función de compartir por WhatsApp al botón correspondiente
$("#compartirPorWhatsAppButton").click(function() {
    // No es necesario hacer nada aquí, ya que el enlace se encarga de compartir el PDF.
});

