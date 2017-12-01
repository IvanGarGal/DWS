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
try {
    $dsn = "mysql:host=$servername;dbname=$database";
    $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$mostrarMensaje=false;

$alumnos = $dbh->prepare("SELECT * FROM ALUMNOS");
$alumnos->setFetchMode(PDO::FETCH_ASSOC);
$alumnos->execute();

$asignaturas = $dbh->prepare("SELECT * FROM ASIGNATURAS");
$asignaturas->setFetchMode(PDO::FETCH_ASSOC);
$asignaturas->execute();

if (isset($_REQUEST["accion"])) {
    $accion = $_REQUEST["accion"];
    $nombreAlu = $_REQUEST["nombreAlumno"];
    $idAlu = $_REQUEST["idAlumno"];
    $nombreAsig = $_REQUEST["nombreAsignatura"];
    $idAsig = $_REQUEST["idAsignatura"];
    
    switch ($accion){
        case "cargar":
            $stmt = $dbh->prepare("SELECT * FROM NOTAS WHERE ID_ALUMNO = ? AND ID_ASIGNATURA = ?");
            $stmt->bindParam(1, $idAlu);
            $stmt->bindParam(2, $idAsig);
            $stmt->execute();
            if(!$fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $mensaje ="No hay notas";
                $mostrarMensaje = true;
            }else{
                $notas=$fila['NOTA'];
            }
            break;
        case "guardar":
            $notas= $_REQUEST["nota"];
            $stmt = $dbh->prepare("UPDATE NOTAS SET NOTA = ? WHERE ID_ALUMNO = ? AND ID_ASIGNATURA = ?");
            $stmt->bindParam(1, $notas);
            $stmt->bindParam(2, $idAlu);
            $stmt->bindParam(3, $idAsig);
            $stmt->execute();
            if (!($stmt->rowCount()) > 0) {
                $stmt = $dbh->prepare("INSERT INTO NOTAS (ID_ALUMNO,ID_ASIGNATURA,NOTA) VALUES (?,?,?)");
                $stmt->bindParam(1, $idAlu);
                $stmt->bindParam(2, $idAsig);
                $stmt->bindParam(3, $notas);
                $stmt->execute();
            }
            $mostrarMensaje = true;
            break;
        case "borrar":
            $stmt = $dbh->prepare("DELETE FROM NOTAS WHERE ID_ALUMNO = ? AND ID_ASIGNATURA = ?");
            $stmt->bindParam(1, $idAlu);
            $stmt->bindParam(2, $idAsig);
            $stmt->execute();
            $mostrarMensaje = true;
            break;
    }
    if($accion != "cargar"){
        if (($filas = $stmt->rowCount()) > 0) {
            $mensaje =$filas." filas modificadas.";
        }else{
            $mensaje ="No se han hecho modificaciones.";
        }
    }
    $stmt = null;
}
$dbh = null;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script>
            function cargarAlumno(id, nombre) {
                document.getElementById("idAlumno").value = id;
                document.getElementById("nombreAlumno").value = nombre;
            }
            function cargarAsignatura(id, nombre) {
                document.getElementById("idAsignatura").value = id;
                document.getElementById("nombreAsignatura").value = nombre;
            }
            function guardar() {
                document.getElementById("accion").value = "guardar";
            }
            function borrar() {
                document.getElementById("accion").value = "borrar";
            }
            function cargar() {
                document.getElementById("accion").value = "cargar";
            }

        </script>
    </head>
    <body>
        <h1>Notas</h1>
        <span>Alumno: </span>
        <select id="alumno" onchange="cargarAlumno(this.value, this.options[this.selectedIndex].innerHTML)">
            <option disabled selected>Selecciona un alumno</option>
            <option disabled>-------------------------</option>
            <?php foreach ($alumnos as $alumno){ ?>
                <option value="<?php echo $alumno['ID'] ?>" name="<?php echo $alumno['NOMBRE'] ?>"><?php echo $alumno['NOMBRE'] ?></option>
            <?php } ?>
        </select>

        <span>Asignatura: </span>
        <select id="asignatura" onchange="cargarAsignatura(this.value, this.options[this.selectedIndex].innerHTML)">
            <option disabled selected>Selecciona una asignatura</option>
            <option disabled>-------------------------</option>
            <?php foreach ($asignaturas as $asignatura){ ?>
                <option value="<?php echo $asignatura['id'] ?>" name="<?php echo $asignatura['NOMBRE'] ?>"><?php echo $asignatura['NOMBRE'] ?></option>
            <?php } ?>
        </select>
        <br>
        <br>
        <br>
        <form action="notas.php">
            <table style="text-align:center">
                <tr>
                    <td>
                        ALUMNO
                        <br>
                        <input type="hidden" id="idAlumno" name="idAlumno" size="1" value="<?php if(isset($idAlu)){ echo $idAlu;} ?>">
                        <input type="text" name="nombreAlumno" id="nombreAlumno" value="<?php if(isset($nombreAlu)){ echo htmlspecialchars($nombreAlu, ENT_QUOTES, 'UTF-8');} ?>">
                    </td>
                    <td>
                        ASIGNATURA
                        <br>
                        <input type="hidden" id="idAsignatura" name="idAsignatura" size="1" value="<?php if(isset($idAsig)){ echo $idAsig;} ?>">
                        <input type="text" name="nombreAsignatura" id="nombreAsignatura" value="<?php if(isset($nombreAsig)){ echo htmlspecialchars($nombreAsig, ENT_QUOTES, 'UTF-8');} ?>">
                    </td>
                    <td>
                        <br>
                        <button onclick="cargar()">Cargar</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        NOTA <input type="text" value="<?php if(isset($notas)){echo $notas;} ?>" id="nota" name="nota" size="1">
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
