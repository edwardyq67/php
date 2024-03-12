<?php
session_start();
include("./bd.php");
$objConexion = new CConexion();

// Obtener la conexión a la base de datos
$conexion = $objConexion->conexionBD();

if ($_POST) {
    $sentencia = $conexion->prepare("SELECT COUNT(*) as n_correo FROM usuarios
     WHERE correo=:correo AND contrasena=:contrasena");


    $correo = $_POST['correo']; // Modificado para usar $_POST['correo']
    $contrasena = $_POST['contrasena'];
    
    
    $sentencia->bindParam(":correo", $correo);
    $sentencia->bindParam(":contrasena", $contrasena);
    
    $sentencia->execute();

    $lista_tbl_correo = $sentencia->fetch(PDO::FETCH_LAZY);
    if($lista_tbl_correo["n_correo"] > 0){

        $_SESSION['correo']=$correo; // Modificado para usar $correo
        $_SESSION['contrasena'] = $contrasena;
        $_SESSION['logeado']=true;

        // Imprimir la sesión antes de la redirección
       

        header("Location:index.php");
        exit(); // Terminamos la ejecución del script después de la redirección
    } else {
        $mensaje = "Error: El correo electrónico o la contraseña son incorrectos.";
    }
}
?>

<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <title> </title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="css.css">
</head>

<body class="bg-body-secondary" >
    <header>
        <!-- place navbar here -->
    </header>
    <?php if(isset($mensaje)){?>
         <div
        class="alert alert-danger"
        role="alert"
    >
        <strong><?php echo $mensaje; ?></strong>
    </div>
    <?php }?>
   
    
    <main class="container d-flex justify-content-center align-items-center">
        <div class="wrapper rounded bg-body-secondary ">
        <h6><b>CORREO: </b> puesto@gmail.com</h6>  
                            <h6><b>CONTRASEÑA: </b>12345</h6>  
            <div class="card-switch bg-light">
              
                    <div class="flip-card__inner">
                        <div class="flip-card__front">
                            <div class="title"> 
                            
                            Log in</div>
                            <form class="flip-card__form" method="post" action="">
                                <input class="flip-card__input" name="correo" placeholder="Email" type="text">
                                <input class="flip-card__input" name="contrasena" placeholder="Password" type="password">
                                <button type="submit" class="flip-card__btn">Let`s go!</button>
                            </form>
                        </div>
                     