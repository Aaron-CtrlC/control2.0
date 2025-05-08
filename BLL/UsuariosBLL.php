<?php
require_once("../Entidades/Usuario.php");
require_once("../DAL/UsuarioDAL.php");
class UsuariosBLL
{
    public function DeleteUser($idUsuario)
    {
        $usuarioDAL = new UsuarioDAL();
        $delete = $usuarioDAL->DeleteUser($idUsuario);
        return $delete;
    }
    public function AuthUsuario($nombreUsuario, $contrasena): ?Usuario
    {
        $usuarioDAL = new UsuarioDAL();
        $usuario = $usuarioDAL->AuthUsuario($nombreUsuario, $contrasena);

        if ($usuario != null) {
            return $usuario;
        }
        if ($usuario === null) {
            return null;
        }
    }

    public function GrabarUsuario($usuario)
    {
        $usuarioDAL = new UsuarioDAL();
        $id = $usuarioDAL->InsertarUsuario($usuario);
        return $id;
    }

    public function UpdateUsuario($usuario)
    {
        $usuarioDAL = new UsuarioDAL();
        $id = $usuarioDAL->UpdateUser($usuario);
        return $id;
    }

    public static function ListaAlumnos(): array
    {
        $usuarioDAL = new UsuarioDAL();
        $lista = $usuarioDAL->getAllUsuarios();
        return $lista;
    }

    public static function obtenerCursos($idUsuario): array
    {
        $cursos = CursoBLL::getCursosByIdPreceptor($idUsuario); // Llamada al método estático
        return $cursos;
    }


    public static function getUsuarioByIdCurso($idUsuario)
    {
        $usuarioDAL= new UsuarioDAL();
        $resultado= $usuarioDAL->getCursoById($idUsuario);
        return $resultado;
    }



}
