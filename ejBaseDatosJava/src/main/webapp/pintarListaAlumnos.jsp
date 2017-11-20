<%-- 
    Document   : pintarListaAlumnos
    Created on : 10-nov-2017, 18:34:01
    Author     : daw
--%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ page import="utils.Constantes" %>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> ALUMNOS </title>
        <script src="funciones.js"></script>
    </head>
    <body>
        <h2> ALUMNOS </h2>
        <h3><c:out value="${mensaje}"></c:out></h3>
        <table border="1">
            <c:forEach items="${alumnos}" var="alumno">  
                <tr>
                    <td>
                        <input type="button" value="Cargar ${alumno.id}" 
                               onclick="cargarAlumno('${alumno.id}'
                                   , '${fn:escapeXml(fn:replace(alumno.nombre,"'", "\\'"))}'
                                   , '<fmt:formatDate value="${alumno.fecha_nacimiento}" pattern="dd-MM-yyyy"/>'
                                   , ${alumno.mayor_edad});"
                        />
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
            <br>
            <button id="actualizar" onclick="actualizarAccion();" value="actualizar" disabled> ACTUALIZAR </button>
            <button id="insertar" onclick="insertarAccion()"> INSERTAR </button>
            <button id="borrar" onclick="borrarAccion()" disabled> BORRAR </button>
        </form>
        <c:if test="${errorBorrar != null}">
            <script>
                var borrarnotas = confirm("${errorBorrar}" + "\n¿DESEAS CONTINUAR?");
                if (borrarnotas == true) {
                    document.getElementById("accion").value = "borrar2";
                    document.getElementById("idalumno").value = "${alumno.id}";
                    document.getElementById("nombre").value = "${alumno.nombre}";
                    document.getElementById("fecha").value = "${fecha}";
                    document.getElementById("mayor").value = "${alumno.mayor_edad}";
                    document.formulario.submit();
                }
            </script>
        </c:if>
    </body>
</html>
