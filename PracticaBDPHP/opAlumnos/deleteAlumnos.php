<?php

try {
    $id = $_REQUEST['idalumno'];


    $stmt = $conn->prepare("DELETE FROM ALUMNOS WHERE ID = ?");
    $stmt->bind_param("i", $id);
    $filasDelete = $stmt->execute();

    if ($conn->errno != 0) {
        if (preg_match('/FOREIGN/',$conn->error)){
            $borrarTotal = 1;
        }else{
            "<script>alert('La operacion ha fallado')</script>";
        }
    } else {
        if ($filasDelete == true)
            echo "<script>alert('La operacion se ha realizado correctamente')</script>";
         $borrarTotal = 0;
    }
    include('selectAlumnos.php');
} catch (mysqli_sql_exception $ex) {
    echo $ex->getMessage();
}
?>

