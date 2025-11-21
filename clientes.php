<?php
include("conexion.php");

// =========================
//   AGREGAR CLIENTE
// =========================
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $domicilio = $_POST['domicilio'];
    $email = $_POST['email'];

    $sql = "INSERT INTO clientes (cli_nombre, cli_apellido, cli_tel, cli_domicilio, cli_email)
            VALUES ('$nombre', '$apellido', '$telefono', '$domicilio', '$email')";
    mysqli_query($conexion, $sql);

    echo "<script>alert('Cliente agregado correctamente'); window.location='clientes.php';</script>";
}

// =========================
//   ELIMINAR CLIENTE
// =========================
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    $sql = "DELETE FROM clientes WHERE cli_id = $id";
    mysqli_query($conexion, $sql);

    echo "<script>alert('Cliente eliminado correctamente'); window.location='clientes.php';</script>";
}

// =========================
//   EDITAR CLIENTE
// =========================
if (isset($_POST['editar'])) {
    $id = $_POST['cli_id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $domicilio = $_POST['domicilio'];
    $email = $_POST['email'];

    $sql = "UPDATE clientes SET 
                cli_nombre='$nombre',
                cli_apellido='$apellido',
                cli_tel='$telefono',
                cli_domicilio='$domicilio',
                cli_email='$email'
            WHERE cli_id=$id";

    mysqli_query($conexion, $sql);

    echo "<script>alert('Cambios guardados correctamente'); window.location='clientes.php';</script>";
}

// =========================
//   CONSULTA PRINCIPAL
// =========================
$consulta = mysqli_query($conexion, "SELECT * FROM clientes")
            or die("Error en la consulta: " . mysqli_error($conexion));

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <link rel="stylesheet" href="css/clientes.css">
</head>
<body>

<h2 class="titulo">🌸 Gestión de Clientes</h2>
<a href="panel.php" class="btnVolver">⬅ Volver</a>

<!-- FORMULARIO AGREGAR CLIENTE -->
<div class="form-container">
    <form action="" method="POST">
        <h3>Agregar Cliente</h3>

        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido" placeholder="Apellido" required>
        <input type="text" name="telefono" placeholder="Teléfono" required>
        <input type="text" name="domicilio" placeholder="Domicilio" required>
        <input type="email" name="email" placeholder="Email" required>

        <button type="submit" name="agregar" class="btn-agregar">Agregar</button>
    </form>
</div>

<!-- TABLA DE CLIENTES -->
<div class="tabla-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Teléfono</th>
            <th>Domicilio</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>

        <?php while ($fila = mysqli_fetch_assoc($consulta)) { ?>
        <tr>
            <td><?= $fila['cli_id'] ?></td>
            <td><?= $fila['cli_nombre'] ?></td>
            <td><?= $fila['cli_apellido'] ?></td>
            <td><?= $fila['cli_tel'] ?></td>
            <td><?= $fila['cli_domicilio'] ?></td>
            <td><?= $fila['cli_email'] ?></td>

            <td>
                <button class="btn-editar"
                    onclick="editarCliente(
                        '<?= $fila['cli_id'] ?>',
                        '<?= $fila['cli_nombre'] ?>',
                        '<?= $fila['cli_apellido'] ?>',
                        '<?= $fila['cli_tel'] ?>',
                        '<?= $fila['cli_domicilio'] ?>',
                        '<?= $fila['cli_email'] ?>'
                    )">
                    Editar
                </button>

                <a href="clientes.php?eliminar=<?= $fila['cli_id'] ?>" 
                   class="btn-eliminar" 
                   onclick="return confirm('¿Eliminar cliente?')">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- MODAL EDITAR -->
<div id="modal" class="modal">
    <div class="modal-content">
        <h3>Editar Cliente</h3>

        <form method="POST" action="">
            <input type="hidden" name="cli_id" id="edit_id">

            <input type="text" name="nombre" id="edit_nombre" required>
            <input type="text" name="apellido" id="edit_apellido" required>
            <input type="text" name="telefono" id="edit_telefono" required>
            <input type="text" name="domicilio" id="edit_domicilio" required>
            <input type="email" name="email" id="edit_email" required>

            <button type="submit" name="editar" class="btn-agregar">Guardar Cambios</button>
            <button type="button" class="btn-cerrar" onclick="cerrarModal()">Cancelar</button>
        </form>
    </div>
</div>

<script>
function editarCliente(id, nombre, apellido, tel, domicilio, email) {
    document.getElementById("modal").style.display = "block";
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_nombre").value = nombre;
    document.getElementById("edit_apellido").value = apellido;
    document.getElementById("edit_telefono").value = tel;
    document.getElementById("edit_domicilio").value = domicilio;
    document.getElementById("edit_email").value = email;
}

function cerrarModal() {
    document.getElementById("modal").style.display = "none";
}
</script>

</body>
</html>
