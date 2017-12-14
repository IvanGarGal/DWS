<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>NotasPHP</title>
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

        function mostrar() {
            document.getElementById("op").value = "GETNOTA";

        }

        function opcionElegida() {
            var encontradoal = false;
            var encontradoasig = false;
            if (document.getElementById("alumno").value != "") {
                for (var i = 0; i < document.forms["formNotas"].idalumno.length && encontradoal == false; i++) {
                    if (document.getElementById("alumno").value == document.forms["formNotas"].idalumno[i].value) {
                        document.forms["formNotas"].idalumno[i].selected = true;
                        encontradoal = true;
                    }
                }

            }

            if (document.getElementById("asignatura").value != "") {
                for (var j = 0; j < document.forms["formNotas"].idasignatura.length && encontradoasig == false; j++) {
                    if (document.getElementById("asignatura").value == document.forms["formNotas"].idasignatura[j].value) {
                        document.forms["formNotas"].idasignatura[j].selected = true;
                        encontradoasig = true;
                    }
                }

            }

        }

        function cambiarCB() {
            document.getElementById("notas").value = "";
        }



    </script>
</head>

<?php
include('config/configJoshcam.php');

if (isset($_REQUEST['op'])) {
    $op = $_REQUEST['op'];
} else {
    $op = "";
}
switch ($op) {
    case "GETNOTA":
        include('opNotas/selectNota.php');

        break;
    case "INSERT":

        include('opNotas/insertNotas.php');

        break;
    case "UPDATE":
        include('opNotas/updateNotas.php');
        break;
    case "DELETE":
        include('opNotas/deleteNotas.php');
        break;
}
?>
<body onload="opcionElegida();">
    <form>
        <input type="button" value="Alumnos" onclick="window.location.href = 'alumnos.php'" />
        <input type="button" value="Asignaturas" onclick="window.location.href = 'asignaturas.php'" />

    </form>
    <h1>NOTAS</h1>


    <form id="formNotas" name="formNotas"  action="notas.php?">

        <input type="hidden" id="op"  name="op"/>
        <input type="hidden" id="alumno"  value="<?php
        if (isset($alumnNota)) {
            echo $alumnNota;
        } else {
            echo "";
        }
        ?>"/>

        <input type="hidden" id="asignatura"  value="<?php
        if (isset($asigNota)) {
            echo $asigNota;
        } else {
            echo "";
        }
        ?>"/>
        <label>Nombre alumno</label>
        </br>


        <select name="idalumno" id="nombre" onchange="cambiarCB();" >
            <?php
            $alumnos = $conn->get("ALUMNOS");
            foreach ($alumnos as $alumno) {
                ?>
                <option value="<?php echo $alumno['ID'] ?>"><?php echo $alumno['NOMBRE'] ?></option>
                <?php
            }
            ?>
        </select>
        </br>
        <label>Asignatura</label>
        </br>
        <select name="idasignatura" id="asign"  onchange="cambiarCB();" >
            <?php
            $asignaturas = $conn->get("ASIGNATURAS");
            foreach ($asignaturas as $asignatura) {
                ?>
                <option value="<?php echo $asignatura['id'] ?>"><?php echo $asignatura['NOMBRE'] ?></option>
                <?php
            }
            ?>
        </select>
        </br>
        <label>Nota</label>
        </br>
        <input type="text" id="notas" name="nota" value="<?php
               if (isset($notaSelect)) {
                   echo $notaSelect['NOTA'];
               } else if (isset($notaupdate)) {
                   echo $notaupdate;
               }else if (isset($notainsert)) {
                   echo $notainsert;
               } else {
                   echo "";
               }
               ?>" />
        </br>
        <button type="submit" onclick="mostrar();" >mostrar</button>
        <button type="submit" onclick="insertar();" >insert</button>
        <button type="submit" onclick="update();">update</button>
        <button type="submit" onclick="borrar();">delete</button>
    </form>
</body>
<?php
$conn->disconnect();
?>
</html>