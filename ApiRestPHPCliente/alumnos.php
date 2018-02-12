<?php
ini_set('display_errors', 'On');
require_once 'config/Config.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CRUD PHP</title>
        <style>
            body {text-align: center}
            table {
                margin-left: auto;
                margin-right: auto;
            }
            .container {
                margin: 0 auto;
                text-align: center;
                width: 100%;
            }
            .container a {
                padding-left: 20px;
                font-size: 1.5em;
            }
        </style>
        <script>
            function cargarAlumno(id, nombre, fecha_nacimiento, mayor_edad) {
                document.getElementById("id").value = id;
                document.getElementById("nombre").value = nombre;
                document.getElementById("fecha_nacimiento").value = fecha_nacimiento;

                if (mayor_edad == true) {
                    document.getElementById("mayor_edad_true").checked = true;
                } else {
                    document.getElementById("mayor_edad_false").checked = true;
                }
            }
            function cargarAsignatura(id, nombre, curso, ciclo) {
                document.getElementById("id").value = id;
                document.getElementById("nombre").value = nombre;
                document.getElementById("curso").value = curso;
                document.getElementById("ciclo").value = ciclo;

            }

        </script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    </head>
    <body>
        <div class="container">
            <a href="alumnos.php">alumnos</a><a href="asignaturas.php">asignaturas</a><a href="notas.php">notas</a>
        </div>
<?php
if (is_int($deletedAlumno) && $deletedAlumno == 409) {//cuando no pueda borrar
    echo '<form action="alumnos.php">
            <h3>';
    echo $messageToUser;
    echo '  </h3>
                <input type="hidden" name="ID" value="' . $id . '" ><br>           
                <button  name="ACTION" value="DELETE_FORCE" type="submit">Borrar Completamente</button>
                <button  name="ACTION" value="CANCEL" type="submit">Cancelar</button>

            </form>';
}

if ($messageToUser != NULL && $deletedAlumno == NULL) {
    echo $messageToUser . "<br>";
}
if ($messageToUser != NULL && is_object($deletedAlumno) && $deletedAlumno->code != Constantes::CodeConflict) {
    echo $messageToUser . "<br>";
}
echo ' 
                    <table class = "table">
                    <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th></th>
                    </tr>';
foreach ($listaAlumnos as $valor) {
    $id = $valor->id;
    $nombre = htmlspecialchars($valor->nombre);
    $fecha_nacimiento = $valor->fecha_nacimiento;
    $mayor_edad = $valor->mayor_edad;

    echo '<tr>
               <td><button id = "cargarAlumno" onClick = "cargarAlumno(';
    echo $id;
    echo ',\'';
    echo str_replace("'", "\'", $nombre);
    echo '\',\'';
    echo $fecha_nacimiento;
    echo '\',';
    echo $mayor_edad;
    echo ')">Cargar</button>
                </td><td contenteditable = "true">';
    echo $nombre;
    echo '</td><td contenteditable = "true">';
    echo $fecha_nacimiento;
    echo '</td></tr>';
}

unset($valor);
echo '</table>'
 . '<form action="alumnos.php" >
                    <input type="hidden" name="ID" id="id" ><br>
                    Nombre:
                    <input type="text" name="NOMBRE" id="nombre" ><br>
                    Fecha Nacimiento:
                    <input type="date" name="FECHA_NACIMIENTO" id="fecha_nacimiento" placeholder="yyyy-mm-dd"><br>
                    Mayor de edad: <br>
                    Si: <input type="radio" name="MAYOR_EDAD" value="on" id="mayor_edad_true" required >
                    No: <input type="radio" name="MAYOR_EDAD" value="off" id="mayor_edad_false" >
                    <br>
                    <input type="submit" name="ACTION" value="INSERT">
                    <input type="submit" name="ACTION" value="UPDATE">
                    <input type="submit" name="ACTION" value="DELETE">
                </form>  
                <p>Nº Alumnos: ';
echo count($listaAlumnos);
echo '</p>';
?>
       <script>
            if (document.getElementById("fecha_nacimiento").type !== "date") {
                $(function () {
                    $('input[type="date"]').datepicker({dateFormat: 'yy-mm-dd'});
                });
            }

            function comprobarInputNota() {
                var formulario = document.getElementsByTagName("input")[0].value;
                if (formulario.length == 0 || !isInt(formulario)) {

                    alert("No has introducido una nota válida!");
                    return false;

                }
            }
            function isInt(value) {
                return !isNaN(value) &&
                        parseInt(Number(value)) == value &&
                        !isNaN(parseInt(value, 10));
            }

        </script>
    </body>
</html>

<?php

$listaAlumnos = NULL;
$deletedAlumno = 0; 

$id = filter_input(INPUT_GET, "ID");
$nombre = filter_input(INPUT_GET, "NOMBRE");
$fecha_nacimiento = filter_input(INPUT_GET, "FECHA_NACIMIENTO");
$mayor_edad = filter_input(INPUT_GET, "MAYOR_EDAD");
$action = filter_input(INPUT_GET, "ACTION");

$messageToUser = NULL;

$alumno = new Alumno($id, $nombre, $fecha_nacimiento, ($mayor_edad == "on") ? 1 : 0);

switch ($action) {
    case "INSERT":
        $alumno = getInstance()->insertAlumno($alumno);

        $messageToUser = ($alumno != null) ?
                "Alumno insertado" : "Fallo al insertar alumno";


        break;
    case "UPDATE";
        $alumno = getInstance()->updateAlumno($alumno);

        $messageToUser = ($alumno != null) ?
                "Alumno actualizado" : "Fallo al actualizar alumno";


        break;
    case "DELETE":

        $deletedAlumno = -1;
        if ($id != null && strlen($id) > 0) {

            $deletedAlumno = getInstance()->deleteAlumno($alumno, FALSE);
        }
        if (is_int($deletedAlumno) && $deletedAlumno == 409) {

            $messageToUser = "Fallo al eliminar alumno";
        } else if (is_object($deletedAlumno)) {

            $messageToUser = "Alumno eliminado";
        }
        break;
    case "DELETE_FORCE":
        if ($id != null && strlen($id) > 0) {
            $borrado = getInstance()->deleteAlumno($alumno, TRUE);
        }
        $messageToUser = (is_object($borrado)) ? "Alumno eliminado" : "Fallo al eliminar alumno";
        break;


    default:


        break;
}

class AlumnosApi {

    private $client;
    private static $instancia;
    

    public function __construct() {
        $this->client = new Client(['base_uri' => "http://localhost:8080/ApiRestJavaServidor/rest/" ,'headers'=>['apikey'=> "keyPHP"]]);        
    }

    public static function getInstance() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    public function getAllAlumnos() {

        $response = $this->client->get("ALUMNOS");
        return json_decode($response->getBody());
    }

    public function insertAlumno($alumno) {
        $response = $this->client->put("ALUMNOS", [
            'query' => [
                'alumno' => json_encode($alumno)
    ]]);
        return json_decode($response->getBody());
    }

    public function updateAlumno($alumno) {
        $response = $this->client->post("ALUMNOS", [
            'form_params' => [
                'alumno' => json_encode($alumno)
            ]
        ]);
        return json_decode($response->getBody());
    }

   
    public function deleteAlumno($alumno,$force) {
       
        try {
            $response = $this->client->delete("ALUMNOS", [
                'query' => [
                    'alumno' => json_encode($alumno),'delete_force'=>($force)?'true':'false'
            ]]);

            $respuesta = json_decode($response->getBody());
            
        } catch (RequestException $e) {
            if ($e->getCode() == 409) {
                $respuesta = $e->getCode();
            }
        } finally {
            
            return $respuesta;
        }
    }

}


