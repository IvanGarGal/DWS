<?php
namespace controller;

class Nivel2 {
    public function nivel ($param) {
        $pagina='vista\ERROR.php';
        
        if (isset($_SESSION["nivel"])){
            $_SESSION["nivel"] = "1";
        }      
        else {
            if($_SESSION["nivel"] = "21"){
                if (isset($param)){
                    $_SESSION["nivel"] = "1";
                }
                else {
                    if ($param=="dos1"){
                        $_SESSION["nivel"] = "22";
                        $pagina='vista\ACIERTO.php';    
                    }
                    else {
                        $_SESSION["nivel"] = "1";
                    }
                }
            } 
            
            if($_SESSION["nivel"] = "22"){
                if (isset($param)){
                    $_SESSION["nivel"] = "1";
                }
                else {
                    if ($param=="23"){
                        $_SESSION["dos2"] = "2";
                        $pagina='vista\ACIERTO.php';    
                    }
                    else {
                        $_SESSION["nivel"] = "1";
                    }
                }
            }
            
            if($_SESSION["nivel"] = "23"){
                if (isset($param)){
                    $_SESSION["nivel"] = "1";
                }
                else {
                    if ($param=="3"){
                        $_SESSION["dos3"] = "2";
                        $pagina='vista\ACIERTO.php';    
                    }
                    else {
                        $_SESSION["nivel"] = "1";
                    }
                }
            }
            
            //else {
                //$_SESSION["nivel"] = "1";
            //}     
        }
        
        include $pagina;
    }
}