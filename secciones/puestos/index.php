<?php
include("../../bd.php");

// Crear una instancia de la clase CConexion (suponiendo que esta clase existe en el archivo bd.php)
$objConexion = new CConexion();

// Obtener la conexión a la base de datos
$conexion = $objConexion->conexionBD();

if (isset($_GET['txtID'])) {
    $txtID = $_GET['txtID']; // No es necesario verificar de nuevo si está seteado
    $sentencia = $conexion->prepare("DELETE FROM puestos WHERE id = :id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();

    // Redireccionar con mensaje de éxito
    header("location: index.php?mensaje=Registro eliminado");
    exit; // Importante: detener la ejecución del script después de redireccionar
}

// Verificar si la conexión es válida antes de continuar
if (!($conexion instanceof PDO)) {
    // Manejar el caso en que la conexión no se estableció correctamente
    echo "Error al conectar a la base de datos.";
    exit; // Importante: detener la ejecución del script si la conexión no es válida
}

try {
    // Ahora puedes realizar consultas con $conexion
    $sentencia = $conexion->prepare("SELECT * FROM puestos");
    $sentencia->execute();
    $lista_puesto = $sentencia->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Manejar errores específicos de PDO
    echo "Error en la consulta: " . $e->getMessage();
    exit; // Importante: detener la ejecución del script si hay un error en la consulta
}
?>

<?php include("../../templates/header.php"); ?>

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-dark" href="crear.php" role="button">Agregar puesto</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre del puesto</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $contador = 1; // Inicializamos el contador
                    foreach ($lista_puesto as $registro) { ?>
                        <tr>
                        <td style="height: 4.5vh;"><?php echo $contador ?></td> <!-- Mostramos el contador -->
<td style="height: 4.5vh;"><?php echo $registro['npuesto'] ?></td>
<td style="height: 4.5vh;" class="d-flex justify-content-around">
    <a name="" id="" style="width:90px" class="btn btn-success" href="editar.php?txtID=<?php echo $registro['id'] ?>" role="button">Editar</a>
    <a name="" id="" style="width:90px" class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id'] ?>);" role="button">Eliminar</a>
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