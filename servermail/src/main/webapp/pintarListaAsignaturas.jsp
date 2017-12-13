<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ taglib prefix="c" 
           uri="http://java.sun.com/jsp/jstl/core" %>
<%@taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ page import="utils.Constantes" %>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>JSP Page</title>
        <script>
            function cargarAsignatura(id, nombre, ciclo, curso) {
                document.getElementById("idasignatura").value = id;
                document.getElementById("nombre").value = nombre;
                document.getElementById("ciclo").value = ciclo;
                document.getElementById("curso").value = curso;
                document.getElementById("actualizar").disabled = false;
                document.getElementById("borrar").disabled = false;
                document.getElementById("insertar").disabled = true;
            }
            function accionActualizar() {
                document.getElementById("accion").value = "actualizar";
            }
            function accionInsertar() {
                document.getElementById("accion").value = "insertar";
            }
            function accionBorrar() {
                document.getElementById("accion").value = "borrar";
            }
        </script>
    </head>
    <body>
        <h1>Asignaturas</h1>
        <h3><c:out value="${mensaje}"></c:out></h3>
            <table border="1">
            <c:forEach items="${asignaturas}" var="asignatura">
                <tr>
                    <td><input type="button" value="Cargar ${asignatura.id}" style="width:100px" onclick="cargarAsignatura('${asignatura.id}',
                                    '${fn:escapeXml(fn:replace(asignatura.nombre,"'", "\\'"))}', '${fn:escapeXml(fn:replace(asignatura.ciclo,"'", "\\'"))}',
                                    '${fn:escapeXml(fn:replace(asignatura.curso,"'", "\\'"))}')"></td>
                    <td>${asignatura.nombre}</td>
                    <td>${asignatura.ciclo}</td>
                    <td>${asignatura.curso}</td>
                </tr>
            </c:forEach>
        </table>
        <br>
        <form name="formulario" action="asignaturas">
            <input type="hidden" id="idasignatura" name="idasignatura">
            <input type="text" id="nombre" name="nombre">
            <input type="text" id="ciclo" name="ciclo">
            <input type="text" id="curso" name="curso">
            <input type="hidden" id="accion" name="accion">
            <br>
            <br>
            <button id="actualizar" onclick="accionActualizar()" disabled>Actualizar</button>
            <button id="insertar" onclick="accionInsertar()">Insertar</button>
            <button id="borrar" onclick="accionBorrar()" disabled>Borrar</button>
        </form>
        <c:if test="${errorBorrar != null}">
            <script>
                var borrarnotas = confirm("${errorBorrar}" + "\n¿Quieres continuar?");
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
