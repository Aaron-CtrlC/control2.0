<?php
require_once("../Entidades/Usuario.php");
require_once("AbstractMapper.php");

class UsuarioDAL extends AbstractMapper
{

    //metodo que recibe un parametro de tipo usuario, busca y actualiza un fila de la tabala usuarios 
    public function UpdateUser($usuario)
    {
        $consulta="UPDATE usuarios 
        SET DNI='" . $usuario->getDni() . "',
            Email='".$usuario->getEmail()."',
            Contrasena='".$usuario->getContrasena()."',
            Nombre='".$usuario->getNombre()."',
            Apellido='".$usuario->getApellido()."',
            idTiposUsuarios='".$usuario->getIdTiposUsuarios()."'

            WHERE DNI='" . $usuario->getDni() . "';        
        ";
        $this->setConsulta($consulta);
        $id= $this->Execute();
        return $id;
    }

    //metodod que elimina usuarios mediante id

    public function DeleteUser($id)
    {
        $consulta= "DELETE FROM usuarios WHERE idUsuarios = '$id' ";
        $this->setConsulta($consulta);
        $id= $this->Execute();      
        return $id;
    }

    //Metodo que recibe un parametro de tipo usuario y graba en la db 
    public function InsertarUsuario($usuario)
    {
        $consulta= "INSERT INTO usuarios(DNI,Email,Contrasena,Nombre,Apellido,idTiposUsuarios) VALUES
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

    public function AuthUsuario($nombreUsuario, $contrasena): ?Usuario  
    {
        $consulta = "SELECT * FROM usuarios WHERE  Nombre='$nombreUsuario' AND Contrasena = '$contrasena'  ";
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
        $consulta= "SELECT * FROM usuarios WHERE idUsuarios= '$idUsuario' ";
        $this->setConsulta($consulta);
        $resultado= $this->FindAll();
        return $resultado;
    }


    
    public function getCursoById($idCurso)
    {
        $consulta= "SELECT * FROM usuarios WHERE idUsuarios= '$idCurso' ";
        $this->setConsulta($consulta);
        $resultado= $this->Find();
        return $resultado;
    }

    public function doLoad($columna)
    {
        $id= (int) $columna["idUsuarios"];
        $dni = (string) $columna["DNI"];
        $email = (string) $columna["Email"];
        $contrasena = (string) $columna["Contrasena"];
        $nombre = (string) $columna["Nombre"];
        $apellido = (string) $columna["Apellido"];
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
