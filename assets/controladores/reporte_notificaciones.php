<?php
// REPORTE de: notificaciones
session_start();
require('./../../fpdf186/fpdf.php'); // Asegúrate de que la ruta a FPDF sea correcta  

$codigo_admin = $_SESSION['codigo_institucional'];
// Establecer la zona horaria a Lima  
date_default_timezone_set('America/Lima');

// Creación de la instancia de FPDF  
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->Image('C:\xampp\htdocs\PPP\assets\images\logo_unfv.jpg', 15, 8, 30); // tengo que corregir la ruta en godaddy
$pdf->Image('C:\xampp\htdocs\PPP\assets\images\FIEI_LOGO-removebg-preview.png', 250, 5, 20); // tengo que corregir la ruta en godaddy

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
$pdf->Cell(0, 10, utf8_decode("Reporte: Notificaciones de usuarios"), 0, 0, 'C');
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
$pdf->Cell(80, 10, 'Mensaje', 1, 0, 'C', 1);
$pdf->Cell(45, 10, 'Fecha-Hora', 1, 0, 'C', 1);
$pdf->Ln();

//para volver a poner sin color los registros, sino saldran con el color del encabezado de la tabla
$pdf->SetFillColor(255, 255, 255); // Fondo blanco para las celdas de datos
$pdf->SetTextColor(0, 0, 0); // Texto negro para las celdas de datos
$pdf->SetFont('Arial', '', 10);

// Conexión a la base de datos  
$conn = new mysqli("localhost:33065", "root", "", "proyecto_integrador");

// Verifica la conexión  
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos que deseas imprimir  
$sql = "SELECT u.codigo,u.nombre1, u.apellido1, e.escuela, n.mensaje, n.fecha_notificacion   
FROM notificaciones n   
JOIN usuario u ON u.codigo = n.id_usuario
JOIN escuelas e ON e.id_escuela = u.id_escuela  
WHERE n.id_usuario <> '$codigo_admin'";
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
            $pdf->Cell(80, 10, 'Mensaje', 1, 0, 'C', 1);
            $pdf->Cell(45, 10, 'Fecha-Hora', 1, 0, 'C', 1);
            $pdf->Ln();
        }

        // Salida de datos de cada fila  
        $pdf->Cell(25, 10, $row['codigo'], 1, 0, 'C', 1);
        $pdf->Cell(55, 10, utf8_decode($row['nombre1'] . ' ' . $row['apellido1']), 1, 0, 'C', 1);
        $pdf->Cell(45, 10, $row['escuela'], 1, 0, 'C', 1);
        $pdf->Cell(80, 10, utf8_decode($row['mensaje']), 1, 0, 'C', 1);
        $pdf->Cell(45, 10, $row['fecha_notificacion'], 1, 0, 'C', 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No hay datos disponibles', 1);
}

// Cierra la conexión  
$conn->close();

// Salida del PDF  
$pdf->Output('I', 'usuarios_registrados.pdf'); // Cambia el nombre del archivo según necesites , para visualizarlo
// cambiar la D por la I o viceversa
