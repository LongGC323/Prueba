document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formProducto");

  // Llenar las opciones de categoría, marca y unidad
  const categoriaSelect = document.querySelector('select[name="categoria"]');
  const marcaSelect = document.querySelector('select[name="marca"]');
  const unidadSelect = document.querySelector('select[name="unidad"]');

  // Función para cargar las opciones desde el servidor
  function cargarOpciones(url, selectElement, keyId, keyNombre) {
    fetch(url)
      .then(response => response.json())
      .then(data => {
        // Mantener las opciones predeterminadas
        const defaultOption = selectElement.querySelector('option[value=""]');
        
        // Eliminar todas las opciones (excepto la predeterminada)
        selectElement.innerHTML = ''; 

        // Re-agregar la opción predeterminada
        selectElement.appendChild(defaultOption);

        // Crear nuevas opciones
        data.forEach(nombre => {
        const option = document.createElement("option");
        option.value = nombre;
        option.textContent = nombre;
        selectElement.appendChild(option);
        });

      })
      .catch(error => console.error("Error al cargar opciones:", error));
  }

  // Cargar categorías, marcas y unidades
  cargarOpciones("../php/get_catalogos.php?tipo=categoria", categoriaSelect, "id_categoria", "nombre_categoria");
  cargarOpciones("../php/get_catalogos.php?tipo=marca", marcaSelect, "id_marca", "nombre_marca");
  cargarOpciones("../php/get_catalogos.php?tipo=unidad", unidadSelect, "id_unidad", "nombre_unidad");

  // Manejar el envío del formulario
  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const datos = new FormData(form);

      fetch("../php/registrar_producto.php", {
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
