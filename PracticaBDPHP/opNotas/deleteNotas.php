<?php

$idalumno = $_REQUEST['idalumno'];
$idasignatura = $_REQUEST['idasignatura'];

$conn->where("ID_ALUMNO", $idalumno);
$conn->where("ID_ASIGNATURA", $idasignatura);
if ($conn->delete('NOTAS'))
    echo "<script>alert('Se ha borrado correctamente');</script>";
else
    echo "<script>alert('No se ha podido borrar ');</script>";
?>