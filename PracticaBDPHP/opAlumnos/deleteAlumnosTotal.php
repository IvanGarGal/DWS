<?php

try {
    $conn->autocommit(false);
    $idal = $_REQUEST['idal'];

    $stmtNota = $conn->prepare("DELETE FROM NOTAS WHERE ID_ALUMNO = ?");
    $stmtNota->bind_param("i", $idal);
    $stmtNota->execute();
    $stmt = $conn->prepare("DELETE FROM ALUMNOS WHERE ID = ?");
    $stmt->bind_param("i", $idal);
    $filasDelete = $stmt->execute();
    $conn->commit();

    if ($conn->errno != 0) {
        echo "<script>alert('La operacion  ha fallado')</script>";
        $conn->rollback();
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
