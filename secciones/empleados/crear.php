<?php
    include("../../bd.php");
    $objConexion = new CConexion();
    
    // Obtener la conexión a la base de datos
    $conexion = $objConexion->conexionBD();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $pnombre = isset($_POST['pnombre']) ? $_POST['pnombre'] : "";
        $snombre = isset($_POST['snombre']) ? $_POST['snombre'] : "";
        $papellido = isset($_POST['papellido']) ? $_POST['papellido'] : "";
        $sapellido = isset($_POST['sapellido']) ? $_POST['sapellido'] : "";

        $foto = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : "";
        $cv = isset($_FILES['cv']['name']) ? $_FILES['cv']['name'] : "";
        
        $fechaIngreso = isset($_POST['fechaIngleso']) ? $_POST['fechaIngleso'] : "";
        $puesto=isset($_POST['idpuesto'])?$_POST['idpuesto']:"";
        // Preparar la consulta para insertar datos
        $sentencia = $conexion->prepare('INSERT INTO empleados (pnombre, snombre, papellido, sapellido, foto, cv,idpuesto, fechaingreso) VALUES (:pnombre, :snombre, :papellido, :sapellido, :foto, :cv,:idpuesto ,:fechaIngreso)');

        // Bind de parámetros
        $sentencia->bindParam(':pnombre', $pnombre);
        $sentencia->bindParam(':snombre', $snombre);
        $sentencia->bindParam(':papellido', $papellido);
        $sentencia->bindParam(':sapellido', $sapellido);

        // nombrar y que sea unico
        $fecha_ = new DateTime();
        $nombreArchivo_foto = ($foto != '') ? $fecha_->getTimestamp() . "_" . $_FILES["foto"]['name'] : "";
        $tmp_foto = $_FILES["foto"]['tmp_name'];
        if ($tmp_foto != "") {
            move_uploaded_file($tmp_foto, "./" . $nombreArchivo_foto);
        }
        $sentencia->bindParam(':foto', $nombreArchivo_foto);

        $fecha_cv = new DateTime();
        $nombreArchivo_cv = ($cv != '') ? $fecha_->getTimestamp() . "_" . $_FILES["cv"]['name'] : "";
        $tmp_cv = $_FILES["cv"]['tmp_name'];
        if ($tmp_cv != "") {
            move_uploaded_file($tmp_cv, "./" . $nombreArchivo_cv);
        }
        $sentencia->bindParam(':cv', $nombreArchivo_cv);


        $sentencia->bindParam(':idpuesto', $puesto);
        $sentencia->bindParam(':fechaIngreso', $fechaIngreso);

        // Ejecutar la consulta
        $sentencia->execute();

        // Redireccionar a la página de inicio
        header("location: index.php?mensaje=Registro creado");
        exit();
    }

    // Consultar los puestos disponibles
    $lista_puesto = [];
    if ($conexion instanceof PDO) {
        try {
            $sentencia = $conexion->prepare("SELECT * FROM puestos");
            $sentencia->execute();
            $lista_puesto = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    }
?>
<?php include("../../templates/header.php"); ?>
<div class="card">
    <div class="card-header">Datos del Empleado</div>
    <div class="card-body">
       <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="PrimerNombre" class="form-label">Primer Nombre:</label>
            <input
                type="text"
                class="form-control"
                name="pnombre"
                id=""
                aria-describedby="helpId"
                placeholder="Primer Nombre"
            />
            
        </div>
        
        <div class="mb-3">
            <label for="SegundoNombre" class="form-label">Segundo Nombre:</label>
            <input
                type="text"
                class="form-control"
                name="snombre"
                id=""
                aria-describedby="helpId"
                placeholder="Segundo Nombre"
            />
            
        </div>
        <div class="mb-3">
            <label for="PrimerApellido" class="form-label">Primer Apellido:</label>
            <input
                type="text"
                class="form-control"
                name="papellido"
                id=""
                aria-describedby="helpId"
                placeholder="Primer Apellido"
            />
            
        </div>
        <div class="mb-3">
            <label for="SegundoApellido" class="form-label">Segundo Apellido:</label>
            <input
                type="text"
                class="form-control"
                name="sapellido"
                id=""
                aria-describedby="helpId"
                placeholder="Segundo Apellido"
            />
            
        </div>
        <div class="mb-3">
            <label for="Foto" class="form-label">Foto :</label>
            <input
                type="file"
                class="form-control"
                name="foto"
                id=""
                aria-describedby="helpId"
                placeholder="Foto"
            />
            
        </div>
        <div class="mb-3">
            <label for="CV(pdf)" class="form-label">CV(pdf):</label>
            <input
                type="file"
                class="form-control"
                name="cv"
                id=""
                aria-describedby="helpId"
                placeholder="CV(pdf)"
            />
            
        </div>
        <div class="mb-3">
            <label for="idpuesto" class="form-label">Puesto: </label>
            <select
                class="form-select form-select-sm"
                name="idpuesto"
                id="idpuesto"
            >
           
            <?php foreach ($lista_puesto as $registro): ?>
        <option value="<?php echo $registro['id']; ?>"><?php echo $registro['npuesto']; ?></option>
    <?php endforeach; ?>
                 <option selected>Select one</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="fechaIngleso" class="form-label">Fecha de ingreso:</label>
            <input
                type="date"
                class="form-control"
                name="fechaIngleso"
                id="fechaIngleso"
                aria-describedby="emailHelpId"
                placeholder="Fecha de ingreso"
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