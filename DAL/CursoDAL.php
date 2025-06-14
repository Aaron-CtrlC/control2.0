<?php
require_once(__DIR__."../../Entidades/Cursos.php");
require_once("AbstractMapper.php");
class CursoDAL extends AbstractMapper
{
    //Busca los cursos mediante el id de la preceptora y retorna un array con el o los cursos
    public  function findCursosById($idPreceptor): array
    {
        $consulta = "SELECT * FROM cursos WHERE idUsuario = '$idPreceptor' ";
        $this->setConsulta($consulta);
        $lista = $this->FindAll();
        return $lista;
    }

    public  function findCursosByAlumno($idAlumno): array
    {
        $consulta = "SELECT * FROM cursos WHERE id = '$idAlumno' ";
        $this->setConsulta($consulta);
        $lista = $this->FindAll();
        return $lista;
    }

    public function getAllCursos(): array
    {
        $consulta = "SELECT * FROM cursos";
        $this->setConsulta($consulta);
        $lista = $this->FindAll();
        return $lista;
    }


    public function deleteCurso($id)
    {
        $consulta= "DELETE FROM cursos WHERE id = '$id' ";
        $this->setConsulta($consulta);
        $id= $this->Execute();      
        return $id;    
    }


    public function InsertarCurso($curso)
    {
        $consulta = "INSERT INTO cursos (ano, division, idUsuario) VALUES (
            '" . $curso->getAno() . "',
            '" . $curso->getDivision() . "',
            '" . $curso->getIdUsuario() . "'
        )";

        $this->setConsulta($consulta);
        $id = $this->Execute();
        return $id;
    }

    public function UpdateCurso($curso)
    {
        $consulta = "UPDATE cursos 
        SET 
            anoo='" . $curso->getAno() . "',
            division='" . $curso->getDivision() . "',
            idUsuario='" . $curso->getIdUsuario() . "'
        WHERE idCursos='" . $curso->getId() . "';";

        $this->setConsulta($consulta);
        $id = $this->Execute();
        return $id;
    }


    public function getCursoById($idCurso)
    {
        $consulta= "SELECT * FROM cursos WHERE id= '$idCurso' ";
        $this->setConsulta($consulta);
        $resultado= $this->Find();
        return $resultado;
    }

    public function doLoad($columna)
    {
        $id = (int) $columna['id'];
        $ano = (int) $columna['ano'];
        $division =  (string) $columna['division'];
        $idUsuario = (int) $columna["idUsuario"];

        $curso = new Cursos(
            $id,
            $ano,
            $division,
            $idUsuario
        );
        return $curso;
    }

}
