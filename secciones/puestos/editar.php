<?php
include("../../bd.php");
$objConexion = new CConexion();

// Obtener la conexión a la base de datos
$conexion = $objConexion->conexionBD();
if(isset($_GET['txtID'])){
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";
    $sentencia = $conexion->prepare("SELECT * FROM puestos WHERE id = :id");

    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $nombrePuesto = $registro["npuesto"];
}
if ($_POST) {
    print_r($_POST);
    $txtID = isset($_POST['txtID']) ? $_POST['txtID'] : "";
    $nombrePuesto = isset($_POST["nombrePuesto"]) ? $_POST["nombrePuesto"] : "";
  
    // Corrige la sentencia de actualización
    $sentencia = $conexion->prepare("UPDATE puestos SET npuesto=:nombrePuesto WHERE id=:id");

    $sentencia->bindParam(':nombrePuesto', $nombrePuesto);
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    header("location: index.php?mensaje=Registro editado");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Puesto</title>
    <!-- Agregar tus enlaces CSS, scripts y otros recursos aquí -->
</head>

<body>
    <?php include("../../templates/header.php"); ?>

    <div class="card">
        <div class="card-header">Editar Puesto</div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="" class="form-label">id</label>
                    <input
                        type="text"
                        class="form-control"
                        name="txtID"
                        id="txtID"
                        value="<?php echo htmlspecialchars($txtID); ?>"
                        aria-describedby="helpId"
                        placeholder=""
                    />
                              </div>
                
                <div class="mb-3">
               
                <br/>
                    <label for="nombrePuesto" class="form-label">Nombre de puesto</label>
                    <input
                        type="text"
                        class="form-control"
                        name="nombrePuesto"
                        id="nombrePuesto"
                        value="<?php echo htmlspecialchars($nombrePuesto); ?>"
                        aria-describedby="helpId"
                        placeholder="Nombre de puesto"
                    />
                </div>
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a class="btn btn-primary" href="index.php" role="button">Cancelar</a>
            </form>
        </div>
    </div>

    <?php include("../../templates/footer.php"); ?>
    <!-- Agregar tus scripts al final del cuerpo del documento, si es necesario -->
</body>

</html>

<?php

?>
