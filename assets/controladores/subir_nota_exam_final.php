$result2 = mysqli_query($conexion, "SELECT id_docente FROM docente WHERE id_usuario = '$codigo'");
$row2 = mysqli_fetch_assoc($result2);
$id_docente = $row2['id_docente'];

$query2 = "UPDATE calificaciones SET examen_final = '$nota_e' WHERE (id_docente = '$id_docente' AND id_alumno = '$id_alumno');";
$stmt2 = mysqli_prepare($conexion, $query2);
if (!$stmt2) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
$ejecutar2 = mysqli_stmt_execute($stmt2); 

 $query = "UPDATE paso_cp SET paso = 14 WHERE id_usuario = '$codigo_a'";
 $stmt = mysqli_prepare($conexion, $query);

 if (!$stmt) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
 $ejecutar = mysqli_stmt_execute($stmt); 

if ($ejecutar2) {    
    $_SESSION['paso_cp'] = '14';
    echo ' Datos almacenados exitosamente ';  
} else {  
    echo '  
            alert("Error al almacenar los datos. Inténtelo nuevamente.");   
         ';  
    echo "Error: " . mysqli_error($conexion);  
}

mysqli_close($conexion);
?>
