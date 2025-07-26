document.getElementById('loginForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const user = document.getElementById('user').value;
  const password = document.getElementById('password').value;

  fetch('php/login.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `user=${encodeURIComponent(user)}&password=${encodeURIComponent(password)}`
  })
  .then(res => res.json())
  .then(data => {
    const mensaje = document.getElementById('mensaje');
    if (data.success) {
      mensaje.style.color = 'green';
      mensaje.textContent = 'Ingreso exitoso...';
      setTimeout(() => window.location.href = 'html/menu.html', 1000);
    } else {
      mensaje.style.color = 'red';
      mensaje.textContent = 'Usuario o contraseña incorrectos.';
    }
  })
  .catch(err => console.error(err));
});
