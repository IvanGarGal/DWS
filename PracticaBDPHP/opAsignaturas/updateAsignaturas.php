<?php

try {
    $id = $_REQUEST['idasignatura'];
    $nombre = htmlspecialchars($_REQUEST['nombre']);
    $curso = htmlspecialchars($_REQUEST['curso']);
    $ciclo = htmlspecialchars($_REQUEST['ciclo']);

    $stmt = $conn->prepare("UPDATE ASIGNATURAS SET NOMBRE = :nombre, CURSO = :curso, CICLO = :ciclo WHERE id = :id");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':curso', $curso);
    $stmt->bindParam(':ciclo', $ciclo);
    $stmt->bindParam(':id', $id);
    $filasUpdate = $stmt->execute();

    if ($filasUpdate == 0) {
        echo "<script>alert('La operacion  ha fallado')</script>";
    } else {
        echo "<script>alert('La operacion se ha realizado correctamente')</script>";
    }
    include('selectAsignaturas.php');
} catch (Exception $ex) {
    echo $ex->Message();
}
?>



