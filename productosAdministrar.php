<?php
$usuario = "administrador"
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mi negocio</title>
        <link rel="stylesheet" href="css/estilos.css">
    </head>
    <body>
        <section id="contenedor">
          <?php
          include "encabezado.php";
          include_once "menu.php";
          require "cuerpo.php";
          include "pie.php";

          ?>
        </section>
        
    </body>
</html>