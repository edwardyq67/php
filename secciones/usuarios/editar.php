<?php
include("../../bd.php");
$objConexion = new CConexion();

// Obtener la conexión a la base de datos
$conexion = $objConexion->conexionBD();
if(isset($_GET['txtID'])){
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";
    $sentencia = $conexion->prepare("SELECT * FROM usuarios WHERE id = :id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $nombrePuesto = $registro["npuesto"];
    $contrasena = $registro["contrasena"]; // Cambiado a 'contrasena' para que coincida con el nombre de la columna en la base de datos
    $correo = $registro["correo"];
}  
if ($_POST) {
    
    
    $nombreUsuario = isset($_POST["nombrePuesto"]) ? $_POST["nombrePuesto"] : "";
    $contrasenaUsuario = isset($_POST["contrasena"]) ? $_POST["contrasena"] : ""; // Cambiado a 'contrasena' para que coincida con el nombre del campo en el formulario HTML
    $correoUsuario = isset($_POST["correo"]) ? $_POST["correo"] : "";

    $sentencia = $conexion->prepare("UPDATE usuarios SET npuesto=:nombrePuesto, contrasena=:contrasena, correo=:correo WHERE id=:id");

    $sentencia->bindParam(':nombrePuesto', $nombreUsuario);
    $sentencia->bindParam(':contrasena', $contrasenaUsuario); // Cambiado a 'contrasena' para que coincida con el nombre de la columna en la base de datos
    $sentencia->bindParam(':correo', $correoUsuario);
    $sentencia->bindParam(':id', $txtID);
    
    // Ejecutar la consulta y manejar errores
    try {
        $sentencia->execute();
        header("location: index.php?mensaje=Registro editado");
    } catch (PDOException $e) {
        echo "Error al actualizar el usuario: " . $e->getMessage();
    }
}
?>
<?php include("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">Usuario</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="" class="form-label">Nombre de Puesto</label>
                <input
                    type="text"
                    class="form-control"
                    name="nombrePuesto"
                    id=""
                    value="<?php echo htmlspecialchars($nombrePuesto); ?>"
                    aria-describedby="helpId"
                    placeholder="Nombre de Puesto"
                />
               
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Contraseña</label>
                <input
                    type="password"
                    class="form-control"
                    name="contrasena"
                    id=""
                    value="<?php echo htmlspecialchars($contrasena); ?>"
                    aria-describedby="helpId"
                    placeholder="Contraseña"
                />
               
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Correo</label>
                <input
                    type="email"
                    class="form-control"
                    name="correo"
                    id=""
                    value="<?php echo htmlspecialchars($correo); ?>"
                    aria-describedby="helpId"
                    placeholder="Corre"
                />
               
            </div>
            <button
            type="submit"
            class="btn btn-success"
        >
         Actualizar   
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
