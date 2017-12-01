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
                // $id es la id autoincremental del ultimo insertado. No la uso para nada.
                // Solo quería saber como recoger esa id.
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
//Esta sería la consulta sin paginación 
//$asignaturas = $db->get('ASIGNATURAS');

//Estas filas son para la paginación, no tienen nada que ver con el ejercicio.
///////////////////////////////////////////////////////////////////////////
$asignaturas = $db->get('ASIGNATURAS');
$totalFilas=$db->count;
$numRes = 10;

$paginacion = new Zebra_Pagination();
$paginacion->records($totalFilas);
$paginacion->records_per_page($numRes);
$conn = new mysqli($servername, $username, $password, $database);
$sql = "SELECT * FROM ASIGNATURAS LIMIT " . (($paginacion->get_page() - 1 ) * $numRes) . ',' . $numRes;
$asignaturas = $conn->query($sql);
$conn->close();
///////////////////////////////////////////////////////////////////////////

$db->disconnect();
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
            .nombreTabla{
                width: 200px;
                margin: 0 -10px;
                border: none;
            }
            #texto{
                position: absolute;
                top: 580px;
            }
        </style>
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
        <table border="1">
            <?php foreach ($asignaturas as $asignatura) { ?>
                <tr>
                    <td class="boton" >
                        <input type="button" value="Cargar <?php echo $asignatura['id'] ?>"
                               onclick="cargar('<?php echo $asignatura['id'] ?>',
                                                   '<?php echo htmlspecialchars(addslashes($asignatura['NOMBRE']), ENT_QUOTES, 'UTF-8'); ?>',
                                                   '<?php echo htmlspecialchars(addslashes($asignatura['CICLO']), ENT_QUOTES, 'UTF-8'); ?>',
                                                   '<?php echo htmlspecialchars(addslashes($asignatura['CURSO']), ENT_QUOTES, 'UTF-8'); ?>')">
                    </td>
                    <td>
                        <input class="nombreTabla" type="text" value="<?php echo htmlspecialchars($asignatura['NOMBRE'], ENT_QUOTES, 'UTF-8'); ?>">
                    </td>
                    <td>
                        <input class="nombreTabla" type="text" value="<?php echo htmlspecialchars($asignatura['CICLO'], ENT_QUOTES, 'UTF-8'); ?>">
                    </td>
                    <td>
                        <input class="nombreTabla" type="text" value="<?php echo htmlspecialchars($asignatura['CURSO'], ENT_QUOTES, 'UTF-8'); ?>">
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <br>
        <div id="form">
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
        </div>
        <div id="paginas">
            <?php
            //Muestra los números de las páginas
            $paginacion->labels("Anterior","Siguiente");
            $paginacion->render();
            ?>
        </div>
        <br>
        <h3 id="texto">
            <?php
            if ($mostrarMensaje == true) {
                echo $mensaje;
            }
            ?>
        </h3>
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