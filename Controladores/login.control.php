<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../BLL/UsuariosBLL.php');
    $usuarioBLL = new UsuariosBLL();
    $isValid = (bool) !empty($_POST["email"]) && !empty($_POST["contrasena"]);
    // Verifica que los POST enviados no estén vacíos
    if ($isValid) {
        $email = $_POST["email"];
        $contrasena = $_POST["contrasena"];

        // Llama al método para autenticar al usuario
        $usuario = $usuarioBLL->AuthUsuario($email, $contrasena);

        // Si se encuentra el usuario
        if ($usuario != null) {
            $_SESSION["usuario"] = serialize($usuario);
            $idUsuario = (int) $usuario->getIdTiposUsuarios();

            if ($idUsuario === 1) {
                header('Location: ../UI/preceptor.php');
                exit;
            }
            if ($idUsuario === 2) {
                header('Location: ../UI/SuperPreceptor.php');
                exit;
            } elseif ($idUsuario == 3) {
                header('Location: ../UI/administrador.php');
                exit;
            }
        }

        if ($usuario === null) {
            $_SESSION['error_message'] = "Usuario o Contraseña incorrectos.";
            header('Location: ../UI/login.php');
        }
    }
}
