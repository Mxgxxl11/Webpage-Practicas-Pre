<?php
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "login.html"; 
    </script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mesa de partes</title>
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    
</head>

<body>
<header>
    <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar.php'; ?>
        <main class="main-content">
            <div class="container2" style="<?php echo $mostrarDiv === '4' ? 'display:block;' : 'display:none;'; ?>">
                <h2> Primer Informe</h2>
                <p>Nota: El primer informe se debe subir 30 dias despues de la fecha de inicio de sus practicas pre profesionales</p>
                <div class="form-group">
                    <label for="fechaRegistroInforme">Fecha de Subida:</label>
                    <input type="date" id="fechaRegistroInforme" class="date-picker" required>
                </div>
                <div class="form-group">
                    <label for="Presentacion">Adjuntar archivo en formato pdf</label>
                    <input id="Presentacion" type="file" value="enviar comprobante">
                    <div class="buttons">
                        <button type="button" class="btn-small">Enviar</button>
                    </div>
                </div>
            </div>
            <div class="container2" style="<?php echo $mostrarDiv === '5' ? 'display:block;' : 'display:none;'; ?>">
                <h2> Segundo Informe</h2>
                <p>Nota: El segundo informe se debe subir 90 dias despues de la 
                    fecha de inicio de sus practicas pre profesionales</p>
                <div class="form-group">
                    <label for="fechaRegistroInforme">Fecha de Subida:</label>
                    <input type="date" id="fechaRegistroInforme" class="date-picker">
                </div>
                <div class="form-group">
                    <label for="Segundoinfor">Adjuntar archivo en formato pdf</label>
                    <input id="Segundoinfor" type="file" value="enviar comprobante">
                    <div class="buttons">
                        <button type="button" class="btn-small">Enviar</button>
                    </div>
                </div>
            </div>
            <div class="container2" style="<?php echo $mostrarDiv === '6' ? 'display:block;' : 'display:none;'; ?>">
                <h2> Tercer Informe</h2>
                <p>Nota: El tercer informe se debe subir al culminar sus practicas pre profesionales 
                    desde la fecha de inicio de sus practicas pre profesionales</p>
                <div class="form-group">
                    <label for="fechaRegistroInforme">Fecha de Subida:</label>
                    <input type="date" id="Fechaultimoinforme" class="date-picker">
                </div>
                <div class="form-group">
                    <label for="Tercerinfor">Adjuntar archivo en formato pdf</label>
                    <input id="Tercerinfor" type="file" value="enviar comprobante">
                    <div class="buttons">
                        <button type="button" class="btn-small">Enviar</button>
                    </div>
                </div>
            </div>
            <div class="container2" style="<?php echo $mostrarDiv === '7' ? 'display:block;' : 'display:none;'; ?>">
                <h2> Subir Constancia de Culminacion</h2>
                <p>Nota: Subir su constancia de culminacion una vez completado las 780 horas</p>
                <div class="form-group">
                    <label for="Informefinal">Fecha de Subida:</label>
                    <input type="date" id="Informefinal" class="date-picker">
                </div>
                <div class="form-group">
                    <label for="Segundoinfor">Adjuntar archivo en formato pdf</label>
                    <input id="Segundoinfor" type="file" value="enviar comprobante">
                    <div class="buttons">
                        <button type="button" class="btn-small">Enviar</button>
                    </div>
                </div>
            </div>
            <div class="container2" style="<?php echo $mostrarDiv === '8' ? 'display:block;' : 'display:none;'; ?>">
                <h2> Subir el Informe Final</h2>
                <div class="form-group">
                    <label for="Informefinal">Fecha de Subida:</label>
                    <input type="date" id="Informefinal" class="date-picker">
                </div>
                <div class="form-group">
                    <label for="Segundoinfor">Adjuntar archivo en formato pdf</label>
                    <input id="Segundoinfor" type="file" value="enviar comprobante">
                    <div class="buttons">
                        <button type="button" class="btn-small">Enviar</button>
                    </div>
                </div>
            </div>
            <div class="container2" style="<?php echo $mostrarDiv === '8' ? 'display:block;' : 'display:none;'; ?>">
                <p>Nota: Si la evaluación de tu informe final se da de manera virtual,  dale continuar</p>
                <div class="form-group">                
                    <div class="buttons">
                        <button type="button" class="btn-small">Continuar</button>
                    </div>
                </div>
            </div>
            <div id="complete" class="container2" style="<?php echo $mostrarDiv === '9' ? 'display:block;' : 'display:none;'; ?>">
                <h2>Proceso ya completado</h2>
                <p>Realice la solicitud de su constancia en la siguiente sección</p>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>
</html>