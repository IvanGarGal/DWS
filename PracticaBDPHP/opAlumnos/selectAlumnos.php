<?php
$sqlSelect = "SELECT * FROM ALUMNOS";
if (!$result = $conn->query($sqlSelect)) {
    die('There was an error running the query [' . $conn->error . ']');
}

$result->num_rows;
?>
<input type="button" value="Asignaturas" onclick="window.location.href = 'asignaturas.php'" />
<input type="button" value="Notas" onclick="window.location.href = 'notas.php'" />
<h1>Alumnos</h1>
<table border="1">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td>
                <input type="button" value="cargar <?php echo $row['ID'] ?>" 
                       onclick="cargarAlumno('<?php echo $row['ID'] ?>',
                                       '<?php
                       if (strpos($row['NOMBRE'], "'") !== false)
                           echo addslashes($row['NOMBRE']);
                       else
                           echo htmlspecialchars($row['NOMBRE'])
                           ?>',
                                       '<?php echo $row['FECHA_NACIMIENTO'] ?>',
    <?php echo $row['MAYOR_EDAD'] ?>);"/>
            </td>
            <td>
    <?php echo $row['NOMBRE']; ?>
            </td>
            <td>
                <?php
                $fecha = new DateTime($row['FECHA_NACIMIENTO']);
                echo $fecha->format("d-m-Y");
                ?>
            </td>
            <td>
                <input type="checkbox"
                <?php
                if ($row['MAYOR_EDAD'] == TRUE) {
                    echo "checked";
                }
                ?> />     



            </td>
        </tr>


        <?php
    }

    $result->free();
    ?>
</table>

