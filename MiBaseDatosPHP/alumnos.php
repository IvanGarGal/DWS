<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script>

            function cargarAlumno(id, nombre, fecha, mayor) {
                document.getElementById("nombre").value = nombre;
                document.getElementById("idalumno").value = id;
            }

            function anadirUsuario() {
                document.alumnos.action = 'Alumnos.php?op=INSERTAR';
                document.alumnos.submit();

            }
            function actualizarUsuario() {
                document.alumnos.action = 'Alumnos.php?op=ACTUALIZAR';
                document.alumnos.submit();
            }
            function removerUsuario() {
                document.alumnos.action = 'Alumnos.php?op=REMOVER';
                document.alumnos.submit();

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
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("CONEXION FALLIDA: " . $conn->connect_error);
        }
        $sql;
        $op = $_REQUEST["op"];
        if (isset($op)) {
            $nombre = $_REQUEST["nombre"];
            $id = $_REQUEST["idAlumno"];
            $fecha_nacimiento = $_REQUEST["fecha_nac"];

            switch ($op) {
                case "INSERTAR":
                    try {
                        $statement = $conn->prepare("INSERT INTO ALUMNOS (NOMBRE,FECHA_NACIMIENTO,MAYOR_EDAD) VALUES(?,?,?)");
                        $date = new DateTime($fecha_nacimiento);
                        $date_format = $date->format('Y-m-d');
                        $mayor = 1;
                        $statement->bind_param('ssi', $nombre, $date_format, $mayor);

                        if (!$statement->execute()) {
                            if (strpos($statement->error, 'foreign')) {
                                $foreign = true;
                            }
                        }
                        $ok = true;
                    } catch (Exception $ex) {
                        echo "PROBLEMA AL INSERTAR ALUMNO";
                    }
                    break;
                case "ACTUALIZAR":
                    try {
                        $statement = $conn->prepare("UPDATE ALUMNOS SET NOMBRE = ?, FECHA_NACIMIENTO = ?,MAYOR_EDAD = ? WHERE id = ?");
                        $date = new DateTime($fecha_nacimiento);
                        $date_format = $date->format('Y-m-d');
                        $mayor = 1;
                        $statement->bind_param('ssii', $nombre, $date_format, $mayor, $id);
                        $statement->execute();
                        $ok = true;
                    } catch (Exception $exc) {
                        echo "PROBLEMA AL ACTUALIZAR ALUMNO";
                    }

                    break;
                case "REMOVER":
                    try {
                        $statement = $conn->prepare("DELETE FROM ALUMNOS WHERE id=?");
                        $statement->bind_param('i', $id);
                        $statement->execute();
                    } catch (Exception $ex) {
                        echo "PROBLEMA AL REMOVER ALUMNO";                
                    }
                    break;
                case "DELETEALL":
                    try {
                        mysqli_autocommit($con, FALSE);
                        $statement = $conn->prepare("DELETE FROM NOTAS WHERE ID_ALUMNO=?");
                        $statement->bind_param('i', $id);
                        $statement->execute();
                        if ($statement == TRUE) {
                            $statement = $conn->prepare("DELETE FROM ALUMNOS WHERE id=?");
                            $statement->bind_param('i', $id);
                            $statement->execute();
                        }
                        $conn->commit();
                        $ok = true;
                    } catch (Exception $ex) {
                        echo "PROBLEMA AL REMOVER AL ALUMNO COMPLETAMENTE";
                        $conn->rollback();
                    }
                    break;
            }
            $statement->close();
        }
        $sql = "SELECT * FROM ALUMNOS";

        if (!$alumnos = $conn->query($sql)) {
            die('Ha ocurrido un error durante la query [' . $conn->error . ']');
        }
        $conn->close();
        ?>

        <table border="1">
            <?php
            foreach ($alumnos as $alumno) {
                $date = new DateTime($alumno['FECHA_NACIMIENTO']);
                ?>
                <tr>
                    <td>
                        <input type="button" value="cargar <?php echo $alumno['ID'] ?>" onclick="cargarAlumno('<?php echo $alumno['ID'] ?>', '<?php echo $alumno['NOMBRE'] ?>', '<?php echo $alumno['FECHA_NACIMIENTO'] ?>')" pattern ="yyyy-MM-dd"/>
                    </td> 
                    <td>
                        <?php echo $alumno['NOMBRE']; ?>
                    </td>

                    <td>
                        <?php echo $date->format('d-m-Y'); ?>
                    </td>

                    <td>
                        <input type="checkbox" checked="true" />
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>

        <form name="alumnos" action="Alumnos.php?op=insertar" method="POST">
            <input type="text" id="idalumno" name="idAlumno" />
            <input type="text" id="nombre" size="12" name="nombre"/>
            <input type="date" name="fecha_nac">
            <input type="button" value="añadir" onclick="anadirUsuario()">
            <input type="button" value="actualizar" onclick="actualizarUsuario()">
            <input type="button" value="eliminar" onclick="removerUsuario()">           
        </form>
        <?php if ($foreign) { ?>
            <script>
                var continuar = null;
                continuar = confirm("EL ALUMNO TIENE NOTA \n¿Borrar?");
                if (continuar === true) {
                    document.getElementById("idalumno").value = "<?php echo $id; ?>";
                    document.alumnos.action = 'Alumnos.php?op=DELETEALL';
                    document.alumnos.submit();
                }
            </script>
        <?php } ?>
    </body>
</html>