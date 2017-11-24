<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once 'vendor/autoload.php';
$servername = "db4free.net:3307";
$username = "oscarnovillo";
$password = "c557ef";
$database = "clasesdaw";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("No se ha podido establecer la conexión: " . $conn->connect_error);
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

//Estas filas son para la paginación, no tienen nada que ver con el ejercicio.
///////////////////////////////////////////////////////////////////////////
$filas = $conn->query("SELECT * FROM ALUMNOS");
$totalFilas = mysqli_num_rows($filas);
$numRes = 10;

$paginacion = new Zebra_Pagination();
$paginacion->records($totalFilas);
$paginacion->records_per_page($numRes);

$sql = "SELECT * FROM ALUMNOS LIMIT " . (($paginacion->get_page() - 1 ) * $numRes) . ',' . $numRes;
///////////////////////////////////////////////////////////////////////////

//Esta sería la consulta normal sin paginación:
//$sql = "SELECT * FROM ALUMNOS";
if (!$alumnos = $conn->query($sql)) {
    die('Ocurrió un error al hacer la consulta [' . $conn->error . ']');
}
$conn->close();

?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="vendor/stefangabos/zebra_pagination/public/css/zebra_pagination.css" type="text/css">
        <title></title>
        <style>
            td{
                padding: 0 10px;
            }
            .boton{
                padding: 0;
            }
            #paginas{
                position: absolute;
                top: 530px;
            }
            #form{
                position: absolute;
                top: 420px;
            }
            .nombreAlumno{
                width: 150px;
                max-width: 150px;
                height: 10px;
                max-height: 10px;
                overflow: hidden;
            }
        </style>
        <script>
            function cargar(id, nombre, fecha, mayor) {
                document.formulario['id'].value = id;
                document.formulario['nombre'].value = nombre;
                document.formulario['fecha'].value = fecha;
                if (mayor == 1) {
                    document.formulario['mayor'].checked = true;
                } else {
                    document.formulario['mayor'].checked = false;
                }
                document.formulario['actualizar'].disabled = false;
                document.formulario['borrar'].disabled = false;
                document.formulario['guardar'].disabled = true;
            }

            function accionActualizar() {
                document.formulario['accion'].value = "actualizar";
            }
            function accionGuardar() {
                document.formulario['accion'].value = "guardar";
            }
            function accionBorrar() {
                document.formulario['accion'].value = "borrar";
            }
        </script>
    </head>
    <body>
        <h1>Alumnos</h1>
        <h3>
            <?php
            if ($mostrarMensaje == true) {
                echo $mensaje;
            }
            ?>
        </h3>
        <table border="1">
            <?php foreach ($alumnos as $alumno) { ?>
                <tr>
                    <td class="boton">
                        <input type="button" value="Cargar <?php echo $alumno['ID'] ?>"
                               onclick="cargar('<?php echo $alumno['ID'] ?>',
                               '<?php echo addslashes($alumno['NOMBRE']) ?>',
                               '<?php $fecha = new DateTime($alumno['FECHA_NACIMIENTO']);
                               echo $fecha->format('d-m-Y');?>',
                               '<?php echo $alumno['MAYOR_EDAD'] ?>')">
                    </td>
                    <td class="nombreAlumno">
                        <?php echo $alumno['NOMBRE']; ?>
                    </td>
                    <td>
                        <?php
                        $fecha = new DateTime($alumno['FECHA_NACIMIENTO']);
                        echo $fecha->format('d-m-Y');
                        ?>
                    </td>
                    <td>
                        <input type="checkbox"<?php if ($alumno['MAYOR_EDAD']) { ?>checked<?php } ?>>
                    </td>
                </tr>
            <?php } ?>
        </table>
        
        <div id="paginas">
            <?php
            //Muestra los números de las páginas
            $paginacion->labels("Anterior","Siguiente");
            $paginacion->render();
            ?>
        </div>
        
        <br>
        <br>
        <div id="form">
            <form action="alumnos.php" name="formulario">
                <input type="hidden" name="id" id="id" value="">
                <input type="text" name="nombre" id="nombre" value="">
                <input type="text" name="fecha" id="fecha" value="">
                <input type="checkbox" name="mayor" id="mayor">
                <input type="hidden" name="accion" id="accion" value="">
                <br>
                <br>
                <button onclick="accionActualizar()" id="actualizar" disabled>Actualizar</button>
                <button onclick="accionGuardar()" id="guardar">Guardar</button>
                <button onclick="accionBorrar()" id="borrar" disabled>Borrar</button>
            </form>
        </div>
        <?php
        if (isset($errorIntegridad) && $errorIntegridad == true) {
            ?>
            <script>
                var borrarNotas = confirm("<?php echo $mensaje ?>" + "\n¿Quieres continuar?");
                if (borrarNotas == true) {
                    document.formulario['accion'].value = "borrar2";
                    document.formulario['id'].value = '<?php echo $id ?>';
                    document.formulario.submit();
                }
            </script>
            <?php
        }
        ?>
    </body>
</html>