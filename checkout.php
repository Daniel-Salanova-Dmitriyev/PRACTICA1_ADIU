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

    <link rel="stylesheet" href="css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css" integrity="sha512-6p+GTq7fjTHD/sdFPWHaFoALKeWOU9f9MPBoPnvJEWBkGS4PKVVbCpMps6IXnTiXghFbxlgDE8QRHc3MU91lJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" integrity="sha512-pVCM5+SN2+qwj36KonHToF2p1oIvoU3bsqxphdOIWMYmgr4ZqD3t5DjKvvetKhXGc/ZG5REYTT6ltKfExEei/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    <div class="container" style="margin-top:130px; margin-bottom:130px;">
        <a href="./home.php" class="btn btn-outline-secondary mt-4 mb-4">&larr; Volver</a>
        <h2 class="mb-4">Checkout</h2>

        <form action="./order/order.php" method="get" class="mb-6">
            <div class="row">
                <div class="col-md-6">
                    <h4>Domicilio</h4>
                    <?php
                    //Mostratermos todos los domicilios a los que puede escoger el usaurio comprador, estos son los que ha creado a la hora de registrarse
                    //o manualmente en la base de datos ya que no se gestiona para un grupo de 1 persona


                    include 'Test/config.php';

                    $usuarioCookie = $_COOKIE["usuario"];
                    //Recogemos el ID del usuario
                    $instruccion = 'SELECT com_id FROM comprador WHERE com_usuario = "' . $usuarioCookie . '"';
                    $res = mysqli_query($conn, $instruccion);
                    $id = mysqli_fetch_assoc($res)["com_id"];

                    $instruccion = "SELECT dom_id, dom_letra, dom_numero, dom_bloque, ciu_nombre, cal_nombre FROM domicilio INNER JOIN calle ON dom_cal_id = cal_id INNER JOIN ciudad ON ciu_id = cal_ciu_id WHERE dom_com_id = " . $id;
                    $res = mysqli_query($conn, $instruccion);

                    echo '<select class="form-control mb-3" name="dom_id" id="dom_id" required>';
                    while ($fila = mysqli_fetch_assoc($res)) {
                        echo '<option value="' .  $fila["dom_id"] . '">' . $fila["ciu_nombre"] . " - " . $fila["cal_nombre"] . " " . $fila["dom_numero"] . " " .  $fila["dom_letra"] . " " . $fila["dom_bloque"] . '</option>';
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

                        include 'Test/config.php';

                        $precioTotal = 0;
                        $array = json_decode($_COOKIE["carrito"]);
                        $cantidad = json_decode($_COOKIE["cantidadCarrito"]);
                        echo '<tbody>';
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
                            echo '<td>' . $fila["pro_nombre"] . '</td>';
                            echo '<td>' . $fila["pro_precio"] . '</td>';
                            echo '<td>' . $cantidad[$i] . '</td>';
                            echo '<td>' . ($precio * $cantidad[$i]) . '€</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '<div class="text-right">';
                        echo '<p><strong>Total:' . $precioTotal   . '€</strong></p>';
                        echo '<button type="submit" class="btn btn-primary mb-4">Realizar Pedido</button>';
                        echo '</div>';
                        ?>
                </div>
                
            </div>

      
        </form>
    </div>



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