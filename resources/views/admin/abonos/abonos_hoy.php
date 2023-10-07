<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préstamos Pendientes para Hoy</title>
</head>
<body>
    <h1>Préstamos Pendientes para Hoy</h1>
    
    <!-- Contenedor para mostrar los préstamos -->
    <div id="prestamos-container">
        Cargando préstamos...
    </div>

    <script>
        // Función para cargar los préstamos pendientes para hoy en tiempo real
        function cargarPrestamos() {
            // Crear una instancia de XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Definir la URL del archivo PHP que obtiene los préstamos
            var url = "validar_abonohoy.php";

            // Definir los parámetros que deseas enviar al servidor (en este caso, la zona del supervisor)
            var zona = "<?= $zonaSupervisor ?>"; // Esto debe coincidir con la zona del supervisor actual
            var params = "zona=" + zona;

            // Configurar la solicitud AJAX
            xhr.open("GET", url + "?" + params, true);

            // Configurar la función de callback para manejar la respuesta
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // La solicitud se ha completado y la respuesta está lista
                    // Actualizar el contenido del contenedor con los préstamos obtenidos
                    document.getElementById("prestamos-container").innerHTML = xhr.responseText;
                }
            };

            // Enviar la solicitud
            xhr.send();
        }

        // Cargar los préstamos al cargar la página
        cargarPrestamos();

        // Actualizar los préstamos cada cierto intervalo de tiempo (por ejemplo, cada 30 segundos)
        setInterval(cargarPrestamos, 300); // 30000 milisegundos = 30 segundos
    </script>
</body>
</html>
