<?php
session_start(); // Inicio sesión

if (isset($_SESSION['nombre'])) {
    $nombre   = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $rol      = $_SESSION['rol'];
} else {
    $nombre = "Invitado";
    $apellido = "";
    $rol = "Usuario";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIM MODA</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- HEADER RESPONSIVE -->
<header class="bg-dark text-white py-4 shadow">
    <div class="container">

        <div class="row align-items-center">

            <!-- Título -->
            <div class="col-12 col-md-6 text-center text-md-start">
                <h1 class="fw-bold mb-0">KIM MODA</h1>
                <p class="mb-0">
                    Bienvenido 
                    <strong><?= $rol ?></strong>
                </p>
            </div>

            <!-- Usuario -->
            <div class="col-12 col-md-6 text-center text-md-end mt-3 mt-md-0">
                <span class="badge bg-warning text-dark fs-6">
                    <?= $nombre . " " . $apellido ?>
                </span>
            </div>

        </div>

        <hr class="border-light my-3">

        <div class="text-center text-md-start">
            <h5 class="fw-light">Gestión de Productos</h5>
        </div>

    </div>
</header>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
