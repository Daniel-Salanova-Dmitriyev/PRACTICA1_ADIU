<!-- 
    Autor: Daniel Salanova Dmitriyev
    DNI: 49610682G
-->

<?php
    //Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "") or die("Error conecting to database server!");
    $bd = mysqli_select_db($conexion, "bd2oracle") or die("Error selecting database!"); //Elegimos conexión y tabla a la que conectarnos
    
    $hoy = getDate();
    $fecha = $hoy["year"] . "-" . $hoy["mon"] . "-" .$hoy["mday"]; 
    $usuarioCookie = $_COOKIE["usuario"];   
    
    //Recogemos el ID del usuario
    $instruccion = 'SELECT com_id FROM comprador WHERE com_usuario = "' . $usuarioCookie . '"';
    $res = mysqli_query($conexion, $instruccion);
    $id = mysqli_fetch_assoc($res)["com_id"];


    //Recogemos el dato enviado en el fomulario que contiene el id del domicilio
    $dom = $_GET["dom_id"];

    //Ejecutamos el insert de pedidos
    $instruccion = 'INSERT INTO pedido (ped_fecha, ped_pagado, ped_estado, ped_com_id, ped_dom_id, ped_tarjeta) VALUES ("'.$fecha.'", TRUE, "Pagado",' . $id . ', ' . $dom .', "'. $_GET["cuentaBancaria"] .'")';  
    mysqli_query($conexion, $instruccion);

    //Reocgemos el ultimo id del auto_increment
    $pedido = mysqli_insert_id($conexion);
    
    //Ahora que el pedido esta hecho debemos crear las líneas de productos del propio pedido
    $array = json_decode($_COOKIE["carrito"]);
    $cantidad = json_decode($_COOKIE["cantidadCarrito"]);

    $instruccion = 'INSERT INTO linea(lin_cantidad, lin_ped_id, lin_pro_id) VALUES ';
    for($i = 0; $i < count($array); $i++){
        $instruccion = $instruccion . "(" . $cantidad[$i] . ', ' . $pedido . ", " . $array[$i] . "),"; 
    }
    
    $instruccion = substr_replace($instruccion,"",-1);
    mysqli_query($conexion, $instruccion); //Ejecutamos los inserts de líneas

    //Actualizamos los productos anteriores descontandoles las cantidades compradas
    for($i=0;$i < count($cantidad) ; $i++){
        $update = "UPDATE producto SET pro_cantidad=pro_cantidad -" .$cantidad[$i] . ' WHERE pro_id = ' . $array[$i]; 
        print($update);
        mysqli_query($conexion, $update);
    }

    //Eliminamos la cache del carrito ya que esta comprado
    setcookie("carrito", json_encode([]) ,3600, '/', 'localhost');
    unset($_COOKIE['carrito']);
    setcookie("cantidadCarrito", json_encode([]), 3600, '/', 'localhost');
    unset($_COOKIE['cantidadCarrito']);

    //Redirigimos a menu home
    header("Location: ../home.php");
?>