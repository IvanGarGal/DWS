<%-- 
    Document   : pintarListaAlumnos
    Created on : Oct 28, 2017, 8:02:42 PM
    Author     : oscar
--%>

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

            function cargarAsignatura(id, nombre, ciclo, curso) {
                document.getElementById("nombre").value = nombre;
                document.getElementById("id").value = id;
                document.getElementById("ciclo").value = ciclo;
                document.getElementById("curso").value = curso;

            }

            
            function addAsignatura() {
                document.usuarios.action='asignaturas?op=INSERT';
                document.usuarios.submit();
                
            }
            function updAsignatura() {
                document.usuarios.action='asignaturas?op=UPDATE';
                document.usuarios.submit();
            }
            function rmAsignatura() {
                document.usuarios.action='asignaturas?op=REMOVE';
                document.usuarios.submit();
                
            }
        </script>
    </head>
    <body>
        <h1>ASIGNATURAS</h1>
        pruebaCTE: <%= Constantes.PRUEBA%> <br>
        <table border="1">
            <c:forEach items="${asignaturas}" var="asignatura">  
                <tr>
                    <td>
                        <input type="button" value="cargar ${asignatura.id}" onclick="cargarAsignatura('${asignatura.id}', '${asignatura.nombre}','${asignatura.ciclo}','${asignatura.curso}');"/>
                    </td> 
                    <td>
                        ${asignatura.nombre}
                    </td>
                    <td>
                        ${asignatura.ciclo}
                    </td>
                    <td>
                        ${asignatura.curso}
                    </td>
            </c:forEach> 

        </table>

        <form name="usuarios" action="asignaturas?op=INSERT" method="POST">
            <input type="hidden" id="id" name="id" />
            <input type="text" id="nombre" size="12" name="nombre" placeholder="nombre"/>
            <input type="text" id="ciclo" size="12" name="ciclo" placeholder="ciclo"/>
            <input type="text" id="curso" size="12" name="curso" placeholder="curso"/>
            <input type="button" value="añadir" onclick="addAsignatura()">
            <input type="button" value="actualizar" onclick="updAsignatura()">
            <input type="button" value="eliminar" onclick="rmAsignatura()">           
        </form>



    </body>
</html>
