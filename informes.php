<?php
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "login.html"; 
    </script>';
}
$mostrarDiv = isset($_SESSION['paso_cp']) ? $_SESSION['paso_cp'] : '';  
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
            <div id="complete" class="container2" style="<?php echo $mostrarDiv < '5' ? 'display:block;' : 'display:none;'; ?>">
                <h2>Necesitas completar el proceso anterior</h2>
            </div>
            <div class="container2" style="<?php echo $mostrarDiv === '5' ? 'display:block;' : 'display:none;'; ?>">
                <h2> Primer Informe</h2>
                <p>Nota: El primer informe se debe subir 30 dias despues de la fecha de inicio de sus practicas pre profesionales</p>
                <div class="form-group">
                    <label for="fechaInforme1">Fecha de Subida:</label>
                    <input type="date" name="fechaInforme1" id="fechaInforme1" class="date-picker" required>
                </div>
                <div class="form-group">
                    <label for="informe1">Adjuntar archivo en formato pdf</label>
                    <input id="informe1" name="informe1" type="file" accept=".pdf" required>                        
                    <div class="buttons">
                        <button id="uploadButton" type="button" class="btn-small">Enviar</button>
                    </div>
                </div>   
            </div>
            <div class="container2" style="<?php echo $mostrarDiv === '6' ? 'display:block;' : 'display:none;'; ?>">
                <h2> Segundo Informe</h2>
                <p>Nota: El segundo informe se debe subir 90 dias despues de la 
                    fecha de inicio de sus practicas pre profesionales</p>
                <div class="form-group">
                    <label for="fechaInforme2">Fecha de Subida:</label>
                    <input type="date" name="fechaInforme2" id="fechaInforme2" class="date-picker" required>
                </div>
                <div class="form-group">
                    <label for="informe2">Adjuntar archivo en formato pdf</label>
                    <input id="informe2" name="informe2" type="file" accept=".pdf" required> 
                    <div class="buttons">
                        <button type="button" id="uploadButton2" class="btn-small">Enviar</button>
                    </div>
                </div>
            </div>
            <div class="container2" style="<?php echo $mostrarDiv === '7' ? 'display:block;' : 'display:none;'; ?>">
                <h2> Tercer Informe</h2>
                <p>Nota: El tercer informe se debe subir al culminar sus practicas pre profesionales 
                    desde la fecha de inicio de sus practicas pre profesionales</p>
                <div class="form-group">
                    <label for="fechaInforme3">Fecha de Subida:</label>
                    <input type="date" name="fechaInforme3" id="fechaInforme3" class="date-picker" required>
                </div>
                <div class="form-group">
                    <label for="informe3">Adjuntar archivo en formato pdf</label>
                    <input id="informe3" name="informe3" type="file" accept=".pdf" required> 
                    <div class="buttons">
                        <button type="button" id="uploadButton3" class="btn-small">Enviar</button>
                    </div>
                </div>
            </div>
            <div class="container2" style="<?php echo $mostrarDiv === '8' ? 'display:block;' : 'display:none;'; ?>">
                <h2> Subir Constancia de Culminacion</h2>
                <p>Nota: Subir su constancia de culminacion una vez completado las 780 horas</p>
                <div class="form-group">
                    <label for="fechaInforme4">Fecha de Subida:</label>
                    <input type="date" name="fechaInforme4" id="fechaInforme4" class="date-picker" required>
                </div>
                <div class="form-group">
                    <label for="informe4">Adjuntar archivo en formato pdf</label>
                    <input id="informe4" name="informe4" type="file" accept=".pdf" required> 
                    <div class="buttons">
                        <button type="button" id="uploadButton4" class="btn-small">Enviar</button>
                    </div>
                </div>
            </div>
            <div class="container2" style="<?php echo $mostrarDiv === '9' ? 'display:block;' : 'display:none;'; ?>">
                <h2> Subir el Informe Final</h2>
                <div class="form-group">
                    <label for="fechaInforme5">Fecha de Subida:</label>
                    <input type="date" name="fechaInforme5" id="fechaInforme5" class="date-picker" required>
                </div>
                <div class="form-group">
                    <label for="informe5">Adjuntar archivo en formato pdf</label>
                    <input id="informe5" name="informe5" type="file" accept=".pdf" required> 
                    <div class="buttons">
                        <button type="button" id="uploadButton5" class="btn-small">Enviar</button>
                    </div>
                </div>
            </div>
            <div id="complete" class="container2" style="<?php echo $mostrarDiv >= '10' ? 'display:block;' : 'display:none;'; ?>">
                <h2>Proceso ya completado</h2>
                <p>Continue con su proceso en la siguiente sección</p>
            </div>
            <div class="form-buttons">
                <button onclick="closeProfileForm()" class="close-btn">Cerrar</button>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes2.js"></script>
</body>
</html>
