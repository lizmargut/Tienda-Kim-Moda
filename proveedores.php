<?php
include("conexion.php");

// ----- AGREGAR PROVEEDOR -----
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $sql = "INSERT INTO proveedores (prov_nombre, prov_apellido, prov_telefono, prov_direccion)
            VALUES ('$nombre', '$apellido', '$telefono', '$direccion')";

    if (mysqli_query($conexion, $sql)) {
        echo "<script>alert('✔ Proveedor agregado correctamente'); window.location='proveedores.php';</script>";
    } else {
        echo "<script>alert('❌ Error al agregar proveedor');</script>";
    }
}

// ----- ELIMINAR PROVEEDOR -----
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];

    $sql = "DELETE FROM proveedores WHERE prov_id = $id";

    if (mysqli_query($conexion, $sql)) {
        echo "<script>alert('✔ Proveedor eliminado correctamente'); window.location='proveedores.php';</script>";
    } else {
        echo "<script>alert('❌ Error al eliminar proveedor');</script>";
    }
}

// ----- EDITAR PROVEEDOR -----
if (isset($_POST['editar'])) {
    $id = $_POST['prov_id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $sql = "UPDATE proveedores SET
            prov_nombre='$nombre',
            prov_apellido='$apellido',
            prov_telefono='$telefono',
            prov_direccion='$direccion'
            WHERE prov_id=$id";

    if (mysqli_query($conexion, $sql)) {
        echo "<script>alert('✔ Datos actualizados correctamente'); window.location='proveedores.php';</script>";
    } else {
        echo "<script>alert('❌ Error al actualizar');</script>";
    }
}

// Consulta principal
$consulta = mysqli_query($conexion, "SELECT * FROM proveedores")
            or die("Error en consulta: " . mysqli_error($conexion));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proveedores</title>
    <link rel="stylesheet" href="css/proveedores.css">
</head>
<body>
<a href="panel.php" class="btnVolver">⬅ Volver</a>
<h2 class="titulo">Gestión de Proveedores</h2>

<div class="form-container">
    <form action="" method="POST">
        <h3>Agregar Proveedor</h3>

        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido" placeholder="Apellido" required>
        <input type="text" name="telefono" placeholder="Teléfono" required>
        <input type="text" name="direccion" placeholder="Dirección" required>

        <button type="submit" name="agregar">Agregar</button>
    </form>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Teléfono</th>
        <th>Dirección</th>
        <th>Acciones</th>
    </tr>

    <?php while ($fila = mysqli_fetch_assoc($consulta)): ?>
    <tr>
        <td><?= $fila['prov_id'] ?></td>
        <td><?= $fila['prov_nombre'] ?></td>
        <td><?= $fila['prov_apellido'] ?></td>
        <td><?= $fila['prov_telefono'] ?></td>
        <td><?= $fila['prov_direccion'] ?></td>

        <td>
            <!-- Editar -->
            <button class="btnEditar"
                onclick="editarProveedor(
                    '<?= $fila['prov_id'] ?>',
                    '<?= $fila['prov_nombre'] ?>',
                    '<?= $fila['prov_apellido'] ?>',
                    '<?= $fila['prov_telefono'] ?>',
                    '<?= $fila['prov_direccion'] ?>'
                )">Editar</button>

            <!-- Eliminar -->
            <a href="proveedores.php?eliminar=<?= $fila['prov_id'] ?>" class="btnEliminar" onclick="return confirm('¿Eliminar proveedor?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- MODAL EDITAR -->
<div id="modal" class="modal">
    <div class="modal-content">
        <h3>Editar Proveedor</h3>

        <form method="POST" action="">
            <input type="hidden" name="prov_id" id="edit_id">

            <input type="text" name="nombre" id="edit_nombre" required>
            <input type="text" name="apellido" id="edit_apellido" required>
            <input type="text" name="telefono" id="edit_telefono" required>
            <input type="text" name="direccion" id="edit_direccion" required>

            <button type="submit" name="editar">Guardar Cambios</button>
            <button type="button" class="cerrar" onclick="cerrarModal()">Cancelar</button>
        </form>
    </div>
</div>

<script>
function editarProveedor(id, nombre, apellido, telefono, direccion) {
    document.getElementById("modal").style.display = "block";
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_nombre").value = nombre;
    document.getElementById("edit_apellido").value = apellido;
    document.getElementById("edit_telefono").value = telefono;
    document.getElementById("edit_direccion").value = direccion;
}

function cerrarModal() {
    document.getElementById("modal").style.display = "none";
}
</script>

</body>
</html>
