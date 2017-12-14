<?php
try {
    $id = $_REQUEST['idalumno'];

    $nombre =htmlspecialchars($_REQUEST['nombre']);

    if (isset($_REQUEST['mayor'])) {
        $mayor = TRUE;
    } else {
        $mayor = 0;
    }

    $fecna = new DateTime($_REQUEST['fecna']);
    $fecha = $fecna->format("Y-m-d");


    $stmt = $conn->prepare("UPDATE ALUMNOS SET NOMBRE = ?, FECHA_NACIMIENTO = ?, MAYOR_EDAD = ? WHERE ID = ?");
    $stmt->bind_param("sssi", $nombre, $fecha, $mayor, $id);
    $filasUpdate = $stmt->execute();

    if ($filasUpdate == 1) {
        echo "<script>alert('La operacion se ha realizado correctamente')</script>";
    } else {
        echo "<script>alert('La operacion  ha fallado')</script>";
    }
    include('selectAlumnos.php');
} catch (mysqli_sql_exception $ex) {
    echo $ex->Message();
}
?>

