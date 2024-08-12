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
            <div class="container2" style="<?php echo $mostrarDiv === '9' ? 'display:block;' : 'display:none;'; ?>">
                <h2> Subir el Examen Final</h2>
                <div class="form-group">
                    <label for="fechaExamen">Fecha de Subida:</label>
                    <input type="date" name="fechaExamen" id="fechaExamen" required>
                </div>
                <div class="form-group">
                    <label for="examen">Adjuntar examen en formato pdf</label>
                    <input id="examen" name="examen" type="file" accept=".pdf" required> 
                    <div class="buttons">
                        <button type="button" id="upload_Examen" class="btn-small">Enviar</button>
                    </div>
                </div>
            </div>
            <div class="container2" style="<?php echo $mostrarDiv === '10' ? 'display:block;' : 'display:none;'; ?>">
                <h2>Notas de la evaluación</h2>
                <div class="form-group">
                    <label for="nota1">Nota de evaluación de informes:</label>
                    <input type="text" name="nota1" id="nota1" readonly>
                </div>
                <div class="form-group">
                    <label for="nota2">Nota del examen:</label>
                    <input type="text" name="nota2" id="nota2" readonly>
                </div>
                <div class="form-group">
                    <label for="nota3">Nota de apreciación del docente:</label>
                    <input type="text" name="nota3" id="nota3" readonly>
                </div>
                <div class="form-group">
                    <label for="prom">Promedio:</label>
                    <input type="text" name="prom" id="prom" readonly>
                </div>
            </div>
            <div class="form-buttons">
                <button onclick="closeProfileForm()" class="close-btn">Cerrar</button>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>