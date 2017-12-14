<?php
$stmt = $conn->prepare("SELECT * FROM ASIGNATURAS");

$stmt->setFetchMode(PDO::FETCH_ASSOC);

$stmt->execute();
?>
<input type="button" value="Alumnos" onclick="window.location.href = 'alumnos.php'" />
<input type="button" value="Notas" onclick="window.location.href = 'notas.php'" />

<h1>Asignaturas</h1>
<table border="1">
    <?php while ($row = $stmt->fetch()) { ?>
        <tr>
            <td>
                <input type="button" value="cargar <?php echo $row['id'] ?>" 
                       onclick="cargarAlumno('<?php echo $row['id'] ?>',
                                       '<?php
                       if (strpos($row['NOMBRE'], "'") !== false)
                           echo addslashes($row['NOMBRE']);
                       else
                           echo htmlspecialchars($row['NOMBRE']);
                       ?>',
                                       '<?php
                       if (strpos($row['CURSO'], "'") !== false)
                           echo addslashes($row['CURSO']);
                       else
                           echo htmlspecialchars($row['CURSO']);
                       ?>',
                                       '<?php
                   if (strpos($row['CICLO'], "'") !== false)
                       echo addslashes($row['CICLO']);
                   else
                       echo htmlspecialchars($row['CICLO']);
                   ?>');
                       "/>
            </td>
            <td>
    <?php echo $row['NOMBRE']; ?>
            </td>
            <td>
                <?php
                echo $row['CURSO'];
                ?>
            </td>
            <td>
        <?php
        echo $row['CICLO'];
        ?>   
            </td>
        </tr>


<?php }
?>
</table>