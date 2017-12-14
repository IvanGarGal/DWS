<%-- 
    Document   : pintarListaAlumnos
    Created on : Oct 28, 2017, 8:02:42 PM
    Author     : Miguel Angel Diaz
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ taglib prefix="c" 
           uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<%@taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/style.css">

        <title>JSP Page</title>
        <script>

            function cargarAlumno(id, nombre, fecha, mayor) {
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
        <nav class="navbar navbar-inverse" style="border-radius: 0">
            <div class="container-fluid">
                <div style=" margin-right: 100px" class="navbar-header">
                    <span style="cursor: default" class="navbar-brand"><strong><c:out value="${nombreUsuario}"></c:out></strong></span>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a style="cursor: default; pointer-events: none" href="#">Alumnos</a></li>
                    <li><a href="/sesion/asignaturas">Asignaturas</a></li>
                    <li><a href="/sesion/notas">Notas</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="/users?accion=logout"><span class="glyphicon glyphicon-log-out"></span> Cerrar sesión</a>
                    </li>
                </ul>
            </div>
        </nav>
            <div class="container">
                <div class="col-xs-8 col-xs-offset-2">
                    <h1>ALUMNOS</h1>
                
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

                    <h3><c:out value="${mensaje}"></c:out></h3>

                    <table class="table table-striped">
                        <tr style="font-weight: bold">
                            <td></td>
                            <td>NOMBRE</td>
                            <td>FECHA DE NACIMIENTO</td>
                            <td>MAYOR DE EDAD</td>
                        </tr>
                        <c:forEach items="${alumnos}" var="alumno">  
                            <tr>
                                <td>
                                    <input type="button" value="Cargar ${alumno.id}" style="width:100px"
                                           onclick="cargarAlumno('${alumno.id}', '${fn:escapeXml(fn:replace(alumno.nombre,"'", "\\'"))}'
                                                           , '<fmt:formatDate value="${alumno.fecha_nacimiento}" pattern="dd-MM-yyyy"/>'
                                                           , ${alumno.mayor_edad});"/>
                                </td> 
                                <td>${alumno.nombre}</td>
                                <td><fmt:formatDate value="${alumno.fecha_nacimiento}" pattern="dd-MM-yyyy"/></td>
                                <td><input type="checkbox" <c:if test="${alumno.mayor_edad}" >checked</c:if> /></td>
                                </tr>
                        </c:forEach>                   
                    </table>
                </div>
            </div>
        <c:if test="${errorBorrar != null}">
            <script>
                var borrarnotas = confirm("${errorBorrar}" + "\n¿Quieres continuar?");
                if (borrarnotas == true) {
                    document.getElementById("accion").value = "borrar2";
                    document.getElementById("idalumno").value = "${idAlumno}";
                    //Le paso la fecha tambien porque si no da error en el servlet
                    //Si está vacia no puede hacer el parse a local date
                    document.getElementById("fecha").value = "${fecha}";
                    document.formulario.submit();
                }
            </script>
        </c:if>
    </body>
</html>
