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
            function cargarAlumno(id, nombre) {
                document.getElementById("nombreAl").value = nombre;
                document.getElementById("idalumno").value = id;
            }
            function cargarAsignatura(id, nombre) {
                document.getElementById("idasignatura").value = id;
                document.getElementById("nombreAs").value = nombre;
            }

            function boton(num) {
                var opcion = null;
                switch (num) {
                    case 1:
                        opcion = "notasMysqliDB.php?opcion=insert";
                        break;
                    case 2:
                        opcion = "notasMysqliDB.php?opcion=delete";
                        break;
                    case 3:
                        opcion = "notasMysqliDB.php?opcion=update";
                        break;
                    case 4:
                        opcion = "notasMysqliDB.php?opcion=select";
                        break;
                }
                document.forms.formulario1.action = opcion;
                document.forms.formulario1.submit();
            }
        </script>
    </head>
    <body>
        <?php
        require_once 'vendor/autoload.php';
        $servername = "db4free.net:3307";
        $username = "oscarnovillo";
        $password = "c557ef";
        $database = "clasesdaw";
        $controllerOpcion;
        $controllerNombreAlumno;
        $controllerNombreAsignatura;
        $controllerIdAlumno;
        $controllerIdAsignatura;
        $controllerNota;
        $sql;
        $statement;
        $notas;
        $valor = "introduce notas";



        //----------------------Controller Inicio----------------------
        if (isset($_REQUEST["opcion"])) {
            $controllerOpcion = $_REQUEST["opcion"];
            $controllerNombreAlumno = $_REQUEST["nombreAlumno"];
            $controllerNombreAsignatura = $_REQUEST["nombreAsignatura"];
            $controllerIdAlumno = $_REQUEST["idAlumno"];
            $controllerIdAsignatura = $_REQUEST["idAsignatura"];
            $controllerNota = $_REQUEST["nota"];
            $notas = null;
        }
        //----------------------Controller Fin----------------------
        //-----------------------DAO Inicio----------------------------
        //crear conexion
        try {
            $conn = new MysqliDb($servername, $username, $password, $database);
            $conn->autoReconnect = false;
            //checkear conexion
        } catch (Exception $ex) {
            echo "Error al conectar la BD " . $ex->getMessage() . "<br>";
            die();
        }



        switch ($controllerOpcion) {
            case "insert":
                try {
                    $parametros = Array("ID_ALUMNO" => $controllerIdAlumno, "ID_ASIGNATURA" => $controllerIdAsignatura, "NOTA" => $controllerNota);
                    $statement = $conn->insert("NOTAS", $parametros);
                } catch (Exception $e) {
                    echo "error al insertar";
                }
                break;

            case "delete":
                try {
                    $conn->where('ID_ALUMNO', $controllerIdAlumno);
                    $conn->where('ID_ASIGNATURA', $controllerIdAsignatura);
                    $statement = $conn->delete('NOTAS');
                } catch (Exception $e) {
                    echo "error al borrar";
                }
                break;

            case "update":
                try {
                    $parametros = Array('NOTA' => $controllerNota);
                    $conn->where('ID_ALUMNO', $controllerIdAlumno);
                    $conn->where('ID_ASIGNATURA', $controllerIdAsignatura);
                    $statement = $conn->update('NOTAS', $parametros);
                } catch (Exception $e) {
                    echo "error al actualizar";
                }
                break;
            case "select":
                try {
                    $parametros = Array($controllerIdAlumno, $controllerIdAsignatura);
                    $notas = $conn->rawQuery("select * from NOTAS where ID_ALUMNO=? AND ID_ASIGNATURA=?", $parametros);
                    if ($notas == null) {
                        $valor = "no tiene notas";
                    } else {
                        $valor = "Introducir notas";
                    }
                } catch (Exception $e) {
                    echo "error al seleccionar";
                }
                break;
        }
        try {
            $alumnos = $conn->get('ALUMNOS');
            $asignaturas = $conn->get('ASIGNATURAS');
        } catch (Exception $e) {
            echo "error al obtener el listado de alumnos/asigaturas";
        }
        //-----------------------DAO Fin----------------------------
        ?>





        <!-----------------------Cliente Inicio-------------------->


        <label>Alumno: </label>
        <select id="alumno" onchange="cargarAlumno(this.value, this.options[this.selectedIndex].innerHTML)">
            <option disabled selected>alumno</option>
            <?php
            foreach ($alumnos as $alumno) {
                ?>
                <option value="<?php echo $alumno["ID"] ?>"><?php echo $alumno["NOMBRE"] ?></option>
                <?php
            }
            ?>
        </select>

        <label>Asignatura: </label>
        <select id="asignatura" onchange="cargarAsignatura(this.value, this.options[this.selectedIndex].innerHTML)">
            <option disabled selected>asignatura</option>
            <?php
            foreach ($asignaturas as $asignatura) {
                ?>
                <option value="<?php echo $asignatura["id"] ?>"><?php echo $asignatura["NOMBRE"] ?></option>
                <?php
            }
            ?>
        </select>

        <form action="notasMysqliDB.php" name="formulario1" method="POST" >
            <table>
                <tr>
                    <td>
                        ALUMNO
                        <br>
                        <input type="hidden" id="idalumno" name="idAlumno"/>
                        <input type="text" id="nombreAl" name="nombreAlumno" />
                    </td>
                    <td>
                        ASIGNATURA
                        <br>
                        <input type="hidden" id="idasignatura" name="idAsignatura"/>
                        <input type="text" id="nombreAs" name="nombreAsignatura" />
                    </td>
                </tr>
                <tr>
                    <?php
                    if ($notas != null) {
                        foreach ($notas as $nota) {
                            ?>
                            <td>

                                NOTA <input type="text" value="<?php echo $nota["NOTA"] ?>" id="nota" name="nota" size="1">

                            </td>
                            <?php
                        }
                    } else {
                        ?>
                        <td>
                            NOTA <input type="text" value="<?php echo $valor ?>" id="nota" name="nota" size="10">
                        </td>
                        <?php
                    }
                    ?>
                    <td>
                        <input type="button" value="insertar" onclick="boton(1);"/>
                        <input type="button" value="borrar" onclick="boton(2);"/>
                        <input type="button" value="cambiar" onclick="boton(3);"/>
                        <input type="button" value="Ver Nota" onclick="boton(4);"/>
                    </td>
                </tr>
            </table>
        </form>
        <!-----------------------Cliente Fin-------------------->
        <?php
        $conn->disconnect();
        ?>


    </body>
</html>
