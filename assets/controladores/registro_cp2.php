<?php  
include 'bd.php'; 
session_start();  
$codigo = $_SESSION['codigo']; 
$fechaRegistro = $_POST['fechaRegistro'];
$fechaRecord = $_POST['fechaRecord'];
$numLiquidacion = $_POST['numLiquidacion'];

?>