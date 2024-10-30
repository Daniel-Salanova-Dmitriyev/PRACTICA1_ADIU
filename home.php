<!-- 
    Autor: Daniel Salanova Dmitriyev
    DNI: 49610682G
-->
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tu Tienda </title>
    <!-- Enlace a los estilos de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        html,
        body {
            height: 100%;
        }

        .wrapper {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-4px);
            transition: all 0.3s ease-in-out;
        }

        .products-container {
            margin-bottom: 60px;
        }
    </style>
</head>

<body>
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
                    <!-- Carrito -->
                    <?php
                    if (isset($_COOKIE["carrito"])) {
                        $conexion = mysqli_connect("localhost", "root", "") or die("Error conecting to database server!");
                        $bd = mysqli_select_db($conexion, "bd2oracle") or die("Error selecting database!"); //Elegimos conexión y tabla a la que conectarnos
                        
                        echo ' <li class="nav-item dropdown">';
                        echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Carrito</a>';
                        echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                        echo ' <ul class="list-group">';
                        $array = json_decode($_COOKIE["carrito"]);
                        $cantidad = json_decode($_COOKIE["cantidadCarrito"]);
                        $precioTotal = 0;
                        for ($i = 0; $i < count($array); $i++) {
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
                            echo '<li class="list-group-item">' . $fila["pro_nombre"] . '<p>Cantidad: ' . $cantidad[$i] . '</p>' .'<p> Precio: '. $precio . '</p>' . '<form action="./cart/deleteItemCart.php" class="mt-2">' . '<input hidden id="deleteItemCart" name="deleteItemCart" value="' . $i . '" />' . '<button class="btn btn-danger" type="submit">Eliminar</button>' .'</form>' . '</li>';
    
                        }
                        echo '</ul>';
                        echo '<div class="dropdown-divider"></div>';
                        echo '<p class="ml-3"> Precio total: ' . $precioTotal . '</p>';
                        echo '<a class="dropdown-item btn btn-primary" href="./checkout.php">Comprar</a>';
                        echo '</div>';
                        echo '</li>';
                    }

                    ?>
                    


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

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-9">
                    <h2>Listado de Productos</h2>
                </div>
            </div>
        </div>

        <!-- Buscador -->
        <div class="container mt-4">
            <form class="input-group" action="./home.php">
                <input type="text" class="form-control" name="buscar" id="buscar" placeholder="Buscar productos...">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </form>
        </div>




  
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-3">
                    <!-- Listado de las diferentes categorias -->
                    <h5>Filtros</h5>
                    <div class="list-group">
                        <!--- Listado de categorias --->
                        <a class="list-group-item list-group-item-actio" href="home.php?categoria=0">Todo</a>
                        <?php
                        $conexion = mysqli_connect("localhost", "root", "") or die("Error conecting to database server!");
                        $bd = mysqli_select_db($conexion, "bd2oracle") or die("Error selecting database!"); //Elegimos conexión y tabla a la que conectarnos
                        $instruccion = "SELECT * FROM tipoproducto";
                        $res = mysqli_query($conexion, $instruccion);

                        while ($fila = mysqli_fetch_assoc($res)) {
                            echo "<a class='list-group-item list-group-item-actio' href='home.php?categoria=" . $fila["tpr_id"] . "'>" . $fila["tpr_nombre"] . "</a>";
                        }
                        ?>
                    </div>
                </div>

                <!-- Listado de Productos -->
                <div class="col-md-9  products-container">
                    <div class="row">
                        <?php
                        //Conexión a la base de datos
                        $conexion = mysqli_connect("localhost", "root", "") or die("Error conecting to database server!");
                        $bd = mysqli_select_db($conexion, "bd2oracle") or die("Error selecting database!"); //Elegimos conexión y tabla a la que conectarnos
                        $instruccion = "";
                        if (!isset($_GET["categoria"]) || $_GET["categoria"] == 0) {
                            $instruccion = "SELECT pro_id, pro_nombre,pro_descripcion, pro_precio, pro_oferta, pro_descuento, pro_cantidad, pro_imagen FROM producto";
                        } else {
                            $instruccion = "SELECT pro_id, pro_nombre,pro_descripcion, pro_precio, pro_oferta, pro_descuento, pro_cantidad, pro_imagen FROM producto INNER JOIN TipoxProducto ON txp_pro_id = pro_id WHERE txp_tpr_id =" . $_GET["categoria"];
                        }

                        if (isset($_GET["buscar"])) {
                            $instruccion = "SELECT pro_id, pro_nombre, pro_precio,pro_descripcion, pro_oferta, pro_descuento, pro_cantidad, pro_imagen FROM producto WHERE pro_nombre LIKE" .  "'%" . $_GET["buscar"] . "%'";
                        }

                        $res = mysqli_query($conexion, $instruccion);

                        while ($fila = mysqli_fetch_assoc($res)) {
                            echo '<div class="col-md-4 mb-4">';
                            echo '<div class="card h-100 mb-4">';
                            echo '<img src="./img/'. $fila["pro_imagen"] . '" class="card-img-top h-50" alt="Producto 1">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . '<a  href="./details.php?producto=' . $fila["pro_id"] . '">' . $fila["pro_nombre"] . '</a>' . "</h5>";
                            echo '<p class="card-text">' . $fila["pro_descripcion"] . '</p>';
                            if($fila["pro_oferta"]){
                                echo '<p class="card-text"><strong>Oferta!:</strong><del>' .  $fila["pro_precio"]. '</del> '. ($fila["pro_precio"] - $fila["pro_precio"]*$fila["pro_descuento"]*0.01) . "$</div>";
                            }else{
                                echo '<p class="card-text"><strong>Precio:</strong>' . $fila["pro_precio"] . "$</div>";
                            }
                            if (isset($_COOKIE["usuario"])) {
                                if ($_COOKIE["tipo"] == "comprador") {
                                    if ($fila["pro_cantidad"] > 0) {
                                        echo '<form action="./cart/addItemCart.php">';
                                        echo '<div class="form-group">';
                                        echo '<label for="numero">Cantidad:</label>';
                                        echo '<input hidden id="pro_id" name="pro_id" value="' . $fila["pro_id"] . '" />';
                                        echo '<select class="form-control" name="pro_cantidad" id="pro_cantidad">';
                                        for ($i = 1; $i <= $fila["pro_cantidad"]; $i++) {
                                            echo '<option value="' .  $i . '">' . $i . '</option>';
                                        }
                                        echo '</select>';
                                        echo '<button class="btn-primary" type="submit">Comprar!</button>';
                                        echo '</div>';
                                        echo '</form>';
                                    } else {
                                        echo '<p class="card-text"><strong>No disponible</strong></p>';
                                    }
                                }
                            }
                            echo "</div>";
                            echo "</div>";
                        }


                        ?>

                    </div>
                </div>

            </div>
        </div>

    </main>
    <footer class="footer py-3 bg-dark text-white mt-5">
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