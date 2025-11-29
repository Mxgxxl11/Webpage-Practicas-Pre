<?php
// REPORTE de: visualización de usuarios registrados en la plataforma
session_start();
require('./../../fpdf186/fpdf.php'); // Asegúrate de que la ruta a FPDF sea correcta  

// Establecer la zona horaria a Lima  
date_default_timezone_set('America/Lima');

// Creación de la instancia de FPDF  
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->Image(__DIR__ . '/../images/logo_unfv.jpg', 15, 8, 30);
$pdf->Image(__DIR__ . '/../images/FIEI_LOGO-removebg-preview.png', 250, 5, 20);

// Título del informe  
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 15, utf8_decode('Sistema de prácticas preprofesionales'), 0, 0, 'C'); // Céntrese y añada una línea  
$pdf->Ln(10); // Añadir un espacio antes del siguiente contenido  

//Nombre Universidad
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, utf8_decode("UNIVERSIDAD NACIONAL FEDERICO VILLARREAL"), 0, 0, 'C');
$pdf->Ln(5);

//Nombre Universidad
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, utf8_decode("Facultad Ingeniería Electrónica e Informática (FIEI)"), 0, 0, 'C');
$pdf->Ln(5);

// Informe de Alumnos y Docentes Encargados  
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, utf8_decode("Reporte: Estado de proceso de los alumnos (TELECOMUNICACIONES)"), 0, 0, 'C');
$pdf->Ln(5); // Espacio entre líneas

// Fecha del reporte  
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Fecha del reporte: ' . date('d/m/Y'), 0, 0, 'C');
$pdf->Ln(5); // Espacio entre líneas

// Encargado  
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Encargado: ' . $_SESSION['primer_nombre'] . ' ' . $_SESSION['primer_apellido'], 0, 0, 'C');
$pdf->Ln(10); // Espacio adicional antes de la tabla

// Encabezados de la tabla  
$pdf->SetFillColor(228, 100, 0);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetDrawColor(163, 163, 163);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 10, utf8_decode('Código'), 1, 0, 'C', 1);
$pdf->Cell(55, 10, 'Nombre', 1, 0, 'C', 1);
$pdf->Cell(45, 10, 'Escuela', 1, 0, 'C', 1);
$pdf->Cell(25, 10, 'Semestre', 1, 0, 'C', 1);
$pdf->Cell(25, 10, utf8_decode('Sección'), 1, 0, 'C', 1);
$pdf->Cell(100, 10, 'Estado', 1, 0, 'C', 1);
$pdf->Ln();

//para volver a poner sin color los registros, sino saldran con el color del encabezado de la tabla
$pdf->SetFillColor(255, 255, 255); // Fondo blanco para las celdas de datos
$pdf->SetTextColor(0, 0, 0); // Texto negro para las celdas de datos
$pdf->SetFont('Arial', '', 10);

// Conexión a la base de datos  
$conn = new mysqli("localhost:3306", "root", "", "proyecto_integrador");

// Verifica la conexión  
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos que deseas imprimir  
$sql = "SELECT u.codigo,CONCAT(u.nombre1,' ',u.apellido1,' ',u.apellido2) AS 'NOMBRE_ALUMNO', e.escuela, al.semestre, al.seccion, p.paso
FROM usuario u 
JOIN acceso a ON u.codigo = a.id_usuario 
JOIN escuelas e ON e.id_escuela = u.id_escuela 
JOIN alumno al ON al.id_usuario = u.codigo 
JOIN paso_cp p ON p.id_usuario = u.codigo 
WHERE a.id_rol=3 and e.id_escuela=2;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Salida de datos de cada fila  
    while ($row = $result->fetch_assoc()) {
        // Comprueba si la altura de la celda excede el límite de altura de la página  
        if ($pdf->GetY() + 10 > $pdf->GetPageHeight() - 10) { // Aquí, restamos el margen inferior que asumimos es de 10 mm  
            $pdf->AddPage(); // Añade una nueva página  
            $pdf->SetFont('Arial', 'B', 12);
            // Vuelve a imprimir los encabezados en la nueva página  
            $pdf->SetFillColor(228, 100, 0);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetDrawColor(163, 163, 163);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(25, 10, utf8_decode('Código'), 1, 0, 'C', 1);
            $pdf->Cell(55, 10, 'Nombre', 1, 0, 'C', 1);
            $pdf->Cell(45, 10, 'Escuela', 1, 0, 'C', 1);
            $pdf->Cell(25, 10, 'Semestre', 1, 0, 'C', 1);
            $pdf->Cell(25, 10, utf8_decode('Sección'), 1, 0, 'C', 1);
            $pdf->Cell(100, 10, 'Estado', 1, 0, 'C', 1);
            $pdf->Ln();
        }

        // Salida de datos de cada fila  
        $pdf->Cell(25, 10, $row['codigo'], 1, 0, 'C', 1);
        $pdf->Cell(55, 10, utf8_decode($row['NOMBRE_ALUMNO']), 1, 0, 'C', 1);
        $pdf->Cell(45, 10, $row['escuela'], 1, 0, 'C', 1);
        $pdf->Cell(25, 10, strtoupper($row['semestre']), 1, 0, 'C', 1);
        $pdf->Cell(25, 10, $row['seccion'], 1, 0, 'C', 1);
        $estado = '';
        switch ($row['paso']) {
            case 1:
                $estado = "Inicio del proceso";
                break;
            case 2:
                $estado = "Formulario datos del Alumno";
                break;
            case 3:
                $estado = "Carta de Presentación";
                break;
            case 4:
                $estado = "Subida de NT";
                break;
            case 5:
                $estado = "Apertura de Carpeta";
                break;
            case 6:
                $estado = "1er Informe";
                break;
            case 7:
                $estado = "2do Informe";
                break;
            case 8:
                $estado = "3er Informe";
                break;
            case 9:
                $estado = "Constancia de culminación de la empresa";
                break;
            case 10:
                $estado = "Informe Final";
                break;
            case 11:
                $estado = "Informe Final Calificado por el docente";
                break;
            case 12:
                $estado = "Examen Final Subido por el docente";
                break;
            case 13:
                $estado = "Examen Final Resuelto";
                break;
            case 14:
                $estado = "Examen Final Calificado por el docente";
                break;
            case 15:
                $estado = "Nota de apreciación subida";
                break;
            case 16:
                $estado = "Docente le envió comentario";
                break;
            case 17:
                $estado = "Docente envió ficha de evaluación (coordinador)";
                break;
            case 18:
                $estado = "Docente envió informe final de evaluación (coordinador)";
                break;
            case 19:
                $estado = "Solicitud de Constancia de Culminación";
                break;
        }
        $pdf->Cell(100, 10, utf8_decode($estado), 1, 0, 'C', 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No hay datos disponibles', 1);
}

// Cierra la conexión  
$conn->close();

// Salida del PDF  
$pdf->Output('I', 'alumnos_informatica.pdf'); // Cambia el nombre del archivo según necesites , para visualizarlo
// cambiar la D por la I o viceversa
