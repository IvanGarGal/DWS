<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ taglib prefix="c" 
           uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>JSP Page</title>
        <script>

            function cargarAlumnos(id, nombre, fecha, mayor) {
                document.getElementById("idalumno").value = id;
                document.getElementById("nombre").value = nombre;
                document.getElementById("fecha").value = fecha;
                document.getElementById("mayor").checked = mayor;
                document.getElementById("actualizar").disabled = false;
                document.getElementById("borrar").disabled = false;
                document.getElementById("insertar").disabled = true;
            }

            function actualizarAccion() {
                document.getElementById("accion").value = "actualizar";
            }
            function insertarAccion() {
                document.getElementById("accion").value = "insertar";
            }
            function borrarAccion() {
                document.getElementById("accion").value = "borrar";
            }
        </script>
    </head>
    <body>
        <h1>ALUMNOS</h1>
        <h3><c:out value="${mensaje}"></c:out></h3>

            <table border="1">
            <c:forEach items="${alumnos}" var="alumno">  
                <tr>
                    <td>
                        <input type="button" value="Cargar ${alumno.id}" style="width:100px"
                               onclick="cargarAlumnos('${alumno.id}', '${fn:escapeXml(fn:replace(alumno.nombre,"'", "\\'"))}'
                                               , '<fmt:formatDate value="${alumno.fecha_nacimiento}" pattern="dd-MM-yyyy"/>'
                                               , ${alumno.mayor_edad});"/>
                    </td> 
                    <td>${alumno.nombre}</td>
                    <td><fmt:formatDate value="${alumno.fecha_nacimiento}" pattern="dd-MM-yyyy"/></td>
                    <td><input type="checkbox" <c:if test="${alumno.mayor_edad}" >checked</c:if> /></td>
                    </tr>
            </c:forEach>                   
        </table>

        <br>
        <form id="formulario" name="formulario" action = "alumnos" method="GET">
            <input type="hidden" id="idalumno" name="idalumno" />
            <input type="text" id="nombre" name="nombre" size="12"/>
            <input type="text" id="fecha" name="fecha" size="12"/>
            <input type="checkbox" id="mayor" name="mayor"/>
            <input type="hidden" id="accion" name="accion" value="">
            <br>
            <br>
            <button id="actualizar" onclick="actualizarAccion()" disabled>Actualizar</button>
            <button id="insertar" onclick="insertarAccion()">Insertar</button>
            <button id="borrar" onclick="borrarAccion()" disabled>Borrar</button>
        </form>
        <c:if test="${errorBorrar != null}">
            <script>
                var borrarnotas = confirm("${errorBorrar}" + "\n¿Quieres continuar?");
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
