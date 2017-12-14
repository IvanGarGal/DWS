<?php

$idalumno = $_REQUEST['idalumno'];
$idasignatura = $_REQUEST['idasignatura'];
$nota = $_REQUEST['nota'];
$data = Array("ID_ALUMNO" => $idalumno,
    "ID_ASIGNATURA" => $idasignatura,
    "NOTA" => $nota
);
$id = $conn->insert('NOTAS', $data);
if ($id)
    echo "<script>alert('Se ha insertado correctamente');</script>";
else
    echo "<script>alert('No se ha podido insertar ');</script>";

$notainsert = $nota;
$alumnNota = $idalumno;
$asigNota = $idasignatura;
?>