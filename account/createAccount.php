<!-- 
    Autor: Daniel Salanova Dmitriyev
    DNI: 49610682G
-->

<?php
    //Conexión a la base de datos
    include '../Test/config.php';
    //Elementos recogidos del formulario
    $tipo = $_GET["tipo"];
    $nombre = $_GET["nombre"];
    $apellido1 = $_GET["apellido1"];
    $apellido2 = $_GET["apellido2"];
    $dni = $_GET["dni"];
    $telefono = $_GET["telefono"];
    $usuario = $_GET["usuario"];
    $contraseña = $_GET["contrasena"];
    $calle = $_GET["calle"];
    $numero = $_GET["numero"];
    $puerta = $_GET["puerta"];
    $bloque = $_GET["bloque"]; 


    //Haremos diferentes inserts según el tipo de usuario creado
    if ($tipo == "comprador"){
        //Comprobamos que el correo no este ya dentro de la base de datos
        $comprobacion = 'SELECT com_usuario FROM comprador WHERE com_usuario="' .$usuario . '"';
        $res_comprobacion = mysqli_query($conn, $comprobacion);
        $contador = mysqli_num_rows($res_comprobacion);

        if($contador != 0){
            //Enviar error
            header("Location: ../register.php?estado=0");
        }else{ //Procedemos a hacer un insert
            $instruccion = 'INSERT INTO comprador (com_dni, com_nombre, com_apellido1, com_apellido2, com_usuario, com_contraseña, com_telefono) VALUES("'. $dni .'","' . $nombre . '","' . $apellido1 . '","' . $apellido2 . '","' . $usuario . '","' . $contraseña . '","' . $telefono .'")';
            if($apellido2 == ""){
                $instruccion = 'INSERT INTO comprador (com_dni, com_nombre, com_apellido1, com_apellido2, com_usuario, com_contraseña, com_telefono) VALUES("'. $dni .'","' . $nombre . '","' . $apellido1 . '", NULL,"' . $usuario . '","' . $contraseña . '","' . $telefono .'")';            
            }
            $conn->query($instruccion);

            //Recogemos el ID del comprador añadido
            $instruccion = 'SELECT com_id FROM comprador WHERE com_usuario = "' . $usuario . '"';
            $res = mysqli_query($conn, $instruccion);
            $id = mysqli_fetch_assoc($res)["com_id"];


            $calle = strtok($calle, '-');
            //Insertamos el domicilio al que pertenece
            $instruccion = 'INSERT INTO domicilio (dom_numero, dom_letra, dom_bloque, dom_cal_id, dom_com_id) VALUES ('. $numero . ', "' . $puerta .'", "' .$bloque. '", ' . $calle .  ', ' . $id . ')';
            print($instruccion);
            $conn->query($instruccion);

            header("Location: ../register.php?estado=1");
        }   
    }elseif($tipo == "vendedor"){
        //Comprobamos que el usuario no exista
        $comprobacion = 'SELECT  ven_usuario FROM vendedor WHERE ven_usuario ="' .$usuario . '"';
        $res_comprobacion = mysqli_query($conn, $comprobacion);
        $contador = mysqli_num_rows($res_comprobacion);

        if($contador != 0){
            //Enviar error
            header("Location: ../register.php?estado=0");
        }else{ //Procedemos a hacer un insert
            $instruccion = 'INSERT INTO vendedor (ven_dni, ven_nombre, ven_apellido1, ven_apellido2, ven_usuario, ven_contraseña, ven_telefono) VALUES("'. $dni .'","' . $nombre . '","' . $apellido1 . '","' . $apellido2 . '","' . $usuario . '","' . $contraseña . '","' . $telefono . '")';
            if($apellido2 == ""){
                $instruccion = 'INSERT INTO vendedor (ven_dni, ven_nombre, ven_apellido1, ven_apellido2, ven_usuario, ven_contraseña, ven_telefono) VALUES("'. $dni .'","' . $nombre . '","' . $apellido1 . '", NULL,"' . $usuario . '","' . $contraseña . '","' . $telefono . '")';
            }
            print($instruccion);
            $conn->query($instruccion);
            header("Location: ../register.php?estado=1");
        }

    }elseif($tipo == "controlador"){
        //Comprobamos que el usuario no exista
        $comprobacion = 'SELECT con_usuario FROM controlador WHERE con_usuario ="' .$usuario . '"';
        $res_comprobacion = mysqli_query($conn, $comprobacion);
        $contador = mysqli_num_rows($res_comprobacion);

        if($contador != 0){
            //Enviar error
            header("Location: ../register.php?estado=0");
        }else{
            $instruccion = 'INSERT INTO controlador (con_nombre, con_apellido1, con_apellido2, con_usuario, con_contraseña) VALUES("'. $nombre . '","' . $apellido1 . '","' . $apellido2 . '","' . $usuario . '","' . $contraseña . '")';
            if($apellido2 == ""){
                $instruccion = 'INSERT INTO controlador (con_nombre, con_apellido1, con_apellido2, con_usuario, con_contraseña) VALUES("'. $nombre . '","' . $apellido1 . '", NULL,"' . $usuario . '","' . $contraseña . '")';
            
            }
            print($instruccion);
            $conn->query($instruccion);
            header("Location: ../register.php?estado=1");
            exit();
        }


    }else { //Repartidor
        //Comprobamos que el usuario no exista
        $comprobacion = 'SELECT rep_usuario FROM repartidor WHERE rep_usuario ="' .$usuario . '"';
        $res_comprobacion = mysqli_query($conn, $comprobacion);
        $contador = mysqli_num_rows($res_comprobacion);

        if($contador != 0){
            //Enviar error
            header("Location: ../register.php?estado=0");
        }else{
            $instruccion = 'INSERT INTO repartidor (rep_dni, rep_nombre, rep_apellido1, rep_apellido2, rep_usuario, rep_contraseña, rep_telefono) VALUES("'. $dni .'","' . $nombre . '","' . $apellido1 . '","' . $apellido2 . '","' . $usuario . '","' . $contraseña . '","' . $telefono . '")';
            if($apellido2 == ""){
                $instruccion = 'INSERT INTO repartidor (rep_dni, rep_nombre, rep_apellido1, rep_apellido2, rep_usuario, rep_contraseña, rep_telefono) VALUES("'. $dni .'","' . $nombre . '","' . $apellido1 . '", NULL,"' . $usuario . '","' . $contraseña . '","' . $telefono . '")';
            
            }
            print($instruccion);
            $conn->query($instruccion);
            header("Location: ../register.php?estado=1");
        }

    }


?>