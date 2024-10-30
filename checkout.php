<!-- 
    Autor: Daniel Salanova Dmitriyev
    DNI: 49610682G
-->

<!DOCTYPE html>
<html lang="en">

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

    <div class="container mt-5">
        <a href="./home.php" class="btn btn-outline-secondary mt-4 mb-4">&larr; Volver</a>
        <h2 class="mb-4">Checkout</h2>

        <form action="./order/order.php" method="get" class="mb-6">
            <div class="row">
                <div class="col-md-6">
                    <h4>Domicilio</h4>
                    <?php
                        //Mostratermos todos los domicilios a los que puede escoger el usaurio comprador, estos son los que ha creado a la hora de registrarse
                        //o manualmente en la base de datos ya que no se gestiona para un grupo de 1 persona


                        $conexion = mysqli_connect("localhost", "root", "") or die("Error conecting to database server!");
                        $bd = mysqli_select_db($conexion, "bd2oracle") or die("Error selecting database!"); //Elegimos conexión y tabla a la que conectarnos
                        
                        $usuarioCookie = $_COOKIE["usuario"];  
                        //Recogemos el ID del usuario
                        $instruccion = 'SELECT com_id FROM comprador WHERE com_usuario = "' . $usuarioCookie . '"';
                        $res = mysqli_query($conexion, $instruccion);
                        $id = mysqli_fetch_assoc($res)["com_id"];
                        
                        $instruccion = "SELECT dom_id, dom_letra, dom_numero, dom_bloque, ciu_nombre, cal_nombre FROM domicilio INNER JOIN calle ON dom_cal_id = cal_id INNER JOIN ciudad ON ciu_id = cal_ciu_id WHERE dom_com_id = " . $id;
                        $res = mysqli_query($conexion, $instruccion);

                        echo '<select class="form-control mb-3" name="dom_id" id="dom_id" required>';
                        while($fila = mysqli_fetch_assoc($res)) {
                            echo '<option value="' .  $fila["dom_id"] . '">' . $fila["ciu_nombre"] . " - " . $fila["cal_nombre"] . " " . $fila["dom_numero"] . " " .  $fila["dom_letra"] . " " . $fila["dom_bloque"]. '</option>';
                        }
                        echo '</select>';
                    ?>
                    <h4>Método de pago</h4>
                    <div class="form-group">
                        <label for="cuentaBancaria">Número de la tarjeta</label>
                        <input type="text" class="form-control" id="cuentaBancaria" name="cuentaBancaria" placeholder="Número de cuenta" required>
                        <label for="fechaCaducidad">Fecha de caducidad</label>
                        <input type="month" class="form-control" id="fechaCaducidad" name="fechaCaducidad" placeholder="" min="2023-01" required>
                        <label for="codigoSeguridad">Código de seguridad</label>
                        <input type="number" class="form-control" id="codigoSeguridad" name="codigoSeguridad" placeholder="" min="0" max="999" step="1" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <h4>Resumen de Compra</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <?php 
                            //Contenido de la tabla de resumen de pedido

                            $conexion = mysqli_connect("localhost", "root", "") or die("Error conecting to database server!");
                            $bd = mysqli_select_db($conexion, "bd2oracle") or die("Error selecting database!"); //Elegimos conexión y tabla a la que conectarnos
                            
                            $precioTotal = 0;
                            $array = json_decode($_COOKIE["carrito"]);
                            $cantidad = json_decode($_COOKIE["cantidadCarrito"]);
                            echo '<tbody>';
                                for($i = 0; $i < count($array); $i++) {
                                    $instruccion = "SELECT pro_nombre, pro_precio, pro_descuento, pro_oferta FROM producto WHERE pro_id = " . $array[$i];
                                    $res = mysqli_query($conexion, $instruccion);
                                    $fila = mysqli_fetch_assoc($res);
                                    $precio = 0;
                                    if($fila["pro_oferta"]){
                                        $precio =  ($fila["pro_precio"] - $fila["pro_precio"]*$fila["pro_descuento"]*0.01);
                                    }else{
                                        $precio = $fila["pro_precio"];
                                    }
                                    $precioTotal += ($precio * $cantidad[$i]);
                                    echo '<tr>';
                                        echo '<td>' .$fila["pro_nombre"] .'</td>';
                                        echo '<td>' . $fila["pro_precio"] . '</td>';
                                        echo '<td>' . $cantidad[$i] . '</td>';
                                        echo '<td>' . ($precio * $cantidad[$i]). '€</td>';
                                    echo '</tr>';
                                }
                            echo '</tbody>';
                            echo '</table>';
                            echo '<div class="text-right">';
                            echo '<p><strong>Total:' . $precioTotal   . '€</strong></p>';
                            echo '</div>';
                    ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mb-4">Realizar Pedido</button>
        </form>
    </div>


    
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