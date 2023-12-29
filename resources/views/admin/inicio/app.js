$(document).ready(function () {
    // Función para cargar la lista de pagos
    function loadPagos() {
        $.ajax({
            url: "load_pagos.php",
            type: "GET",
            success: function (data) {
                $("#pagos-list").html(data);
            },
            error: function () {
                alert("Error al cargar la lista de pagos.");
            }
        });
    }

    // Cargar la lista de pagos al cargar la página
    loadPagos();

    // Enviar el formulario para filtrar por fechas
    $("#filter-form").submit(function (e) {
        e.preventDefault();
        const fechaDesde = $("#fechaDesde").val();
        const fechaHasta = $("#fechaHasta").val();

        $.ajax({
            url: "load_pagos.php",
            type: "GET",
            data: { fechaDesde: fechaDesde, fechaHasta: fechaHasta },
            success: function (data) {
                $("#pagos-list").html(data);
            },
            error: function () {
                alert("Error al cargar la lista de pagos.");
            }
        });
    });
});
