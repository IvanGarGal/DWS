<?php

require_once '.src\controller\Nivel1.php';
require_once '.src\controller\Nivel2.php';
require_once '.src\controller\Nivel3.php';

//use controller\Nivel1;
//use controller\Nivel2;
//use controller\Nivel3;


$param=$_REQUEST["nivel"];
$controller;

if (($_SESSION["nivel"]) == "1" || isset($_SESSION["nivel"])){
    $_SESSION["nivel"] = "1"; 
    $controller = new Nivel1();
}

if (($_SESSION["nivel"]) == "21" || ($_SESSION["nivel"]) == "22" || ($_SESSION["nivel"]) == "23") {
    $controller = new Nivel2();
}

if (($_SESSION["nivel"]) == "3"){
    $controller = new Nivel3();
}

$controller -> nivel($param);
    
// 'nivel' hace referencia a la funcion nivel que hay en cada uno de los niveles
 
// en el $param guardo el valor de la key. la key y el valor lo introduzco por teclado a través de la URL.
// si hay una key con el nombre que le he indicado (en este caso "nivel") metería valor de dicha key. si no existe la key
// me meteria valor nulo.

// $controller es una variable que me creo, a la cual le asigno una nueva clase. Posteriormente, 
// al controller le indico la funcion a la que quiero acceder dentro de la clase y le mando el parametro:
//$controller = new Nivel();
//$controller -> nivel($param)
//El parametro que le mando es el valor de la key que introducido manualmente por teclado