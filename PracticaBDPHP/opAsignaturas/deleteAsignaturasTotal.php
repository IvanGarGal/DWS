<?php

try {
    $conn->beginTransaction();
    $idasign = $_REQUEST['idasign'];

    $stmtNota = $conn->prepare("DELETE FROM NOTAS WHERE ID_ASIGNATURA = :id");
    $stmtNota->bindParam(':id', $idasign);
    $stmtNota->execute();

    $stmt = $conn->prepare("DELETE FROM ASIGNATURAS WHERE id = :id");
    $stmt->bindParam(':id', $idasign);
    $filasUpdate = $stmt->execute();
    $conn->commit();
    if ($filasUpdate == 0) {
        echo "<script>alert('La operacion  ha fallado')</script>";
    } else {
        echo "<script>alert('La operacion se ha realizado correctamente')</script>";
    }

    include('selectAsignaturas.php');
} catch (PDOException $ex) {
    $conn->rollback();
    echo $ex->getMessage();
}
