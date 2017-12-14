<?php

$idalumno = $_REQUEST['idalumno'];
$idasignatura = $_REQUEST['idasignatura'];
$nota = $_REQUEST['nota'];

$data = Array("NOTA" => $nota);

$conn->where("ID_ALUMNO", $idalumno);
$conn->where("ID_ASIGNATURA", $idasignatura);

$filaUpdate = $conn->update("NOTAS", $data);



if ($filaUpdate == 1)
    echo "<script>alert('Se ha modificado correctamente');</script>";
else
    echo "<script>alert('No se ha podido modificar ');</script>";

$notaupdate = $nota;
$alumnNota = $idalumno;
$asigNota = $idasignatura;
?>