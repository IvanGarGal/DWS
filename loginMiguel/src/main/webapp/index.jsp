<%-- 
    Document   : index
    Created on : 04-dic-2017, 12:43:29
    Author     : Miguel Palomares
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <title>Acceso</title>
    </head>
    <body>
        <div class="container">
            <h2>Acceso</h2>

            <form class="form-horizontal" action="login?action=acceder" method="POST"> 
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Nombre:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="correo" name="nombre" placeholder="Introduce el nombre">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">Contraseña:</label>
                    <div class="col-md-4">          
                        <input type="password" class="form-control" id="pwd" name="password" placeholder="Introduce la contraseña">
                    </div>
                </div>
                <div class="form-group">        
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Acceder</button>
                    </div>
                </div>
                <a href="registro.jsp">Registrarse</a>
            </form>
        </div>
    </body>
</html>
