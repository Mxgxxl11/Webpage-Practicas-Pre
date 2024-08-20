<?php  
include 'bd.php'; // Conectar a la base de datos  
session_start();  

$codigo_a = $_GET['codigo_a']; // Código del alumno proporcionado a través de GET  
$nombre_archivo = 'Examen Final Resuelto'; // Nombre del archivo  
$ruta_archivo = '';

// Recuperar información del archivo desde la base de datos  
$query = "SELECT ruta FROM archivos WHERE nombre_archivo = ? AND id_carpeta IN (SELECT id_carpeta FROM carpeta_virtual WHERE id_alumno = (SELECT id_alumno FROM alumno WHERE id_usuario = ?))";  

$stmt = $conexion->prepare($query);  
$stmt->bind_param("si", $nombre_archivo, $codigo_a);  
$stmt->execute();  
$stmt->bind_result($ruta_archivo);  
$stmt->fetch();  
$stmt->close();  

if (!$ruta_archivo || !file_exists($ruta_archivo)) {
    echo '  
        <script>  
            alert("Archivo no encontrado.");   
            window.location = "./../../docente-evalua.php?codigo=' . $codigo_a . '";
        </script>';   
    exit();  
}  

// Enviar headers para la descarga  
header('Content-Description: File Transfer');  
header('Content-Type: application/pdf'); // Cambia el tipo MIME si es diferente  
header('Content-Disposition: attachment; filename="' . basename($ruta_archivo) . '"');  
header('Expires: 0');  
header('Cache-Control: must-revalidate');  
header('Pragma: public');  
header('Content-Length: ' . filesize($ruta_archivo));  

// Leer el archivo y enviarlo al output  
readfile($ruta_archivo);  
exit;
?>