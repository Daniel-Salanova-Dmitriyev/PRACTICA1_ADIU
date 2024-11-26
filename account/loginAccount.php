<!-- 
    Autor: Daniel Salanova Dmitriyev
    DNI: 49610682G
-->
<?php
    //Conexión a la base de datos
    include '../Test/config.php';
    
    //Elementos recogidos del formulario
    $tipo = $_GET["tipo"];
    $usuario = $_GET["usuario"];
    $contraseña = $_GET["contrasena"];
    $prefijo = "";
   
    //recogemos el prefijo para generalizar posteriormente las consultas a la BD
    if($tipo == "comprador"){
        $prefijo = "com";
    } else if ($tipo == "vendedor"){
        $prefijo = "ven";
    } else if ($tipo == "repartidor"){
        $prefijo = "rep";
    }else{
        $prefijo = "con";
    }

    $instruccion = "SELECT " . $prefijo . "_id FROM " . $tipo . " WHERE " . $prefijo . '_usuario="' . $usuario . '" AND ' . $prefijo . '_contraseña="' . $contraseña . '";';
    print($instruccion);
    $res_comprobacion = mysqli_query($conn, $instruccion);
    $contador = mysqli_num_rows($res_comprobacion);
    
    //Si contador == 1 es que usuario y contraseña coinciden con algun registro de la tabla 
    if ($contador == 1) {
        setcookie("usuario", $usuario, time()+3600, '/', 'localhost');
        setcookie("tipo", $tipo, time()+3600, '/', 'localhost');

        //Borramos carrito si existe, porque podia estar vinculado a algun usuario anterior
        if (isset($_COOKIE["carrito"])){
            setcookie("carrito", json_encode([]) ,3600, '/', 'localhost');
            unset($_COOKIE['carrito']);
        
            setcookie("cantidadCarrito", json_encode([]), 3600, '/', 'localhost');
            unset($_COOKIE['cantidadCarrito']);
        }

        //redirigimos a inicio de sesión
        header("Location: ../login.php?estado=1");

    }else{

        //redirigimos a inicio de sesion con estado==0, lo que implicará que se mostrará un error
        header("Location: ../login.php?estado=0");
    }

?>