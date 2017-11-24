<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Notas</h1>
        <span>Alumno: </span>
        <select id="alumno" onchange="cargarAlumno(this.value, this.options[this.selectedIndex].innerHTML)">
            <option disabled selected>Selecciona un alumno</option>
            <option disabled>-------------------------</option>
            <c:forEach items="${alumnos}" var="alumno">
                <option value="${alumno.id}" name="${alumno.nombre}">${alumno.nombre}</option>
            </c:forEach>
        </select>

        <span>Asignatura: </span>
        <select id="asignatura" onchange="cargarAsignatura(this.value, this.options[this.selectedIndex].innerHTML)">
            <option disabled selected>Selecciona una asignatura</option>
            <option disabled>-------------------------</option>
            <c:forEach items="${asignaturas}" var="asignatura">
                <option value="${asignatura.id}">${asignatura.nombre}</option>
            </c:forEach>
        </select>
        <br>
        <br>
        <br>
        <form action="notas">
            <table style="text-align:center">
                <tr>
                    <td>
                        ALUMNO
                        <br>
                        <input type="hidden" id="idAlumno" name="idAlumno" size="1" value="${idAlu}">
                        <input type="text" name="nombreAlumno" id="nombreAlumno" value="${nomAlu}">
                    </td>
                    <td>
                        ASIGNATURA
                        <br>
                        <input type="hidden" id="idAsignatura" name="idAsignatura" size="1" value="${idAsig}">
                        <input type="text" name="nombreAsignatura" id="nombreAsignatura" value="${nomAsig}">
                    </td>
                    <td>
                        <br>
                        <button onclick="cargar()">Cargar</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        NOTA <input type="text" value="${nota.nota}" id="nota" name="nota" size="1">
                    </td>
                    <td>
                        <br>
                        <input type="hidden" id="accion" name="accion" value="">
                        <button onclick="guardar()">Guardar</button>
                        <button onclick="borrar()">Borrar</button>
                    </td>
                </tr>
            </table>
        </form>
        <h3>
            <?php
            if ($mostrarMensaje == true) {
                echo $mensaje;
            }
            ?>
        </h3>
    </body>
</html>
