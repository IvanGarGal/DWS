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

            function cargarAlumno(id, nombre, fecha, mayor) {
                document.getElementById("nombre").value = nombre;
                document.getElementById("idalumno").value = id;

            }


            function addUsuario() {
                document.usuarios.action = 'alumnos?op=INSERT';
                document.usuarios.submit();

            }
            function updUsuario() {
                console.log("update");
                document.usuarios.action = 'alumnos?op=UPDATE';
                document.usuarios.submit();
            }
            function rmUsuario() {
                document.usuarios.action = 'alumnos?op=REMOVE';
                document.usuarios.submit();

            }
        </script>
    </head>
    <body>
        <div class="container">
            <h1>ALUMNOS</h1>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Fecha nacimiento</th>
                        <th>Mayor de edad</th>
                    </tr>
                </thead>
                <tbody>
                    <c:forEach items="${alumnos}" var="alumno">  
                        <tr>
                            <td>
                                <input type="button" class="btn btn-primary" value="cargar ${alumno.id}" onclick="cargarAlumno('${alumno.id}', '${alumno.nombre}', '<fmt:formatDate value="${alumno.fecha_nacimiento}" pattern="dd-MM-yyyy"/>',${alumno.mayor_edad});"/>
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
                </tbody>
            </table>

            <form name="usuarios" action="alumnos?op=insertar" method="POST">
                <input type="hidden" id="idalumno" name="idAlumno" />
                <div class="form-group col-sm-4">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" class="form-control" size="12" name="nombre"/>
                </div>
                <div class="form-group col-sm-4">
                    <label for="nombre">Fecha nacimiento</label>
                    <input type="date" class="form-control" name="fecha_nac">
                </div>
                <div class="col-sm-12">
                    <input type="button" class="btn btn-primary" value="añadir" onclick="addUsuario()">
                    <input type="button" class="btn btn-warning" value="actualizar" onclick="updUsuario()">
                    <input type="button" class="btn btn-danger"value="eliminar" onclick="rmUsuario()">     
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
                <a href="asignaturas">Asignaturas</a>
                <a href="notas?op=GETALL">Notas</a>
                <a href="unLogin">Cerrar sesion</a>
            </div>
        </div>
    </body>

</html>
