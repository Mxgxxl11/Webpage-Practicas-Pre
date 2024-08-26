<?php
// REPORTE Informe de Alumnos y Docentes Encargados
session_start();
require('./../../fpdf186/fpdf.php'); // Asegúrate de que la ruta a FPDF sea correcta  

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
$pdf->Cell(0, 10, utf8_decode("Reporte: Informe de Alumnos y Docentes Encargados"), 0, 0, 'C');
$pdf->Ln(5); // Espacio entre líneas

// Fecha del reporte  
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Fecha del reporte: '.date('d/m/Y'), 0, 0, 'C');
$pdf->Ln(5); // Espacio entre líneas

// Encargado  
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Encargado: '. $_SESSION['primer_nombre'].' '.$_SESSION['primer_apellido'], 0, 0, 'C');
$pdf->Ln(10); // Espacio adicional antes de la tabla

// Encabezados de la tabla  
$pdf->Cell(30, 10, utf8_decode('Código'), 1);
$pdf->Cell(70, 10, 'Nombre', 1);
$pdf->Cell(50, 10, 'Escuela', 1);
$pdf->Cell(20, 10, 'Seccion', 1);
$pdf->Cell(60, 10, 'Docente Encargado', 1);
$pdf->Cell(40, 10, utf8_decode('Código Docente'), 1);
$pdf->Ln();

// Conexión a la base de datos  
$conn = new mysqli("localhost:33065", "root", "", "proyecto_integrador");

// Verifica la conexión  
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener los datos que deseas imprimir  
$sql = "SELECT u.codigo AS 'CODIGO_ALUMNO',  
    CONCAT(u.nombre1, ' ', u.nombre2, ' ', u.apellido1, ' ', u.apellido2) AS 'NOMBRE_ALUMNO',   
    e.escuela, a.seccion, dn.id_usuario AS 'ID_DOCENTE',
    (SELECT GROUP_CONCAT(CONCAT(us.nombre1, ' ', us.apellido1) SEPARATOR ', ')  
     FROM usuario us   
     JOIN docente dn_sub ON dn_sub.id_usuario = us.codigo   
     WHERE dn_sub.id_docente = a.id_docente) AS 'NOMBRE_DOCENTE'   
        FROM   
            usuario u   
        JOIN   
            escuelas e ON e.id_escuela = u.id_escuela   
        JOIN   
            alumno a ON a.id_usuario = u.codigo   
        JOIN   
            acceso ac ON ac.id_usuario = u.codigo   
        JOIN   
            docente dn ON dn.id_docente = a.id_docente -- Aquí realizamos la unión con la tabla docente  
        WHERE   
            ac.id_rol = 3  
        ORDER BY   
            a.id_docente, u.id_escuela, u.codigo;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Salida de datos de cada fila  
    while ($row = $result->fetch_assoc()) {
        // Comprueba si la altura de la celda excede el límite de altura de la página  
        if ($pdf->GetY() + 10 > $pdf->GetPageHeight() - 10) { // Aquí, restamos el margen inferior que asumimos es de 10 mm  
            $pdf->AddPage(); // Añade una nueva página  
            $pdf->SetFont('Arial', 'B', 12);
            // Vuelve a imprimir los encabezados en la nueva página  
            $pdf->Cell(30, 10, 'Codigo', 1);
            $pdf->Cell(70, 10, 'Nombre', 1);
            $pdf->Cell(50, 10, 'Escuela', 1);
            $pdf->Cell(20, 10, 'Seccion', 1);
            $pdf->Cell(60, 10, 'Docente Encargado', 1);
            $pdf->Cell(40, 10, 'Codigo Docente', 1);
            $pdf->Ln();
        }

        // Salida de datos de cada fila  
        $pdf->Cell(30, 10, $row['CODIGO_ALUMNO'], 1);
        $pdf->Cell(70, 10, utf8_decode($row['NOMBRE_ALUMNO']), 1);
        $pdf->Cell(50, 10, $row['escuela'], 1);
        $pdf->Cell(20, 10, $row['seccion'], 1);
        $pdf->Cell(60, 10, $row['NOMBRE_DOCENTE'], 1);
        $pdf->Cell(40, 10, $row['ID_DOCENTE'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No hay datos disponibles', 1);
}

// Cierra la conexión  
$conn->close();

// Salida del PDF  
$pdf->Output('I', 'Relacion_alumno-docente.pdf'); // Cambia el nombre del archivo según necesites , para visualizarlo
// cambiar la D por la I o viceversa
