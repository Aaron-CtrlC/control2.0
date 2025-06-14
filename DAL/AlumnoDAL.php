<?php
require_once("../Entidades/Alumno.php");
require_once("AbstractMapper.php");

class AlumnoDAL  extends AbstractMapper
{

    public function InsertarAlumno($alumno)
    {
        $consulta = "INSERT INTO alumnos (dni, nombre, apellido, genero, nacionalidad, fechaNacimiento, direccion, idCurso, idTutor, idPreceptor) VALUES 
        ('" . $alumno->getDni() . "', '" . $alumno->getNombre() . "', 
        '" . $alumno->getApellido() . "', '" . $alumno->getGenero() . "', 
        '" . $alumno->getNacionalidad() . "', '" . $alumno->getFechaNacimiento() . "',
        '" . $alumno->getDireccion() . "','" . $alumno->getIdCurso() . "', 
        '" . $alumno->getIdTutor() . "', '" . $alumno->getIdPreceptor() . "')";

        $this->setConsulta($consulta);
        $id = $this->Execute();
        return $id;
        
    }

    public function deleteAlumno($idAlumno)
    {
        $consulta = "DELETE FROM alumnos WHERE idAlumnos = '$idAlumno'";
        $this->setConsulta($consulta);
        $resultado = $this->Execute();
        return $resultado;
    }

    //Metodo que mediante la id del curso busca los alumnos que esten en ese curso 
    public function findAlumnosByIdCurso($idCurso): array
    {
        $consulta = "SELECT * FROM alumnos WHERE idCursos ='$idCurso'";
        $this->setConsulta($consulta);
        return $this->FindAll();  // Devuelve un array de objetos Alumno
    }
    //Busca los alumnos mediante el dni y retorna un objeto 
    public function findId(string $dni)
    {
        $consulta =  "SELECT * FROM alumnos WHERE DNI = '$dni'";
        $this->setConsulta($consulta);
        $resultado = $this->Find();
        $id =  $resultado->getId();
        return $id;
    }

    //Recupera un array de todos los objetos tipo alumnos
    public function getAllAlumnos()
    {
        $consulta = "SELECT * FROM alumnos";
        $this->setConsulta($consulta);
        $lista = $this->FindAll();
        return $lista;
    }

    public function UpdateAlumno($alumno)
    {
        $consulta = "UPDATE alumnos 
        SET DNI='" . $alumno->getDni() . "',
            Nombre='" . $alumno->getNombre() . "',
            Apellido='" . $alumno->getApellido() . "',
            Genero='" . $alumno->getGenero() . "',
            Nacionalidad='" . $alumno->getNacionalidad() . "',
            FechaNacimiento='" . $alumno->getFechaNacimiento() . "',
            Direccion='" . $alumno->getDireccion() . "',
            idCursos='" . $alumno->getIdCurso() . "'
        WHERE idAlumnos='" . $alumno->getId() . "';";

        $this->setConsulta($consulta);
        $id = $this->Execute();
        return $id;
    }


    public function doLoad($columna)
    {
        $id = (int) $columna["idAlumno"];
        $dni = (string) $columna["dni"];
        $nombre = (string) $columna["nombre"];
        $apellido = (string) $columna["apellido"];
        $nacionalidad = (string) $columna["nacionalidad"];
        $genero = (string) $columna["genero"];
        $fechaNacimiento = (string) $columna["fechaNacimiento"];
        $direccion = (string) $columna["direccion"];
        $idCurso = (int) $columna["idCurso"];
        $idTutor = (int) $columna["idTutor"];
        $idPreceptor = (int) $columna["idUsuario"];

        $alumno = new Alumno(
            $id,
            $dni,
            $nombre,
            $apellido,
            $genero,
            $nacionalidad,
            $fechaNacimiento,
            $direccion,
            $idCurso,
            $idTutor,
            $idPreceptor
        );

        return $alumno;
    }
}
