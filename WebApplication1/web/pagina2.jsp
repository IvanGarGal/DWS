<%-- 
    Document   : pagina2
    Created on : 03-oct-2017, 10:40:59
    Author     : daw
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>JSP Page</title>
    </head>
    <body>
        <h1> HOLA PÁGINA 2 </h1>
        <p> <%=session.getAttribute("usuario")%> </p>
    </body>
</html>
