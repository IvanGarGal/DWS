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

$db = new MysqliDb($servername, $username, $password, $database);


$mostrarMensaje = false;
$borrar = false;

if (isset($_REQUEST["accion"])) {
    $accion = $_REQUEST["accion"];
    $nombre = $_REQUEST["nombre"];
    $ciclo = $_REQUEST["ciclo"];
    $curso = $_REQUEST["curso"];


    switch ($accion) {
        case "actualizar":
            $id = $_REQUEST["id"];
            $data = array('NOMBRE' => $nombre, 'CICLO' => $ciclo, 'CURSO' => $curso);
            $db->where('id', $id);
            if (!$db->update('ASIGNATURAS', $data)) {
                $filas = -1;
            } else {
                $filas = $db->count;
            }
            break;
        case "guardar":
            $data = array('NOMBRE' => $nombre, 'CICLO' => $ciclo, 'CURSO' => $curso);
            if (!$id = $db->insert('ASIGNATURAS', $data)) {
                // $id es la id del ultimo insertado
                $filas = -1;
            } else {
                $filas = $db->count;
            }
            break;
        case "borrar":
            $id = $_REQUEST["id"];
            $db->where('id', $id);
            if (!$db->delete('ASIGNATURAS')) {
                $filas = -1;
            } else {
                $filas = 1;
            }
            $borrar = true;
            break;
        case "borrar2":
            $id = $_REQUEST["id"];
            $db->startTransaction();
            $db->where('ID_ASIGNATURA', $id);
            $filas = $db->delete('NOTAS');
            if ($filas == true) {
                $db->where('id', $id);
                $filas = $db->delete('ASIGNATURAS');
            }
            if($filas==false){
                $db->rollback();
            }else{
                $db->commit();
            }
            $borrar = true;
            break;
    }
    $mostrarMensaje = true;

    if ($filas > 0) {
        $mensaje = $filas . " filas modificadas.";
    } else if ($filas == -1) {
        $mensaje = "Ocurrió un error al hacer la consulta.";
    } else if ($filas == 0) {
        $mensaje = "No se han hecho modificaciones.";
    }
    if($borrar == true){
        $mensaje = "Filas borradas correctamente.";
    }
    
    $error = $db->getLastError();
    
    if (($errorIntegridad = strpos($error, 'foreign')) == true) {
        $mostrarMensaje = false;
        $mensaje = "Si borras esta asignatura se borrarán todas sus notas.";
    }
}

$asignaturas = $db->get('ASIGNATURAS');

$db->disconnect();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script>
            function cargar(id, nombre, ciclo, curso) {
                document.formulario['id'].value = id;
                document.formulario['nombre'].value = nombre;
                document.formulario['ciclo'].value = ciclo;
                document.formulario['curso'].value = curso;

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
        <h1>Asignaturas</h1>
        <h3>
            <?php
            if ($mostrarMensaje == true) {
                echo $mensaje;
            }
            ?>
        </h3>
        <table border="1">
            <?php foreach ($asignaturas as $asignatura) { ?>
                <tr>
                    <td>
                        <input type="button" value="Cargar <?php echo $asignatura['id'] ?>"
                               onclick="cargar('<?php echo $asignatura['id'] ?>', '<?php echo addslashes($asignatura['NOMBRE']) ?>',
                                                   '<?php echo addslashes($asignatura['CICLO']) ?>', '<?php echo addslashes($asignatura['CURSO']) ?>')">
                    </td>
                    <td>
                        <?php echo $asignatura['NOMBRE']; ?>
                    </td>
                    <td>
                        <?php echo $asignatura['CICLO']; ?>
                    </td>
                    <td>
                        <?php echo $asignatura['CURSO']; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <br>
        <form action="asignaturas.php" name="formulario">
            <input type="hidden" name="id" id="id" value="">
            <input type="text" name="nombre" id="nombre" value="">
            <input type="text" name="ciclo" id="ciclo" value="">
            <input type="text" name="curso" id="curso" value="">
            <input type="hidden" name="accion" id="accion" value="">
            <br>
            <br>
            <button onclick="accionActualizar()" id="actualizar" disabled>Actualizar</button>
            <button onclick="accionGuardar()" id="guardar">Guardar</button>
            <button onclick="accionBorrar()" id="borrar" disabled>Borrar</button>
        </form>
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