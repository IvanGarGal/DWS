<!DOCTYPE html>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Alumnos</title>
    </head>
    <script>

        function insertar() {

            document.getElementById("op").value = "INSERT";
        }

        function update() {

            document.getElementById("op").value = "UPDATE";
        }

        function borrar() {

            document.getElementById("op").value = "DELETE";
        }

        function cargarAlumno(id, nombre, fecha, mayor) {
            document.getElementById("nombre").value =nombre;
            document.getElementById("idalumno").value = id;
            document.getElementById("fecna").value = fecha;
            if (mayor == true) {
                document.getElementById("mayor").checked = "checked";
            } else {
                document.getElementById("mayor").checked = "";
            }

        }
    </script>
    <?php
    include('config/configMySQLi.php');

    if (isset($_REQUEST['op'])) {
        $op = $_REQUEST['op'];
    } else {

        $op = "GETALL";
    }
    switch ($op) {
        case "GETALL":
            include('opAlumnos/selectAlumnos.php');
            break;
        case "INSERT":
            include('opAlumnos/insertAlumnos.php');
            break;
        case "UPDATE":
            include('opAlumnos/updateAlumnos.php');
            break;
        case "DELETE":
            include('opAlumnos/deleteAlumnos.php');
            break;
        case "DELETESIOSI":
            include ('opAlumnos/deleteAlumnosTotal.php');
            break;
    }
    ?>

    <script>
        function borrarSiosi() {
<?php
if (isset($borrarTotal)) {
    if ($borrarTotal == 1) {
        ?>
                    var borrar = confirm("Desea borrar las notas de el alumno");
                    if (borrar) {
                        document.getElementById("op").value = "DELETESIOSI";
                        document.getElementById("formalum").submit();
                    }
        <?php
    }
}
?>
        }

    </script>
    <body onload="borrarSiosi();">


        </br>
        <form id="formalum" action="alumnos.php?">
            <input type="hidden" id="idal" name="idal" value="<?php if (isset($borrarTotal)) {
    if ($borrarTotal == 1) {
        echo $id;
    }}?>"/>
            <input type="hidden" id="idalumno" name="idalumno"/>
            <input type="hidden" id="op"  name="op"/>
            <label>Nombre</label><input type="text" id="nombre" name="nombre" size="12"/>
            <label>Fecha Nac.</label><input type="date" id="fecna" name="fecna" />
            <label>Mayor de Edad</label><input type="checkbox" id="mayor" name="mayor" />
            <br>
            <button type="submit" onclick="insertar();" >insert</button>
            <button type="submit" onclick="update();">update</button>
            <button type="submit" onclick="borrar();">delete</button>
        </form>

        <?php
        $conn->close();
        ?>
    </body>
</html>

