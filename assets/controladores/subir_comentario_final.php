<?php  
include 'bd.php'; 
session_start();  
$codigo = $_SESSION['codigo_institucional'];
$codigo_a = $_POST['codigo_a'];
$comentario = $_POST['comentario'];

$result = mysqli_query($conexion, "SELECT id_alumno FROM alumno WHERE id_usuario = '$codigo_a'");
$row = mysqli_fetch_assoc($result);
$id_alumno = $row['id_alumno'];

$result2 = mysqli_query($conexion, "SELECT id_docente FROM docente WHERE id_usuario = '$codigo'");
$row2 = mysqli_fetch_assoc($result2);
$id_docente = $row2['id_docente'];

$query2 = "UPDATE calificaciones SET comentario_calificacion = '$comentario' WHERE (id_docente = '$id_docente' AND id_alumno = '$id_alumno');";
$stmt2 = mysqli_prepare($conexion, $query2);
if (!$stmt2) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
$ejecutar2 = mysqli_stmt_execute($stmt2); 

// $query = "UPDATE paso_cp SET paso = 4 WHERE id_usuario = '$codigo'";
// $stmt = mysqli_prepare($conexion, $query);

// if (!$stmt) {  
//    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
//    exit();  
//} 
// $ejecutar = mysqli_stmt_execute($stmt); 

if ($ejecutar2) {    
    //$_SESSION['paso_cp'] = '4';
    echo ' Datos almacenados exitosamente ';  
} else {  
    echo '  
            alert("Error al almacenar los datos. Inténtelo nuevamente.");   
         ';  
    echo "Error: " . mysqli_error($conexion);  
}

mysqli_close($conexion);
?>