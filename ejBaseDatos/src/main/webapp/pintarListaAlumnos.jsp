<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ taglib prefix="c" 
           uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ page import="utils.Constantes" %>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> Alumnos </title>
        <script src="funciones.js"></script>
    </head>
    <body>
        <h1>ALUMNOS</h1>
        <table border="1">
            <c:forEach items="${alumnos}" var="alumno">  
                <tr>
                    <td>
                        <input type="button" value="Cargar ${alumno.id}" 
                               onclick="cargarAlumno('${alumno.id}', '${alumno.nombre}'
                                   , '<fmt:formatDate value="${alumno.fecha_nacimiento}" pattern="dd-MM-yyyy"/>'
                                   , ${alumno.mayor_edad});"/>
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
        <form id="formulario" action = "alumnos" method="GET">
            <input type="hidden" id="idalumno" name="idalumno" />
            <input type="text" id="nombre" name="nombre" size="12"/>
            <input type="text" id="fecha" name="fecha" size="12"/>
            <input type="checkbox" id="mayor" name="mayor"/>
            <input type="hidden" id="accion" name="accion" value="">
            <br>
            <br>
            <button id="actualizar" onclick="actualizarAccion();" value="actualizar" disabled>Actualizar</button>
            <button id="insertar" onclick="insertarAccion()">Insertar</button>
            <button id="borrar" onclick="borrarAccion()" disabled>Borrar</button>
        </form>

    </body>
</html>
