<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    session_start(); // inicio la sesion
    if(isset($_SESSION['nombre'])){ // si se encuntra el signo !: es para preguntar si esta seteado el nombre de la sesion
     $nombre = $_SESSION['nombre'];
    $apellido= $_SESSION['apellido'];
    $rol= $_SESSION['rol'];
}
   $rol = "pepito"
?>
<header>
    <h1>KIM MODA</h1>
    <h3>Bienvenida Dueña</h3> 
    
    <br/>
    <h5 style= "font-family: 22px; font-style: Open Sans; text-align: left;">Gestión de Productos</h5>    
</header>
    
</body>
</html>