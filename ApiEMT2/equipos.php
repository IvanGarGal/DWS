<?php

require 'vendor/autoload.php';
use GuzzleHttp\Client;  
$client = new Client();

$uri = 'http://api.football-data.org/v1/competitions/455/leagueTable';
$header = array('headers' => array('X-Auth-Token' => '2deee83e549c4a6e9709871d0fd58a0a'));
$response = $client->get($uri, $header);          
$equipos = json_decode($response->getBody()); 
var_dump($json);
     foreach ( $json->standing as $team)
    {
        echo $team->teamName . " ". $team->points ." <br>";
        
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <h1 align="center">LISTADO DE MEDICOS</h1>
    <table width="70%" border="1px" align="center">
        <?php
        foreach ($equipos -> standing as equipo) {
        ?>
        <tr align="center">
        <td>Codigo</td>
        <td>Identificacion</td>
        <td>Nombre</td>
        <td>Apellidos</td>
        <td>Especialidad</td>
        <td>Telefono</td>
        <td>Correo</td>
    </tr>
        <?php
        }
        ?>
    
    <?php 
        while($datos=$resultado->fetch_array()){
        ?>
            <tr>
                <td><?php echo $datos["idMedico"]?></td>
                <td><?php echo $datos["medIdentificacion"]?></td>
                <td><?php echo $datos["medNombres"]?></td>
                <td><?php echo $datos["medApellidos"]?></td>
                <td><?php echo $datos["medEspecialidad"]?></td>
                <td><?php echo $datos["medTelefono"]?></td>
                <td><?php echo $datos["medCorreo"]?></td>
            </tr>
            <?php   
        }

     ?>
    </table>

</body>
</html>