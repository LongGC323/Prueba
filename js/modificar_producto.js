// modificar_producto.js

function actualizarProducto(event) {
  event.preventDefault();

  const formData = new FormData(document.getElementById('form-modificar'));

  fetch('modificar_producto.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      window.location.href = '../html/consulta_productos.html';
    } else {
      alert(data.message);
    }
  })
  .catch(error => {
    console.error('Error al actualizar el producto:', error);
    alert('Hubo un error al actualizar el producto.');
  });
}
