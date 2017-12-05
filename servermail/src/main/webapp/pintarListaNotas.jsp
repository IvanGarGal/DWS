<%-- 
    Document   : pintarListaNotas
    Created on : 10-nov-2017, 11:53:58
    Author     : Miguel Angel Diaz
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ taglib prefix="c" 
           uri="http://java.sun.com/jsp/jstl/core" %>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>JSP Page</title>
        <script>
            function cargarAlumno(id, nombre) {
                document.getElementById("idAlumno").value = id;
                document.getElementById("nombreAlumno").value = nombre;
            }
            function cargarAsignatura(id, nombre) {
                document.getElementById("idAsignatura").value = id;
                document.getElementById("nombreAsignatura").value = nombre;
            }
            function guardar() {
                document.getElementById("accion").value = "guardar";
            }
            function borrar() {
                document.getElementById("accion").value = "borrar";
            }
            function cargar() {
                document.getElementById("accion").value = "cargar";
            }

        </script>
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
        <br>
        <h3><c:out value="${mensaje}"></c:out></h3>
    </body>
</html>
