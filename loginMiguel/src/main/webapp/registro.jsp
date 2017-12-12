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
        <title>Registro</title>
    </head>
    <body>
        <div class="container">
            <h2>Registro</h2>

            <form class="form-horizontal" action="registro" method="POST">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">Nombre:</label>
                    <div class="col-md-4">          
                        <input type="text" class="form-control"  placeholder="Introduce el nombre" name="nombre">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Correo electrónico</label>
                    <div class="col-md-4">
                        <input type="email" class="form-control" id="correo" name="correo" placeholder="Introduce el correo">
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
                        <button type="submit" class="btn btn-primary">Registrarse</button>
                    </div>
                </div>
                <p style="color: green">${requestScope.mensaje}</p>
            </form>
        </div>
    </body>
</html>
