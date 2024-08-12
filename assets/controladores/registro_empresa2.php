<?php  
include 'bd.php'; 
session_start();  
$codigo = $_SESSION['codigo_institucional'];
$jefeInmediato = $_POST['jefeInmediato'];
$areaTrabajo = $_POST['areaTrabajo'];
$telefonoCelular = $_POST['telefonoCelular'];
$nombreEmpresa = $_POST['nombreEmpresa'];
$rucEmpresa = $_POST['rucEmpresa'];
$direccionEmpresa = $_POST['direccionEmpresa'];
$fechaInicio = $_POST['fechaInicio'];
$fechaCulminacion = $_POST['fechaCulminacion'];
// Convierte las fechas a objetos DateTime
$inicio = new DateTime($fechaInicio);
$culminacion = new DateTime($fechaCulminacion);

$intervalo = $inicio->diff($culminacion);  
$meses = $intervalo->y * 12 + $intervalo->m; // Total de meses  
$horas = ($intervalo->days * 24) + $intervalo->h; // Total de horas 

$result = mysqli_query($conexion, "SELECT id_alumno FROM alumno WHERE id_usuario = '$codigo'");  
$row = mysqli_fetch_assoc($result);
$id_alumno = $row['id_alumno'];

$result2 = mysqli_query($conexion, "SELECT id_empresa FROM empresa WHERE nombre_empresa = '$nombreEmpresa'");  
$row2 = mysqli_fetch_assoc($result2);
$id_empresa = $row2['id_empresa'];

$query2 = "UPDATE empresa SET razon_social = '$nombreEmpresa', jefe_inmediato = '$jefeInmediato' WHERE id_empresa = '$id_empresa';";
$stmt2 = mysqli_prepare($conexion, $query2);
if (!$stmt2) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
$ejecutar2 = mysqli_stmt_execute($stmt2); 

$query = "UPDATE practicas SET area_trabajo = '$areaTrabajo', fecha_inicio = '$fechaInicio', fecha_final = '$fechaCulminacion', horas = '$horas', meses = '$meses'  WHERE id_empresa = '$id_empresa';";
$stmt = mysqli_prepare($conexion, $query);
if (!$stmt) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
$ejecutar = mysqli_stmt_execute($stmt); 

if ($ejecutar and $ejecutar2) {    
    echo ' Datos almacenados exitosamente ';  
} else {  
    echo '  
            alert("Error al almacenar los datos. Inténtelo nuevamente.");   
         ';  
    echo "Error: " . mysqli_error($conexion);  
}

mysqli_close($conexion);
?>