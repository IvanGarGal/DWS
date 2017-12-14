<?php

$idalumno = $_REQUEST['idalumno'];
$idasignatura = $_REQUEST['idasignatura'];

$conn->where("ID_ALUMNO", $idalumno);
$conn->where("ID_ASIGNATURA", $idasignatura);
$notaSelect = $conn->getOne("NOTAS");

$alumnNota = $idalumno;
$asigNota = $idasignatura;
?>