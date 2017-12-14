<%-- 
    Document   : pintarListaAsignaturas
    Created on : 07-nov-2017, 9:44:08
    Author     : Miguel Angel Diaz
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ taglib prefix="c" 
           uri="http://java.sun.com/jsp/jstl/core" %>
<%@taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/style.css">
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
        <nav class="navbar navbar-inverse" style="border-radius: 0">
            <div class="container-fluid">
                <div style=" margin-right: 100px" class="navbar-header">
                    <span style="cursor: default" class="navbar-brand"><strong><c:out value="${nombreUsuario}"></c:out></strong></span>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="/sesion/alumnos">Alumnos</a></li>
                    <li class="active"><a style="cursor: default; pointer-events: none" href="#">Asignaturas</a></li>
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
                <h1>Asignaturas</h1>
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
                <h3><c:out value="${mensaje}"></c:out></h3>
                <table class="table table-striped">
                    <tr style="font-weight: bold">
                        <td></td>
                        <td>NOMBRE</td>
                        <td>CICLO</td>
                        <td>CURSO</td>
                    </tr>
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
            </div>
        </div>
        <c:if test="${errorBorrar != null}">
            <script>
                var borrarnotas = confirm("${errorBorrar}" + "\n¿Quieres continuar?");
                if (borrarnotas == true) {
                    document.getElementById("accion").value = "borrar2";
                    document.getElementById("idasignatura").value = "${idAsignatura}";
                    document.formulario.submit();
                }
            </script>
        </c:if>
    </body>
</html>
