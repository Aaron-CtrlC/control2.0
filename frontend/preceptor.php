<?php
session_start();
require_once("../Entidades/Usuario.php");
require_once("../BLL/CursoBLL.php");
require_once("../BLL/AlumnoBLL.php");
require_once("../UI/components/main.template.php");

// Verificar si el usuario está autenticado y tiene el rol adecuado
$usuario = unserialize($_SESSION["usuario"]);
$idUsuario = (int) $usuario->getIdTiposUsuarios();
if ($idUsuario === 3) {
    header('Location: ../UI/login.php');
    exit();
}

$nombreCompleto= $usuario->getNombre()." ".$usuario->getApellido();

$cursoBLL = new CursoBLL();
$listaCursos = $cursoBLL->cursosAsignados();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../UI/assets/img/logo.jpg">
    <title>Panel del Preceptor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/preceptor.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.cssx ">
</head>

<body>

<nav class="navbar d-flex align-items-center justify-content-center navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <span class="navbar-brand"><?php echo $nombreCompleto ?></span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                foreach ($listaCursos as $curso) {
                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="?idCurso=' . $curso->getId() . '" tabindex="-1" aria-disabled="true">' . $curso->getAno() . '° ' . $curso->getDivision() . '</a>
                    </li>';
                }
                ?>
            </ul>
            <form method="POST" action="../Controladores/logout.control.php" class="d-flex">
                <button type="submit" class="btn btn-outline-danger">Cerrar sesión</button>
            </form>
        </div>
    </div>
</nav>

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
        echo "<div class='d-flex justify-content-center'>
                <h1>Selecciona un curso</h1>
              </div>";
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

<script src="js/preceptor.js"></script>
<script src="js/js.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.jqueryui.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.jqueryui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>


<script>
new DataTable('#tableInformeCurso', {
    layout: {
        topStart: {
            buttons: [
                { 
                    extend: 'excel', 
                    className: 'btn btn-success', // Usar clase de Bootstrap para el botón Excel
                    text: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16"><path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V5.707a1 1 0 0 0-.293-.707L10.707 0a1 1 0 0 0-.707-.293zM8 4V1h2v3H8zM3 1h2v3H3V1zm0 12V5h10v8H3z"/></svg> Excel'
                }
            ]
        }
    },
    searching: true,  // Elimina el campo de búsqueda
    paging: false      // Elimina la paginación
});

$(document).ready(function() {
    // Inicializar DataTable para cada tabla individual de alumno
    $('table[id^="#InformeIndividual"]').each(function() {
        new DataTable(this, {
            layout: {
                topStart: {
                    buttons: [
                        { 
                            extend: 'excel', 
                            className: 'btn btn-success', // Usar clase de Bootstrap para el botón Excel
                            text: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16"><path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V5.707a1 1 0 0 0-.293-.707L10.707 0a1 1 0 0 0-.707-.293zM8 4V1h2v3H8zM3 1h2v3H3V1zm0 12V5h10v8H3z"/></svg> Excel'
                        }
                    ]
                }
            },
            searching: false,  // Elimina el campo de búsqueda
            paging: false      // Elimina la paginación
        });
    });
});


</script>

</body>

</html>
