<?php  
include 'bd.php'; 
session_start();  
$codigo = $_SESSION['codigo_institucional'];

$fechaExam = $_POST['fechaExam'];
$exam = $_FILES['exam'];

$result = mysqli_query($conexion, "SELECT id_alumno FROM alumno WHERE id_usuario = '$codigo'");  
$row = mysqli_fetch_assoc($result);  
$id_alumno = $row['id_alumno'];

?>