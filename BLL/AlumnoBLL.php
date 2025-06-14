<?php
require_once("../DAL/AlumnoDAL.php");

class AlumnoBLL
{

    public function GrabarAlumno($alumno)
    {
        $alumnoDAL= new AlumnoDAL();
        $id= $alumnoDAL->InsertarAlumno($alumno);
        return $id;
    }
    public function getIdAlumnoDni($dni)
    {
        $alumnoDAL= new AlumnoDAL();
        $id= $alumnoDAL->findId($dni);
        return $id;
    }

    public static function getAlumnosByIdCurso($idCurso):array
    {
        $alumnoDAL= new AlumnoDAL();
        $lista= $alumnoDAL->findAlumnosByIdCurso($idCurso);
        return $lista;
    }

    public static function listaAlumnos(): array
    {
        $AlumnoDAL= new AlumnoDAL();
        $lista= $AlumnoDAL->getAllAlumnos();
        return $lista;
    }

    public function deleteAlumno($id)
    {
        $alumnoDAL = new AlumnoDAL();
        $resultado= $alumnoDAL->deleteAlumno($id);
        return $resultado;
    }

    public function UpdateAlumno($alumno)
    {
        $alumnoDAL = new AlumnoDAL();
        $resultado= $alumnoDAL->UpdateAlumno( $alumno);
        return $resultado;
    }
}