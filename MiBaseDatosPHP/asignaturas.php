<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script>

            function cargarAsignatura(id, nombre, ciclo, curso) {
                document.getElementById("nombre").value = nombre;
                document.getElementById("idasignatura").value = id;
                document.getElementById("ciclo").value = ciclo;
                document.getElementById("curso").value = curso;

            }


            function anadirAsignatura() {
                document.asignaturas.action = 'Asignaturas.php?op=INSERTAR';
                document.asignaturas.submit();

            }
            function actualizarAsignatura() {
                document.asignaturas.action = 'Asignaturas.php?op=ACTUALIZAR';
                document.asignaturas.submit();
            }
            function removerAsignatura() {
                document.asignaturas.action = 'Asignaturas.php?op=REMOVER';
                document.asignaturas.submit();

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

        try {
            $dsn = "mysql:host=" . $servername . ";dbname=" . $database;
            $dbh = new PDO($dsn, $username, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $op = $_REQUEST["op"];
        if (isset($op)) {
            $nombre = $_REQUEST["nombre"];
            $id = $_REQUEST["idAsignatura"];
            $ciclo = $_REQUEST["ciclo"];
            $curso = $_REQUEST["curso"];
            switch ($op) {
                case "INSERTAR":
                    try {
                        $stmt = $dbh->prepare("INSERT INTO ASIGNATURAS (NOMBRE,CICLO,CURSO) VALUES (?,?,?)");
                        $stmt->bindParam(1, $nombre);
                        $stmt->bindParam(2, $ciclo);
                        $stmt->bindParam(3, $curso);
                        $stmt->execute();
                    } catch (Exception $ex) {
                        echo "PROBLEMA AL INSERTAR ASIGNATURA";
                    }
                    break;
                case "ACTUALIZAR":
                    try {
                        $stmt = $dbh->prepare("UPDATE ASIGNATURAS SET NOMBRE = ?, CICLO = ?, CURSO = ? WHERE id = ?");
                        $stmt->bindParam(1, $nombre);
                        $stmt->bindParam(2, $ciclo);
                        $stmt->bindParam(3, $curso);
                        $stmt->bindParam(4, $id);
                        $stmt->execute();
                    } catch (Exception $ex) {
                        echo "PROBLEMA AL ACTUALIZAR ASIGNATURA";
                    }
                    break;
                case "REMOVER":
                    try {
                        $dbh->exec("DELETE FROM ASIGNATURAS WHERE id=" . $id);
                    } catch (Exception $exc) {
                        echo "PROBLEMA AL ELIMINAR ASIGNATURA";
                    }                 
                    break;
            }
        }
        $stmt = $dbh->prepare("SELECT * FROM ASIGNATURAS");
        $stmt->execute();
        $stmt->bindColumn(1, $ID);
        $stmt->bindColumn(2, $NOMBRE);
        $stmt->bindColumn(3, $CICLO);
        $stmt->bindColumn(4, $CURSO);
        $dbh = null;
        ?>

        <table border="1">
            <tr>
                <td></td>
                <td>Nombre</td>
                <td>Ciclo</td>
                <td>Curso</td>
            </tr>
            <?php while ($row = $stmt->fetch(PDO::FETCH_BOUND)) { ?>
                <tr>
                    <td>
                        <input type="button" value="cargar <?php echo $ID ?>" onclick="cargarAsignatura('<?php echo $ID ?>', '<?php echo $NOMBRE ?>', '<?php echo $CICLO ?>', '<?php echo $CURSO ?>')"/>
                    </td> 
                    <td>
                        <?php echo $NOMBRE ?>
                    </td>

                    <td>
                        <?php echo $CICLO ?>
                    </td>
                    <td>
                        <?php echo $CURSO ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>

        <form name="asignaturas" action="Asignaturas.php?op=insertar" method="POST">
            <input type="hidden" id="idasignatura" name="idAsignatura"/>
            <input type="text" id="nombre" size="12" name="nombre"/>
            <input type="text" id="ciclo" name="ciclo">
            <input type="curso" id="curso" name="curso">
            <input type="button" value="añadir" onclick="anadirAsignatura()">
            <input type="button" value="actualizar" onclick="actualizarAsignatura()">
            <input type="button" value="eliminar" onclick="removerAsignatura()">           
        </form>
    </body>
</html>
