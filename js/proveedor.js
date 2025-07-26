document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formProveedor");
  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const datos = new FormData(form);

      fetch("../php/registrar_proveedor.php", {
        method: "POST",
        body: datos
      })
      .then(response => response.text())
      .then(data => {
        document.getElementById("mensaje").innerText = data;
        form.reset();
      })
      .catch(error => console.error("Error:", error));
    });
  }
});
