<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aquí procesarías la simulación del préstamo, realizarías cálculos y demás acciones necesarias
    // Para esta simulación, simplemente estamos mostrando el modal

    // Esta función muestra el modal después de que se procese el préstamo
    function mostrarModal() {
        echo '<script>
                // Ejecutar código JavaScript para mostrar el modal
                document.addEventListener("DOMContentLoaded", function() {
                    // Seleccionar el modal y mostrarlo
                    const modal = document.getElementById("miModal");
                    modal.style.display = "block";

                    // Cerrar el modal al hacer clic en uno de los botones
                    const btnCerrar = document.getElementById("btnCerrarModal");
                    const btnOtroProceso = document.getElementById("btnOtroProceso");

                    btnCerrar.onclick = function() {
                        modal.style.display = "none";
                    }

                    btnOtroProceso.onclick = function() {
                        modal.style.display = "none";
                        // Aquí podrías redirigir a otra página o realizar otra acción adicional
                    }
                });
            </script>';

        // El HTML del modal
        echo '<div id="miModal" class="modal">
                <div class="modal-content">
                    <span id="btnCerrarModal" class="close">&times;</span>
                    <p>Simulación terminada</p>
                    <button id="btnOtroProceso">Otro Proceso</button>
                </div>
            </div>';
    }

    // Llamar a la función para mostrar el modal
    mostrarModal();
}
?>
