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

    <link rel="stylesheet" href="css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css" integrity="sha512-6p+GTq7fjTHD/sdFPWHaFoALKeWOU9f9MPBoPnvJEWBkGS4PKVVbCpMps6IXnTiXghFbxlgDE8QRHc3MU91lJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" integrity="sha512-pVCM5+SN2+qwj36KonHToF2p1oIvoU3bsqxphdOIWMYmgr4ZqD3t5DjKvvetKhXGc/ZG5REYTT6ltKfExEei/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

        <div class="navigationBar">
            <a href="#" class="logo"><i class="ri-store-3-fill"></i><span>Estimazon</span></a>
            <ul class="itemsBar">
                <li><a href="./home.php" class="active">Home</a></li>
                <li><a href="./graficas.php">Estadísticas</a></li>
                <li><a href="https://www.uib.cat/">Universidad</a></li>
            </ul>
            <div class="logins">


                <a href="#" id="cart-icon"><i class="ri-shopping-cart-line"></i></a>


                <?php
                if (isset($_COOKIE["usuario"])) {
                    echo '<a href="#" class="user"><i class="ri-user-line"></i>' . $_COOKIE["usuario"] . '</a>';
                    echo '<a href="./account/closeAccount.php">Cerrar Sesión</a>';
                } else {
                    echo '<a href="./login.php" class="user"><i class="ri-user-line"></i>Iniciar Sesión</a>';
                    echo '<a href="./register.php">Registrarse</a>';
                }
                ?>

                <div class="bx bx-menu" id="menu-icon"></div>
            </div>
        </div>

        <div class="itemsCart h-auto w-50">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_COOKIE["carrito"])) {
                        include 'Test/config.php';

                        $array = json_decode($_COOKIE["carrito"]);
                        $cantidad = json_decode($_COOKIE["cantidadCarrito"]);
                        $precioTotal = 0;
                        for ($i = 0; $i < count($array); $i++) {
                            $instruccion = "SELECT pro_nombre, pro_precio, pro_descuento, pro_oferta FROM producto WHERE pro_id = " . $array[$i];
                            $res = mysqli_query($conn, $instruccion);
                            $fila = mysqli_fetch_assoc($res);

                            $precio = 0;
                            if ($fila["pro_oferta"]) {
                                $precio =  ($fila["pro_precio"] - $fila["pro_precio"] * $fila["pro_descuento"] * 0.01);
                            } else {
                                $precio = $fila["pro_precio"];
                            }
                            $precioTotal += ($precio * $cantidad[$i]);
                            echo '<tr>';
                            echo '<th scope="row">' . $fila["pro_nombre"] . "</th>";
                            echo '<td>' . $cantidad[$i] . "</td>";
                            echo '<td>' . $precio . "</td>";
                            echo '<td>' . '<form action="./cart/deleteItemCart.php">' . '<input hidden id="deleteItemCart" name="deleteItemCart" value="' . $i . '" />' . '<button class="btn btn-outline-danger" type="submit">Eliminar</button>' . '</form>' . "</td>";
                            echo '</tr>';
                        }
                        echo '<tr>';
                        echo '<th scope="row">Total: </th>';
                        echo '<td colspan="2">' . $precioTotal . '</td>';
                        echo '<td>' . '<form action="./checkout.php">'  . '<button class="btn btn-outline-success" type="submit">Comprar</button>' . '</form>'  . '</td>';
                        echo '</tr>';
                    }


                    ?>

                </tbody>
            </table>


        </div>

    </header>
    <main class="container" style="margin-top:130px;">
        <a href="./home.php" class="btn btn-outline-secondary mt-4">&larr; Volver</a>
        <div class="card card-login mt-4">
            <div class="card-body">
                <h5 class="card-title text-center">Iniciar Sesión</h5>
                <form action="./account/loginAccount.php" method="get">
                    <div class="form-group mt-2">
                        <label for="role">Rol</label>
                        <select class="form-control" id="tipo" name="tipo" required>
                            <option value="comprador">Comprador</option>
                            <option value="vendedor">Vendedor</option>
                            <option value="controlador">Controlador</option>
                            <option value="repartidor">Repartidor</option>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="username">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ingrese su nombre de usuario" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-4">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </main>

    <footer class="footer py-3 bg-dark text-white mt-5 p-3 position-fixed bottom-0 w-100">
        <div class="text-center">
            <p>&copy; 2024 Estimazon</p>
        </div>
    </footer>

    <!-- Enlace a los scripts de Bootstrap (jQuery y Popper.js son necesarios) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>