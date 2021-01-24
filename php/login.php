<?php
session_start(); //1 se inicia la sesion
    include "./conexion.php";
    $email = $_POST['email'];
    $pass= $_POST['pass'];

    $res = $conexion -> query("
    SELECT * FROM usuarios where email='$email' 
    and pass = '".sha1($pass)."'") or die($conexion -> error);

    if(mysqli_num_rows($res) > 0){
        $fila = mysqli_fetch_row($res);
        $id= $fila['0'];
        $nombre = $fila['1']; //se trata como arreglo por eso el 1
        $ap =$fila['2'];
        //$email =$fila['3'];
        $imagen =$fila['5'];

        $array =array(
            'Id'=> $id,
            'Nombre'=>$nombre,
            'Ap'=>$ap,
            'Email'=>$email,
            'Imagen'=>$imagen
        );

        //echo json_encode($array);
        $_SESSION['userData']=$array;
        header("Location: ../index.php");
        //variables de sesion que debesn de existir hasta que se cierre la sesion


    }else{
        echo "Login incorrecto";
    }
?>