document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("contabilidad-form");
    const resultadoDiv = document.getElementById("resultado");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const tipoReporte = document.getElementById("tipo_reporte").value;
        const periodo = document.getElementById("periodo").value;

        fetch("generar_reporte.php", {
            method: "POST",
            body: new URLSearchParams({ tipo_reporte, periodo }),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("La solicitud no se completó correctamente.");
            }
            return response.text();
        })
        .then(data => {
            console.log(data); // Muestra la respuesta en la consola
            try {
                const jsonData = JSON.parse(data);
                if (jsonData.resultado) {
                    resultadoDiv.textContent = jsonData.resultado;
                } else {
                    resultadoDiv.textContent = "No se encontraron resultados.";
                }
            } catch (error) {
                console.error("Error al analizar la respuesta JSON:", error);
            }
        })
        .catch(error => {
            console.error("Error al obtener el reporte:", error);
        });
    });
});
