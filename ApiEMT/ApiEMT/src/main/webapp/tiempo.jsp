<%-- 
    Document   : tiempo
    Created on : 19-ene-2018, 9:13:49
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
        <title>TIEMPO</title>
    </head>
    <body>
        <h1>TIEMPO</h1>
        <h3><c:out value="${mensaje}"> </c:out> </h3>
        <table border="1">   
            <tr>
                <td> <b> Número Linea </b> </td>
                <td> <b> Destino </b> </td>
                <td> <b> Número Bus </b> </td>
                <td> <b> Tiempo de llegada (segundos) <br> Si es todo 9 es más de 20 minutos </b> </td>
                <td> <b> Distancia</b> </td>
                <td> <b> Latitud </b> </td>
                <td> <b> Longitud </b> </td>
                <td> <b> Posición Bus </b> </td>
            </tr>
            <c:forEach items="${tiempos}" var="tiempo">
            <tr>
                <td> ${tiempo.lineId}</td>
                <td> ${tiempo.destination}</td>
                <td> ${tiempo.busId}</td>
                <td> ${tiempo.busTimeLeft}</td>
                <td> ${tiempo.busDistance}</td>
                <td> ${tiempo.latitude}</td>
                <td> ${tiempo.longitude}</td>
                <td> ${tiempo.busPositionType}</td>
            </tr>    
            </c:forEach>
        </table>
    </body>
</html>