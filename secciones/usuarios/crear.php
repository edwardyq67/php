<?php

include("../../bd.php");
$objConexion = new CConexion();

// Obtener la conexión a la base de datos
$conexion = $objConexion->conexionBD();
if($_POST){
    print_r($_POST);
    $nombrePuesto=(isset($_POST['nombrePuesto'])? $_POST['nombrePuesto']:"");
    $contrasena=(isset($_POST['contrasena'])? $_POST['contrasena']:"");
    $correo=(isset($_POST['correo'])? $_POST['correo']:"");
    
    $sentencia=$conexion->prepare("INSERT INTO usuarios (usuario, contrasena, correo) VALUES (:nombrePuesto, :contrasenia, :correo)");
    
    $sentencia->bindParam(':nombrePuesto',$nombrePuesto); 
    $sentencia->bindParam(':contrasenia', $contrasena);
    $sentencia->bindParam(':correo',$correo);

    $sentencia->execute();
    header("location:index.php?mensaje=Registro creado");
   
}
?>
<?php include("../../templates/header.php"); ?>
<div class="card">
    <div class="card-header">CREAR NUEVO USUARIO</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="" class="form-label">Usuario</label>
                <input
                    type="text"
                    class="form-control"
                    name="nombrePuesto"
                    id=""
                    aria-describedby="helpId"
                    placeholder="Usuario"
                />
               
            </div>
            <div class="mb-3">
                <label for="" class="form-label">contrasena</label>
                <input
                    type="password"
                    class="form-control"
                    name="contrasena"
                    id=""
                    aria-describedby="helpId"
                    placeholder="contrasena"
                />
               
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Correo</label>
                <input
                    type="email"
                    class="form-control"
                    name="correo"
                    id=""
                    aria-describedby="helpId"
                    placeholder="Corre"
                />
               
            </div>
            <button
            type="submit"
            class="btn btn-success"
        >
            Agregar
        </button>
        <a
            name=""
            id=""
            class="btn btn-primary"
            href="index.php"
            role="button"
            >
            Cancelar</a
        >
        
        </form>
    </div>
    
</div>

<?php include("../../templates/footer.php"); ?> 