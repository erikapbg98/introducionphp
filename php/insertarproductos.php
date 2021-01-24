<?php
    include "conexion.php";
  

    $nombrep = $_POST['nombre'];
    $precio = $_POST['precio'];
    $inventario = $_POST['inventario'];
    $image_name = $_FILES['imagen']['name'];
    $image_temp = $_FILES['imagen']['tmp_name'];
    $exp = explode(".", $image_name);
    $end = end($exp);
    $name = $image_name;
    $path = "../img/productos/".$name;
    $allowed_ext = array("gif", "jpg", "jpeg", "png");
    if(in_array($end, $allowed_ext)){
    
            if(move_uploaded_file($image_temp, $path)){
             
                $conexion ->query("insert into productos (nombre,precio,inventario,imagen)
                values ('$nombrep',$precio,$inventario,'$name')") or die($conexion->error);
    
                header("Location: ../productos.php?success= Se agrego un producto correctamente");
            }else{
                header("Location: ../productos.php?error= ocurrio un error al subir la imagen");
            }
        }else{
            header("Location: ../productos.php?error= tipo de archivo no valido");
        }
