<?php
session_start();
include './assets/controladores/bd.php';

if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "index.html"; 
    </script>';
    exit;
}

if (isset($_GET['archivo'])) {
    $archivo_relativo = urldecode($_GET['archivo']);
    
    // Construir la ruta completa desde la raíz del proyecto
    $archivo = './' . $archivo_relativo;
    
    // Normalizar las barras invertidas a barras normales para comparación
    $directorio_permitido = str_replace('\\', '/', realpath('./assets/carpetas_virtuales/'));
    
    // DEBUG: Mostrar información
    if (!file_exists($archivo)) {
        $mensaje_debug = "Ruta relativa: $archivo_relativo\\n";
        $mensaje_debug .= "Ruta completa intentada: $archivo\\n";
        $mensaje_debug .= "Existe: " . (file_exists($archivo) ? 'SI' : 'NO') . "\\n";
        $mensaje_debug .= "Directorio actual: " . getcwd();
        
        echo '<script>
        alert("DEBUG - El archivo no existe:\\n' . addslashes($mensaje_debug) . '");
        window.history.back();
        </script>';
        exit;
    }
    
    // Verificar que el archivo exista
    if (file_exists($archivo)) {
        // Obtener la ruta real del archivo
        $archivo_real = str_replace('\\', '/', realpath($archivo));
        
        // Verificar que esté dentro del directorio permitido
        if (strpos($archivo_real, $directorio_permitido) === 0) {
            $nombre_archivo = basename($archivo);
            
            // Configurar encabezados para la descarga
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $nombre_archivo . '"');
            header('Content-Length: ' . filesize($archivo));
            header('Pragma: public');
            header('Cache-Control: must-revalidate');
            header('Expires: 0');
            
            // Leer y enviar el archivo
            readfile($archivo);
            exit;
        } else {
            echo '<script>
            alert("No tienes permiso para descargar este archivo (fuera del directorio permitido)");
            window.history.back();
            </script>';
            exit;
        }
    }
} else {
    echo '<script>
    alert("No se especificó un archivo");
    window.history.back();
    </script>';
    exit;
}
?>
