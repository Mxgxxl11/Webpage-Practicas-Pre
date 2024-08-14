<?php  
include 'bd.php'; 
session_start();  
$codigo = $_SESSION['codigo_institucional'];
$codigo_a = $_POST['codigo_a'];
$nota_a = $_POST['nota_a'];

$result = mysqli_query($conexion, "SELECT id_alumno FROM alumno WHERE id_usuario = '$codigo_a'");
$row = mysqli_fetch_assoc($result);
$id_alumno = $row['id_alumno'];

$result2 = mysqli_query($conexion, "SELECT id_docente FROM docente WHERE id_usuario = '$codigo'");
$row2 = mysqli_fetch_assoc($result2);
$id_docente = $row2['id_docente'];

$result3 = mysqli_query($conexion, "SELECT trabajo_final FROM calificaciones WHERE (id_docente = '$id_docente' AND id_alumno = '$id_alumno')");
$row3 = mysqli_fetch_assoc($result3);
$trabajo_final = $row3['trabajo_final'];

$result4 = mysqli_query($conexion, "SELECT examen_final FROM calificaciones WHERE (id_docente = '$id_docente' AND id_alumno = '$id_alumno')");
$row4 = mysqli_fetch_assoc($result4);
$examen_final = $row4['examen_final'];

$promedio = ($trabajo_final + $examen_final + $nota_a) / 3;
$fecha = date("Y-m-d");

$query = "UPDATE calificaciones SET promedio_final = '$promedio', fecha_calificacion = '$fecha' WHERE (id_docente = '$id_docente' AND id_alumno = '$id_alumno');";
$stmt = mysqli_prepare($conexion, $query);
if (!$stmt) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
$ejecutar = mysqli_stmt_execute($stmt);

$query2 = "UPDATE calificaciones SET apreciacion = '$nota_a' WHERE (id_docente = '$id_docente' AND id_alumno = '$id_alumno');";
$stmt2 = mysqli_prepare($conexion, $query2);
if (!$stmt2) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
$ejecutar2 = mysqli_stmt_execute($stmt2); 

 $query = "UPDATE paso_cp SET paso = 15 WHERE id_usuario = '$codigo_a'";
 $stmt = mysqli_prepare($conexion, $query);

 if (!$stmt) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
 $ejecutar3 = mysqli_stmt_execute($stmt); 

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
