<%-- 
    Document   : paradas
    Created on : 19-ene-2018, 9:13:35
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
        <title>PARADAS</title>
    </head>
    <body>
        <h1>PARADAS</h1>
        <h3><c:out value="${mensaje}"> </c:out> </h3>
        <table border="1">  
            <tr>
                <td> <b> Número parada </b> </td>
                <td> <b> Nombre </b> </td>
            </tr>
            <c:forEach items="${paradas}" var="parada">           
            <tr onclick="location = 'http://localhost:8080/ApiEMT/EMTApiTiempo?stop=${parada.node}'">
                <td> ${parada.node}</td>
                <td> ${parada.name}</td>
            </tr>    
            </c:forEach>
        </table>
    </body>
</html>