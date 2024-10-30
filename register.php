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
            echo "<script>alert('Error al crear el usuario');</script>";
        } elseif ($estado == "1") {
            echo "<script>alert('Se ha creado el usuario correctamente');</script>";
            header("Location: login.php");
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
            <!-- Formulario-->
            <div class="card-body">
                <h5 class="card-title text-center">Iniciar Sesión</h5>
                <form id="formulario" action="./account/createAccount.php" method="get" onsubmit="return enviarFormulario()"><br>
                <div class="form-group">
                        <label for="role">Rol</label>
                        <select class="form-control" id="tipo" name="tipo" required onchange="ocultarCampos()">
                            <option value="comprador">Comprador</option>
                            <option value="vendedor">Vendedor</option>
                            <option value="controlador">Controlador</option>
                            <option value="repartidor">Repartidor</option>
                        </select>
                    </div>
                    <div class="form-group">
                            <label for="nombre">Nombre*</label>
                            <input type="text" name="nombre" id="nombre" required>
                    </div>
                    <div class="form-group">
                            <label for="apellido1">Primer Apellido*</label>
                            <input type="text" name="apellido1" id="apellido1" required>
                    </div>
                    <div class="form-group">
                            <label for="apellido2">Segundo Apellido</label>
                            <input type="text" name="apellido2" id="apellido2">
                    </div>
                    <div id ="cDni" class="form-group hidden">
                            <label for="dni">DNI*</label>
                            <input type="text" name="dni" id="dni" required>
                    </div>
                    <div id ="cTelefono" class="form-group hidden">
                            <label for="dni">Teléfono*</label>
                            <input type="text" name="telefono" id="telefono" required>
                    </div>
                    <div class="form-group">
                            <label for="usuario">Usuario*</label>
                            <input type="text" name="usuario" id="usuario" required>
                    </div>
                    <div class="form-group">
                            <label for="contrasena">Contraseña*</label>
                            <input type="password" name="contrasena" id="contrasena" required>
                    </div>
                   <div id="cDireccion" class="form-group hidden">
                        <label for="pais">Direccion*</label>
                        Pais:<select class="form-control" name="pais" id="pais" required>
                            <option disabled selected value> -- selecciona un país -- </option>
                            <?php
                            //Recogemos todos los paises disponibles dentro de la pagina web
                            $conexion = mysqli_connect("localhost", "root", "") or die("Error conecting to database server!");
                            $bd = mysqli_select_db($conexion, "bd2oracle") or die("Error selecting database!"); //Elegimos conexión y tabla a la que conectarnos
                            $instruccion = "SELECT pai_id, pai_nombre FROM pais";
                            $res = mysqli_query($conexion, $instruccion);

                            while ($fila = mysqli_fetch_assoc($res)) {
                                echo '<option value="' . $fila["pai_id"] . '">' . $fila["pai_nombre"] . '</option>';
                            }
                            ?>
                        </select>
                        <label for="ciudad" class="mt-2">Ciudad*</label>
                        <select class="form-control" name="ciudad" id="ciudad" required>
                            <option disabled selected value> -- selecciona una ciudad -- </option>
                            <?php
                            //Recogemos todas las ciudades dentro de la base de datos
                            $conexion = mysqli_connect("localhost", "root", "") or die("Error conecting to database server!");
                            $bd = mysqli_select_db($conexion, "bd2oracle") or die("Error selecting database!"); //Elegimos conexión y tabla a la que conectarnos
                            $instruccion = "SELECT ciu_id, ciu_nombre, ciu_pai_id, pai_nombre FROM ciudad INNER JOIN pais ON ciu_pai_id = pai_id";
                            $res = mysqli_query($conexion, $instruccion);

                            while ($fila = mysqli_fetch_assoc($res)) {
                                echo '<option value="' . $fila["ciu_id"] . '-' . $fila["ciu_pai_id"] . '">' . $fila["ciu_nombre"] . ' - ' . $fila["pai_nombre"] . '</option>';
                            }
                            ?>
                        </select>
                        <label for="calle" class="mt-2">Calle*</label>
                        <select class="form-control" name="calle" id="calle" required>
                            <option disabled selected value> -- selecciona una calle -- </option>
                            <?php
                            //Recogemos todas las calles
                            $conexion = mysqli_connect("localhost", "root", "") or die("Error conecting to database server!");
                            $bd = mysqli_select_db($conexion, "bd2oracle") or die("Error selecting database!"); //Elegimos conexión y tabla a la que conectarnos
                            $instruccion = "SELECT cal_id, cal_nombre, cal_ciu_id, ciu_nombre FROM calle INNER JOIN ciudad ON cal_ciu_id = ciu_id";
                            $res = mysqli_query($conexion, $instruccion);

                            while ($fila = mysqli_fetch_assoc($res)) {
                                echo '<option value="' . $fila["cal_id"] . '-' . $fila["cal_ciu_id"] . '">' . $fila["cal_nombre"] . ' - ' . $fila["ciu_nombre"]. '</option>';
                            }
                            ?>
                        </select>
                        <label for="numero" class="mt-4">Número de puerta*</label>
                        <input id="numero" name="numero" type="text" required></input>
                        
                        <label for="puerta">Letra de puerta</label>
                        <input id="puerta" name="puerta" type="text"></input>
                        
                        <label for="bloque">Número del bloque</label>
                        <input id="bloque" name="bloque" type="text"></input>

                    </div>
                    <button type="submit">Enviar!</button>
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
    <script>
        //Funcion que en caso de que no se hayan escogido un pais, ciudad y calle que pertenezcan una a otra, indicara que ha habido un error
        function enviarFormulario() {
            let tipo = document.getElementById("tipo").value;
            if (tipo === "comprador") {
                let pais = document.getElementById("pais").value;
                let ciudad = document.getElementById("ciudad").value.split("-");
                let calle = document.getElementById("calle").value.split("-");
                if (pais == parseInt(ciudad[1]) && parseInt(ciudad[0]) == parseInt(calle[1])) {
                    return true;
                } else {
                    alert("Debe de haber algun error al seleccionar Pais, Ciudad y Calle. Compruebe que cada una pertenezca a otra.");
                    return false;
                }

            } else {
                return true
            }


        }

        //Ocultamos campos si se escoge un rol u otro para evitar escribir cosas innecesarias
        function ocultarCampos() {
            let opcionSeleccionada = document.getElementById("tipo").value;

            if (opcionSeleccionada === "comprador") {
                document.getElementById("cDni").style.display = "block";
                document.getElementById("dni").required = true;

                document.getElementById("cTelefono").style.display = "block";
                document.getElementById("telefono").required = true;

                document.getElementById("cDireccion").style.display = "block";
                document.getElementById("calle").required = true;
                document.getElementById("ciudad").required = true;
                document.getElementById("pais").required = true;
                document.getElementById("numero").required = true;

            } else if (opcionSeleccionada === "vendedor") {
                document.getElementById("cDni").style.display = "block";
                document.getElementById("dni").required = true;

                document.getElementById("cTelefono").style.display = "block";
                document.getElementById("telefono").required = true;

                document.getElementById("cDireccion").style.display = "none";
                document.getElementById("calle").required = false;
                document.getElementById("ciudad").required = false;
                document.getElementById("pais").required = false;
                document.getElementById("numero").required = false;

            } else {
                if(opcionSeleccionada === "repartidor"){
                    document.getElementById("cDni").style.display = "block";
                    document.getElementById("dni").required = true;
                }else{
                    document.getElementById("cDni").style.display = "none";
                    document.getElementById("dni").required = false;
                }
              

                if(opcionSeleccionada === "repartidor"){
                    document.getElementById("cTelefono").style.display = "block";
                    document.getElementById("telefono").required = true;
                }else{
                    document.getElementById("cTelefono").style.display = "none";
                    document.getElementById("telefono").required = false;
                }


                document.getElementById("cDireccion").style.display = "none";
                document.getElementById("calle").required = false;
                document.getElementById("ciudad").required = false;
                document.getElementById("pais").required = false;
                document.getElementById("numero").required = false;
            }

        }
    </script>
</body>

</html>