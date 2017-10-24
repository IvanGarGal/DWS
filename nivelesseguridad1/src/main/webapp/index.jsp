<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%@taglib  prefix = "c" uri="http://java.sun.com/jsp/jstl/core"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>SEGURIDAD</title>
    </head>
    <body>      
    <c:set var = "acertado" scope = "request" value = "${acertado}"/>
    
    <c:if test = "${acertado eq 'acierto'}">
        <h1> ACIERTO </h1>
    </c:if>
    <c:if test = "${acertado eq 'continua'}">
        <h1> CONTINUA </h1>
    </c:if>
    <c:if test = "${acertado eq 'error'}">
        <h1> ERROR </h1>
    </c:if>
</body>
</html>
