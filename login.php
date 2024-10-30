<!-- 
    Autor: Daniel Salanova Dmitriyev
    DNI: 49610682G
-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Estimazon</title>
    <!-- Enlace a los estilos de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .card-login {
            max-width: 400px;
            margin: auto;
            margin-top: 100px;
        }

        .navbar {
            background-color: #343a40;
        }

        .navbar-light .navbar-nav .nav-link {
            color: #ffffff;
        }

        .footer {
            background-color: #343a40;
            color: #ffffff;
        }

        .product-details {
            max-width: 800px;
            margin: auto;
            margin-top: 20px;
        }

        .product-image-container {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product-image-container img {
            width: 100%;
            height: auto;
        }

        .comments-section {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .comment-form {
            margin-bottom: 20px;
        }

        .similar-products-section {
            margin-top: 20px;
        }

        .carousel-item {
            display: flex;
        }

        .similar-product {
            width: 150px;
        }

        .similar-product img {
            width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <?php
    //Para las alertas de creación
    if (isset($_GET["estado"])) {
        $estado = $_GET["estado"];
        if ($estado == "0") {
            echo "<script>alert('Error en el nombre o contraseña');</script>";
        } elseif ($estado == "1") {
            echo "<script>alert('Se ha hecho iniciado sesión correctamente correctamente');</script>";
            header("Location: home.php");
        }
    }
    ?>
    <header>
        <!-- Barra de Navegación -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="./home.php">Estimazon</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCart" aria-controls="navbarCart" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCart" aria-controls="navbarCart" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">

                    <?php
                    if (isset($_COOKIE["usuario"])) {
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link">Logeado con ' . $_COOKIE["usuario"] . "</a>";
                        echo '</li>';
                        echo '<li class="nav_item">';
                        echo '<a class="nav-link" href="./account/closeAccount.php">Cerrar Sesión</a>';
                        echo '</li>';
                    } else {
                        echo '<li class="nav_item">';
                        echo '<a class="nav-link" href="./login.php">Inicio de Sesión</a>';
                        echo '</li>';
                        echo '<li class="nav_item">';
                        echo '<a class="nav-link" href="./register.php">Registrarse</a>';
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>


        </nav>
    </header>
    <main class="container">
        <a href="./home.php" class="btn btn-outline-secondary mt-4">&larr; Volver</a>
        <div class="card card-login mt-4">
            <div class="card-body">
                <h5 class="card-title text-center">Iniciar Sesión</h5>
                <form action="./account/loginAccount.php" method="get">
                    <div class="form-group">
                        <label for="role">Rol</label>
                        <select class="form-control" id="tipo" name="tipo" required>
                            <option value="comprador">Comprador</option>
                            <option value="vendedor">Vendedor</option>
                            <option value="controlador">Controlador</option>
                            <option value="repartidor">Repartidor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingrese su nombre de usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </main>

    <footer class="footer py-3 bg-dark text-white">
        <div class="container text-center">
            <p>&copy; 2023 Estimazon</p>
        </div>
    </footer>

    <!-- Enlace a los scripts de Bootstrap (jQuery y Popper.js son necesarios) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>