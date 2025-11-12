<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Login</title>
    <!-- Vinculo con el CSS -->
    <link rel="stylesheet" href="css/estilos3.css?v=1">
</head>
<body>
    <br>
    <br>
    <!-- <h1>Formulario de logeo</h1> -->
    
    <!-- Imagen -->
    <img src="img/logo.jpg" alt="Logo de la página">

    <!-- Formulario -->
    <div id="Formulario">
        <form action="productosAdministrar.php" method="post"> 
            <input type="text" name="user" id="user" required placeholder="Usuario"><br><br>
            <input type="password" name="password" id="password" placeholder="Contraseña" required><br><br>
            <input type="submit" value="Login" id="login">
        </form> 
    </div>  
</body>
</html>