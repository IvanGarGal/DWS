<?php
ini_set('display_errors', 'On');
require_once 'config/Config.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CRUD PHP</title>
        <style>
            body {text-align: center}
            table {
                margin-left: auto;
                margin-right: auto;
            }
            .container {
                margin: 0 auto;
                text-align: center;
                width: 100%;
            }
            .container a {
                padding-left: 20px;
                font-size: 1.5em;
            }
        </style>
        <script>
            function cargarAlumno(id, nombre, fecha_nacimiento, mayor_edad) {
                document.getElementById("id").value = id;
                document.getElementById("nombre").value = nombre;
                document.getElementById("fecha_nacimiento").value = fecha_nacimiento;

                if (mayor_edad == true) {
                    document.getElementById("mayor_edad_true").checked = true;
                } else {
                    document.getElementById("mayor_edad_false").checked = true;
                }
            }
            function cargarAsignatura(id, nombre, curso, ciclo) {
                document.getElementById("id").value = id;
                document.getElementById("nombre").value = nombre;
                document.getElementById("curso").value = curso;
                document.getElementById("ciclo").value = ciclo;

            }

        </script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    </head>
    <body>
        <div class="container">
            <a href="alumnos.php">alumnos</a><a href="asignaturas.php">asignaturas</a><a href="notas.php">notas</a>
        </div>
<?php
echo '<form action="notas.php" >
                    <select name="ID_ASIGNATURA">';

foreach ($listaAsignaturas as &$valor) {
    $id = $valor->id;
    $nombre = htmlspecialchars($valor->nombre);
    $curso = htmlspecialchars($valor->curso);
    $ciclo = htmlspecialchars($valor->ciclo);

    echo ' <option value="' . $id . '"';

    if ($id == $id_asignatura) {
        echo 'selected >';
    } else {
        echo '>';
    }

    echo str_replace("'", "\'", $nombre) . '</option>';
}
unset($valor);

echo '</select> 
            <select name="ID_ALUMNO">';
foreach ($listaAlumnos as &$valor) {
    $id = $valor->id;
    $nombre = htmlspecialchars($valor->nombre);
    $fecha_nacimiento = $valor->fecha_nacimiento;
    $mayor_edad = $valor->mayor_edad;

    echo '<option value="' . $id . '"';

    if ($id == $id_alumno) {
        echo 'selected >';
    } else {
        echo '>';
    }
    echo $nombre . '</option>';
}
unset($valor);
echo '</select>            
      <input type="text" name="NOTA" value="';
if ($notaDB == null) {//primera llamada
    echo '" > ';
} else if (is_object($notaDB)) {
    echo $notaDB->nota . '"> ';
} else if (is_int($notaDB) && $notaDB == "Codigo no encontrado") {
    echo '" placeholder="' . $messageToUser . '">';
}

echo
'<input type="submit" name="ACTION" value="VIEW">
            <input type="submit" name="ACTION" value="UPDATE" onclick="return comprobarInputNota()" >
        </form>';
if (is_object($notaDB)) {
    echo '<p>' . $messageToUser . '</p>';
}
?>
       <script>
            if (document.getElementById("fecha_nacimiento").type !== "date") {
                $(function () {
                    $('input[type="date"]').datepicker({dateFormat: 'yy-mm-dd'});
                });
            }

            function comprobarInputNota() {
                var formulario = document.getElementsByTagName("input")[0].value;
                if (formulario.length == 0 || !isInt(formulario)) {

                    alert("No has introducido una nota válida!");
                    return false;

                }
            }
            function isInt(value) {
                return !isNaN(value) &&
                        parseInt(Number(value)) == value &&
                        !isNaN(parseInt(value, 10));
            }

        </script>
    </body>
</html>

