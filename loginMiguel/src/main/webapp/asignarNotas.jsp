<%-- 
    Document   : asignarNotas
    Created on : 13-nov-2017, 12:20:22
    Author     : Miguel Palomares
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@ taglib uri = "http://java.sun.com/jsp/jstl/core" prefix = "c" %>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <title>Notas</title>
        <script>
            function cargarAlumno() {
                console.log("cargando alumno");
                //document.getElementById("asigId").value = asigId;
                var e = document.getElementById("alumnos");
                var alumnoId = e.options[e.selectedIndex].value;
                document.getElementById("alumnoId").value = alumnoId;
            }

            function cargarAsig() {
                var e = document.getElementById("asignaturas");
                var asigId = e.options[e.selectedIndex].value;
                document.getElementById("asigId").value = asigId;
            }

            function cargar() {
                var idAlumno = document.getElementById("alumnoId").value;
                var idAsig = document.getElementById("asigId").value;
                $.post('notas?op=notas', {
                    alumnoId: idAlumno,
                    asigId: idAsig

                }, function (data) {
                    document.getElementById("nota").value = data;
                });
            }

            function updNota() {
                document.notas.action = 'notas?op=UPDATE';
                console.log("actualizar nota");
                document.notas.submit();
            }
            function rmNota() {
                document.notas.action = 'notas?op=REMOVE';
                document.notas.submit();
            }
        </script>
    </head>
    <body>
        <h1>Notas</h1>
        <form  method="POST" name="notas">
            <select id="alumnos" onclick="cargarAlumno()">
                <c:forEach items="${alumnos}" var="alumno">
                    <option value="${alumno.id}">${alumno.nombre}</option>
                </c:forEach>
            </select>

            <select id="asignaturas" onclick="cargarAsig()">
                <c:forEach items="${asignaturas}" var="asignatura">
                    <option value="${asignatura.id}">${asignatura.nombre}</option>
                </c:forEach>
            </select>
            <input type="text" placeholder="nota" id="nota" name="nota">
            <input type="hidden" id="alumnoId" name="alumnoId">
            <input type="hidden" id="asigId"  name="asigId">
            <input type="button" class="btn btn-primary" value="Cargar" onclick="cargar()">
            <input type="button" class="btn btn-danger" value="Eliminar" onclick="rmNota()">
            <input type="button" class="btn btn-warning" value="Actualizar" onclick="updNota()">
        </form>
        <p style="color: green">${requestScope.resultado}</p>
    </body>

    <h3>Seleciona a la página a la que quieres ir</h3>
    <a href="alumnos">Alumnos</a>
    <a href="asignaturas">Asignaturas</a>
    <a href="unLogin">Cerrar sesion</a>
</html>
