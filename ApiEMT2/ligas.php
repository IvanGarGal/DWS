<?php

require 'vendor/autoload.php';
    use GuzzleHttp\Client;  
    $client = new Client();

    $uri = 'http://api.football-data.org/v1/competitions/455/leagueTable';
    $header = array('headers' => array('X-Auth-Token' => '2deee83e549c4a6e9709871d0fd58a0a'));
    $response = $client->get($uri, $header);          
    $json = json_decode($response->getBody()); 