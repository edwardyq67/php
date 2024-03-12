<?php
include("../../bd.php");
$objConexion = new CConexion();

// Obtener la conexión a la base de datos
$conexion = $objConexion->conexionBD();
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
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


    $tiempoInicio = new DateTime($fechadeingreso);
    $fechaFin = new DateTime(date("Y-m-d"));
    
    // Calcula la diferencia total en meses
    $diff = $tiempoInicio->diff($fechaFin);
    $totalMeses = $diff->y * 12 + $diff->m;
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
}
ob_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARTA DE RECOMENDACION</title>
</head>

<body >
<div class="container position-relative">
    <h1>Estimad@ <?= $pnombre . ' ' . $snombre . ' ' . $papellido . ' ' . $sapellido ?></h1>
    <div class="position-absolute top-0 end-0"></div>
   
    <p class="lh-base">He tenido el placer de trabajar con <?= $pnombre . ' ' . $snombre . ' ' . $papellido . ' ' . $sapellido ?> durante <b><?= $totalMeses ?> meses</b>, donde desempeñó el cargo de <b><?= $lista_puestos[0]['puesto'] ?></b>.</p>
    <p>Estoy seguro/a de que continuará teniendo un impacto positivo donde quiera que vaya.</p>
    <p>Si necesitas más información o tienes alguna pregunta, no dudes en contactarme.</p>
</div>

    
    
</body>

</html>
<?php
    $HTML=ob_get_clean();
    require_once("../../libs/dompdf/autoload.inc.php");
    use Dompdf\Dompdf;
    $dompdf = new DOMPDF();
    $opciones=$dompdf->getOptions(); 
    $opciones->set(array("isRemoteEnabled"=>true));
    $dompdf->setOptions($opciones);
    $dompdf->loadHtml($HTML);
    $dompdf->setPaper('latter');
    $dompdf->render();
    $dompdf->stream("archivo.pdf",array("Attachment"=>false));
?>