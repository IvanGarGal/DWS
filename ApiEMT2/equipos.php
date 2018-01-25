 <?php

require 'vendor/autoload.php';
    use GuzzleHttp\Client;     
    $client2 = new Client();
    $uri2 = 'http://api.football-data.org/v1/competitions/455/leagueTable';
    $header2 = array('headers' => array('X-Auth-Token' => '7455d306d1734284a744a80bfe86e426'));
    $response2 = $client2->get($uri2, $header2);          
    $json2 = json_decode($response2->getBody());  
    echo '<h5>' . $json2->leagueCaption . '</h5>';
    echo '<table border=1>'
    . '<tr>'
    . '<th>Posicion</th>'
    . '<th>Nombre del equipo</th>'
    . '<th>Logo</th>'        
    . '<th>Puntos</th>'
    . '<th>Goles</th>'
    . '<th>Goles en contra </th>'
    . '<th>Diferencia de goles </th>'
    //. '<th></th>'
    . '</tr>';
    foreach ($json2->standing as $liga) {
        echo '<tr>';
        echo '<td>' . $liga->position . '</td>';
        echo '<td>' . $liga->teamName . '</td>';
        echo '<td><img src="' . $liga->crestURI . '" width="60" height="80""></td>';
        echo '<td>' . $liga->points . '</td>';
        echo '<td>' . $liga->goals . '</td>';
        echo '<td>' . $liga->goalsAgainst . '</td>';
        echo '<td>' . $liga->goalDifference . '</td>';   
        echo '</tr>';
    }
    echo '</table>';
    echo "<br/> <br/> <br/> <br/>";