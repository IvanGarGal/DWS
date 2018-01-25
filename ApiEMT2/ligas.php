<?php

require 'vendor/autoload.php';
    use GuzzleHttp\Client;  
    $client = new Client();
    $uri = 'http://api.football-data.org/v1/competitions/?season=2017';
    $header = array('headers' => array('X-Auth-Token' => '7455d306d1734284a744a80bfe86e426'));
    $response = $client->get($uri, $header);          
    $json = json_decode($response->getBody());  
    
    echo '<table border=1>'
    . '<tr>'
    . '<th>ID</th>'
    . '<th>Nombre de la liga</th>'
    . '<th>Liga</th>'
    . '<th>Año</th>'
    . '<th>Número de equipos</th>'
    //. '<th></th>'
    . '</tr>';
    foreach ($json as $ligas) {
        echo '<tr>';
        echo '<td>' . $ligas->id . '</td>';
        echo '<td>' . $ligas->caption . '</td>';
        echo '<td>' . $ligas->league . '</td>';
        echo '<td>' . $ligas->year . '</td>';
        echo '<td>' . $ligas->numberOfTeams . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo "<br/> <br/> <br/> <br/>";
