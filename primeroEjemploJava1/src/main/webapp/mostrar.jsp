<%@page import="java.util.Map.Entry"%>
<%@page import="java.util.Map"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title> PALABRAS DE COLORES </title>
    </head>
    <body>
        <h1> OBSERVA LAS PALABRAS </h1>
        <%
            Map<String,String[]> parameters = request.getParameterMap();
            for (Entry <String,String[]> parametros : parameters.entrySet()) { 
                String nombre = parametros.getKey();
                String[] valor = parametros.getValue();
                String letra = nombre.substring(0,1);
         %>
         <h1 style="color: <% out.println(nombre); %>">
             <%
                 if(letra.equals("r")){
                    out.println(nombre + " ==> " + valor[0]);
                 }
                 else{
                  out.println("EMPIEZA POR LA LETRA R/r");
                 }
             %> 
        </h1>
         <%}%>
    </body>
</html>
