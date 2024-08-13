<?php
if (isset($_GET['carpeta']) && isset($_GET['nombre_carpeta'])) {
    $carpeta = urldecode($_GET['carpeta']);
    $nombre_carpeta = urldecode($_GET['nombre_carpeta']);
    
    if (is_dir($carpeta)) {
        $zip = new ZipArchive();
        $zip_filename = $nombre_carpeta . ".zip";

        if ($zip->open($zip_filename, ZipArchive::CREATE) !== TRUE) {
            exit("No se puede abrir <$zip_filename>\n");
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($carpeta, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            // Agregar los archivos al ZIP con el prefijo del nombre de la carpeta
            $zip->addFile($file, $nombre_carpeta . '/' . basename($file));
        }

        $zip->close();

        // Configurar encabezados para la descarga del archivo ZIP
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=' . $zip_filename);
        header('Content-Length: ' . filesize($zip_filename));

        // Leer el archivo y enviarlo al navegador
        readfile($zip_filename);

        // Eliminar el archivo ZIP después de la descarga
        unlink($zip_filename);
        exit;
    } else {
        exit("La carpeta no existe.");
    }
}
?>
