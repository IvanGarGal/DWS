<!DOCTYPE html>
<html>
    <body>
        <table style="width:50%">
            <tr>
                <th>
                    <form action="" method="POST">

                        <label>Nombre:</label>  <br>
                        <input type="text" placeholder="Introduce el nombre" name="nombre"> <br> <br>

                        <label for="pwd">Contraseña:</label>  <br>
                        <input type="password" id="password" name="password" placeholder="Introduce la contraseña"> <br> <br>

                        <button name="login" value="ACCESO">Acceso</button>
                    </form>
                </th> 
                <th>
                    <form action="registro" method="POST">

                        <label>Nombre:</label>  <br>     
                        <input type="text" placeholder="Introduce el nombre" name="nombre"> <br> <br>

                        <label>Correo electrónico</label> <br>
                        <input type="email" id="correo" name="correo" placeholder="Introduce el correo"> <br> <br>

                        <label>Contraseña:</label>  <br>      
                        <input type="password" id="password" name="password" placeholder="Introduce la contraseña"> <br> <br>

                        <button name="registro" id="registro" value="REGISTRO">Registrarse</button>
                    </form>
                </th> 
            </tr>
        </table>
    </body>
</html>
