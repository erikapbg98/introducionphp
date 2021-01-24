<?php

session_start();
if(!isset($_SESSION['userData'])){
  header("Location: ./login.php");}
$userData=$_SESSION['userData'];

include "./php/conexion.php";
$resultado= $conexion-> query("select * from productos order by id DESC") or die($conexion->error);



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mi Tienda</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./dashboard./plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dashboard./dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
   <?php include "./layouts/header.php"; ?>
  <!-- /.navbar -->
   <?php include "./layouts/sidebar.php" ?>
    <!-- /.sidebar -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Productos</h1>
          </div>
         
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Agregar Producto</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <?php
            if(isset($_GET['error'])){
          ?>
            <div class="alert alert-danger">
              <b>Error</b> <?php echo $_GET['error']?>
            </div>
          <?php
            }
            if(isset($_GET['success'])){
          ?>
            <div class="alert alert-success">
              <b>Listo</b> <?php echo $_GET['success']?>
            </div>
          <?php
            }
          ?>
          
          <form action="./php/insertarproductos.php" class="row" method="POST" enctype="multipart/form-data">
            <div class="col-4">
                <label for="">Nombre</label>
                <input type="text" class="form-control" placeholder="inserta el Nombre" name="nombre" id="txtnombre" required=""><!--name es para php    id es para javascript o css -->
            </div>
            <div class="col-4">
                <label for="">Precio</label>
                <input type="number" class="form-control" placeholder="inserta el precio" name="precio" required="">
            </div>
            <div class="col-4">
                <label for="">Inventario</label>
                <input type="number" class="form-control" placeholder="inserta el inventario" 
                min="1" name="inventario" required="">
            </div>
            <div class="col-4">
                <label for="">imagen</label>
                <input type="file" class="form-control" placeholder="imagen" name="imagen" required="">
            </div>
            
            <div class="col-12 p-2">
            <br>
                <button class="btn btn-primary"><i class="fa fa-plus"></i> Insertar</button>
            </div>

          </form>
        </div>
      </div>
      <!-- /.card -->
      <h2 class="subtitle"> Productos</h2>
      <table class="table">
        <thead>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Inventario</th>
            <th></th>
        </thead>
        <tbody>
        <?php
       
include "./php/conexion.php";
$resultado= $conexion-> query("select * from productos order by id DESC") or die($conexion->error);
          while($fila= mysqli_fetch_array($resultado)){

          
        ?>
            <tr>
                <td>
                <img src=".img/productos/<?php echo $fila['imagen']; ?>" style="width: 50px ;
    height: 50px; border-radius: 100%;" alt="" class="img-rounded" >
     <?php echo $fila['nombre'];?>
                </td>
                <td><?php echo $fila['precio'];?></td>
                <td><?php echo $fila['inventario'];?></td>
                <td>

                <button class="btn btn-sm btn-warning btnEdit"
                data-id="<?php echo $fila['id'];?>"
                data-nombre="<?php echo $fila['nombre'];?>"
                data-precio="<?php echo $fila['precio'];?>"
                data-inventario="<?php echo $fila['inventario'];?>"
                data-toggle="modal" data-target="#modal-editar"><i class="fa fa-edit"></i></button>
                
                <button class="btn btn-sm btn-danger btnEliminar" 
                data-id="<?php echo $fila['id'];?>" 
                data-toggle="modal" data-target="#modal-eliminar"><i class="fa fa-trash"></i></button>
                </td>
            </tr>

        <?php }?>
        </tbody>
      </table>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php include "./layouts/footer.php"; ?>
<!-- modal eliminar-->
 <div class="modal fade" id="modal-eliminar">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">Eliminar producto</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="./php/eliminarproducto.php" method="POST">
            <div class="modal-body">
              <p>deseas eliminar el producto?</p>
              <input type="hidden" id="idEliminar" name="id">
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-outline-light">Eliminar</button>
            </div>
            </form>
          </div>
                    <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

</div>

<!-- modal editar-->
<div class="modal fade" id="modal-editar">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Editar producto</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="./php/editarproductos.php" method="POST">
            <div class="modal-body">

            <div class="col-12">
                <label for="">Nombre</label>
                <input type="text" class="form-control" placeholder="inserta el Nombre" name="nombre" id="nombreEdit" required=""><!--name es para php    id es para javascript o css -->
            </div>
            <div class="col-12">
                <label for="">precio</label>
                <input type="text" class="form-control" placeholder="inserta el precio" name="precio" required id="precioEdit">
            </div>
            <div class="col-12">
                <label for="">inventario</label>
                <input type="email" class="form-control" placeholder="inserta el inventario" name="inventario" required id="inventarioEdit">
            </div>
            <div class="col-12">
                <label for="">imagen</label>
                <input type="file" class="form-control" placeholder="inserta tu nueva imagen" name="imagen" required id="imagenEdit">
            </div>

              <input type="hidden" id="idEditar" name="id">
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-outline-primary">Guardar</button>
            </div>
            </form>
          </div>
                    <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

</div>

<!-- ./wrapper -->

<!-- jQuery -->
<script src="./dashboard./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./dashboard./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./dashboard./dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./dashboard./dist/js/demo.js"></script>
<script>
  var idEliminar = 0;
  $(document).ready(function(){
    $(".btnEliminar").click( function(){
      idEliminar=$(this).data('id');
      $("#idEliminar").val(idEliminar);
    });

    $(".btnEdit").click(function(){
      var idEdit=$(this).data('id');
      var nombre=$(this).data('nombre');
      var precio=$(this).data('precio');
      var inventario=$(this).data('inventario');

      $("#idEditar").val(idEdit);
      $("#nombreEdit").val(nombre);
      $("#precioEdit").val(precio);
      $("#inventarioEdit").val(inventario);
      
    });
  });

 
</script>
</body>
</html>