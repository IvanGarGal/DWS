<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
$username = "oscarnovillo";
$password = "c557ef";
try {
    $mbd = new PDO('mysql:host=db4free.net:3307;dbname=clasesdaw', $username, $password);
    foreach($mbd->query('SELECT * from FOO') as $fila) {
        print_r($fila);
    }
    $mostrarMensaje = false;

    if (isset($_REQUEST["accion"])) {
        $accion = $_REQUEST["accion"];
        $nombre = $_REQUEST["nombre"];
        $fechaObj = new DateTime($_REQUEST["fecha"]);
        $fecha = $fechaObj->format('Y-m-d');
        if (isset($_REQUEST["mayor"])) {
            $mayor = 1;
        } else {
            $mayor = 0;
        }

        switch ($accion) {
            case "actualizar":
                $id = $_REQUEST["id"];
                $statement = $conn->prepare("UPDATE ALUMNOS SET NOMBRE = ?, FECHA_NACIMIENTO = ?, MAYOR_EDAD = ? WHERE ID = ?");
                $statement->bind_param('ssii', $nombre, $fecha, $mayor, $id);
                $statement->execute();
                $filas = mysqli_affected_rows($conn);
                break;
            case "guardar":
                $statement = $conn->prepare("INSERT INTO ALUMNOS (NOMBRE,FECHA_NACIMIENTO,MAYOR_EDAD) VALUES(?,?,?)");
                $statement->bind_param('ssi', $nombre, $fecha, $mayor);
                $statement->execute();
                $filas = mysqli_affected_rows($conn);
                $idGenerada = $conn -> insert_id;
                break;
            case "borrar":
                $id = $_REQUEST["id"];
                $statement = $conn->prepare("DELETE FROM ALUMNOS WHERE ID = ?");
                $statement->bind_param('i', $id);
                $statement->execute();
                $filas = mysqli_affected_rows($conn);
                break;
            case "borrar2":
                try {
                    mysqli_autocommit($conn, false);
                    $filas = 0;
                    $id = $_REQUEST["id"];

                    $statement = $conn->prepare("DELETE FROM NOTAS WHERE ID_ALUMNO = ?");
                    $statement->bind_param('i', $id);
                    $statement->execute();
                    $filas += mysqli_affected_rows($conn);


                    $statement = $conn->prepare("DELETE FROM ALUMNOS WHERE ID = ?");
                    $statement->bind_param('i', $id);
                    $statement->execute();
                    $filas += mysqli_affected_rows($conn);

                    mysqli_commit($conn);
                } catch (Exception $ex) {
                    mysqli_rollback($conn);
                    $filas = -1;
                }
                break;
        }
        $mostrarMensaje = true;
        $error = mysqli_error($conn);

        if ($filas > 0) {
            $mensaje = $filas . " filas modificadas.";
        } else if ($filas == -1) {
            $mensaje = "Ocurrió un error al hacer la consulta.";
        } else if ($filas == 0) {
            $mensaje = "No se han hecho modificaciones.";
        }

        if (($errorIntegridad = strpos($error, 'foreign')) == true) {
            $mostrarMensaje = false;
            $mensaje = "Si borras este alumno se borrarán todas sus notas.";
        }
    }
    
    if (!$alumnos = $conn->query($sql)) {
        die('Ocurrió un error al hacer la consulta [' . $conn->error . ']');
    }
    $conn->close();

    $mbd = null;
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script>
            function cargarAlumno(id, nombre) {
                document.formulario['idAlumno'].value = id;
                document.formulario['nombreAlumno'].value = nombre;
            }
            function cargarAsignatura(id, nombre) {
                document.formulario['idAsignatura'].value = id;
                document.formulario['nombreAsignatura'].value = nombre;
            }
            function guardar() {
                document.formulario['accion'].value = "guardar";
            }
            function borrar() {
                document.formulario['accion'].value = "borrar";
            }
            function cargar() {
                document.formulario['accion'].value = "cargar";
            }
        </script>
    </head>
    <body>
        <h1>Notas</h1>
        <span>Alumno: </span>
        <select id="alumno" onchange="cargarAlumno(this.value, this.options[this.selectedIndex].innerHTML)">
            <option disabled selected>Selecciona un alumno</option>
            <option disabled>-------------------------</option>
            <c:forEach items="${alumnos}" var="alumno">
                <option value="${alumno.id}" name="${alumno.nombre}">${alumno.nombre}</option>
            </c:forEach>
        </select>

        <span>Asignatura: </span>
        <select id="asignatura" onchange="cargarAsignatura(this.value, this.options[this.selectedIndex].innerHTML)">
            <option disabled selected>Selecciona una asignatura</option>
            <option disabled>-------------------------</option>
            <c:forEach items="${asignaturas}" var="asignatura">
                <option value="${asignatura.id}">${asignatura.nombre}</option>
            </c:forEach>
        </select>
        <br>
        <br>
        <br>
        <form action="notas">
            <table style="text-align:center">
                <tr>
                    <td>
                        ALUMNO
                        <br>
                        <input type="hidden" id="idAlumno" name="idAlumno" size="1" value="${idAlu}">
                        <input type="text" name="nombreAlumno" id="nombreAlumno" value="${nomAlu}">
                    </td>
                    <td>
                        ASIGNATURA
                        <br>
                        <input type="hidden" id="idAsignatura" name="idAsignatura" size="1" value="${idAsig}">
                        <input type="text" name="nombreAsignatura" id="nombreAsignatura" value="${nomAsig}">
                    </td>
                    <td>
                        <br>
                        <button onclick="cargar()">Cargar</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        NOTA <input type="text" value="${nota.nota}" id="nota" name="nota" size="1">
                    </td>
                    <td>
                        <br>
                        <input type="hidden" id="accion" name="accion" value="">
                        <button onclick="guardar()">Guardar</button>
                        <button onclick="borrar()">Borrar</button>
                    </td>
                </tr>
            </table>
        </form>
        <h3>
            <?php
            if ($mostrarMensaje == true) {
                echo $mensaje;
            }
            ?>
        </h3>
    </body>
</html>
