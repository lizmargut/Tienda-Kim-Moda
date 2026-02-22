<?php
session_start();
require_once "conexion.php";

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $usuario = $conexion->real_escape_string($_POST['user']);
    $pass    = $conexion->real_escape_string($_POST['password']);

    // CONSULTA CORREGIDA CON JOIN
    $sql = "SELECT e.emp_id, 
                   e.emp_usuario, 
                   e.emp_contrasenia,
                   e.emp_nombre,
                   e.emp_apellido,
                   f.fun_descripcion
            FROM empleados e
            INNER JOIN funciones f ON e.fun_id = f.fun_id
            WHERE e.emp_usuario = '$usuario'
            LIMIT 1";

    $res = $conexion->query($sql);

    if ($res->num_rows > 0) {

        $fila = $res->fetch_assoc();

        // Comparación directa (porque tu contraseña no está encriptada)
        if ($fila['emp_contrasenia'] === $pass) {

            // GUARDAR DATOS EN SESIÓN
            $_SESSION['emp_id']            = $fila['emp_id'];
            $_SESSION['emp_nombre']        = $fila['emp_nombre'];
            $_SESSION['emp_apellido']      = $fila['emp_apellido'];
            $_SESSION['usuario']           = $fila['emp_usuario'];
            $_SESSION['fun_descripcion']   = $fila['fun_descripcion'];

            header("Location: panel.php");
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
    <title>Login - KIM MODA</title>
    <link rel="stylesheet" href="css/estilos3.css?v=1">
</head>
<body>

<img src="img/logo.jpg" alt="Logo">

<div id="Formulario">
    <form action="" method="POST" autocomplete="off">
        <input type="text" name="user" required placeholder="Usuario"><br><br>
        <input type="password" name="password" required placeholder="Contraseña"><br><br>
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