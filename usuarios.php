<?php

session_start();
if (!isset($_SESSION['userData'])) {
  header("Location: ./login.php");
}
$userData = $_SESSION['userData'];

include "./php/conexion.php";
$resultado = $conexion->query("select * from usuarios order by id DESC") or die($conexion->error);



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mi Tienda</title>


  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
 
  <link rel="stylesheet" href="./dashboard./plugins/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="./dashboard./dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">

  <div class="wrapper">
  
    <?php include "./layouts/header.php"; ?>
  
    <?php include "./layouts/sidebar.php" ?>



   
    <div class="content-wrapper">

     
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Usuarios</h1>
            </div>

          </div>
        </div>
      </section>

     
      <section class="content">

      
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Agregar Usuarios</h3>

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
            if (isset($_GET['error'])) {
            ?>
              <div class="alert alert-danger">
                <b>Error</b> <?php echo $_GET['error'] ?>
              </div>
            <?php
            }
            if (isset($_GET['success'])) {
            ?>
              <div class="alert alert-success">
                <b>Listo</b> <?php echo $_GET['success'] ?>
              </div>
            <?php
            }
            ?>

            <form action="./php/insertarusuario.php" class="row" method="POST">
              <div class="col-4">
                <label for="">Nombre</label>
                <input type="text" class="form-control" placeholder="inserta tu Nombre" name="nombre" id="txtnombre" required="">
               
              </div>
              <div class="col-4">
                <label for="">Apellido</label>
                <input type="text" class="form-control" placeholder="inserta tu Apellido" name="ap" required="">
              </div>
              <div class="col-4">
                <label for="">Email</label>
                <input type="email" class="form-control" placeholder="inserta tu E-Mail" name="email" required="">
              </div>
              <div class="col-4">
                <label for="">Password</label>
                <input type="password" class="form-control" placeholder="password" name="pass" required="">
              </div>
              <div class="col-4">
                <label for="">Confirma tu password</label>
                <input type="password" class="form-control" placeholder="confirma tu password" name="p2" required="">
              </div>
              <div class="col-4 p-2">
                <br>
                <button class="btn btn-primary"><i class="fa fa-plus"></i> Insertar</button>
              </div>

            </form>
          </div>
        </div>
  
        <h2 class="subtitle"> Usuarios</h2>
        <table class="table">
          <thead>
            <th>Id</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Password</th>
            <th></th>
          </thead>
          <tbody>
            <?php
            while ($fila = mysqli_fetch_array($resultado)) {


            ?>
              <tr>
                <td><?php echo $fila['id']; ?></td>
                <td><?php echo $fila['nombre'] . ' ' . $fila['apellido']; ?></td>
                <td><?php echo $fila['email'] ?></td>
                <td>********</td>
                <td>

                  <button class="btn btn-sm btn-warning btnEdit" data-id="<?php echo $fila['id']; ?>" data-nombre="<?php echo $fila['nombre']; ?>" data-ap="<?php echo $fila['apellido']; ?>" data-email="<?php echo $fila['email']; ?>" data-toggle="modal" data-target="#modal-editar"><i class="fa fa-edit"></i></button>

                  <button class="btn btn-sm btn-danger btnEliminar" data-id="<?php echo $fila['id']; ?>" data-toggle="modal" data-target="#modal-eliminar"><i class="fa fa-trash"></i></button>
                </td>
              </tr>

            <?php } ?>
          </tbody>
        </table>

      </section>
    
    </div>
  

    <?php include "./layouts/footer.php"; ?>
   
    <div class="modal fade" id="modal-eliminar">
      <div class="modal-dialog">
        <div class="modal-content bg-danger">
          <div class="modal-header">
            <h4 class="modal-title">Eliminar Usuario</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="./php/eliminarusuario.php" method="POST">
            <div class="modal-body">
              <p>deseas eliminar el usuario?</p>
              <input type="hidden" id="idEliminar" name="id">
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-outline-light">Eliminar</button>
            </div>
          </form>
        </div>
       
      </div>
    
    </div>

  </div>

  <div class="modal fade" id="modal-editar">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Editar Usuario</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="./php/editarusuario.php" method="POST">
          <div class="modal-body">

            <div class="col-12">
              <label for="">Nombre</label>
              <input type="text" class="form-control" placeholder="inserta tu Nombre" name="nombre" id="nombreEdit" required="">
             
            </div>
            <div class="col-12">
              <label for="">Apellido</label>
              <input type="text" class="form-control" placeholder="inserta tu Apellido" name="ap" required id="apEdit">
            </div>
            <div class="col-12">
              <label for="">Email</label>
              <input type="email" class="form-control" placeholder="inserta tu E-Mail" name="email" required id="mailEdit">
            </div>
            <div class="col-12">
              <label for="">Password</label>
              <input type="password" class="form-control" placeholder="password" name="pass">
            </div>
            <div class="col-12">
              <label for="">Confirma tu password</label>
              <input type="password" class="form-control" placeholder="confirma tu password" name="p2">
            </div>

            <input type="hidden" id="idEditar" name="id">
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-outline-primary">Guardar</button>
          </div>
        </form>
      </div>

    </div>

  </div>


  </div>


  <script src="./dashboard./plugins/jquery/jquery.min.js"></script>

  <script src="./dashboard./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="./dashboard./dist/js/adminlte.min.js"></script>

  <script src="./dashboard./dist/js/demo.js"></script>
  <script>
    var idEliminar = 0;
    $(document).ready(function() {
      $(".btnEliminar").click(function() {
        idEliminar = $(this).data('id');
        $("#idEliminar").val(idEliminar);
      });

      $(".btnEdit").click(function() {
        var idEdit = $(this).data('id');
        var nombre = $(this).data('nombre');
        var apellidos = $(this).data('ap');
        var email = $(this).data('email');

        $("#idEditar").val(idEdit);
        $("#nombreEdit").val(nombre);
        $("#apEdit").val(apellidos);
        $("#mailEdit").val(email);

      });
    });
  </script>
</body>

</html>