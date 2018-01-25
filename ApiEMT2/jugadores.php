<?php

require 'vendor/autoload.php';
    use GuzzleHttp\Client;  
    $client3 = new Client();
    $uri3 = 'http://api.football-data.org/v1/teams/745/players';
    $header3 = array('headers' => array('X-Auth-Token' => '7455d306d1734284a744a80bfe86e426'));
    $response3 = $client3->get($uri3, $header3);          
    $json3 = json_decode($response3->getBody());  
    echo '<table border=1>'
    . '<tr>'
    . '<th>Nombre</th>'
    . '<th>Posicion</th>'
    . '<th>Número</th>'
    . '<th>Fecha de Nacimiento</th>'        
    . '<th>Nacionalidad</th>'
    . '<th>Fin del contrato</th>'
    . '</tr>';
    foreach ($json3->players as $jugador) {
        echo '<tr>';
        echo '<td>' . $jugador->name . '</td>';
        echo '<td>' . $jugador->position . '</td>';
        echo '<td>' . $jugador->jerseyNumber . '</td>';
        echo '<td>' . $jugador->dateOfBirth . '</td>';
        echo '<td>' . $jugador->nationality . '</td>';
        echo '<td>' . $jugador->contractUntil . '</td>';   
        echo '</tr>';
    }
    echo '</table>';
    echo "<br/> <br/> <br/> <br/>";
