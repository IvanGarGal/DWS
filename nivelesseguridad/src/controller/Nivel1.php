<?php
namespace controller;

class Nivel1 {
    public function nivel ($param) {
        $pagina='vista\ERROR.php';
        
        if (isset($_SESSION["nivel"])){
            $_SESSION["nivel"] = "1";
        }      
        else {
            if($_SESSION["nivel"] == "1"){
                if (isset($param)){
                    $_SESSION["nivel"] = "1";
                }
                else {
                    if ($param=="hola"){
                        $_SESSION["nivel"] = "21";
                        $pagina='vista\ACIERTO.php';    
                    }
                }
            }  
            else {
                $_SESSION["nivel"] = "1";
            }     
        }
        
        include $pagina;
    }
}
