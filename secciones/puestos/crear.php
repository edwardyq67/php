<?php
include("../../bd.php");
$objConexion = new CConexion();

// Obtener la conexión a la base de datos
$conexion = $objConexion->conexionBD();
if ($_POST) {
    print_r($_POST);
    $nombrePuesto = (isset($_POST["nombrePuesto"]) ? $_POST["nombrePuesto"] : "");
 
  
    $sentencia = $conexion->prepare("INSERT INTO puestos ( npuesto) VALUES ( :nombrePuesto)");

          
    $sentencia->bindParam(':nombrePuesto', $nombrePuesto);
    $sentencia->execute();
    header("location: index.php?mensaje=Registro creado");
  
}
?>

<?php include("../../templates/header.php"); ?>
<div class="card">
    <div class="card-header">Puesto</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="" class="form-label">Name de puesto</label>
                <input
                    type="text"
                    class="form-control"
                    name="nombrePuesto"
                    id=""
                    aria-describedby="helpId"
                    placeholder="Nombre de puesto"
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