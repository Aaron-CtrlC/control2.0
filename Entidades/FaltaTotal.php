<?php
class FaltaTotal
{
    private int $idAlumno;
    private int $dni;
    private string $nombre;
    private string $apellido;
    private float $asistenciasCompletas;
    private float $asistenciasMedias;
    private float $asistenciasFaltas;
    private float $totalFaltas;

    public function __construct(int $idAlumno, int $dni, string $nombre, string $apellido, float $asistenciasCompletas, float $asistenciasMedias, float $asistenciasFaltas, float $totalFaltas)
    {
        $this->idAlumno = $idAlumno;
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->asistenciasCompletas = $asistenciasCompletas;
        $this->asistenciasMedias = $asistenciasMedias;
        $this->asistenciasFaltas = $asistenciasFaltas;
        $this->totalFaltas = $totalFaltas;
    }

    public function getIdAlumno(): int
    {
        return $this->idAlumno;
    }

    public function getDni(): int
    {
        return $this->dni;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function getAsistenciasCompletas(): float
    {
        return $this->asistenciasCompletas;
    }

    public function getAsistenciasMedias(): float
    {
        return $this->asistenciasMedias;
    }

    public function getAsistenciasFaltas(): float
    {
        return $this->asistenciasFaltas;
    }

    public function getTotalFaltas(): float
    {
        return $this->totalFaltas;
    }
}
