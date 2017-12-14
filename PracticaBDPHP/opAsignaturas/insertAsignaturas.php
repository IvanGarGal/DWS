<?php

try {
    $stmt = $conn->prepare("INSERT INTO ASIGNATURAS (NOMBRE,CURSO,CICLO) VALUES (:nombre,:curso,:ciclo)");

    $nombre = htmlspecialchars($_REQUEST['nombre']);
    $curso =  htmlspecialchars($_REQUEST['curso']);
    $ciclo =  htmlspecialchars($_REQUEST['ciclo']);

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':curso', $curso);
    $stmt->bindParam(':ciclo', $ciclo);

    $insert = $stmt->execute();
    if ($insert == 0) {
        echo "<script>alert('No se ha podido insertar la asignatura')</script>";
    } else {
        echo "<script>alert('Insertado correctamente')</script>";
    }
    include('selectAsignaturas.php');
} catch (PDOException $ex) {
    echo $ex->Message();
}
?>