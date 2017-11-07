<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ page import="utils.Constantes" %>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>JSP Page</title>
        <script>

            function cargarAlumno(id, nombre, fecha, mayor) {
                document.getElementById("idalumno").value = id;
                document.getElementById("idnombre").value = nombre;
                document.getElementById("fecha").value = fecha;
                document.getElementById("mayor").checked = mayor;
            }

            function actualizar() {
                document.getElementById("accion").value = "actualizar";
            }
            function insertar() {
                document.getElementById("accion").value = "insertar";
            }
            function borrar() {
                document.getElementById("accion").value = "borrar";
            }
        </script>
    </head>
    <body>
        <h1>ALUMNOS</h1>
        <c:out value="${mensaje}"></c:out>
        <table border="1">
            <c:forEach items="${alumnos}" var="alumno">  
                <tr>
                    <td>
                        <input type="button" value="Cargar ${alumno.id}" 
                               onclick="cargarAlumno('${alumno.id}', '${alumno.nombre}', '<fmt:formatDate value="${alumno.fecha_nacimiento}" pattern="dd-MM-yyyy"/>', ${alumno.mayor_edad});"/>
                    </td> 
                    <td>
                        ${alumno.nombre}
                    </td>

                    <td>
                        <fmt:formatDate value="${alumno.fecha_nacimiento}" pattern="dd-MM-yyyy"/>
                    </td>

                    <td>
                        <input type="checkbox" <c:if test="${alumno.mayor_edad}" >checked</c:if> />
                        </td>
                    </tr>


            </c:forEach> 

        </table>
        <br>
        <form id="formulario" target = "/alumnos" method="GET">
            <input type="hidden" id="idalumno" name="idalumno" />
            <input type="text" id="idnombre" size="12" name="idnombre" />
            <input type="text" id="fecha" size="12" name="fecha"/>
            <input type="checkbox" id="mayor" name="mayor" />
            <input type="hidden" id="accion" name="accion" value="">
            <br>
            <br>
            <button onclick="actualizar()">Actualizar</button>
            <button onclick="insertar()">Insertar</button>
            <button onclick="borrar()">Borrar</button>
        </form>
        <!request.getSession().setAttribute(Constantes.ATTRIBUTE_NAME, nivel); ->
    </body>
</html>
