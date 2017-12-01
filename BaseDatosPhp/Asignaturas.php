<!DOCTYPE html>

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


            function addAsignatura() {
                document.asignaturas.action = 'Asignaturas.php?op=INSERT';
                document.asignaturas.submit();

            }
            function updAsignatura() {
                document.asignaturas.action = 'Asignaturas.php?op=UPDATE';
                document.asignaturas.submit();
            }
            function rmAsignatura() {
                document.asignaturas.action = 'Asignaturas.php?op=REMOVE';
                document.asignaturas.submit();

            }
        </script>
    </head>
    <body>
        <?php
        //variables con los datos para la conexión de la base de datos
        require_once './vendor/autoload.php';
        $servername = "db4free.net:3307";
        $username = "oscarnovillo";
        $password = "c557ef";
        $database = "clasesdaw";

        error_reporting(E_ALL ^ E_NOTICE);
        try {
            //Conectamo con la base de datos
            $dsn = "mysql:host=" . $servername . ";dbname=" . $database;
            $dbh = new PDO($dsn, $username, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $op = $_REQUEST["op"];
        if (isset($op)) {
            //Recojemos todos los parametros del formulario
            $nombre = $_REQUEST["nombre"];
            $id = $_REQUEST["idAsignatura"];
            $ciclo = $_REQUEST["ciclo"];
            $curso = $_REQUEST["curso"];
            switch ($op) {
                case "INSERT":
                    try {
                    //Insertamos una nueva asignatura
                        $stmt = $dbh->prepare("INSERT INTO ASIGNATURAS (NOMBRE,CICLO,CURSO) VALUES (?,?,?)");
                        $stmt->bindParam(1, $nombre);
                        $stmt->bindParam(2, $ciclo);
                        $stmt->bindParam(3, $curso);
                        $stmt->execute();
                        $ok=true;
                        $message="Nueva asignatura añadida";
                    } catch (Exception $ex) {
                        echo "Ha ocurrido al añadir una nueva asignatura";
                        $message="Error al añadir la asignatura";
                    }
                    break;
                case "UPDATE":
                    //Actualizamos la asignatura
                    try {
                        $stmt = $dbh->prepare("UPDATE ASIGNATURAS SET NOMBRE = ?, CICLO = ?, CURSO = ? WHERE id = ?");
                        $stmt->bindParam(1, $nombre);
                        $stmt->bindParam(2, $ciclo);
                        $stmt->bindParam(3, $curso);
                        $stmt->bindParam(4, $id);
                        $stmt->execute();
                        $ok=true;
                        $message="Asignatura actualizada";
                    } catch (Exception $ex) {
                        echo "Ha ocurrido un error al actualizar la asignatura";
                        $message="Error al eliminar la asignatura";
                    }
                    break;
                case "REMOVE":
                    //Eliminanos la asignatura
                    try {
                        $dbh->exec("DELETE FROM ASIGNATURAS WHERE id=" . $id);
                        $ok=true;
                        $message="Asignatura eliminada";
                    } catch (Exception $exc) {
                        echo "Ha ocurrido un error al eliminar la asignatura";
                        $message="Error al eliminar la asignatura";
                    }                 
                    break;
            }
        }

        //recuperamos de nuevo todas las signaturas de la base de datos
        $stmt = $dbh->prepare("SELECT * FROM ASIGNATURAS");
        // Ejecutamos
        $stmt->execute();
        $stmt->bindColumn(1, $ID);
        $stmt->bindColumn(2, $NOMBRE);
        $stmt->bindColumn(3, $CICLO);
        $stmt->bindColumn(4, $CURSO);
        //Cerramos la conexion con la base de datos
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
            <input type="button" value="añadir" onclick="addAsignatura()">
            <input type="button" value="actualizar" onclick="updAsignatura()">
            <input type="button" value="eliminar" onclick="rmAsignatura()">           
        </form>
        <?php if ($ok) { ?>
        <p style="color: green"><?php echo $message; ?></p>
            <?php } else {
            ?>
            <p style="color: red"><?php echo $message; ?></p>
        <?php } ?>
    </body>
</html>
