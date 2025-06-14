function vista() {
    const passwordInput = document.getElementById('contrasena');
    const icon = document.getElementById('btnViewPass');

    // Alternar entre tipo 'password' y 'text'
    passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';

    // Alternar entre los íconos de ojo abierto/cerrado (Font Awesome)
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
}