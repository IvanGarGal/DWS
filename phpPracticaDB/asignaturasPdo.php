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
            function cargarAsignatura(id, nombre, ciclo, curso) {
                document.getElementById("idasignatura").value = id;
                document.getElementById("nombre").value = nombre;
                document.getElementById("ciclo").value = ciclo;
                document.getElementById("curso").value = curso;
            }
            function boton(num) {
                var opcion = null;
                switch (num) {
                    case 1:
                        opcion = "asignaturasPdo.php?opcion=insert";
                        break;
                    case 2:
                        opcion = "asignaturasPdo.php?opcion=delete";
                        break;
                    case 3:
                        opcion = "asignaturasPdo.php?opcion=update";
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
        $controllerCiclo;
        $controllerNombre;
        $controllerCurso;
        $controllerId;
        $sql;
        $statement;
        $foreign = null;



        //----------------------Controller Inicio----------------------
        if (isset($_REQUEST["opcion"])) {
            $controllerOpcion = $_REQUEST["opcion"];
            $controllerCiclo = $_REQUEST["ciclo"];
            $controllerNombre = $_REQUEST["nombre"];
            $controllerCurso = $_REQUEST["curso"];
            if (isset($_REQUEST["idasignatura"])) {
                $controllerId = $_REQUEST["idasignatura"];
            }
        }
        //----------------------Controller Fin----------------------
        //-----------------------DAO Inicio----------------------------
        //crear conexion
        try {
            $conn = new PDO("mysql:dbname=$database;host=$servername", $username, $password);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //utiliza declaraciones preparadas nativas, si estuviese en true emula las delcaraciones preparadas;
            //checkear conexion
        } catch (PDOException $ex) {
            echo "Error al conectar la BD " . $ex->getMessage() . "<br>";
            die();
        }



        switch ($controllerOpcion) {
            case "insert":
                try {
                    $statement = $conn->prepare("insert into ASIGNATURAS (NOMBRE,CICLO,CURSO) values ( :nombre, :ciclo, :curso)");
                    $statement->bindParam(":nombre", $controllerNombre, PDO::PARAM_STR);
                    $statement->bindParam(":ciclo", $controllerCiclo, PDO::PARAM_STR);
                    $statement->bindParam(":curso", $controllerCurso, PDO::PARAM_STR);
                    $statement->execute();
                    //$newId = $conn->lastInsertId(); para coger el auto incremental
                } catch (PDOException $ex) {
                    echo "Fallo al insertar ";
                }

                break;

            case "delete":
                try {
                    $statement = $conn->prepare("DELETE FROM ASIGNATURAS WHERE ID= :id");
                    $statement->bindParam(":id", $controllerId, PDO::PARAM_INT);
                    if ($statement->execute()) {
                        
                    } else {
                        if (strpos($statement->errorInfo()[2], "foreign")) {
                            $foreign = true;
                        }
                    }
                } catch (PDOException $ex) {
                    echo "Fallo al borrar ";
                }
                break;

            case "update":
                try {
                    $statement = $conn->prepare("UPDATE ASIGNATURAS set NOMBRE= :nombre, CICLO= :ciclo, CURSO= :curso WHERE ID= :id");
                    $statement->bindParam(":nombre", $controllerNombre, PDO::PARAM_STR);
                    $statement->bindParam(":ciclo", $controllerCiclo, PDO::PARAM_STR);
                    $statement->bindParam(":curso", $controllerCurso, PDO::PARAM_STR);
                    $statement->bindParam(":id", $controllerId, PDO::PARAM_INT);
                    $statement->execute();
                } catch (PDOException $ex) {
                    echo "Fallo al cambiar ";
                }
                break;
            case "total":
                try {
                    $conn->beginTransaction();

                    $statement = $conn->prepare("DELETE FROM NOTAS WHERE ID_ASIGNATURA=:id");
                    $statement->bindParam(":id", $controllerId, PDO::PARAM_INT);
                    $statement->execute();

                    $statement2 = $conn->prepare("DELETE FROM ASIGNATURAS WHERE ID=:id");
                    $statement2->bindParam(":id", $controllerId, PDO::PARAM_INT);
                    $statement2->execute();

                    $conn->commit();
                } catch (Exception $ex) {
                    echo "Fallo al borrar todo";
                    $conn->rollback();
                }
                break;
        }
        $result = $conn->prepare("select * FROM ASIGNATURAS");
        $result->execute();
        //-----------------------DAO Fin----------------------------
        ?>





        <!-----------------------Cliente Inicio-------------------->
        <table border=1 cellspacing=4 cellpadding=4>
            <?php
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $nombre = $row["NOMBRE"];
                $curso = $row["CURSO"];
                $ciclo = $row["CICLO"];
                ?>

                <tr> 
                    <td><input type="button" value="cargar"  onclick="cargarAsignatura('<?php echo $row["id"] ?>', '<?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>', '<?php echo htmlspecialchars($curso, ENT_QUOTES, 'UTF-8') ?>', '<?php echo htmlspecialchars($ciclo, ENT_QUOTES, 'UTF-8') ?>')"/></td>
                    <td><?php echo $nombre ?></td>
                    <td><?php echo $curso ?></td>
                    <td><?php echo $ciclo ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <form action="asignaturasPdo.php" name="formulario1" method="post" >
            <input type="hidden" id="idasignatura" name="idasignatura" />
            <input type="text" id="nombre" name="nombre" size="12"/>
            <input type="text" id="curso" name="curso" size="12"/>
            <input type="text" id="ciclo" name="ciclo" size="12"/>
            <input type="button" value="insertar" onclick="boton(1);"/>
            <input type="button" value="borrar" onclick="boton(2);"/>
            <input type="button" value="cambiar" onclick="boton(3);"/>
        </form>

        <?php
        if ($foreign) {
            ?>
            <script>
                var seguir = confirm("La asignatura seleccionada tiene nota \n¿Borrar?");
                if (seguir === true) {
                    document.getElementById("nombre").value = "<?php echo $controllerNombre ?>";
                    document.getElementById("idasignatura").value = <?php echo $controllerId ?>;
                    document.getElementById("curso").value = "<?php echo $controllerCurso ?>";
                    document.getElementById("ciclo").value = "<?php echo $controllerCiclo ?>";
                    document.forms.formulario1.action = "asignaturasPdo.php?opcion=total";
                    document.forms.formulario1.submit();
                }
            </script>

            <?php
        }
        ?>
        <!-----------------------Cliente Fin-------------------->
        <?php
        $statement->null;
        $result->null;
        $conn->null;
        ?>


    </body>
</html>
