<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script>
            function cargarAlumno() {
                var e = document.getElementById("alumnos");
                var alumnoId = e.options[e.selectedIndex].value;
                var nombre = e.options[e.selectedIndex].text;
                document.getElementById("alumnoId").value = alumnoId;
                document.getElementById("alumno").value = nombre;
            }

            function cargarAsig() {
                var e = document.getElementById("asignaturas");
                var asigId = e.options[e.selectedIndex].value;
                var asig = e.options[e.selectedIndex].text;
                document.getElementById("asigId").value = asigId;
                document.getElementById("asignatura").value = asig;
            }

            function cargar() {
                document.nota.action = 'Notas.php?op=SEARCH';
                document.nota.submit();
            }

            function updNota() {
                document.nota.action = 'Notas.php?op=UPDATE';
                document.nota.submit();
            }
            function rmNota() {
                document.nota.action = 'Notas.php?op=REMOVE';
                document.nota.submit();
            }
        </script>
    </head>
    <body>
        <?php
        require_once './vendor/autoload.php';
        //variables con todos los datos paara la conexión con la base de datos
        $servername = "db4free.net:3307";
        $username = "oscarnovillo";
        $password = "c557ef";
        $database = "clasesdaw";

        error_reporting(E_ALL ^ E_NOTICE);
        //conectamos con la base de datos
        $db = new MysqliDb($servername, $username, $password, $database);

        $op = $_REQUEST["op"];
        if (isset($op)) {
            //obtenemos los datos del formulario
            $alumnoId = $_REQUEST["alumnoId"];
            $asigId = $_REQUEST["asigId"];
            $nota = $_REQUEST["nota"];
            $alumnoNombre = $_REQUEST["alumno"];
            $asigNombre = $_REQUEST["asignatura"];

            switch ($op) {
                case "SEARCH":
                    //buscamos la nota del usuario con la asignatura seleccionada
                    try {
                        $db->where("ID_ALUMNO", $alumnoId);
                        $db->where("ID_ASIGNATURA", $asigId);
                        $notas = $db->getOne("NOTAS");
                        $nota_alum = $notas['NOTA'];
                        $ok = true;
                    } catch (Exception $ex) {
                        echo "Ha ocurrido un error al buscar la nota";                      
                    }
                    break;
                case "UPDATE":
                    //Actualizamos las notas
                    try {
                        $params = Array("NOTA" => $nota);
                        $db->where("ID_ALUMNO", $alumnoId);
                        $db->where("ID_ASIGNATURA", $asigId);
                        $update = $db->update("NOTAS", $params);
                        $message = "Nota actualizada correctamente";
                        $ok = true;
                        if ($update == FALSE) {
                            //Introducimos los datos 
                            try {
                                $params = Array("ID_ALUMNO" => $alumnoId, "ID_ASIGNATURA" => $asigId, "NOTA" => $nota);
                                $statement = $db->insert("NOTAS", $params);
                                $message = "Nota añadida correctamente";
                                $ok = true;
                            } catch (Exception $ex) {
                                echo "Ha ocurrido un error durante la insercción de la nota";
                                $message = "Error al añadir nota";
                            }
                        }
                    } catch (Exception $ex) {
                        echo "Ha ocurrido un error durante la actulización";
                        $message = "Error al actualizar la nota";
                    }
                    break;
                case "REMOVE":
                    //Eliminamos la nota
                    try {
                        $db->where("ID_ALUMNO", $alumnoId);
                        $db->where("ID_ASIGNATURA", $asigId);
                        $statement = $db->delete("NOTAS");
                        $message = "Nota eliminada correctamente";
                        $ok = true;
                    } catch (Exception $ex) {
                        echo "Ha ocurrido un error durante el borrado de la nota";
                        $message = "Error al eliminar la nota";
                    }
                    break;
            }
      
        }

        //Obtenemos los alumnos y las asignaturas antes de cargar la pagina de nuevo
        $alumnos = $db->get('ALUMNOS');
        $asignaturas = $db->get('ASIGNATURAS');
        //cerramos la conexión con la base de datos
        $db->disconnect();
        ?>

        <h1>Notas</h1>
        <form name="nota" action="notas.php" method="POST">
            <select id="alumnos" onclick="cargarAlumno()">
                <?php
                foreach ($alumnos as $alumno) {
                    ?>
                    <option value="<?php echo $alumno['ID'] ?>"><?php echo $alumno['NOMBRE'] ?></option>
                <?php } ?>
            </select>

            <select id="asignaturas" onclick="cargarAsig()">
                <?php foreach ($asignaturas as $asignatura) { ?>
                    <option value="<?php echo $asignatura['id'] ?>"><?php echo $asignatura['NOMBRE'] ?></option>
                <?php } ?>

            </select>
            <br>
            <input type="text" placeholder="nota" name="nota" value="<?php
            if (isset($nota_alum)) {
                echo $nota_alum;
            } else {
                echo 'Sin nota';
            }
            ?>">
            <p>Nombre del alumno seleccionado anteriormente</p>
            <input type="text" placeholder="alumno" name="alumno" id="alumno" value="<?php
            if (isset($alumnoNombre)) {
                echo $alumnoNombre;
            } else {
                echo 'Alumno';
            }
            ?>" >
             <p>Nombre de la asignatura seleccionada anteriormente</p>
            <input type="text" placeholder="asignatura" name="asignatura" id="asignatura" value="<?php
            if (isset($asigNombre)) {
                echo $asigNombre;
            } else {
                echo 'Asignatura';
            }
            ?>" >
            <input type="hidden" id="alumnoId" name="alumnoId">
            <input type="hidden" id="asigId"  name="asigId">
            <br>
            <input type="button" value="Cargar" onclick="cargar()">
            <input type="button" value="Eliminar" onclick="rmNota()">
            <input type="button" value="Actualizar" onclick="updNota()">
        </form>
        <?php if ($ok) { ?>
        <p style="color: green"><?php echo $message; ?></p>
            <?php } else {
            ?>
            <p style="color: red"><?php echo $message; ?></p>
        <?php } ?>
    </body>
</html>
