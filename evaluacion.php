<?php
session_start();
include './assets/controladores/bd.php';
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "login.html"; 
    </script>';
}
$mostrarDiv = 0;
$codigo = $_SESSION['codigo_institucional'];
$promedio_final = '';  
$trabajo_final = '';
$examen_final = '';
$apreciacion = '';
$codigo_alum = '';
try {  
    // Preparar consulta  
    $stmt = $conexion->prepare("SELECT paso FROM paso_cp WHERE id_usuario = ?");  
    $stmt->bind_param("i", $codigo); 
    $stmt->execute();  
    $stmt->bind_result($mostrarDiv);  
    $stmt->fetch();  
    $stmt->close();  
    
} catch (Exception $e) {  
    echo 'Error en la consulta: ' . $e->getMessage();  
} 
try {  
    // Preparar consulta  
    $stmt = $conexion->prepare("SELECT id_alumno FROM alumno WHERE id_usuario = ?");  
    $stmt->bind_param("i", $codigo); 
    $stmt->execute();  
    $stmt->bind_result($codigo_alum);  
    $stmt->fetch();  
    $stmt->close();  
    
} catch (Exception $e) {  
    echo 'Error en la consulta: ' . $e->getMessage();  
} 
try {  
    // Preparar consulta  
    $stmt = $conexion->prepare("SELECT promedio_final, trabajo_final, apreciacion, examen_final FROM calificaciones WHERE id_alumno = ?");  
    $stmt->bind_param("i", $codigo_alum); 
    $stmt->execute();  
    $stmt->bind_result($promedio_final, $trabajo_final, $apreciacion, $examen_final);  
    $stmt->fetch();  
    $stmt->close();  
    
} catch (Exception $e) {  
    echo 'Error en la consulta: ' . $e->getMessage();  
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mesa de partes</title>
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
</head>

<body>
<header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar.php'; ?>

        <main class="main-content">
            <div id="complete" class="container2" style="<?php echo $mostrarDiv < 10 ? 'display:block;' : 'display:none;'; ?>">
                <h2>Necesitas completar el proceso anterior</h2>
            </div>
            <div id="complete" class="container2" style="<?php echo $mostrarDiv === 10 ? 'display:block;' : 'display:none;'; ?>">
                <h2>El docente esta calificando tu informe final</h2>
                <p>*La siguiente pestaña se habilitará cuando tu profesor encargado suba la nota de tu informe final</p>
            </div>
            <div id="complete" class="container2" style="<?php echo $mostrarDiv === 11 ? 'display:block;' : 'display:none;'; ?>">
                <h2>Aún no puedes continuar</h2>
                <p>*La siguiente pestaña se habilitará cuando tu profesor encargado suba tu examen final</p>
            </div>
            <div class="container2" style="<?php echo $mostrarDiv === 12 ? 'display:block;' : 'display:none;'; ?>">
                <h2> Subir el Examen Final</h2>
                <div class="form-group">
                    <label for="fechaExamen">Fecha de Subida:</label>
                    <input type="date" name="fechaExamen" id="fechaExamen" required>
                </div>
                <div class="form-group">
                    <label for="examen">Adjuntar examen en formato pdf</label>
                    <input id="examen" name="examen" type="file" accept=".pdf" required> 
                    <div class="buttons">
                        <button type="button" name="upload_Examen" id="upload_Examen" class="btn-small">Enviar</button>
                    </div>
                </div>
            </div>
            <div id="complete" class="container2" style="<?php echo $mostrarDiv === 13 ? 'display:block;' : 'display:none;'; ?>">
                <h2>Aún no puedes continuar</h2>
                <p>*La siguiente pestaña se habilitará cuando tu profesor encargado suba la nota de tu examen final</p>
            </div>
            <div id="complete" class="container2" style="<?php echo $mostrarDiv === 14 ? 'display:block;' : 'display:none;'; ?>">
                <h2>Aún no puedes continuar</h2>
                <p>*La siguiente pestaña se habilitará cuando tu profesor encargado suba la nota apreciacion</p>
            </div>
            <div class="container2" style="<?php echo $mostrarDiv === 15 ? 'display:block;' : 'display:none;'; ?>">
                <h2>Notas de la evaluación</h2>
                <div class="form-group">
                    <label for="nota1">Nota de evaluación de informes:</label>
                    <input type="text" value="<?php echo $trabajo_final; ?>" name="nota1" id="nota1" readonly>
                </div>
                <div class="form-group">
                    <label for="nota2">Nota del examen:</label>
                    <input type="text"  value="<?php echo $examen_final; ?>" name="nota2" id="nota2" readonly>
                </div>
                <div class="form-group">
                    <label for="nota3">Nota de apreciación del docente:</label>
                    <input type="text" value="<?php echo $apreciacion; ?>" name="nota3" id="nota3" readonly>
                </div>
                <div class="form-group">
                    <label for="prom">Promedio:</label>
                    <input type="text" name="prom" id="prom" value="<?php echo $promedio_final; ?>" readonly>
                </div>
            </div>
            <div class="form-buttons">
                <button onclick="closeProfileForm()" class="close-btn">Cerrar</button>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes2.js"></script>
</body>
</html>
