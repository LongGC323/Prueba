document.addEventListener("DOMContentLoaded", function () {
  const busqueda = document.getElementById("busqueda");
  const tabla = document.getElementById("tabla-productos");
  const btnBuscar = document.getElementById("btnBuscar");

  function cargarProductos(filtro = "") {
  fetch(`../php/consulta_producto.php?busqueda=${encodeURIComponent(filtro)}`)
    .then(res => res.json())
    .then(data => {
      const tabla = document.getElementById("tabla-productos");
      tabla.innerHTML = "";
      if (data.length > 0) {
        data.forEach(producto => {
          const fila = document.createElement("tr");
          fila.innerHTML = `
            <td>${producto.nombre_producto}</td>
            <td>${producto.categoria}</td>
            <td>${producto.marca}</td>
            <td>${producto.unidad}</td>
            <td>${producto.precio_compra}</td>
            <td>${producto.precio_venta}</td>
            <td>${producto.stock}</td>
            <td><button class="modificar" onclick="modificarProducto(${producto.id_producto})">Modificar</button></td>
          `;
          tabla.appendChild(fila);
        });
      } else {
        tabla.innerHTML = `<tr><td colspan="8">No se encontraron resultados.</td></tr>`;
      }
    })
    .catch(err => {
      console.error(err);
      tabla.innerHTML = `<tr><td colspan="8">Error al cargar los datos.</td></tr>`;
    });
}
  btnBuscar.addEventListener("click", () => {
    cargarProductos(busqueda.value.trim());
  });
});

function modificarProducto(idProducto) {
  window.location.href = `../php/modificar_producto.php?id_producto=${idProducto}`;
}
