<?php  
require('./../../fpdf186/fpdf.php'); // Asegúrate de que la ruta a FPDF sea correcta  

// Establecer la zona horaria a Lima  
date_default_timezone_set('America/Lima');  

// Creación de la instancia de FPDF  
$pdf = new FPDF('L', 'mm', 'A4');   
$pdf->AddPage();  

// Establece la fuente para la fecha  
$pdf->SetFont('Arial', '', 10);  
$pdf->Cell(0, 10, date('d/m/Y'), 0, 1, 'R'); // Fecha en la esquina superior derecha 

// Título del informe  
$pdf->SetFont('Arial', 'B', 16); // Cambia el tamaño de fuente para el título
$pdf->Cell(0, 10, 'Informe de Alumnos y Docentes Encargados', 0, 1, 'C'); // Céntrese y añada una línea  
$pdf->Ln(10); // Añadir un espacio antes de la tabla   

$pdf->SetFont('Arial', 'B', 12);  

// Encabezados de la tabla  
$pdf->Cell(30, 10, 'Codigo', 1);  
$pdf->Cell(60, 10, 'Nombre', 1);  
$pdf->Cell(50, 10, 'Escuela', 1);  
$pdf->Cell(20, 10, 'Seccion', 1);   
$pdf->Cell(60, 10, 'Docente Encargado', 1);  
$pdf->Cell(40, 10, 'Codigo Docente', 1);   
$pdf->Ln();  

// Conexión a la base de datos  
$conn = new mysqli("localhost:3306", "root", "", "proyecto_integrador");  

// Verifica la conexión  
if ($conn->connect_error) {  
    die("Conexión fallida: " . $conn->connect_error);  
}  

// Consulta SQL para obtener los datos que deseas imprimir  
$sql = "SELECT u.codigo AS 'CODIGO_ALUMNO',  
                        CONCAT(u.nombre1, ' ', u.nombre2, ' ', u.apellido1, ' ', u.apellido2) AS 'NOMBRE_ALUMNO',   
                        e.escuela, a.seccion, a.id_docente,   
                        (SELECT GROUP_CONCAT(CONCAT(us.nombre1, ' ', us.apellido1) SEPARATOR ', ')  
                         FROM usuario us   
                         JOIN docente dn ON dn.id_usuario = us.codigo   
                         WHERE dn.id_docente = a.id_docente) AS 'NOMBRE_DOCENTE'   
                         FROM usuario u   
                         JOIN escuelas e ON e.id_escuela = u.id_escuela   
                         JOIN alumno a ON a.id_usuario = u.codigo   
                         JOIN acceso ac ON ac.id_usuario = u.codigo   
                         WHERE ac.id_rol = 3
                         ORDER BY a.id_docente, u.codigo"; 
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
            $pdf->Cell(60, 10, 'Nombre', 1);  
            $pdf->Cell(50, 10, 'Escuela', 1);  
            $pdf->Cell(20, 10, 'Seccion', 1);   
            $pdf->Cell(60, 10, 'Docente Encargado', 1);  
            $pdf->Cell(40, 10, 'Codigo Docente', 1);   
            $pdf->Ln();  
        }  

        // Salida de datos de cada fila  
        $pdf->Cell(30, 10, $row['CODIGO_ALUMNO'], 1);  
        $pdf->Cell(60, 10, $row['NOMBRE_ALUMNO'], 1);  
        $pdf->Cell(50, 10, $row['escuela'], 1);  
        $pdf->Cell(20, 10, $row['seccion'], 1);   
        $pdf->Cell(60, 10, $row['NOMBRE_DOCENTE'], 1);  
        $pdf->Cell(40, 10, $row['id_docente'], 1);   
        $pdf->Ln();  
    }  
} else {  
    $pdf->Cell(0, 10, 'No hay datos disponibles', 1);  
}  

// Cierra la conexión  
$conn->close();  

// Salida del PDF  
$pdf->Output('D', 'Relacion_alumno-docente.pdf'); // Cambia el nombre del archivo según necesites  
?>