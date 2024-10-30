<!-- 
    Autor: Daniel Salanova Dmitriyev
    DNI: 49610682G
-->
<?php
      if(isset($_GET["deleteItemCart"])){
        $array = json_decode($_COOKIE["carrito"]);
        $numero = intval($_GET["deleteItemCart"]); 
        if($numero == 0){ 
            array_shift($array);
            setcookie("carrito", json_encode($array) ,3600, '/', 'localhost');
        }else{
            array_splice($array,$numero,$numero);
        }
        

        //Si no hay elementos borraremos el registro cookies
        if (count($array) == 0){
            unset($_COOKIE['carrito']);
        }else{
            //Guardamos el carrito
            setcookie("carrito", json_encode($array) ,time()+3600, '/', 'localhost');
        
        }
        
        //Redirigimos a la pantalla inicial
        header("Location: ../home.php");

    }

?>