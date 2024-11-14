<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gráficas de Ventas</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="graficas.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css" integrity="sha512-6p+GTq7fjTHD/sdFPWHaFoALKeWOU9f9MPBoPnvJEWBkGS4PKVVbCpMps6IXnTiXghFbxlgDE8QRHc3MU91lJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" integrity="sha512-pVCM5+SN2+qwj36KonHToF2p1oIvoU3bsqxphdOIWMYmgr4ZqD3t5DjKvvetKhXGc/ZG5REYTT6ltKfExEei/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <div class="navigationBar">
        <a href="#" class="logo"><i class="ri-store-3-fill"></i><span>Estimazon</span></a>
        <ul class="itemsBar">
            <li><a href="./home.php" class="active">Home</a></li>
            <li><a href="./graficas.html">Estadísticas</a></li>
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
    <h2>Grafica API</h2>
    <div id="container" style="width: 50%; height: 400px; margin: auto;"></div>
    <h2>Graficas BD</h2>
    <div id="grafico1" style="width: 50%; height: 400px; margin: auto;"></div>
    <div id="grafico2" style="width: 50%; height: 400px; margin: auto;"></div>
</body>
</html>
