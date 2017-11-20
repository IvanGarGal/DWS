<%-- 
    Document   : pintarListaNotas
    Created on : 14-nov-2017, 9:28:01
    Author     : daw
--%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> NOTAS </title>
        <script src="funciones.js"></script>
    </head>
    <body>
        <h2> NOTAS </h2>

        <span>ALUMNO: </span>
        <select id="alumno" onchange="cargarAlumno(this.value, this.options[this.selectedIndex].innerHTML)">
            <option disabled selected>Elige un alumno</option>
            <option disabled> ------------ </option>
            <c:forEach items="${alumnos}" var="alumno">
                <option value="${alumno.id}" name="${alumno.nombre}">${alumno.nombre}</option>
            </c:forEach>
        </select>

        <span>ASIGNATURA: </span>
        <select id="asignatura" onchange="cargarAsignatura(this.value, this.options[this.selectedIndex].innerHTML)">
            <option disabled selected>Selecciona una asignatura</option>
            <option disabled> ------------ </option>
            <c:forEach items="${asignaturas}" var="asignatura">
                <option value="${asignatura.id}">${asignatura.nombre}</option>
            </c:forEach>
        </select>
        <br>
        <br>
        <br>
        <form action="notas">
            <table>
                <tr>
                    <td>
                        Alumno
                        <br>
                        <input type="hidden" id="idAlumno" name="idAlumno" size="1" value="${idAlu}">
                        <input type="text" name="nombreAlumno" id="nombreAlumno" value="${nomAlu}">
                    </td>
                    <td>
                        Asignatura
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
                        <button onclick="guardar()"> GUARDAR </button>
                        <button onclick="borrar()"> BORRAR </button>
                    </td>
                </tr>
            </table>
        </form>
        <br>
        <h3><c:out value="${mensaje}"></c:out></h3>
    </body>
</html>
