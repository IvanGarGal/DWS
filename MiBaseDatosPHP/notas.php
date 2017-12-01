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

            function cargarAsignatura() {
                var e = document.getElementById("asignaturas");
                var asigId = e.options[e.selectedIndex].value;
                var asig = e.options[e.selectedIndex].text;
                document.getElementById("asigId").value = asigId;
                document.getElementById("asignatura").value = asig;
            }

            function cargarNota() {
                document.nota.action = 'Notas.php?op=BUSCAR';
                document.nota.submit();
            }

            function actualizarNota() {
                document.nota.action = 'Notas.php?op=ACTUALIZAR';
                document.nota.submit();
            }
            function removerNota() {
                document.nota.action = 'Notas.php?op=REMOVER';
                document.nota.submit();
            }
        </script>
    </head>
    <body>
        <?php
        require_once './vendor/autoload.php';
        $servername = "db4free.net:3307";
        $username = "oscarnovillo";
        $password = "c557ef";
        $database = "clasesdaw";
        $db = new MysqliDb($servername, $username, $password, $database);
        $op = $_REQUEST["op"];
        if (isset($op)) {
            $alumnoId = $_REQUEST["alumnoId"];
            $asigId = $_REQUEST["asigId"];
            $nota = $_REQUEST["nota"];
            $alumnoNombre = $_REQUEST["alumno"];
            $asigNombre = $_REQUEST["asignatura"];

            switch ($op) {
                case "BUSCAR":
                    try {
                        $db->where("ID_ALUMNO", $alumnoId);
                        $db->where("ID_ASIGNATURA", $asigId);
                        $notas = $db->getOne("NOTAS");
                        $nota_alum = $notas['NOTA'];
                    } catch (Exception $ex) {
                        echo "PROBLEMA AL BUSCAR NOTA";                      
                    }
                    break;
                case "ACTUALIZAR":
                    try {
                        $params = Array("NOTA" => $nota);
                        $db->where("ID_ALUMNO", $alumnoId);
                        $db->where("ID_ASIGNATURA", $asigId);
                        $update = $db->update("NOTAS", $params);
                        if ($update == FALSE) {
                            try {
                                $params = Array("ID_ALUMNO" => $alumnoId, "ID_ASIGNATURA" => $asigId, "NOTA" => $nota);
                                $statement = $db->insert("NOTAS", $params);
                            } catch (Exception $ex) {
                                echo "PROBLEMA AL INSERTAR NOTA";
                            }
                        }
                    } catch (Exception $ex) {
                        echo "PROBLEMA AL ACTUALIZAR NOTA";
                    }
                    break;
                case "REMOVER":
                    try {
                        $db->where("ID_ALUMNO", $alumnoId);
                        $db->where("ID_ASIGNATURA", $asigId);
                        $statement = $db->delete("NOTAS");
                    } catch (Exception $ex) {
                        echo "PROBLEMA AL REMOVER NOTA";
                    }
                    break;
            }
      
        }
        $alumnos = $db->get('ALUMNOS');
        $asignaturas = $db->get('ASIGNATURAS');
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

            <select id="asignaturas" onclick="cargarAsignatura()">
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
            <p>NOMBRE DEL ALUMNO SELECCIONADO ANTES</p>
            <input type="text" placeholder="alumno" name="alumno" id="alumno" value="<?php
            if (isset($alumnoNombre)) {
                echo $alumnoNombre;
            } else {
                echo 'Alumno';
            }
            ?>" >
             <p>NOMBRE DE LA ASIGNATURA SELECCIONADA ANTES</p>
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
            <input type="button" value="Cargar" onclick="cargarNota()">
            <input type="button" value="Eliminar" onclick="removerNota()">
            <input type="button" value="Actualizar" onclick="actualizarNota()">
        </form>
    </body>
</html>
