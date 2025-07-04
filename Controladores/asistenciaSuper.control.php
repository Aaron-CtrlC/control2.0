<?php
// Archivo: grabarAsistencia.control.php
session_start();
require_once("../BLL/AsistenciaBLL.php");
require_once("../Entidades/Usuario.php");

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header('Location: ../UI/login.php');
    exit();
}

$asistenciaBLL = new AsistenciaBLL();
$usuario = unserialize($_SESSION['usuario']);
$idUsuario = $usuario->getId();

// Obtener listas de asistencia, inasistencias, y tipo de clase
$listaId = isset($_POST["idAlumno"]) ? (array) $_POST["idAlumno"] : [];
$listaInasistencias = isset($_POST["inasistencias"]) ? (array) $_POST["inasistencias"] : [];
$tipoClase = isset($_POST["tipoClase"]) ? (array) $_POST["tipoClase"] : [];

// Determinar listas de asistencia e inasistencia
$listaAsistencias = array_intersect($listaId, $listaInasistencias);
$inasistencias = array_diff($listaInasistencias, $listaId);

// Grabar las asistencias con valor 0 (presente en taller o teoría)
foreach ($listaAsistencias as $asistencia) {
    foreach ($tipoClase as $clase) {
        $valorAsistencia = ($clase == 1) ? 0.5 : (($clase == 2) ? 1 : 2);
        $asistenciaBLL->grabarAsistencia($valorAsistencia, $asistencia, $clase);
    }
}

// Grabar las inasistencias con valor 0.5 para taller y 1 para teoría
foreach ($inasistencias as $inasistencia) {
    foreach ($tipoClase as $clase) {
        $valorAsistencia = 0;
        $asistenciaBLL->grabarAsistencia($valorAsistencia, $inasistencia, $clase);
    }
}

// Almacenar mensaje de éxito en la sesión y redirigir
$_SESSION['mensaje'] = "Se grabaron con éxito las asistencias";
header('Location: ../UI/SuperPreceptor.php');
?>
