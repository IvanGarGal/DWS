<?php

try {
    $nombre = htmlspecialchars($_REQUEST['nombre']);
    if (isset($_REQUEST['mayor'])) {
        $mayor = 1;
    } else {
        $mayor = 0;
    }

    $fecna = new DateTime($_REQUEST['fecna']);
    $fecha = $fecna->format("Y-m-d");

    $stmt = $conn->prepare("INSERT INTO ALUMNOS (NOMBRE,FECHA_NACIMIENTO,MAYOR_EDAD) VALUES(?,?,?)");
    $stmt->bind_param("sss", $nombre, $fecha, $mayor);
 

    $insert = $stmt->execute();
 
    if ($insert == 0) {
        echo "<script>alert('No se ha podido insertar el alumno')</script>";
    } else {
        echo "<script>alert('Insertado correctamente')</script>";
    }

    include('selectAlumnos.php');
} catch (mysqli_sql_exception $ex) {
    echo $ex . Message();
}
?>
