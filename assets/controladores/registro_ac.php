<?php  
include 'bd.php'; 
session_start();  
$codigo = $_SESSION['codigo_institucional']; 
$apellidos = $_SESSION['primer_apellido'] . '_' . $_SESSION['segundo_apellido'];
$fechaRegistroS = $_POST['fechaRegistroS'];
$fechaRecord = $_POST['fechaRecord'];
$fut = $_FILES['blob1'];  
$ficha_empresa = $_FILES['blob2']; 
$record_a = $_FILES['RecordAca'];
$CartaRec = $_FILES['CartaRec'];
$CartaAceptacion = $_FILES['CartaAceptacion'];
$id_tipoSolicitud = 2;
$estado = "Iniciado";
$numLiquidacion = 0;
$nt = 0;

// Obtener el id_rol basado en el código  
$result = mysqli_query($conexion, "SELECT id_alumno FROM alumno WHERE id_usuario = '$codigo'");  
$row = mysqli_fetch_assoc($result);  
$id_alumno = $row['id_alumno']; 

$result2 = mysqli_query($conexion, "SELECT id_carpeta FROM carpeta_virtual WHERE id_alumno = '$id_alumno'");  
$row = mysqli_fetch_assoc($result2);  
$id_carpeta = $row['id_carpeta'];

// Preparar la consulta  
$query = "INSERT INTO solicitud (id_alumno, id_carpeta, id_tipoSolicitud, fecha_solicitud, estado, fecha_recordAcademico, numero_liquidacion, nt_solicitud)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conexion, $query);  
if (!$stmt) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 

// Establecer los tipos de datos y enlazar los parámetros  
mysqli_stmt_bind_param($stmt, "iiisssii", $id_alumno, $id_carpeta, $id_tipoSolicitud, $fechaRegistroS, $estado, $fechaRecord, $numLiquidacion, $nt);  

// Ejecutar la consulta  
$ejecutar = mysqli_stmt_execute($stmt);  

$query2 = "UPDATE paso_cp SET paso = 4 WHERE id_usuario = '$codigo'";
$stmt2 = mysqli_prepare($conexion, $query2);

if (!$stmt2) {  
    echo "Error en la preparación de la consulta: " . mysqli_error($conexion);  
    exit();  
} 
$ejecutar2 = mysqli_stmt_execute($stmt2); 

$result3 = mysqli_query($conexion, "SELECT id_solicitud FROM solicitud WHERE id_alumno = '$id_alumno' AND id_tipoSolicitud = '$id_tipoSolicitud'");  
$row = mysqli_fetch_assoc($result3);  
$id_solicitud = $row['id_solicitud'];

if ($fut['error'] === UPLOAD_ERR_OK && $ficha_empresa['error'] === UPLOAD_ERR_OK && $record_a['error'] === UPLOAD_ERR_OK && $CartaRec['error'] === UPLOAD_ERR_OK && $CartaAceptacion['error'] === UPLOAD_ERR_OK) {  
    // Leer el contenido de los archivos  
    $contenido_fut = file_get_contents($fut['tmp_name']);  
    $contenido_ficha_empresa = file_get_contents($ficha_empresa['tmp_name']);
    $contenido_record_a = file_get_contents($record_a['tmp_name']);  
    $contenido_carta_rec = file_get_contents($CartaRec['tmp_name']);  
    $contenido_carta_acep = file_get_contents($CartaAceptacion['tmp_name']);    

    // Preparar la consulta SQL para insertar en la base de datos  
    $sql = "INSERT INTO documentos (id_solicitud, nombre_documento, contenido) VALUES (?, ?, ?)";  
    $sql2 = "INSERT INTO documentos (id_solicitud, nombre_documento, contenido) VALUES (?, ?, ?)";
    $sql3 = "INSERT INTO documentos (id_solicitud, nombre_documento, contenido) VALUES (?, ?, ?)";  
    $sql4 = "INSERT INTO documentos (id_solicitud, nombre_documento, contenido) VALUES (?, ?, ?)";
    $sql5 = "INSERT INTO documentos (id_solicitud, nombre_documento, contenido) VALUES (?, ?, ?)"; 
    
    $stmt = $conexion->prepare($sql);  
    $stmt2 = $conexion->prepare($sql2);
    $stmt3 = $conexion->prepare($sql3);  
    $stmt4 = $conexion->prepare($sql4); 
    $stmt5 = $conexion->prepare($sql5);  

    $nombre_archivo1 = "FUT";
    $nombre_archivo2 = "Ficha de Inscripción";
    $nombre_archivo3 = "Record Academico Actualizado";
    $nombre_archivo4 = "Carta de Presentacion";
    $nombre_archivo5 = "Carta de Aceptación";

    // Enlazar parámetros  
    $stmt->bind_param("isi", $id_solicitud, $nombre_archivo1, $contenido_fut);  
    $stmt2->bind_param("isi", $id_solicitud, $nombre_archivo2, $contenido_ficha_empresa);
    $stmt3->bind_param("isi", $id_solicitud, $nombre_archivo3, $contenido_record_a);  
    $stmt4->bind_param("isi", $id_solicitud, $nombre_archivo4, $contenido_carta_rec);  
    $stmt5->bind_param("isi", $id_solicitud, $nombre_archivo5, $contenido_carta_acep);      

    // Ejecutar la consulta  
    if ($stmt->execute() and $stmt2->execute() and $stmt3->execute() and $stmt4->execute() and $stmt5->execute()) {  
        echo "Archivos almacenados correctamente en la base de datos.";  
    } else {  
        echo "Error al almacenar los archivos: " . $stmt->error;  
    }  

    // Cerrar el statement  
    $stmt->close(); 
    $stmt2->close();
    $stmt3->close(); 
    $stmt4->close();
    $stmt5->close();
} else {  
    echo "Error al subir los archivos.";  
}  

if ($ejecutar and $ejecutar2) {  

    $_SESSION['paso_cp'] = '4'; // Cambia esto según el div que desees mostrar  

    echo ' Datos almacenados exitosamente ';  
} else {  
    echo '  
            alert("Error al almacenar los datos. Inténtelo nuevamente.");   
         ';  
    echo "Error: " . mysqli_error($conexion);  
}  

mysqli_close($conexion);
?>  