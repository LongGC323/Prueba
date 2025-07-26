document.addEventListener("DOMContentLoaded", function () {
  const busqueda = document.getElementById("busqueda");
  const tabla = document.getElementById("tabla-proveedores");
  const btnBuscar = document.getElementById("btnBuscar");

  function cargarProveedores(filtro = "") {
    fetch(`../php/consulta_proveedor.php?busqueda=${encodeURIComponent(filtro)}`)
      .then(res => res.json())
      .then(data => {
        tabla.innerHTML = "";
        if (data.length > 0) {
          data.forEach(proveedor => {
            const fila = document.createElement("tr");
            fila.innerHTML = `
              <td>${proveedor.nombre}</td>
              <td>${proveedor.telefono}</td>
              <td>${proveedor.email}</td>
              <td><button class="modificar" onclick="modificarProveedor(${proveedor.id_proveedor})">Modificar</button></td>
            `;
            tabla.appendChild(fila);
          });
        } else {
          tabla.innerHTML = `<tr><td colspan="4">No se encontraron resultados.</td></tr>`;
        }
      })
      .catch(err => {
        tabla.innerHTML = `<tr><td colspan="4">Error al cargar los datos.</td></tr>`;
        console.error(err);
      });
  }

  btnBuscar.addEventListener("click", () => {
    cargarProveedores(busqueda.value.trim());
  });
});

// 👇 Función accesible globalmente
function modificarProveedor(idProveedor) {
  window.location.href = `../php/modificar_proveedor.php?id_proveedor=${idProveedor}`;

}
