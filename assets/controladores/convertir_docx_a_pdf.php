<?php
/**
 * Convierte un archivo DOCX a PDF usando PhpWord
 * Retorna la ruta del archivo PDF generado o false si falla
 */
function convertirDocxAPdf($rutaDocx) {
    require_once __DIR__ . '/../../phpoffice/vendor/autoload.php';
    
    if (!file_exists($rutaDocx)) {
        return false;
    }
    
    try {
        // Cargar el documento DOCX
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($rutaDocx);
        
        // Configurar DomPDF como renderizador
        $domPdfPath = __DIR__ . '/../../phpoffice/vendor/dompdf/dompdf';
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');
        
        // Generar nombre del archivo PDF
        $rutaPdf = str_replace(['.docx', '.DOCX'], '.pdf', $rutaDocx);
        
        // Convertir a PDF
        $pdfWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
        $pdfWriter->save($rutaPdf);
        
        return file_exists($rutaPdf) ? $rutaPdf : false;
        
    } catch (Exception $e) {
        error_log("Error al convertir DOCX a PDF: " . $e->getMessage());
        return false;
    }
}
?>
