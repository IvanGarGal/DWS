<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script>
            function cargarAlumno(id, nombre, fecha, mayor) {
                document.getElementById("nombre").value = nombre;
                document.getElementById("idalumno").value = id;
                document.getElementById("fecha").value = fecha;
                document.getElementById("edad").value = mayor;
            }
            function boton(num) {
                var opcion = null;
                switch (num) {
                    case 1:
                        opcion = "alumnosMysqli.php?opcion=insert";
                        break;
                    case 2:
                        opcion = "alumnosMysqli.php?opcion=delete";
                        break;
                    case 3:
                        opcion = "alumnosMysqli.php?opcion=update";
                        break;
                }
                document.forms.formulario1.action = opcion;
                document.forms.formulario1.submit();
            }
        </script>
    </head>
    <body>
        <?php
        $servername = "db4free.net:3307";
        $username = "oscarnovillo";
        $password = "c557ef";
        $database = "clasesdaw";
        $controllerOpcion;
        $controllerEdad;
        $controllerNombre;
        $dateController;
        $controllerFecha;
        $controllerId;
        $sql;
        $statement;
        $foreign = false;


        //----------------------Controller Inicio----------------------
        if (isset($_REQUEST["opcion"])) {
            $controllerOpcion = $_REQUEST["opcion"];
            $controllerEdad = $_REQUEST["edad"];
            $controllerNombre = $_REQUEST["nombre"];
            try {
                $dateController = new DateTime($_POST["fecha"]);
                $controllerFecha = $dateController->format('Y-m-d');
            } catch (Exception $e) {
                echo "Fallo al convertir la fecha";
            }
            if (isset($_REQUEST["idalumno"])) {
                $controllerId = $_REQUEST["idalumno"];
            }
        }
        //----------------------Controller Fin----------------------
        //-----------------------DAO Inicio----------------------------
        //crear conexion
        $conn = new mysqli($servername, $username, $password, $database);
        //checkear conexion
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        switch ($controllerOpcion) {
            case "insert":
                try {
                    $statement = $conn->prepare("INSERT INTO ALUMNOS (NOMBRE,FECHA_NACIMIENTO,MAYOR_EDAD) VALUES(?,?,?)");
                    $statement->bind_param('ssi', $controllerNombre, $controllerFecha, $controllerEdad);
                    $statement->execute();
                } catch (Exception $ex) {
                    echo "Fallo al insertar";
                }
                break;

            case "delete":
                try {
                    $statement = $conn->prepare("DELETE FROM ALUMNOS WHERE ID=?");
                    $statement->bind_param('i', $controllerId);

                    if ($statement->execute()) {
                        
                    } else {
                        if (strpos($statement->error, 'foreign')) {
                            $foreign = true;
                        }
                    }
                } catch (Exception $ex) {
                    echo "Fallo al borrar";
                }
                break;

            case "update":
                try {
                    $statement = $conn->prepare("UPDATE ALUMNOS set NOMBRE=?,FECHA_NACIMIENTO=?,MAYOR_EDAD=? WHERE ID=?");
                    $statement->bind_param('ssii', $controllerNombre, $controllerFecha, $controllerEdad, $controllerId);
                    $statement->execute();
                } catch (Exception $ex) {
                    echo "Fallo al actualizar";
                }
                break;
            case "total":
                try {
                    mysqli_autocommit($conn, FALSE);
                    $statement = $conn->prepare("DELETE FROM NOTAS WHERE ID_ALUMNO=?");
                    $statement->bind_param('i', $controllerId);
                    $statement->execute();

                    $statement2 = $conn->prepare("DELETE FROM ALUMNOS WHERE ID=?");
                    $statement2->bind_param('i', $controllerId);
                    $statement2->execute();

                    $conn->commit();
                } catch (Exception $ex) {
                    echo "Fallo al borrar todo";
                    $conn->rollback();
                }
                break;
        }
        mysqli_autocommit($conn, TRUE);
        try {
            $sql = "SELECT * FROM `ALUMNOS`";
            $result = $conn->query($sql);
        } catch (Exception $ex) {
            echo "Fallo al extraer alumnos";
        }
        //-----------------------DAO Fin----------------------------
        ?>

        <!-----------------------Cliente Inicio-------------------->


        <table border=1 cellspacing=4 cellpadding=4>
            <?php
            while ($row = $result->fetch_assoc()) {
                $dateCliente = new DateTime($row["FECHA_NACIMIENTO"]);
                $fechaCliente = $dateCliente->format('d-m-Y');
                $nombre = $row["NOMBRE"];
                $edad = $row["MAYOR_EDAD"];
                ?>

                <tr> 
                    <td><input type="button" value="cargar"  onclick="cargarAlumno('<?php echo $row["ID"] ?>', '<?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>', '<?php echo $row["FECHA_NACIMIENTO"] ?>', '<?php echo htmlspecialchars($edad, ENT_QUOTES, 'UTF-8') ?>')"/></td>
                    <td><?php echo $nombre ?></td>
                    <td><?php echo $fechaCliente ?></td>
                    <td><input type="checkbox" name="mayor" <?php if ($edad) { ?> checked <?php } ?> /></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <form action="alumnosMysqli.php" name="formulario1" method="post" >
            <input type="hidden" id="idalumno" name="idalumno" />
            <input type="text" id="nombre" name="nombre" size="12"/>
            <input type="text" id="fecha" name="fecha" size="12"/>
            <input type="text" id="edad" name="edad" size="12"/>
            <input type="button" value="insertar" onclick="boton(1);"/>
            <input type="button" value="borrar" onclick="boton(2);"/>
            <input type="button" value="cambiar" onclick="boton(3);"/>
        </form>
        <?php
        if ($foreign) {
            ?>
            <script>
                var seguir = null;
                seguir = confirm("El alumno selecionado tiene nota \n¿Borrar?");
                if (seguir === true) {
                    document.getElementById("nombre").value = "<?php echo $controllerNombre ?>";
                    document.getElementById("idalumno").value = <?php echo $controllerId ?>;
                    document.getElementById("fecha").value = <?php echo $controllerFecha ?>;
                    document.getElementById("edad").value = <?php echo $controllerEdad ?>;
                    document.forms.formulario1.action = "alumnosMysqli.php?opcion=total";
                    document.forms.formulario1.submit();
                }
            </script>

            <?php
        }
        ?>
        <!-----------------------Cliente Fin-------------------->
        <?php
        $statement->close();
        $result->free();
        $conn->close();
        ?>


    </body>
</html>
