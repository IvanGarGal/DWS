<%-- 
    Document   : lineas
    Created on : 19-ene-2018, 9:13:23
    Author     : IvanGarGal
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
        <title>LINEAS</title>
    </head>
    <body>
        <h1>LINEAS</h1>
        <h3><c:out value="${mensaje}"></c:out> </h3>
        <table border="1">   
            <tr>
                <td> <b> Etiqueta </b></td>
                <td> <b> Direccion A </b> </td>
                <td> <b> Direccion B </b> </td>
            </tr>
            <c:forEach items="${lines}" var="line">           
            <tr onclick="location = 'http://localhost:8080/ApiEMT/EMTApiParada?line=${line.line}'">
                <td> ${line.label}</td>
                <td> ${line.nameA}</td>
                <td> ${line.nameB}</td>
            </tr>    
            </c:forEach>
        </table>
    </body>
</html>
