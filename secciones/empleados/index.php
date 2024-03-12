<?php
include("../../bd.php");

// Crear una instancia de la clase CConexion (suponiendo que esta clase existe en el archivo bd.php)
$objConexion = new CConexion();

// Obtener la conexión a la base de datos
$conexion = $objConexion->conexionBD();
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['txtID'])) {
    // Si se recibió un ID para eliminar un usuario
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";
    // obtener datos fotos y cv
    $sentencia = $conexion->prepare("SELECT foto,cv FROM empleados WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);
    // eleimianr
    if (isset($registro_recuperado["foto"]) && $registro_recuperado["foto"] != "") {
        if (file_exists("./" . $registro_recuperado["foto"])) {
            unlink("./" . $registro_recuperado["foto"]);
        }
    }
    if (isset($registro_recuperado["cv"]) && $registro_recuperado["cv"] != "") {
        if (file_exists("./" . $registro_recuperado["cv"])) {
            unlink("./" . $registro_recuperado["cv"]);
        }
    }
    // Preparar la consulta para eliminar el usuario
    $sentencia = $conexion->prepare("DELETE FROM empleados WHERE id = :id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    header("location: index.php");
    exit; // Importante: detener la ejecución del script después de redireccionar
}
if ($conexion instanceof PDO) {
    try {
        // Ahora puedes realizar consultas con $conexion
        $sentencia = $conexion->prepare("SELECT *,(SELECT npuesto FROM  puestos WHERE puestos.id=empleados.idpuesto limit 1 ) as puesto FROM  empleados");  // No es necesario escapar las comillas dobles
        $sentencia->execute();
        $lista_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        // Imprimir la lista de puestos

    } catch (PDOException $e) {
        // Manejar errores específicos de PDO
        echo "Error en la consulta: " . $e->getMessage();
    }
} else {
    // Manejar el caso en que la conexión no se estableció correctamente
    echo "Error al conectar a la base de datos.";
}
?>
<?php include("../../templates/header.php"); ?>


<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-dark" href="crear.php" role="button">Agregar registro</a>
    </div>
    <div class="card-body">
        <!-- Agrega un elemento con el ID "mensaje" donde quieres mostrar el mensaje -->
        <div id="mensaje"></div>

        <script>
              
            // Función para mostrar el mensaje según el ancho de la ventana
            function mostrarMensaje() {
                var windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                var mensajeDiv = document.getElementById("mensaje");

                var valor = windowWidth > 1200; // Si el ancho de la ventana es mayor a 1400, valor será true, de lo contrario, será false

                // Verifica el valor de la variable
                if (valor) {
                    $(document).ready(function(){
        $("#tabla_id").DataTable({
            "pageLength": 5,
            "lengthMenu": [
                [3, 5, 10, 20],
                [3, 5, 10, 20] // Esto corresponde a los textos que se mostrarán en el menú
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json" // Corregido el enlace al archivo de idioma
            },
            "info": false,
       
      
        });
    });
                    // Si valor es true, muestra la tabla
                    mensajeDiv.innerHTML = `
                    <div class="table-responsive-sm">
                <table class="table" id="tabla_id">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Foto</th>
                            <th scope="col">CV</th>
                            <th scope="col">Puesto</th>
                            <th scope="col">Fecha de ingreso</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $contador = 1;
                        foreach ($lista_puestos as $registroPuesto) {
                        ?>
                            <tr class="">
                            <td style="height: 4.5vh;"><?php echo $contador ?></td>
                            <td style="height: 4.5vh; white-space: nowrap;" scope="row"><?= $registroPuesto['pnombre'] . ' ' . $registroPuesto['snombre'] . ' ' . $registroPuesto['papellido'] . ' ' . $registroPuesto['sapellido'] ?></td>

<td style="height: 4.5vh;" class=""><img src="<?= $registroPuesto['foto'] ?>" class="img-fluid rounded" style="height: 40px;"></td>
<td style="height: 4.5vh;"><a href="<?= $registroPuesto['cv'] ?>" target="_blank"><i style="color: black; font-size: 2em;" class="fa-solid fa-file-pdf"></i></a></td>
<td style="height: 4.5vh; white-space: nowrap;"><?= $registroPuesto['puesto'] ?></td>
<td style="height: 4.5vh; white-space: nowrap;"><?= $registroPuesto['fechaingreso'] ?></td>
<td style="height: 4.5vh;" class="d-flex justify-content-around">
    <a style="width:90px;height: auto" class=" btn btn-info" href="carta.php?txtID=<?php echo $registroPuesto['id'] ?>" role="button">Carta</a>
    <a style="width:90px;height: auto" name="" id="" class="btn btn-success" href="editar.php?txtID=<?php echo $registroPuesto['id'] ?>" role="button">Editar</a>
    <a style="width:90px;height: auto" name="" id="" class="btn btn-danger" href="index.php?txtID=<?php echo $registroPuesto['id'] ?>" role="button">Eliminar</a>
</td>

                            </tr>
                        <?php
                            $contador++; // Incrementamos el contador
                        }
                        ?>



                    </tbody>
                </table>
            </div>
                    `;
                } else {
                    $(document).ready(function(){
        $("#tabla_id").DataTable({
            "pageLength": 5,
            "lengthMenu": [
                [3, 5, 10, 20],
                [3, 5, 10, 20] // Esto corresponde a los textos que se mostrarán en el menú
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json" // Corregido el enlace al archivo de idioma
            },
            "info":false
        });
    });
                    mensajeDiv.innerHTML = `
                <div class="table-responsive-sm">
                    <table class="table" id="tabla_id">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nombre</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contador = 1;
                            foreach ($lista_puestos as $registroPuesto) {
                            ?>
                                <tr class="">
                                    <td><?php echo $contador ?></td>
                                    <td scope="row ">
                                        <?= $registroPuesto['pnombre'] . ' ' . $registroPuesto['snombre'] . ' ' . $registroPuesto['papellido'] . ' ' . $registroPuesto['sapellido'] ?>
                                    </td>
                                    <td> <i class="fa-solid fs-2 fa-sort-down" data-bs-toggle="collapse" href="#collapseExample<?php echo $contador ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $contador ?>"></i></td>
                                    
                                    <tr>
    <td colspan="3">
        <div class="collapse" id="collapseExample<?php echo $contador ?>">
            <div class="card card-body">
            <div style="text-align: center;">
    <img src="<?= $registroPuesto['foto'] ?>" class="mb-3 img-fluid rounded" style="min-width: 30%; max-width: 10vw; margin: auto;">
    <div class="mb-3 d-flex justify-content-center align-items-center" style="margin: auto;">
        <a href="<?= $registroPuesto['cv'] ?>" target="_blank"><i style="color: black; font-size: 2.5em;" class="me-4 fa-solid fa-file-pdf"></i></a>
        <div class="row justify-content-start">
    <div class="col-auto">
        <h6><b>PUESTO: </b><?= $registroPuesto['puesto'] ?></h6>
    </div>
    <div class="col-auto">
        <h6><b>FECHA: </b><?= $registroPuesto['fechaingreso'] ?></h6>
    </div>
    
</div>
    </div>
    <div class=" d-flex justify-content-around align-items-center">
<a style="width:90px" class="my-1 btn btn-info" href="carta.php?txtID=<?php echo $registroPuesto['id'] ?>" role="button">Carta</a>
                                    <a style="width:90px" name="" id="" class="my-1 btn btn-success" href="editar.php?txtID=<?php echo $registroPuesto['id'] ?>" role="button">Editar</a>
                                    <a style="width:90px" name="" id="" class="my-1 btn btn-danger" href="index.php?txtID=<?php echo $registroPuesto['id'] ?>" role="button">Eliminar</a>
    </div>
</div>

            </div>
        </div>
    </td>
</tr>
                                </tr>
                                
                               
                                
                                
                            <?php
                                $contador++; // Incrementamos el contador
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            `;
                }
            }

            // Llama a la función al cargar la página
            window.onload = mostrarMensaje;
        </script>


    </div>
</div>

<?php include("../../templates/footer.php"); ?>