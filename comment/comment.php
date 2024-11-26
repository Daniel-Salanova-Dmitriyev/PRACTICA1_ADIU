<!-- 
    Autor: Daniel Salanova Dmitriyev
    DNI: 49610682G
-->
<?php
    //Conexión a la base de datos
    include '../Test/config.php';
    
    $comentario = $_GET["comentario"];
    $comprador = $_GET["com_id"];
    $producto = $_GET["pro_id"];

    //Ejecutamos un insert dentro de la tabla comentarios
    $instruccion = 'INSERT INTO comentario (cmt_descripcion, cmt_com_id, cmt_pro_id) VALUES ("' . $comentario . '", ' . $comprador . ", " . $producto . ")";
    mysqli_query($conn, $instruccion);

    //Redirigmos a los detalles del producto comentado
    header("Location: ../details.php?producto=".$producto)
?>