<?php
session_start();
include 'bd.php';

if (empty($_SESSION['codigo_institucional'])) {
    http_response_code(403);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

if (isset($_GET['carpeta'])) {
    $carpeta = urldecode($_GET['carpeta']);
    
    // Ajustar la ruta relativa desde este archivo (que está en assets/controladores/)
    // hacia la carpeta que está en assets/carpetas_virtuales/
    $carpeta_ajustada = '../../' . $carpeta;
    
    if (!is_dir($carpeta_ajustada)) {
        echo json_encode(['error' => 'La carpeta no existe: ' . $carpeta]);
        exit;
    }
    
    $carpeta = $carpeta_ajustada;
    
    $archivos = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($carpeta, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    
    // Obtener la ruta base del proyecto (2 niveles arriba desde este archivo)
    $ruta_base = realpath(dirname(dirname(__DIR__)));
    
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            // Construir una ruta relativa desde la raíz del proyecto
            $ruta_absoluta = str_replace('\\', '/', realpath($file->getPathname()));
            $ruta_base_normalizada = str_replace('\\', '/', $ruta_base);
            
            // Remover la ruta base para obtener la ruta relativa
            $ruta_relativa_descarga = str_replace($ruta_base_normalizada . '/', '', $ruta_absoluta);
            
            $fileInfo = [
                'nombre' => $file->getFilename(),
                'ruta_relativa' => str_replace($carpeta . DIRECTORY_SEPARATOR, '', $file->getPathname()),
                'ruta_completa' => $ruta_relativa_descarga,  // Ruta relativa para la descarga
                'tamano' => filesize($file->getPathname()),
                'fecha' => date("d/m/Y H:i", filemtime($file->getPathname()))
            ];
            $archivos[] = $fileInfo;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($archivos);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Parámetro carpeta no proporcionado']);
}
?>
