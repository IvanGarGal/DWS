<%-- 
    Document   : newjsp
    Created on : 16-oct-2017, 12:59:35
    Author     : DAW
--%>
<%@page import="utils.Constantes"%>

import utils.Constantes;
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Superado</title>
    </head>
    <body>
        <%
            if (request.getSession().getAttribute(Constantes.ATTRIBUTE_NAME).equals("3")) {
                out.println("<h1> Reto conseguido </h1>");
            } else {
                out.println("<h1> Paso completado </h1>");
            }
        %>

    </body>
</html>
