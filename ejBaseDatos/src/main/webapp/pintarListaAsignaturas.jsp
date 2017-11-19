<%-- 
    Document   : pintarListaAsignaturas
    Created on : 10-nov-2017, 18:35:29
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
        <title> ASIGNATURAS </title>
        <script src="funciones.js"></script>
    </head>
    <body>
        <h2> ASIGNATURAS </h2>
        <table border="1">
            <c:forEach items="${asignaturas}" var="asignatura">  
                <tr>
                    <td>
                        <input type="button" value="Cargar ${asignatura.id}" 
                               onclick="cargarAsignatura('${asignatura.id}'
                                   , '${fn:escapeXml(fn:replace(asignatura.nombre,"'", "\\'"))}'
                                   , '${fn:escapeXml(fn:replace(asignatura.ciclo,"'", "\\'"))}'
                                   , '${fn:escapeXml(fn:replace(asignatura.curso,"'", "\\'"))}';"
                        />
                    </td> 
                    <td>
                        ${asignatura.nombre}
                    </td>

                    <td>
                        ${asignatura.curso}
                    </td>

                    <td>
                        ${asignatura.ciclo}
                    </td>
                </tr>


            </c:forEach> 

        </table>
        <br>
        <form id="formulario" action = "asignaturas" method="GET">
            <input type="hidden" id="idasignatura" name="idasignatura" />
            <input type="text" id="nombre" name="nombre" size="12"/>
            <input type="text" id="curso" name="fecha" size="12"/>
            <input type="text" id="ciclo" name="fecha" size="12"/>
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
                    document.getElementById("idasignatura").value = "${asignatura.id}";
                    document.getElementById("nombre").value = "${asignatura.nombre}";
                    document.getElementById("ciclo").value = "${asignatura.ciclo}";
                    document.getElementById("curso").value = "${asignatura.curso}";
                    document.formulario.submit();
                }
            </script>
        </c:if>
    </body>
</html>