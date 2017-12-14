<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Asignaturas</title>
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

        function cargarAlumno(id, nombre, curso, ciclo) {
            document.getElementById("nombre").value =  nombre;
            document.getElementById("idasignatura").value = id;
            document.getElementById("ciclo").value =  ciclo;
            document.getElementById("curso").value = curso;

        }
    </script>
    <?php
    include('config/configPDO.php');

    if (isset($_REQUEST['op'])) {
        $op = $_REQUEST['op'];
    } else {

        $op = "GETALL";
    }
    switch ($op) {
        case "GETALL":
            include('opAsignaturas/selectAsignaturas.php');

            break;
        case "INSERT":

            include('opAsignaturas/insertAsignaturas.php');

            break;
        case "UPDATE":
            include('opAsignaturas/updateAsignaturas.php');
            break;
        case "DELETE":
            include('opAsignaturas/deleteAsignaturas.php');
            break;
        case "DELETESIOSI":
            include ('opAsignaturas/deleteAsignaturasTotal.php');
            break;
    }
    ?>
<script>
        function borrarSiosi() {
<?php
if (isset($borrarTotal)) {
    if ($borrarTotal == 1) {
        ?>
                    var borrar = confirm("Desea borrar las notas de la asignatura");
                    if (borrar) {
                        document.getElementById("op").value = "DELETESIOSI";
                        document.getElementById("formasign").submit();
                    }
        <?php
    }
}
?>
        }

    </script>
    <body onload="borrarSiosi()">


        </br>
        <form id="formasign" action="asignaturas.php?">
            <input type="hidden" id="idasign" name="idasign" value="<?php if (isset($borrarTotal)) {
    if ($borrarTotal == 1) {
        echo $id;
    }}?>"/>
            <input type="hidden" id="idasignatura" name="idasignatura"/>
            <input type="hidden" id="op"  name="op"/>
            <label>Nombre Asignatura:</label><input type="text" id="nombre" name="nombre" size="12"/>
            <label>Curso</label><input type="text" id="curso" name="curso" size="12"/>
            <label>Ciclo</label><input type="text" id="ciclo" name="ciclo" size="12"/>
            <button type="submit" onclick="insertar();" >insert</button>
            <button type="submit" onclick="update();">update</button>
            <button type="submit" onclick="borrar();">delete</button>
        </form>

        <?php
        $conn = null;
        ?>
    </body>
</html>


