<?php  
include 'bd.php'; // Conectar a la base de datos  
session_start(); 

// Activar modo debug si se pasa el parámetro debug=1
$debug = isset($_GET['debug']) && $_GET['debug'] == '1';

$codigo_a = $_SESSION['codigo_institucional']; // Código del alumno
$nombre_archivo = 'Constancia de culminacion'; // Nombre del archivo como se guarda en generar_constancia.php
$ruta_archivo = '';

$debug_info = [];
if ($debug) {
    $debug_info['codigo_alumno'] = $codigo_a;
    $debug_info['nombre_archivo_buscado'] = $nombre_archivo;
}

// Primero intentar buscar por el patrón del nombre del archivo físico
$query = "SELECT a.ruta, a.nombre_archivo 
          FROM archivos a 
          INNER JOIN carpeta_virtual cv ON a.id_carpeta = cv.id_carpeta 
          INNER JOIN alumno al ON cv.id_alumno = al.id_alumno 
          WHERE al.id_usuario = ? 
          AND (a.nombre_archivo = ? OR a.ruta LIKE ?)
          ORDER BY a.fecha_subida DESC 
          LIMIT 1";  

$patron_ruta = '%CONSTANCIA-CULMINACION-' . $codigo_a . '%';

$stmt = $conexion->prepare($query);  
$stmt->bind_param("iss", $codigo_a, $nombre_archivo, $patron_ruta);  
$stmt->execute();  
$stmt->bind_result($ruta_archivo, $nombre_bd);  
$stmt->fetch();  
$stmt->close();

if ($debug) {
    $debug_info['ruta_en_bd'] = $ruta_archivo ?: 'No se encontró en la BD';
    $debug_info['nombre_en_bd'] = $nombre_bd ?: 'No se encontró';
    
    // Verificar si existe el alumno
    $check_alumno = "SELECT id_alumno FROM alumno WHERE id_usuario = ?";
    $stmt2 = $conexion->prepare($check_alumno);
    $stmt2->bind_param("i", $codigo_a);
    $stmt2->execute();
    $stmt2->bind_result($id_alumno);
    $stmt2->fetch();
    $stmt2->close();
    $debug_info['id_alumno'] = $id_alumno ?: 'No encontrado';
    
    // Verificar si existe carpeta virtual
    if ($id_alumno) {
        $check_carpeta = "SELECT id_carpeta, nombre_carpeta FROM carpeta_virtual WHERE id_alumno = ?";
        $stmt3 = $conexion->prepare($check_carpeta);
        $stmt3->bind_param("i", $id_alumno);
        $stmt3->execute();
        $stmt3->bind_result($id_carpeta, $nombre_carpeta);
        $stmt3->fetch();
        $stmt3->close();
        $debug_info['id_carpeta'] = $id_carpeta ?: 'No encontrada';
        $debug_info['nombre_carpeta'] = $nombre_carpeta ?: 'No encontrada';
        
        // Listar todos los archivos en esa carpeta
        if ($id_carpeta) {
            $check_archivos = "SELECT nombre_archivo, ruta FROM archivos WHERE id_carpeta = ?";
            $stmt4 = $conexion->prepare($check_archivos);
            $stmt4->bind_param("i", $id_carpeta);
            $stmt4->execute();
            $result = $stmt4->get_result();
            $archivos_encontrados = [];
            while ($row = $result->fetch_assoc()) {
                $archivos_encontrados[] = $row;
            }
            $stmt4->close();
            $debug_info['archivos_en_carpeta'] = $archivos_encontrados;
        }
    }
}

if (!$ruta_archivo) {
    if ($debug) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'debug' => $debug_info, 'message' => 'No se encontró el archivo en la base de datos']);
        exit();
    }
    
    // Si es una petición AJAX, retornar JSON
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Archivo no encontrado en la base de datos']);
        exit();
    }
    exit('Archivo no encontrado en la base de datos.');
}

// Convertir ruta relativa a absoluta
$ruta_limpia = str_replace(['../', './'], '', $ruta_archivo);
$ruta_absoluta = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $ruta_limpia;
$ruta_absoluta = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $ruta_absoluta);
$ruta_absoluta = realpath($ruta_absoluta);

if ($debug) {
    $debug_info['ruta_limpia'] = $ruta_limpia;
    $debug_info['ruta_absoluta_calculada'] = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $ruta_limpia;
    $debug_info['ruta_absoluta_real'] = $ruta_absoluta ?: 'realpath() falló';
    $debug_info['archivo_existe'] = $ruta_absoluta && file_exists($ruta_absoluta) ? 'Sí' : 'No';
    $debug_info['__DIR__'] = __DIR__;
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'debug' => $debug_info, 'message' => 'Archivo encontrado']);
    exit();
}

if (!$ruta_absoluta || !file_exists($ruta_absoluta)) {
    // Si es una petición AJAX, retornar JSON
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Archivo no encontrado en el servidor', 'ruta_esperada' => $ruta_absoluta ?: 'Error al calcular ruta']);
        exit();
    }
    exit('Archivo no encontrado en el servidor.');
}

// Verificar la extensión del archivo
$extension = strtolower(pathinfo($ruta_absoluta, PATHINFO_EXTENSION));

// Determinar el tipo MIME según la extensión
$content_type = 'application/octet-stream';
if ($extension === 'pdf') {
    $content_type = 'application/pdf';
} elseif ($extension === 'docx') {
    $content_type = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
} elseif ($extension === 'doc') {
    $content_type = 'application/msword';
}

// Nombre amigable para la descarga
$nombre_descarga = 'Constancia_Culminacion_' . $codigo_a . '.' . $extension;

// Enviar headers para la descarga
header('Content-Description: File Transfer');
header('Content-Type: ' . $content_type);
header('Content-Disposition: attachment; filename="' . $nombre_descarga . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($ruta_absoluta));

// Lee el archivo y lo envía al usuario
readfile($ruta_absoluta);
exit;
?>
