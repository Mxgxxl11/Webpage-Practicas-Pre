<?php
session_start();
include './assets/controladores/bd.php';
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "index.html"; 
    </script>';
}
$codigo = $_GET['codigo']; 
$codigo2 = $_SESSION['codigo_institucional'];
$codigo_doc = '';
$promedio_final = '';  
$codigo_alum = '';
$mostrarDiv = 0;
try {  
    // Preparar consulta  
    $stmt = $conexion->prepare("SELECT id_docente FROM docente WHERE id_usuario = ?");  
    $stmt->bind_param("i", $codigo2); 
    $stmt->execute();  
    $stmt->bind_result($codigo_doc);  
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
    $stmt = $conexion->prepare("SELECT promedio_final FROM calificaciones WHERE (id_alumno = ? AND id_docente = ?)");  
    $stmt->bind_param("ii", $codigo_alum, $codigo_doc); 
    $stmt->execute();  
    $stmt->bind_result($promedio_final);  
    $stmt->fetch();  
    $stmt->close();  
    
} catch (Exception $e) {  
    echo 'Error en la consulta: ' . $e->getMessage();  
} 
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MENU SECRETARIA</title>
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Estilos CSS embebidos */
        .profile-form {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
        }

        .otro-con {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #FF5722;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #E64A19;
        }

        .btn-previsualizar {
            background-color: #FF5722;
            margin-top: 5px;
        }

        .btn-submit {
            background-color: #FF5722;
            margin-top: 20px;
        }

        .preview-box {
            width: 300px;
            height: 200px;
            border: 1px solid #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            background-color: #f0f0f0;
        }

        .preview-box img {
            max-width: 100%;
            max-height: 100%;
        }

        .empty-container {
            width: 300px;
            height: 200px;
            background-color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar-docente.php'; ?>
        <main class="main-content">    
        <input type="text" name="codigo_a" id="codigo_a" value="<?php echo $codigo; ?>" style="display: none;">

            <!-- EVALUACIÓN DEL ALUMNO-- INFORME FINAL DEL ALUMNO--->
            <div class="container2" style="border: 0;"><br>
                <h2>EVALUACIÓN DEL ALUMNO</h2>
                <br>
            
            <div id="complete" class="container2" style="<?php echo $mostrarDiv < 10 ? 'display:block;' : 'display:none;'; ?>">
                <h2>El informe final del alumno aún no está disponible</h2>
                <p>*La siguiente pestaña se habilitará cuando el alumno suba su informe final</p>
            </div>
            <div class="container2" style="<?php echo $mostrarDiv === 10 ? 'display:block;' : 'display:none;'; ?>">
                <h2>Informe Final Del alumno</h2>
                <div class="form-group">
                    <input type="text" id="id_alumno" name="id_alumno" value="<?php echo $codigo ?>" style="display: none;">
                    <div class="buttons">
                        <button id="d_i_f" type="button" class="btn-small">Descargar informe final</button>
                    </div>

                </div>

                <div class="form-group">
                    <label for="calificacion_reporte">Calificación:</label>
                    <input type="text" id="calificacion_reporte" name="calificacion_reporte" placeholder="Nota de la evaluacion" required>
                </div>

                <div class="form-group">
                    <button id="envi" type="button" class="btn">Enviar calificación</button>
                </div>
            </div>

            <!-- DOCENTE ENVIA PRACTICA AL ALUMNO--->
            <div class="container2" style="<?php echo $mostrarDiv === 11 ? 'display:block;' : 'display:none;'; ?>">
                <h2>Examen de PRACTICA PRE-PROFESIONAL</h2>
                <form action="assets/controladores/enviar_examen.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="codigo_a" id="codigo_a" value="<?php echo $codigo; ?>" style="display: none;">
                    <div class="form-group">
                        <label for="fechaExam">Fecha de Examen (Hoy):</label>
                        <input type="date" name="fechaExam" id="fechaExam" class="date-picker" required>
                    </div>
                    <div class="form-group">
                        <input id="exam" name="exam" type="file" accept=".pdf" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn">Enviar examen</button>
                    </div>
                </form>
            </div>
            
            <div id="complete" class="container2" style="<?php echo $mostrarDiv === 12 ? 'display:block;' : 'display:none;'; ?>">
                <h2>El examen final del alumno aún no está disponible para su calificación</h2>
                <p>*La siguiente pestaña se habilitará cuando el alumno suba su examen final resuelto</p>
            </div>
            <!-- DOCENTE CALIFICA EXAMEN DEL ALUMNO-->
            <div class="container2" style="<?php echo $mostrarDiv === 13 ? 'display:block;' : 'display:none;'; ?>">
                <h2>Calificar examen del alumno</h2>
                <div class="form-group">
                    <input type="text" id="id_alumno" name="id_alumno" value="<?php echo $codigo ?>" style="display: none;">
                    <div class="buttons">
                        <button id="d_e_f_r" name="d_e_f_r" type="button" class="btn-small">Descargar Examen Resuelto</button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nota_e">Calificación del examen:</label>
                    <input type="text" id="nota_e" name="nota_e" placeholder="Nota de la evaluacion" required>
                </div>

                <div class="form-group">
                    <button type="button" id="calificar" name="calificar" class="btn">Calificar examen</button>
                </div>
            </div>

            <!-- NOTA DE APRESIACION DEL DOCENTE-->
            <div class="container2" style="<?php echo $mostrarDiv === 14 ? 'display:block;' : 'display:none;'; ?>">
                <h2>Apreciación final del docente</h2>
                <div class="form-group">
                    <label for="nota_a">Apreciación final:</label>
                    <input type="text" id="nota_a" name="nota_a" placeholder="Apreciación" required>
                </div>

                <div class="form-group">
                    <button id="apreciacion" class="btn">Enviar nota de apreciación</button>
                </div>

            </div>

            <!-- PROMEDIO FINAL DEL ALUMNO-->
            <div class="container2" style="<?php echo $mostrarDiv === 15 ? 'display:block;' : 'display:none;'; ?>">

                <h2>PROMEDIO FINAL DEL ALUMNO</h2>
                <div class="form-group">
                    <label for="prom_final">Promedio final:</label>
                    <input type="text" id="prom_final" name="prom_final" value="<?php echo htmlspecialchars($promedio_final) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="comentario">Comentario final sobre el alumno:</label>
                    <input type="text" id="comentario" name="comentario" placeholder="Comentario final" required>
                </div>

                <div class="form-group">
                    <button id="e_comentario" class="btn">Enviar comentario</button>
                </div>
            </div>
            <div id="complete" class="container2" style="<?php echo $mostrarDiv === 16 ? 'display:block;' : 'display:none;'; ?>">
                <h2>Proceso completado</h2>
                <p>*Se ha completado todo el proceso de calificación de este alumno</p>
            </div>
            </div>
            <div class="form-buttons">
                <button onclick="closeProfileForm()" class="close-btn"> Cerrar</button>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes4.js"></script>
</body>
</html>
