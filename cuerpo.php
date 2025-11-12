<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - KIN MODA</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

       

        .productos {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            justify-content: center;
            align-items: start;
            padding: 0 20px;
            margin: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .card h3 {
            color: #222;
            margin: 10px 0;
        }

        .card p {
            color: #555;
            font-size: 0.9rem;
            padding: 0 10px;
            min-height: 50px;
        }

        .info {
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .precio {
            color: #28a745;
        }

        .stock {
            color: #007bff;
        }

        .categoria {
            display: inline-block;
            margin: 10px 0 15px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            color: white;
        }

        .femenino {
            background-color: #e83e8c;
        }

        .masculino {
            background-color: #007bff;
        }

        .unisex {
            background-color: #17a2b8;
        }
    </style>
</head>
<body>


    <section class="productos">

        <!-- Producto 1 -->
        <div class="card">
            <img src="img/blusa.jpeg" alt="Blusa Elegante">
            <h3>Blusa Elegante</h3>
            <p>Blusa de seda con diseño elegante para ocasiones especiales.</p>
            <div class="info">
                <span class="precio">$49.99</span>
                <span class="stock">Stock: 15</span>
            </div>
            <span class="categoria femenino">Femenino</span>
        </div>

        <!-- Producto 2 -->
        <div class="card">
            <img src="img/remera.jpeg" alt="Remera Casual">
            <h3>Remera Casual</h3>
            <p>Remera de algodón para uso diario, muy cómoda y fresca.</p>
            <div class="info">
                <span class="precio">$39.99</span>
                <span class="stock">Stock: 20</span>
            </div>
            <span class="categoria masculino">Masculino</span>
        </div>

        <!-- Producto 3 -->
        <div class="card">
            <img src="img/jeans.jpeg" alt="Jeans Clásicos">
            <h3>Jeans Clásicos</h3>
            <p>Jeans de corte recto para cualquier ocasión.</p>
            <div class="info">
                <span class="precio">$59.99</span>
                <span class="stock">Stock: 30</span>
            </div>
            <span class="categoria unisex">Unisex</span>
        </div>

    </section>

</body>
</html>
