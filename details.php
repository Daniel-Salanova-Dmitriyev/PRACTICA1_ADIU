<!-- 
    Autor: Daniel Salanova Dmitriyev
    DNI: 49610682G
-->
<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Estimazon</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <style>
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
    <main>


        <!-- Detalles del Producto -->
        <div class="container mt-4">
            <div class="row">

                <?php
                $conexion = mysqli_connect("localhost", "root", "") or die("Error conecting to database server!");
                $bd = mysqli_select_db($conexion, "bd2oracle") or die("Error selecting database!"); //Elegimos conexión y tabla a la que conectarnos
                $instruccion = "SELECT pro_nombre,pro_descripcion,pro_color,pro_medidas, pro_precio, pro_oferta, pro_cantidad, pro_descuento, pro_imagen, ven_usuario FROM producto INNER JOIN vendedor ON pro_ven_id = ven_id WHERE pro_id=" . $_GET["producto"];
                $res = mysqli_query($conexion, $instruccion);

                $fila = mysqli_fetch_assoc($res);
                
                
                echo '<div class="col-md-6">';
                    echo '<div class="product-image-container">';
                    echo '<img src="./img/'. $fila["pro_imagen"] . '" class="card-img-top h-50" alt="Producto 1">';
                    echo '</div>';
                echo '</div>';
                
                echo '<div class="col-md-6">';
                    echo '<div class="card">';
                        echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . $fila["pro_nombre"] . '</h5>';
                            echo '<p class="card-text">' . $fila["pro_descripcion"] .'</p>';
                            echo '<p class="card-text"><strong> Vendedor: </strong>' . $fila["ven_usuario"] . '</p>';
                            echo '<p class="card-text"><strong>Color:</strong>' . $fila["pro_color"] . "</p>";
                            echo '<p class="card-text"><strong>Medias:</strong>' . $fila["pro_medidas"] . "</p>"; 
                            if($fila["pro_oferta"]){
                                echo '<p class="card-text"><strong>Oferta!:</strong><del>' .  $fila["pro_precio"]. '</del> '. ($fila["pro_precio"] - $fila["pro_precio"]*$fila["pro_descuento"]*0.01) . "$</div>";
                            }else{
                                echo '<p class="card-text"><strong>Precio:</strong>' . $fila["pro_precio"] . "$</div>";
                            }
                            if (isset($_COOKIE["usuario"])) {
                                if ($_COOKIE["tipo"] == "comprador" && $fila["pro_cantidad"] >0) {
                            echo '<form action="./cart/addItemCart.php">';
                            echo '<input hidden id="pro_id" name="pro_id" value="' . $_GET["producto"] . '" />';
                                echo '<div class="form-group">';
                                echo '<select class="form-control" name="pro_cantidad" id="pro_cantidad">';
                                for ($i = 1; $i <= $fila["pro_cantidad"]; $i++) {
                                    echo '<option value="' .  $i . '">' . $i . '</option>';
                                }
                                echo '</select>';
                                echo '<button class="btn-primary mt-3" type="submit">Comprar!</button>';
                                echo '</div>';
                            echo '</form>';
                                }else{
                                    echo '<strong>No disponible </strong>';
                                }
                            }
                        echo '</div>';
                    echo '</div>';
                ?>
                </div>
            </div>

            <!-- Sección de Productos Similares-->
            <div class="mt-4">
                <h4>Productos Similares</h4>
                <div id="similarProductsSlider" class="slick-slider mt-3">
                    <?php
                        $conexion = mysqli_connect("localhost", "root", "") or die("Error conecting to database server!");
                        $bd = mysqli_select_db($conexion, "bd2oracle") or die("Error selecting database!"); //Elegimos conexión y tabla a la que conectarnos
                        $instruccion = "SELECT pro_nombre FROM producto WHERE pro_id = " . $_GET["producto"];
                        $res = mysqli_query($conexion, $instruccion);
                        $fila = mysqli_fetch_assoc($res);

                        $instruccion = "SELECT pro_id, pro_nombre,pro_descripcion, pro_precio, pro_imagen, ven_usuario FROM producto INNER JOIN vendedor ON pro_ven_id = ven_id WHERE pro_id  != ". $_GET["producto"] ." AND pro_nombre LIKE " . "'%" . $fila["pro_nombre"] . "%'" ;
                        $res = mysqli_query($conexion,$instruccion);
                        while ($fila = mysqli_fetch_assoc($res)){
                            echo '<div class="card h-100 mr-4">';
                            echo '<img src="./img/'. $fila["pro_imagen"] . '" class="card-img-top h-50" alt="Producto 1">';
                            echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . '<a  href="./details.php?producto=' . $fila["pro_id"] . '">' . $fila["pro_nombre"] . '</a>' . "</h5>";
                                echo '<p class="card-text">' . $fila["pro_descripcion"] . '</p>';
                                echo '<p class="card-text"><strong> Vendedor: </strong>' . $fila["ven_usuario"] . '</p>';
                                echo '<p class="card-text"><strong>Precio:</strong> ' . $fila["pro_precio"] . '€</p>';
                                echo '</div>';
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>

            <!-- Sección de Comentarios -->
            <div class="comments-section">
                <h4>Comentarios de Clientes</h4>
                <!-- Formulario para Insertar Comentarios -->
            <?php
                $conexion = mysqli_connect("localhost", "root", "") or die("Error conecting to database server!");
                $bd = mysqli_select_db($conexion, "bd2oracle") or die("Error selecting database!"); //Elegimos conexión y tabla a la que conectarnos 
                if(isset($_COOKIE["usuario"])){ //Esta logueado
                    if($_COOKIE["tipo"] == "comprador"){
                        $usuarioCookie = $_COOKIE["usuario"];   
    
                        //Recogemos el ID del usuario
                        $instruccion = 'SELECT com_id FROM comprador WHERE com_usuario = "' . $usuarioCookie . '"';
                        $res = mysqli_query($conexion, $instruccion);
                        $id = mysqli_fetch_assoc($res)["com_id"];
        
                        $instruccion = "SELECT COUNT(ped_id) AS contador FROM pedido INNER JOIN linea ON ped_id = lin_ped_id WHERE lin_pro_id =". $_GET["producto"] ." AND ped_com_id =" . $id;
                        $res = mysqli_query($conexion, $instruccion);
                        $contadorCompra = mysqli_fetch_assoc($res)["contador"];
        
        
                        $instruccion = "SELECT COUNT(cmt_com_id) AS contador FROM comentario WHERE cmt_com_id =" . $id . " AND cmt_pro_id =" . $_GET["producto"];
                        $res = mysqli_query($conexion, $instruccion);
                        $contadorComentario = mysqli_fetch_assoc($res)["contador"];
                    
                        if($contadorCompra > 0 && $contadorComentario == 0){
                            echo '<div class="comment-form">';
                                echo '<h5>Deja tu Comentario</h5>';
                                echo '<form action="./comment/comment.php">';
                                    echo '<input hidden id="pro_id" name="pro_id" value="'. $_GET["producto"] .'" />';
                                    echo '<input hidden id="com_id" name="com_id" value="'. $id .'" />';
                                
                                    echo '<div class="form-group">';
                                        echo '<label for="commentText">Comentario</label>';
                                        echo '<textarea class="form-control" id="comentario" name="comentario" rows="3" placeholder="Escribe tu comentario" required></textarea>';
                                    echo '</div>';
                                    echo '<button type="submit" class="btn btn-primary">Enviar Comentario</button>';
                                echo '</form>';
                            echo '</div>';
                        }
                    }
                }




                //Imprimimos los comentarios
                $instruccion = "SELECT cmt_descripcion, cmt_fecha, com_usuario FROM comentario INNER JOIN comprador ON cmt_com_id = com_id WHERE cmt_pro_id=" . $_GET["producto"];
                $res = mysqli_query($conexion, $instruccion);
                    echo '<div class="comment-list">';
                        echo '<h5>Comentarios Anteriores</h5>';
                        echo '<ul class="list-group">';
                        while($fila = mysqli_fetch_assoc($res)){
                            echo '<li class="list-group-item">' .$fila["com_usuario"] . ' - '  . $fila["cmt_descripcion"]. ' - ' . $fila["cmt_fecha"] . '</li>';
                        }
                        echo '</ul>';
                    echo '</div>';
                
            ?>
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#similarProductsSlider').slick({
                slidesToShow: 4, // Muestra 4 cartas a la vez
                slidesToScroll: 1, // Desplaza una carta a la vez
                autoplay: false, // Reproducción automática
                dots: true, // Muestra los indicadores (dots)
                autoplaySpeed: 5000, // Velocidad de reproducción automática en milisegundos
                prevArrow: '<button type="button" class="slick-prev">&#9664;</button>',
                nextArrow: '<button type="button" class="slick-next">&#9654;</button>',
            });
        });
    </script>
</body>

</html>