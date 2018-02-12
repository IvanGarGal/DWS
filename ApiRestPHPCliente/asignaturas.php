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
if (is_int($deletedAsignatura) && $deletedAsignatura == 409) {//cuando no pueda borrar
    echo ' <form action="asignaturas.php">
                <h3>' . $messageToUser . '</h3>
                <input type="hidden" name="ID" value="' . $id . '" ><br>           
                <button name="ACTION"  value="DELETE_FORCE" type="submit">Borrar Completamente</button>
                <button name="ACTION"  value="CANCEL" type="submit">Cancelar</button>

            </form>';
}

if ($messageToUser != NULL && $deletedAsignatura == NULL) {
    echo $messageToUser . "<br>";
}

if ($messageToUser != NULL && is_object($deletedAsignatura) && $deletedAsignatura->code != Constantes::CodeConflict) {
    echo $messageToUser . "<br>";
}

echo '<table class="table">
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Curso</th>                
                <th>Ciclo</th>
            </tr>';
foreach ($listaAsignaturas as &$valor) {
    $id = $valor->id;
    $nombre = htmlspecialchars($valor->nombre);
    $curso = htmlspecialchars($valor->curso);
    $ciclo = htmlspecialchars($valor->ciclo);
    echo '<tr>
                    <td>
                    <button id="cargarAsignatura" onClick="
                cargarAsignatura(' . $id . ',\'' . str_replace("'", "\'", $nombre) . '\',\'' . str_replace("'", "\'", $curso) . '\',\'' . str_replace("'", "\'", $ciclo) . '\')">Cargar</button>';
    echo '</td>
                    <td contenteditable="true">
                        ' . $nombre . '
                    </td>
                    <td contenteditable="true">
                        ' . $curso . '
                    </td>
                    <td contenteditable="true">
                        ' . $ciclo . '
                    </td>

                </tr>';
}
unset($valor);
echo '</table>'
 . '<form action="asignaturas.php" >
                    <input type="hidden" name="ID" id="id" ><br>
                    Nombre:
                    <input type="text" name="NOMBRE" id="nombre" ><br>
                    Curso:
                    <input type="text" name="CURSO" id="curso" placeholder=""><br>
                    Ciclo: 
                    <input type="text" name="CICLO" id="ciclo" placeholder=""><br>
                    <br>
                    <input type="submit" name="ACTION" value="INSERT">
                    <input type="submit" name="ACTION" value="UPDATE">
                    <input type="submit" name="ACTION" value="DELETE">
                </form>  
                <p>Nº Asignaturas: ';
echo count($listaAsignaturas);
echo '</p>';
echo '</p>';
?>
       <script>
            if (document.getElementById("fecha_nacimiento").type !== "date") { //if browser doesn't support input type="date", initialize date picker widget:
                $(function () {
                    // Find any date inputs and override their functionality
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

$asignatura = new Asignatura($id, $nombre, $curso, $ciclo);

switch ($action) {
    case "INSERT":

        $asignatura = getInstance()->insertAsignatura($asignatura);
        $messageToUser = ($asignatura != NULL) ?
                "Asignatura insertada" : "Fallo al insertar asignatura";


        break;
    case "UPDATE";
        $asignatura = getInstance()->updateAsignatura($asignatura);
        $messageToUser = ($asignatura != NULL) ?
                "Asignatura actualizada" : "Fallo al actualizar asignatura";


        break;
    case "DELETE":
        $deletedAsignatura = -1;
        if ($id != null && strlen($id) > 0) {
            $deletedAsignatura = getInstance()->deleteAsignatura($asignatura, FALSE);
        }
        if (is_int($deletedAsignatura) && $deletedAsignatura == 409) {

            $messageToUser = "Fallo al eliminar asignatura";
        } else if (is_object($deletedAsignatura)) {

            $messageToUser = "Asignatura eliminada";
        }
        break;
    case "DELETE_FORCE":
        if ($id != null && strlen($id) > 0) {
            $borrado = getInstance()->deleteAsignatura($asignatura, TRUE);
        }
        $messageToUser = (is_object($borrado)) ? "Asignatura eliminada" : "Fallo al eliminar asignatura otra vez";

        break;


    default:


        break;
}


$listaAsignaturas = AsignaturasApi::getInstance()->getAllAsignaturas();

class AsignaturasApi {

    private $client;
    private static $instancia;

    public function __construct() {
        $this->client = new Client(['base_uri' => "http://localhost:8080/ApiRestJavaServidor/rest/", 'headers' => ['apikey' => "heyPHP"]]);
    }

    public static function getInstance() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    public function getAllAsignaturas() {

        $response = $this->client->get("asignaturas");
        return json_decode($response->getBody());
    }

    public function insertAsignatura($asignatura) {
        $response = $this->client->put("asignaturas", [
            'query' => [
                'asignatura' => json_encode($asignatura)
        ]]);
        return json_decode($response->getBody());
    }

    public function updateAsignatura($asignatura) {
        $response = $this->client->post("asignaturas", [
            'form_params' => [
                'asignatura' => json_encode($asignatura)
            ]
        ]);
        return json_decode($response->getBody());
    }

    public function deleteAsignatura($asignatura, $force) {

        try {
            $response = $this->client->delete("asignaturas", [
                'query' => [
                    'asignatura' => json_encode($asignatura), 'delete_force' => ($force) ? 'true' : 'false'
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
