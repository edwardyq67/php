<?php
include("./templates/header.php"); 
include("./bd.php");
$objConexion = new CConexion();

// Obtener la conexión a la base de datos
$conexion = $objConexion->conexionBD();

// Verificar si el usuario está logeado
if (isset($_SESSION['correo']) && isset($_SESSION['contrasena'])) {
    // Realizar una consulta para obtener la información del usuario
    $correo = $_SESSION['correo'];
    $contrasena = $_SESSION['contrasena'];

    $sentencia = $conexion->prepare("SELECT * FROM usuarios WHERE correo=:correo AND contrasena=:contrasena");
    $sentencia->bindParam(":correo", $correo);
    $sentencia->bindParam(":contrasena", $contrasena);
    $sentencia->execute();

    
    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

}
?>

<div class="p-5 mb-4 bg-dark-subtle rounded-3" >
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">  <?php echo $usuario['usuario']?></h1>
        <p class="col-md-8 fs-4">
        No dudes en acercarte si necesitas alguna orientación o apoyo durante tus primeros días. Estamos aquí para ayudarte en tu integración y para asegurarnos de que te sientas cómodo/a y valorado/a desde el primer momento.
        </p>
    
    </div>
</div>
<?php include("./templates/footer.php"); ?>
