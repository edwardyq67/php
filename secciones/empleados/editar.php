<?php
   include("../../bd.php");
   $objConexion = new CConexion();
   
   // Obtener la conexión a la base de datos
   $conexion = $objConexion->conexionBD();
   if(isset($_GET['txtID'])){
       $txtID =( isset($_GET['txtID'])) ? $_GET['txtID'] : "";
       $sentencia = $conexion->prepare("SELECT * FROM empleados WHERE id=:id");
       $sentencia->bindParam(':id', $txtID);
       $sentencia->execute();
       $registro = $sentencia->fetch(PDO::FETCH_LAZY);
        
        // Asignar valores a variables
        $pnombre = $registro["pnombre"];
        $snombre = $registro["snombre"]; 
        $papellido = $registro["papellido"];
        $sapellido = $registro["sapellido"];

        $foto = $registro["foto"];
        $cv = $registro["cv"];

        $idpuesto = $registro["idpuesto"];
        $fechadeingreso = $registro["fechaingreso"];

        $sentencia = $conexion->prepare("SELECT * FROM puestos");
            $sentencia->execute();
            $lista_puesto = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    if($_POST){
        $txtID =( isset($_GET['txtID'])) ? $_GET['txtID'] : "";
        $pnombre = isset($_POST['pnombre']) ? $_POST['pnombre'] : "";
        $snombre = isset($_POST['snombre']) ? $_POST['snombre'] : "";
        $papellido = isset($_POST['papellido']) ? $_POST['papellido'] : "";
        $sapellido = isset($_POST['sapellido']) ? $_POST['sapellido'] : "";
 
        $fechaingreso = isset($_POST['fechaingreso']) ? $_POST['fechaingreso'] : "";
        $puesto=isset($_POST['idpuesto'])?$_POST['idpuesto']:"";
        // Preparar la consulta para insertar datos
        $sentencia = $conexion->prepare('UPDATE
        empleados SET pnombre=:pnombre ,snombre=:snombre , papellido=:papellido ,sapellido=:sapellido,idpuesto=:idpuesto,fechaingreso=:fechaingreso WHERE id=:id');
         
        // Bind de parámetros
        $sentencia->bindParam(':id', $txtID);
        $sentencia->bindParam(':pnombre', $pnombre);
        $sentencia->bindParam(':snombre', $snombre);
        $sentencia->bindParam(':papellido', $papellido);
        $sentencia->bindParam(':sapellido', $sapellido);

        $sentencia->bindParam(':idpuesto', $puesto);
        $sentencia->bindParam(':fechaingreso', $fechaingreso);
        
        $sentencia->execute();
        // agregar la nueva foto y eliminar el antiguo
        $foto = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : "";
        $fecha_=new Datetime();

        $nombreArchivo_foto = ($foto != '') ? $fecha_->getTimestamp() . "_" . $_FILES["foto"]['name'] : "";
        $tmp_foto = $_FILES["foto"]['tmp_name'];
        if ($tmp_foto != "") {
            move_uploaded_file($tmp_foto, "./" . $nombreArchivo_foto);
        
            $sentencia=$conexion->prepare("SELECT foto FROM empleados WHERE id=:id");
            $sentencia->bindParam(":id",$txtID);
            $sentencia->execute();
            $registro_recuperado=$sentencia->fetch(PDO::FETCH_LAZY);
            // eleimianr
            if(isset($registro_recuperado["foto"])&&$registro_recuperado["foto"]!=""){
                if(file_exists("./".$registro_recuperado["foto"])){
                    unlink("./".$registro_recuperado["foto"]);
                }
            }
            
        $sentencia= $conexion -> prepare('update empleados set foto = :foto where id=:id');
        $sentencia-> bindparam(':foto',$nombreArchivo_foto);
        $sentencia->bindParam(':id', $txtID);
        $sentencia-> execute();
        }
       
      
        $cv = isset($_FILES['cv']['name']) ? $_FILES['cv']['name'] : "";

        $nombreArchivo_cv = ($cv != '') ? $fecha_->getTimestamp() . "_" . $_FILES["cv"]['name'] : "";
        $tmp_cv = $_FILES["cv"]['tmp_name'];
        if ($tmp_cv != "") {
            move_uploaded_file($tmp_cv, "./" . $nombreArchivo_cv);
        
            $sentencia=$conexion->prepare("SELECT cv FROM empleados WHERE id=:id");
            $sentencia->bindParam(":id",$txtID);
            $sentencia->execute();
            $registro_recuperado=$sentencia->fetch(PDO::FETCH_LAZY);
            // eleimianr
            if(isset($registro_recuperado["cv"])&&$registro_recuperado["cv"]!=""){
                if(file_exists("./".$registro_recuperado["cv"])){
                    unlink("./".$registro_recuperado["cv"]);
                }
            }
            
        $sentencia= $conexion -> prepare('update empleados set cv=:cv where id=:id');
        $sentencia-> bindparam(':cv',$nombreArchivo_cv);
        $sentencia->bindParam(':id', $txtID);
        $sentencia-> execute();
        }
       
        header("location: index.php?mensaje=Registro editado");
        exit();
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
        id="SegundoNombre"
        value="<?php echo htmlspecialchars($pnombre); ?>"
        aria-describedby="helpId"
        placeholder="Segundo Nombre"
    />
        </div>
        
        <div class="mb-3">
            <label for="SegundoNombre" class="form-label">Segundo Nombre:</label>
            <input
                type="text"
                class="form-control"
                name="snombre"
                id=""
                value="<?php echo $snombre; ?>"
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
                value="<?php echo $papellido; ?>"
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
                value="<?php echo $sapellido; ?>"
                aria-describedby="helpId"
                placeholder="Segundo Apellido"
            />
            
        </div>
        <div class="mb-3">
            <label for="Foto" class="form-label">Foto :</label>
            <td><img src="<?php echo $foto ?> " class="mb-3 img-fluid rounded"  style="height: 30px;"></td> 
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
            <a href="<?php echo $cv; ?>" target="_blank"><i style="color: black; font-size: 2em;" class="fa-solid fa-file-pdf"></i></a>
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
        <option <?php echo ($idpuesto==$registro['id'])?"selected":""?> value="<?php echo $registro['id']; ?>"><?php echo $registro['npuesto']; ?></option>
    <?php endforeach; ?>
    
            </select>
        </div>
        <div class="mb-3">
            <label for="fechaIngleso" class="form-label">Fecha de ingreso:</label>
            <input
                type="date"
                class="form-control"
                name="fechaingreso"
                id="fechaingreso"
                value="<?php echo $fechadeingreso; ?>"
                aria-describedby="emailHelpId"
                placeholder="Fecha de ingreso"
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