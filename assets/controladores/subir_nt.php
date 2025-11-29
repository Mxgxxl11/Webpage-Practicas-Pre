<?php  
include 'bd.php'; 
session_start();  
$codigo = $_SESSION['codigo_institucional'];
$nt = $_POST['nt'];

if(strlen($nt) != 6 || $nt == '000000'){
    echo 'Número de tramite invalido.';  
    exit(); 
}

$query2 = "UPDATE alumno SET nt = '$nt' WHERE id_usuario = '$codigo';";
$stmt2 = mysqli_prepare($conexion, $query2);
if (!$stmt2) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
$ejecutar2 = mysqli_stmt_execute($stmt2); 

$query = "UPDATE paso_cp SET paso = 4 WHERE id_usuario = '$codigo'";
$stmt = mysqli_prepare($conexion, $query);

if (!$stmt) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
$ejecutar = mysqli_stmt_execute($stmt); 

if ($ejecutar and $ejecutar2) {    
    $_SESSION['paso_cp'] = '4';
    echo ' Datos almacenados exitosamente ';  
} else {  
    echo '  
            alert("Error al almacenar los datos. Inténtelo nuevamente.");   
         ';  
    echo "Error: " . mysqli_error($conexion);  
}

mysqli_close($conexion);
?>
