document.addEventListener("DOMContentLoaded", function () {
    const mensaje = document.querySelector(".mensaje-exito");
    if (mensaje) {
        setTimeout(() => {
            mensaje.style.opacity = "0";
            setTimeout(() => mensaje.remove(), 500);
        }, 3000);
    }

    // Desactiva el botón después de enviarlo
    const form = document.querySelector("form");
    const btnGuardar = document.getElementById("btnGuardar");

    if (form && btnGuardar) {
        form.addEventListener("submit", function () {
            btnGuardar.disabled = true;
            btnGuardar.textContent = "Guardando...";
        });
    }
});
