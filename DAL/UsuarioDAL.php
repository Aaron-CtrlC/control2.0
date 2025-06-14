<?php
require_once("../Entidades/Usuario.php");
require_once("AbstractMapper.php");

class UsuarioDAL extends AbstractMapper
{

    //metodo que recibe un parametro de tipo usuario, busca y actualiza un fila de la tabala usuarios 
    public function UpdateUser($usuario)
    {
        $consulta="UPDATE usuarios 
        SET dni='" . $usuario->getDni() . "',
            email='".$usuario->getEmail()."',
            contrasena='".$usuario->getContrasena()."',
            nombre='".$usuario->getNombre()."',
            apellido='".$usuario->getApellido()."',
            idTiposUsuarios='".$usuario->getIdTiposUsuarios()."'

            WHERE dni='" . $usuario->getDni() . "';        
        ";
        $this->setConsulta($consulta);
        $id= $this->Execute();
        return $id;
    }

    //metodod que elimina usuarios mediante id

    public function DeleteUser($idUser)
    {
        $consulta= "DELETE FROM usuarios WHERE id = '$idUser' ";
        $this->setConsulta($consulta);
        $id= $this->Execute();      
        return $id;
    }

    //Metodo que recibe un parametro de tipo usuario y graba en la db 
    public function InsertarUsuario($usuario)
    {
        $consulta= "INSERT INTO usuarios(dni,email,contrasena,nombre,apellido,idTiposUsuarios) VALUES
        ('".$usuario->getDni()."',
        '".$usuario->getEmail()."',
        '".$usuario->getContrasena()."',
        '".$usuario->getNombre()."',
        '".$usuario->getApellido()."',
        '".$usuario->getIdTiposUsuarios()."'
        )
        ";

        $this->setConsulta($consulta);
        $id= $this->Execute();
        return $id;
    }
    //Metodo para buscar un  objetos tipo usuario, recibe dos parametros y mediante esos los busca en la base de datos 

    public function AuthUsuario($email, $contrasena): ?Usuario  
    {
        $consulta = "SELECT * FROM usuarios WHERE  email='$email' AND contrasena = '$contrasena'  ";
        $this->setConsulta(consulta: $consulta);
        $usuario = $this->Find();
        if ($usuario instanceof  Usuario && $usuario != null) {
            return $usuario;
        }

        return null;    
    }

    //Metodo para recuperar un array de objetos tipo usuarios
    public function getAllUsuarios(): array
    {
        $consulta= "SELECT * FROM usuarios";
        $this->setConsulta($consulta);
        $lista= $this->FindAll();
        return $lista;
    }

    public function getUsuarioByIdCurso($idUsuario)
    {
        $consulta= "SELECT * FROM usuarios WHERE id= '$idUsuario' ";
        $this->setConsulta($consulta);
        $resultado= $this->FindAll();
        return $resultado;
    }


    
    public function getCursoById($idCurso)
    {
        $consulta= "SELECT * FROM usuarios WHERE id= '$idCurso' ";
        $this->setConsulta($consulta);
        $resultado= $this->Find();
        return $resultado;
    }

    public function doLoad($columna)
    {
        $id= (int) $columna["id"];
        $dni = (string) $columna["dni"];
        $email = (string) $columna["email"];
        $contrasena = (string) $columna["contrasena"];
        $nombre = (string) $columna["mombre"];
        $apellido = (string) $columna["apellido"];
        $idTipoUsuario= (int) $columna["idTiposUsuarios"]; 
        $usuario = new Usuario(
            $id,
            $dni,
            $email,
            $contrasena,
            $nombre,
            $apellido,
            $idTipoUsuario
        );
        return $usuario;
    }
}
