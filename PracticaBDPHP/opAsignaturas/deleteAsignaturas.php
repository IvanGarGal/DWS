<?php

try {
    $id = $_REQUEST['idasignatura'];

    $stmt = $conn->prepare("DELETE FROM ASIGNATURAS WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $filasUpdate = $stmt->execute();

    if ($filasUpdate == 0) {
        echo "<script>alert('La operacion  ha fallado')</script>";
    } else {
        echo "<script>alert('La operacion se ha realizado correctamente')</script>";
    }
    include('selectAsignaturas.php');
} catch (PDOException $ex) {
    if (preg_match('/FOREIGN/',$ex->getMessage())){
         
            $borrarTotal = 1;
    }else{
        echo $ex->getMessage();
    }
}