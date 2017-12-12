<%-- 
    Document   : pintarListaAlumnos
    Created on : Oct 28, 2017, 8:02:42 PM
    Author     : Miguel Palomares
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <title>JSP Page</title>
        <script>

            function cargarAsignatura(id, nombre, ciclo, curso) {
                document.getElementById("nombre").value = nombre;
                document.getElementById("id").value = id;
                document.getElementById("ciclo").value = ciclo;
                document.getElementById("curso").value = curso;

            }


            function addAsignatura() {
                document.usuarios.action = 'asignaturas?op=INSERT';
                document.usuarios.submit();

            }
            function updAsignatura() {
                document.usuarios.action = 'asignaturas?op=UPDATE';
                document.usuarios.submit();
            }
            function rmAsignatura() {
                document.usuarios.action = 'asignaturas?op=REMOVE';
                document.usuarios.submit();

            }
        </script>
    </head>
    <body>
        <div class="container">
            <h1>ASIGNATURAS</h1>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Ciclo</th>
                        <th>Curso</th>
                    </tr>
                </thead>
                <tbody>
                    <c:forEach items="${asignaturas}" var="asignatura">  
                        <tr>
                            <td>
                                <input type="button" class="btn btn-primary" value="cargar ${asignatura.id}" onclick="cargarAsignatura('${asignatura.id}', '${asignatura.nombre}', '${asignatura.ciclo}', '${asignatura.curso}');"/>
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
                </tbody>
            </table>

            <form name="usuarios" action="asignaturas?op=INSERT" method="POST">
                <input type="hidden" id="id" name="id" />
                <div class="form-group col-sm-4">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" size="12" class="form-control" id="nombre" name="nombre" placeholder="nombre"/>
                </div>
                <div class="form-group col-sm-4">
                    <label for="ciclo">Ciclo:</label>
                    <input type="text" id="ciclo" size="12" class="form-control" name="ciclo" placeholder="ciclo"/>
                </div>
                <div class="form-group col-sm-4">
                    <label for="curso">Curso:</label>
                    <input type="text" id="curso" class="form-control" size="12" name="curso" placeholder="curso"/>
                </div>
                <div class="col-sm-12">
                    <input type="button" class="btn btn-primary" value="añadir" onclick="addAsignatura()">
                    <input type="button" class="btn btn-warning" value="actualizar" onclick="updAsignatura()">
                    <input type="button" class="btn btn-danger" value="eliminar" onclick="rmAsignatura()"> 
                </div>
            </form>
            <div class="col-md-12">
                <c:if test = "${number_state eq 1}">
                    <div class="alert alert-success">
                        <strong>Correcto!</strong> ${requestScope.estado}
                    </div>
                </c:if>
                <c:if test = "${number_state eq 0}">
                    <div class="alert alert-danger">
                        <strong>Error!</strong> ${requestScope.estado}
                    </div>
                </c:if>
            </div>
            <div class="col-md-12">
                <h3>Seleciona a la página a la que quieres ir</h3>
                <a href="alumnos">Alumnos</a>
                <a href="notas?op=GETALL">Notas</a>
                <a href="unLogin">Cerrar sesion</a>
            </div>
        </div>
    </body>
</html>
