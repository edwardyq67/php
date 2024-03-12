<?php
include("../../bd.php");

// Crear una instancia de la clase CConexion (suponiendo que esta clase existe en el archivo bd.php)
$objConexion = new CConexion();

// Obtener la conexión a la base de datos
$conexion = $objConexion->conexionBD();

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['txtID'])) {
    // Si se recibió un ID para eliminar un usuario
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";

    // Preparar la consulta para eliminar el usuario
    $sentencia = $conexion->prepare("DELETE FROM usuarios WHERE id = :id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    header("location: index.php?mensaje=Registro eliminado");
    exit; // Importante: detener la ejecución del script después de redireccionar
}

// Obtener la lista de usuarios después de la posible eliminación
if ($conexion instanceof PDO) {
    try {
        $sentencia = $conexion->prepare("SELECT * FROM usuarios");
        $sentencia->execute();
        $lista_usuario = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
        echo "Error en la consulta: " . $th->getMessage();
    }
}
?>

<?php include("../../templates/header.php"); ?>
<div class="card">
    <div class="card-header"> <a name="" id="" class="btn btn-dark" href="crear.php" role="button">Agragar Usuario</a>
    </div>
    <div class="card-body">

        <div class="table-responsive-sm">
            <table class="table " id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Contraseña</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador = 1; // Inicializamos el contador
                    foreach ($lista_usuario as $registro) { ?>
                        <tr>
                        <td style="height: 4.5vh;"><?php echo $contador ?></td>
<td style="height: 4.5vh;"><?php echo  $registro['usuario'] ?></td>
<td style="height: 4.5vh;"><?php echo str_repeat('*', strlen($registro['contrasena'])); ?></td>
<td style="height: 4.5vh;"><?php echo  $registro['correo'] ?></td>
<td style="height: 4.5vh;" class="d-flex justify-content-around">
    <a style="width:90px;" name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $registro['id'] ?>" role="button">Eliminar</a>
    <a style="width:90px;" name="" id="" class="btn btn-success" href="editar.php?txtID=<?php echo $registro['id'] ?>" role="button">Editar</a>
</td>

                        </tr>
                    <?php
                        $contador++; // Incrementamos el contador
                    } ?>


                </tbody>
            </table>
        </div>
    </div>

</div>


<?php include("../../templates/footer.php"); ?>