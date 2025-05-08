<?php

require_once("../Entidades/FaltaTotal.php");
require_once("AbstractMapper.php");

class FaltaTotalDAL extends AbstractMapper
{


    public function faltasTotales ($idAlumno): array
    {
        $consulta= '
      SELECT 
    alumnos.idAlumnos,
    alumnos.DNI,
    alumnos.nombre,
    alumnos.apellido,
    COUNT(CASE WHEN asistencias.ValorAsistencia = 0 THEN 1 END) AS AsistenciasCompletas,
    COUNT(CASE WHEN asistencias.ValorAsistencia = 0.5 THEN 1 END) AS AsistenciasMedias,
    COUNT(CASE WHEN asistencias.ValorAsistencia = 1 THEN 1 END) AS AsistenciasFaltas,

    SUM(asistencias.ValorAsistencia) AS FaltasTotales
FROM 
    asistencias 
INNER JOIN 
    alumnos 
ON 
    asistencias.idAlumnos = alumnos.idAlumnos 
INNER JOIN
    tipoclase
ON 
    asistencias.idtipoClase = tipoclase.idtipoClase
INNER JOIN
    cursos
ON 
    cursos.idCursos = alumnos.idCursos
WHERE 
	alumnos.idAlumnos = '.$idAlumno.'
GROUP BY     
    alumnos.idAlumnos,
    alumnos.DNI,
    alumnos.nombre,
    alumnos.apellido;
 ';

        $this->setConsulta($consulta);
        $resultado= $this->FindAll();
        return $resultado;

    }


    public function informeCurso($idCurso)
    {
        $consulta = '
  SELECT 
    alumnos.idAlumnos,
    alumnos.DNI,
    alumnos.nombre,
    alumnos.apellido,
    COUNT(CASE WHEN asistencias.ValorAsistencia = 0 THEN 1 END) AS AsistenciasCompletas,
    COUNT(CASE WHEN asistencias.ValorAsistencia = 0.5 THEN 1 END) AS AsistenciasMedias,
    COUNT(CASE WHEN asistencias.ValorAsistencia = 1 THEN 1 END) AS AsistenciasFaltas,
    SUM(asistencias.ValorAsistencia) AS FaltasTotales
FROM 
    asistencias 
INNER JOIN 
    alumnos ON asistencias.idAlumnos = alumnos.idAlumnos 
INNER JOIN
    tipoclase ON asistencias.idtipoClase = tipoclase.idtipoClase
INNER JOIN
    cursos ON cursos.idCursos = alumnos.idCursos
WHERE 
    alumnos.idCursos = '.$idCurso.'
GROUP BY     
    alumnos.idAlumnos,
    alumnos.DNI,
    alumnos.nombre,
    alumnos.apellido;


        ';
    
        $this->setConsulta($consulta);
        $resultado = $this->FindAll();
        return $resultado;
    }
    

    public function doLoad($columna)
    {
        $id= (int) $columna["idAlumnos"];
        $dni= (int) $columna["DNI"];
        $nombre= (string) $columna["nombre"];
        $apellido= (string) $columna["apellido"];
        $asistencia= (float) $columna["AsistenciasCompletas"];
        $asistenciaMedia= (float) $columna["AsistenciasMedias"];
        $asistenciaFalta = (float) $columna["AsistenciasFaltas"];
        $totalFaltas= (float) $columna["FaltasTotales"];


        $faltaTotal= new FaltaTotal(
            $id,
            $dni,
            $nombre,
            $apellido,
            $asistencia,
            $asistenciaMedia,
            $asistenciaFalta,
            $totalFaltas
        );

        return $faltaTotal;
    }
}
