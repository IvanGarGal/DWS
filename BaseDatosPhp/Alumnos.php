<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script>

            function cargarAlumno(id, nombre, fecha, mayor) {
                document.getElementById("nombre").value = nombre;
                document.getElementById("idalumno").value = id;

            }


            function addUsuario() {
                document.alumnos.action = 'Alumnos.php?op=INSERT';
                document.alumnos.submit();

            }
            function updUsuario() {
                document.alumnos.action = 'Alumnos.php?op=UPDATE';
                document.alumnos.submit();
            }
            function rmUsuario() {
                document.alumnos.action = 'Alumnos.php?op=REMOVE';
                document.alumnos.submit();

            }
        </script>
    </head>
    <body>
        <?php
        require_once './vendor/autoload.php';
        //variables con los datos para la conexion con la base de datos
        $servername = "db4free.net:3307";
        $username = "oscarnovillo";
        $password = "c557ef";
        $database = "clasesdaw";

        error_reporting(E_ALL ^ E_NOTICE);
        //creamos la conexion
        $conn = new mysqli($servername, $username, $password, $database);
        //comprobamos que la conexion no a fallado
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        $sql;
        $op = $_REQUEST["op"];
        if (isset($op)) {
            //Recojemos los datos del formulario
            $nombre = $_REQUEST["nombre"];
            $id = $_REQUEST["idAlumno"];
            $fecha_nacimiento = $_REQUEST["fecha_nac"];

            switch ($op) {
                case "INSERT":
                    //Insertamos los nuevos datos del alumno
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
                        $message = "Alumno añadido";
                    } catch (Exception $ex) {
                        echo "Ha ocurrido un error al insertar el alumno";
                        $message = "Error al añadir un nuevo alumno";
                    }
                    break;
                case "UPDATE":
                    //Actualizamos el alumno
                    try {
                        $statement = $conn->prepare("UPDATE ALUMNOS SET NOMBRE = ?, FECHA_NACIMIENTO = ?,MAYOR_EDAD = ? WHERE id = ?");
                        $date = new DateTime($fecha_nacimiento);
                        $date_format = $date->format('Y-m-d');
                        $mayor = 1;
                        $statement->bind_param('ssii', $nombre, $date_format, $mayor, $id);
                        $statement->execute();
                        $ok = true;
                        $message = "Alumno actualizado";
                    } catch (Exception $exc) {
                        echo "Ha ocurrido un error durante la actualización del usuario";
                        $message = "Error al actualizar el alumno";
                    }

                    break;
                case "REMOVE":
                    //Eliminamos el alumno
                    try {
                        $statement = $conn->prepare("DELETE FROM ALUMNOS WHERE id=?");
                        $statement->bind_param('i', $id);
                        $statement->execute();
                    } catch (Exception $ex) {
                        echo "Ha ocurrido un error durante la eliminación del usuario";
                        
                    }
                    break;
                case "DELETEALL":
                    //eliminamos por completo el alumno despues de la confirmacion
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
                        $message = "Alumno eliminado";
                    } catch (Exception $ex) {
                        echo "Ha ocurrido un error al eliminar por completo el alumno";
                        $conn->rollback();
                        $message = "Error al eliminar el alumno";
                    }
                    break;
            }
            //cerramos el statement
            $statement->close();
        }


        //recuperamos todos los alumnos
        $sql = "SELECT * FROM ALUMNOS";

        if (!$alumnos = $conn->query($sql)) {
            die('Ha ocurrido un error durante la query [' . $conn->error . ']');
        }

        //cerramos la conexión con la base de datos
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
            <input type="button" value="añadir" onclick="addUsuario()">
            <input type="button" value="actualizar" onclick="updUsuario()">
            <input type="button" value="eliminar" onclick="rmUsuario()">           
        </form>
        <?php if ($foreign) { ?>
            <script>
                var continuar = null;
                continuar = confirm("El alumno tiene nota \n¿Borrar?");
                if (continuar === true) {
                    document.getElementById("idalumno").value = "<?php echo $id; ?>";
                    document.alumnos.action = 'Alumnos.php?op=DELETEALL';
                    document.alumnos.submit();
                }
            </script>
        <?php } ?>
        <!--mensaje de estado-->
        <?php if ($ok) { ?>
            <p style="color: green"><?php echo $message; ?></p>
        <?php } else {
            ?>
            <p style="color: red"><?php echo $message; ?></p>
        <?php } ?>
    </body>
</html>