<?php
include 'bd.php'; // Conectar a la base de datos  
session_start();

$codigo_a = $_SESSION['codigo_institucional']; // Código del alumno proporcionado a través de GET  
$nombre_archivo = 'Carta de presentacion'; // Nombre del archivo como se guarda en la BD
$ruta_archivo = '';

// Recuperar información del archivo desde la base de datos  
$query = "SELECT ruta FROM archivos WHERE nombre_archivo = ? AND id_carpeta IN (SELECT id_carpeta FROM carpeta_virtual WHERE id_alumno = (SELECT id_alumno FROM alumno WHERE id_usuario = ?))";

$stmt = $conexion->prepare($query);
$stmt->bind_param("si", $nombre_archivo, $codigo_a);
$stmt->execute();
$stmt->bind_result($ruta_archivo);
$stmt->fetch();
$stmt->close();

if (!$ruta_archivo) {
    exit('Archivo no encontrado. La carta de presentación aún no ha sido generada por el administrador.');
}

// La ruta en BD es relativa desde la raíz del proyecto
// Ejemplo: ./../carpetas_virtuales/2025_8-Castro_Jimenez/CARTA_PRESENTACION-2022015401.docx
// Esto significa: assets/carpetas_virtuales/...

// Limpiar la ruta quitando ./ y ../
$ruta_limpia = str_replace(['../', './'], '', $ruta_archivo);
// Resultado: carpetas_virtuales/2025_8-Castro_Jimenez/CARTA_PRESENTACION-2022015401.docx

// Construir la ruta absoluta
// __DIR__ = C:\...\assets\controladores
// Necesitamos: C:\...\assets\carpetas_virtuales\...
$ruta_absoluta = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $ruta_limpia;

// Normalizar la ruta para el sistema operativo actual
$ruta_absoluta = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $ruta_absoluta);

// Resolver la ruta real (elimina .. y . de la ruta)
$ruta_absoluta = realpath($ruta_absoluta);

if (!$ruta_absoluta || !file_exists($ruta_absoluta)) {
    // Si realpath falla o el archivo no existe, mostrar ruta sin normalizar para debug
    $ruta_debug = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $ruta_limpia;
    $ruta_debug = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $ruta_debug);
    exit('Archivo no encontrado en el servidor. Ruta esperada: ' . $ruta_debug);
}

// Enviar headers para la descarga  
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); // Tipo MIME para archivos .docx
header('Content-Disposition: attachment; filename="' . basename($ruta_archivo) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($ruta_absoluta));

// Lee el archivo y lo envía al usuario
readfile($ruta_absoluta);
exit;
