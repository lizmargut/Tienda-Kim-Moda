<?php
//inicia codigo php
session_start();
//inicio sesion para guardar datos
require_once "conexion.php";

$mensaje = "";
//variable para guardar mensaje de error o estado

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //ingresa cuando el usuario presiona login

    $usuario = $conexion->real_escape_string($_POST['user']);
    $pass = $conexion->real_escape_string($_POST['password']);

    // Consulta en la tabla empleados
    $sql = "SELECT emp_id, emp_usuario, emp_contrasenia, fun_id 
            FROM empleados 
            WHERE emp_usuario = '$usuario' LIMIT 1";
            //que solo devuelve 1 registro

    $res = $conexion->query($sql);//ejecuta la consulta y $res es respuesta

    if ($res->num_rows > 0) {//si es que existe
        $fila = $res->fetch_assoc();//obtiene datos del usuario como arreglo asociativo

        // Validar contraseña EXACTA (ya que en tu BD no están encriptadas)
        if ($fila['emp_contrasenia'] === $pass) {//comparacion de constraseña ingresada con la de la base de datos

            // Guardar datos en la sesión
            $_SESSION['usuario'] = $fila['emp_usuario'];
            $_SESSION['emp_id'] = $fila['emp_id'];
            $_SESSION['rol'] = $fila['fun_id'];   // 3: Admin - 4: Vendedor

            header("Location: panel.php");  // redirige a tu página principal
            exit;//detiene la ejecución del script

        } else {
            $mensaje = "❌ Contraseña incorrecta";//si no existe la contraseña
        }

    } else {
        $mensaje = "❌ Usuario no encontrado";//si no existe el usuario
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/estilos3.css?v=1">
</head>
<body>

<img src="img/logo.jpg" alt="Logo">

<div id="Formulario">
    <form action="" method="POST" autocomplete="off">
    <input type="text" name="user" id="user" required placeholder="Usuario" autocomplete="off"><br><br>
    <input type="password" name="password" id="password" required placeholder="Contraseña" autocomplete="new-password"><br><br>
    <input type="submit" value="Login" id="login">
    <!-- boton para enviar el formulario -->
    </form>

    <?php if ($mensaje != "") { ?>
        <!-- solo muestra mensaje si hay error -->
        <p style="color:red; text-align:center; font-weight:bold;">
            <?= $mensaje ?>
        </p>
    <?php } ?>
</div>

</body>
</html>
