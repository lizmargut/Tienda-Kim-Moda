<?php
session_start();
require_once "conexion.php";

// Verificar si el usuario ha iniciado sesión y tiene permisos para ver esta página
// (Implementa tu lógica de autenticación y autorización aquí)

// Obtener el ID del pedido de la URL
$pedido_id = isset($_GET['pedido_id']) && is_numeric($_GET['pedido_id']) ? (int)$_GET['pedido_id'] : 0;

// Si no se proporciona un ID de pedido válido, mostrar un mensaje de error
if ($pedido_id <= 0) {
    echo "<script>alert('Error: ID de pedido inválido.'); window.location='ventas.php';</script>";
    exit;
}

// Procesar el formulario de devolución (si se ha enviado)
if (isset($_POST['procesar_devolucion'])) {
    // Recuperar los datos del formulario
    $prod_id = (int)$_POST['prod_id'];
    $cantidad_devuelta = (int)$_POST['cantidad_devuelta'];
    $motivo_devolucion = $conexion->real_escape_string($_POST['motivo_devolucion']);
    $dev_plazo = $conexion->real_escape_string($_POST['dev_plazo']); // Nuevo campo

    // Validar los datos
    if ($prod_id <= 0 || $cantidad_devuelta <= 0) {
        echo "<script>alert('Error: Datos inválidos.');</script>";
    } else {
        // Iniciar transacción para asegurar la integridad de los datos
        $conexion->begin_transaction();
        try {
            // 1. Obtener información del detalle de venta
            $sql_detalle = "SELECT cantidad FROM detalledeventas WHERE pedido_id = $pedido_id AND prod_id = $prod_id";
            $result_detalle = $conexion->query($sql_detalle);
            if (!$result_detalle) {
                throw new Exception("Error al obtener el detalle de venta: " . $conexion->error);
            }
            $row_detalle = $result_detalle->fetch_assoc();
            $cantidad_original = $row_detalle['cantidad'];

            // 2. Verificar si la cantidad devuelta es válida
            if ($cantidad_devuelta > $cantidad_original) {
                throw new Exception("Error: La cantidad devuelta excede la cantidad original.");
            }

            // 3. Actualizar el stock del producto
            $sql_update_stock = "UPDATE productos SET prod_stock = prod_stock + $cantidad_devuelta WHERE prod_id = $prod_id";
            if (!$conexion->query($sql_update_stock)) {
                throw new Exception("Error al actualizar el stock: " . $conexion->error);
            }

            // 4. Registrar la devolución en la tabla de devoluciones
            $sql_insert_devolucion = "INSERT INTO devoluciones (pedido_id, dev_fecha, dev_plazo, dev_motivo) VALUES ($pedido_id, NOW(), '$dev_plazo', '$motivo_devolucion')";
            if (!$conexion->query($sql_insert_devolucion)) {
                throw new Exception("Error al registrar la devolución: " . $conexion->error);
            }

             // 5. Actualizar la cantidad en detalledeventas (si es necesario)
             $nueva_cantidad = $cantidad_original - $cantidad_devuelta;
             if ($nueva_cantidad > 0) {
                 $sql_update_detalle = "UPDATE detalledeventas SET cantidad = $nueva_cantidad WHERE pedido_id = $pedido_id AND prod_id = $prod_id";
             } else {
                 // Si la cantidad es 0, eliminar el registro de detalledeventas
                 $sql_update_detalle = "DELETE FROM detalledeventas WHERE pedido_id = $pedido_id AND prod_id = $prod_id";
             }
             if (!$conexion->query($sql_update_detalle)) {
                 throw new Exception("Error al actualizar el detalle de venta: " . $conexion->error);
             }


            // Confirmar la transacción
            $conexion->commit();

            echo "<script>alert('Devolución procesada correctamente.');</script>";
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $conexion->rollback();
            echo "<script>alert('Error al procesar la devolución: " . addslashes($e->getMessage()) . "');</script>";
        }
    }
}

// Obtener la lista de productos en el pedido
$sql_productos = "
    SELECT dv.prod_id, p.prod_nombre, dv.cantidad
    FROM detalledeventas dv
    JOIN productos p ON dv.prod_id = p.prod_id
    WHERE dv.pedido_id = $pedido_id
";
$result_productos = $conexion->query($sql_productos);

if (!$result_productos) {
    echo "<script>alert('Error al obtener los productos del pedido: " . $conexion->error . "'); window.location='ventas.php';</script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Devoluciones</title>
    <link rel="stylesheet" href="css/devoluciones.css">
</head>
<body>

    <div class="container">
        <h1>Devoluciones</h1>

        <h2>Pedido #<?php echo $pedido_id; ?></h2>

        <form method="POST" class="devolucion-form">
            <label for="prod_id">Producto a Devolver:</label>
            <select name="prod_id" id="prod_id" required>
                <option value="" disabled selected>Seleccione un Producto</option>
                <?php
                if ($result_productos && $result_productos->num_rows > 0) {
                    while ($row_producto = $result_productos->fetch_assoc()) {
                        echo "<option value='" . $row_producto['prod_id'] . "'>" . htmlspecialchars($row_producto['prod_nombre']) . " (Cantidad: " . $row_producto['cantidad'] . ")</option>";
                    }
                } else {
                    echo "<option value='' disabled>No hay productos en este pedido</option>";
                }
                ?>
            </select>

            <label for="cantidad_devuelta">Cantidad a Devolver:</label>
            <input type="number" name="cantidad_devuelta" id="cantidad_devuelta" required>

            <label for="dev_plazo">Plazo de Devolución:</label>
            <input type="text" name="dev_plazo" id="dev_plazo" required>

            <label for="motivo_devolucion">Motivo de la Devolución:</label>
            <textarea name="motivo_devolucion" id="motivo_devolucion" rows="4" required></textarea>

            <button type="submit" name="procesar_devolucion" class="btn-procesar">Procesar Devolución</button>
            <button type="button" onclick="window.location.href='ventas.php'" class="btn-volver">Volver</button>


        </form>
    </div>

    <!-- Implementar la visualización de las devoluciones ya procesadas aquí -->
     
</body>
</html>