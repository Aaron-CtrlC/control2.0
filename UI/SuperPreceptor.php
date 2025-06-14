<?php
session_start();
require_once("../Entidades/Usuario.php");
require_once("../BLL/CursoBLL.php");
require_once("../BLL/AlumnoBLL.php");
require_once("../BLL/TutorBLL.php");
require("../UI/components/mainSuperPreceptor.php");

// Verificar si el usuario está autenticado y tiene el rol adecuado
$usuario = unserialize($_SESSION["usuario"]);
$idUsuario = (int) $usuario->getIdTiposUsuarios();
if ($idUsuario === 3 && $idUsuario === 1) {
    header('Location: ../UI/login.php');
    exit();
}

$listaCursos = CursoBLL::getAllCursos();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
    // Agrupar cursos por año
    $divisiones = [];
    foreach ($listaCursos as $curso) {
        $ano = $curso->getAno();
        $division = $curso->getDivision();
        $cursoLink = '<a class="dropdown-item" href="?idCurso=' . $curso->getId() . '">' . $ano . '° ' . $division . '</a>';

        // Si no existe la división (año), la inicializamos
        if (!isset($divisiones[$ano])) {
            $divisiones[$ano] = [];
        }
        $divisiones[$ano][] = $cursoLink;
    }

    // Construir la navbar con los dropdowns por cada año
    $navbar = '
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top justify-content-center">
      <div class="container-fluid">
          <span class="navbar-brand mx-auto">SuperPreceptor</span>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
              <ul class="navbar-nav mx-auto mb-2 mb-lg-0">';

    // Generar un dropdown para cada año
    foreach ($divisiones as $ano => $cursos) {
        $navbar .= '
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="dropdown' . $ano . '" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          ' . $ano . '° División
                      </a>
                      <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdown' . $ano . '">';

        // Listar cada curso dentro del dropdown del año, mostrando año y división
        foreach ($cursos as $cursoLink) {
            $navbar .= '
                          <li>' . $cursoLink . '</li>';
        }

        $navbar .= '
                      </ul>
                  </li>';
    }

    $navbar .= '
              </ul>
              <form method="POST" action="../Controladores/logout.control.php" class="d-flex ms-auto">
                  <button type="submit" class="btn btn-outline-danger">Cerrar sesión</button>
              </form>
          </div>
      </div>
  </nav>';

    echo $navbar;
    ?>

    <div class="container mt-5 pt-5">
    <?php

if (isset($_GET["idCurso"])) {
    $idCurso = (int)$_GET["idCurso"];
    $alumnoBLL = new AlumnoBLL();
    $tutorBLL = new TutorBLL();
    $listaTutores = $tutorBLL->getAllTutor();
    $listaAlumnos = $alumnoBLL->getAlumnosByIdCurso($idCurso);
    $main = new Main_template($listaAlumnos, $listaTutores);
    $main->render();
} else {
    echo '
        <div class="d-flex justify-content-center align-items-center" style="height: 50vh;">
            <div class="alert alert-warning text-center w-50">
                No seleccionaste el curso.
            </div>
        </div>';
}
        // Verificar si hay un mensaje en la sesión
        if (isset($_SESSION['mensaje'])) {
            echo '
                <div class="d-flex justify-content-center align-items-center" style="height: 50vh;">
                    <div class="alert alert-success text-center w-50">
                        Se grabaron con éxito las asistencias
                    </div>
                </div>';
            unset($_SESSION['mensaje']); // Limpiar el mensaje después de mostrarlo
        }
        
        ?>
    </div>
</body>

</html>

<!-- Bootstrap JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Remover duplicados o scripts innecesarios -->
<script src="js/preceptor.js"></script>
<script src="js/js.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.jqueryui.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.jqueryui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Asegurarse de que los dropdowns de Bootstrap funcionen
    var dropdownElements = document.querySelectorAll('.dropdown-toggle');
    dropdownElements.forEach(function (dropdown) {
        new bootstrap.Dropdown(dropdown);
    });
});

</script>