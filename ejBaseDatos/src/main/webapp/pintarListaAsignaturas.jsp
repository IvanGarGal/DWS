<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ taglib prefix="c" 
           uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@ page import="utils.Constantes" %>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> Asignaturas </title>
        <script src="funciones.js"></script>
    </head>
    <body>
        <h1>ALUMNOS</h1>
        <table border="1">
            <c:forEach items="${asignaturas}" var="asignatura">  
                <tr>
                    <td>
                        <input type="button" value="Cargar ${asignatura.id}" 
                               onclick="cargarAsignatura('${asignatura.id}', '${asignatura.nombre}'
                                   , '${asignatura.curso}', '${asignatura.ciclo})';"/>
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
            <button id="actualizar" onclick="actualizarAccion();" value="actualizar" disabled>Actualizar</button>
            <button id="insertar" onclick="insertarAccion()">Insertar</button>
            <button id="borrar" onclick="borrarAccion()" disabled>Borrar</button>
        </form>

    </body>
</html>