<!-- 
    Autor: Daniel Salanova Dmitriyev
    DNI: 49610682G
-->
<?php
   
    //Sino existe carrito lo crearemos para poder insertar cosas dentro
    if(!isset($_COOKIE["carrito"])){
        echo "No existe";
        
        //Creación del array que almacenara los items del carrito
        $array = array(); //Guardará los ID's de los productos
        array_push($array, $_GET["pro_id"]);

        $cantidad = array(); //Guardará las cantidades de los productos guardados dentro del carrito
        array_push($cantidad, $_GET["pro_cantidad"]);

        //Guardamos el carrito en cache
        setcookie("carrito", json_encode($array) ,time()+3600, '/', 'localhost');
        setcookie("cantidadCarrito", json_encode($cantidad) ,time()+3600, '/', 'localhost');
        
        //Redirigimos a la pantalla de inicio 
        header("Location: ../home.php");

    }else{ //Ahora mismo existe ya la variable carrito, por lo que simplemente la modificamos
        $array = json_decode($_COOKIE["carrito"]); //Recogemos el array
        $cantidad = json_decode($_COOKIE["cantidadCarrito"]); //Recogemos el array
        
        $pro_id = $_GET["pro_id"];
        $pro_cantidad = $_GET["pro_cantidad"];

        //Si ya existe de antes lo actualizaremos dentro del carrito
        $encontrado = false;
        for($i = 0; $i<count($array) && !$encontrado; $i++){
            if($array[$i] == $pro_id){
                $cantidad[$i] = $pro_cantidad;
                $encontrado = true;
            }
        }

        //Como no hemos encontrado el producto, vamos a añadirlo al final
        if(!$encontrado){
            array_push($array, $_GET["pro_id"]);  
            array_push($cantidad, $_GET["pro_cantidad"]);  
        
        }

        //Guardamos el carrito en cache
        setcookie("carrito", json_encode($array) ,time()+3600, '/', 'localhost');
        setcookie("cantidadCarrito", json_encode($cantidad) ,time()+3600, '/', 'localhost');
        
        //Redirigimos a pantalla inicial
        header("Location: ../home.php");
    }   


?>