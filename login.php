<?php
session_start();
require_once "conexion.php";

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $usuario = $conexion->real_escape_string($_POST['user']);
    $pass = $conexion->real_escape_string($_POST['password']);

    // Consulta en la tabla empleados
    $sql = "SELECT emp_id, emp_usuario, emp_contrasenia, fun_id 
            FROM empleados 
            WHERE emp_usuario = '$usuario' LIMIT 1";

    $res = $conexion->query($sql);

    if ($res->num_rows > 0) {
        $fila = $res->fetch_assoc();

        // Validar contraseña EXACTA (ya que en tu BD no están encriptadas)
        if ($fila['emp_contrasenia'] === $pass) {

            // Guardar datos en la sesión
            $_SESSION['usuario'] = $fila['emp_usuario'];
            $_SESSION['emp_id'] = $fila['emp_id'];
            $_SESSION['rol'] = $fila['fun_id'];   // 3: Admin - 4: Vendedor

            header("Location: panel.php");  // Cambiar a tu página principal
            exit;

        } else {
            $mensaje = "❌ Contraseña incorrecta";
        }

    } else {
        $mensaje = "❌ Usuario no encontrado";
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
    <form action="" method="POST"> 
        <input type="text" name="user" id="user" required placeholder="Usuario"><br><br>
        <input type="password" name="password" id="password" placeholder="Contraseña" required><br><br>
        <input type="submit" value="Login" id="login">
    </form>

    <?php if ($mensaje != "") { ?>
        <p style="color:red; text-align:center; font-weight:bold;">
            <?= $mensaje ?>
        </p>
    <?php } ?>
</div>

</body>
</html>
