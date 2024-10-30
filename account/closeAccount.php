<!-- 
    Autor: Daniel Salanova Dmitriyev
    DNI: 49610682G
-->
<?php
      if(isset($_COOKIE["usuario"])){

        //Borramos las cookies
        setcookie("usuario", $usuario, time(), '/', 'localhost');
        setcookie("tipo", $tipo, time(), '/', 'localhost');


         //Borramos carrito si existe
      if (isset($_COOKIE["carrito"])){
          setcookie("carrito", json_encode([]) ,3600, '/', 'localhost');
          unset($_COOKIE['carrito']);
      
          setcookie("cantidadCarrito", json_encode([]), 3600, '/', 'localhost');
          unset($_COOKIE['cantidadCarrito']);
      }
        //Nos redirigimos a la pantalla de inicio
        header("Location: ../home.php");
    }

?>