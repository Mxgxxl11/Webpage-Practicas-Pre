<?php
session_start();
include './assets/controladores/bd.php';
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "login.html"; 
    </script>';
}
$codigo = $_GET['codigo']; 
$codigo2 = $_SESSION['codigo_institucional'];
$codigo_alum = '';
$codigo_doc = '';
$nombre_alumno = '';
$nombre_alumno2 = '';
$apellido_alumno = '';
$apellido_alumno2 = '';
$nombre_docente = '';
$nombre_docente2 = '';
$apellido_docente = '';
$apellido_docente2 = '';
$promedio_final = '';  
$trabajo_final = '';
$examen_final = '';
$apreciacion = '';
$id_escuela = '';
$escuela = '';
$id_empresa = '';
$nombre_empresa = '';
$mostrarDiv = 0;
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
    $stmt = $conexion->prepare("SELECT nombre1, nombre2, apellido1, apellido2, id_escuela FROM usuario WHERE codigo = ?");  
    $stmt->bind_param("i", $codigo); 
    $stmt->execute();  
    $stmt->bind_result($nombre_alumno, $nombre_alumno2, $apellido_alumno, $apellido_alumno2, $id_escuela);  
    $stmt->fetch();  
    $stmt->close();  
    
} catch (Exception $e) {  
    echo 'Error en la consulta: ' . $e->getMessage();  
} 
try {  
    // Preparar consulta  
    $stmt = $conexion->prepare("SELECT escuela FROM escuelas WHERE id_escuela = ?");  
    $stmt->bind_param("i", $id_escuela); 
    $stmt->execute();  
    $stmt->bind_result($escuela);  
    $stmt->fetch();  
    $stmt->close();  
    
} catch (Exception $e) {  
    echo 'Error en la consulta: ' . $e->getMessage();  
} 
try {  
    // Preparar consulta  
    $stmt = $conexion->prepare("SELECT nombre1, nombre2, apellido1, apellido2 FROM usuario WHERE codigo = ?");  
    $stmt->bind_param("i", $codigo2); 
    $stmt->execute();  
    $stmt->bind_result($nombre_docente, $nombre_docente2, $apellido_docente, $apellido_docente2);  
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
    $stmt = $conexion->prepare("SELECT id_empresa FROM practicas WHERE id_alumno = ?");  
    $stmt->bind_param("i", $codigo_alum); 
    $stmt->execute();  
    $stmt->bind_result($id_empresa);  
    $stmt->fetch();  
    $stmt->close();  
    
} catch (Exception $e) {  
    echo 'Error en la consulta: ' . $e->getMessage();  
} 
try {  
    // Preparar consulta  
    $stmt = $conexion->prepare("SELECT nombre_empresa FROM empresa WHERE id_empresa = ?");  
    $stmt->bind_param("i", $id_empresa); 
    $stmt->execute();  
    $stmt->bind_result($nombre_empresa);  
    $stmt->fetch();  
    $stmt->close();  
    
} catch (Exception $e) {  
    echo 'Error en la consulta: ' . $e->getMessage();  
} 
try {  
    // Preparar consulta  
    $stmt = $conexion->prepare("SELECT promedio_final, trabajo_final, apreciacion, examen_final FROM calificaciones WHERE (id_alumno = ? AND id_docente = ?)");  
    $stmt->bind_param("ii", $codigo_alum, $codigo_doc); 
    $stmt->execute();  
    $stmt->bind_result($promedio_final, $trabajo_final, $apreciacion, $examen_final);  
    $stmt->fetch();  
    $stmt->close();  
    
} catch (Exception $e) {  
    echo 'Error en la consulta: ' . $e->getMessage();  
} 
$nombre_alumno_completo = $nombre_alumno . ' ' . $nombre_alumno2 . ' ' . $apellido_alumno . ' ' . $apellido_alumno2;
$nombre_docente_completo = $nombre_docente . ' ' . $nombre_docente2 . ' ' . $apellido_docente . ' ' . $apellido_docente2;
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
        .ficha-evaluacion {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            box-sizing: border-box;
            margin-top: 20px;
        }

        .ficha-evaluacion h2 {
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
            text-align: left;
        }

        .campo {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .campo label {
            width: 30%;
            font-weight: bold;
            font-size: 14px;
        }

        .campo input {
            width: 65%;
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .criterios-evaluacion {
            margin-top: 20px;
        }

        .criterios-evaluacion h3 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .criterios-evaluacion table {
            width: 100%;
            border-collapse: collapse;
        }

        .criterios-evaluacion th,
        .criterios-evaluacion td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .criterios-evaluacion th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .criterios-evaluacion td {
            background-color: #ffffff;
            text-align: center;
        }

        .diseno-ingenieria {
            margin-top: 20px;
        }

        .diseno-ingenieria h3 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .diseno-ingenieria table {
            width: 100%;
            border-collapse: collapse;
        }

        .diseno-ingenieria th,
        .diseno-ingenieria td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .diseno-ingenieria th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .diseno-ingenieria td {
            background-color: #ffffff;
            text-align: center;
        }

        .diseno-ingenieria td label {
            display: block;
            margin: 0 auto;
            text-align: center;
        }

        .btn-small {
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            background-color: #000;
            color: white;
        }

        .btn-small:hover {
            background-color: #c08143;
        }
    </style>
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar-docente.php' ?>
        <main class="main-content">
            <div class="profile-form">
                    <div class="ficha-evaluacion" style="<?php echo $mostrarDiv < 16 ? 'display:block;' : 'display:none;'; ?>">
                        <h2>Proceso aún no disponible</h2>
                        <p>*Debes completar toda la evaluacion del alumno para pasar a los informes</p>
                    </div>
                    <div style="<?php echo $mostrarDiv === 16 ? 'display:block;' : 'display:none;'; ?>">
                    <form action="assets/controladores/enviar_evaluacion_coordinador.php" method="post" enctype="multipart/form-data">
                        <h2>Ficha de Evaluación del Coordinador - FIEI Práctica Pre Profesional</h2>
                        <p>Descargue el formato aquí: <a href="https://web.unfv.edu.pe/facultades/fiei/images/oficinas/practicas_preprofesionales/formato_5_.pdf" target="_blank">descargar</a></p>
                        <input type="text" name="codigo_a" id="codigo_a" value="<?php echo $codigo; ?>" style="display: none;">
                        <h2>Datos del practicante:</h2>
                            <div class="campo">
                                <label>Estudiante:</label>
                                <input id="estudiante" type="text" value="<?php echo $nombre_alumno_completo; ?>" readonly>
                            </div>
                            <div class="campo">
                                <label>Escuela Profesional:</label>
                                <input id="escuela" type="text" value="<?php echo $escuela; ?>" readonly>
                            </div>
                            <div class="campo">
                                <label>Empresa:</label>
                                <input id="empresa" type="text" value="<?php echo $nombre_empresa; ?>" readonly>
                            </div>
                            <div class="campo">
                                <label>Coordinador:</label>
                                <input id="coordinador" type="text" value="<?php echo $nombre_docente_completo; ?>" readonly>
                            </div>
                            <h2>Calificaciones:</h2>
                    <div class="campo">
                                <label>Nota de evaluación de informes:</label>
                                <input type="text" id="nota_informes" name="nota_informes" value="<?php echo $trabajo_final; ?>" disabled>
                            </div>
                            <div class="campo">
                                <label>Nota de examen:</label>
                                <input type="text" id="nota_examen" name="nota_examen" value="<?php echo $examen_final; ?>" disabled>
                            </div>
                            <div class="campo">
                                <label>Nota de apreciación del docente:</label>
                                <input type="text" id="nota_docente" name="nota_docente" value="<?php echo $apreciacion; ?>" disabled>
                            </div>
                            <div class="campo">
                                <label>Promedio:</label>
                                <input type="text" id="promedio" name="promedio" value="<?php echo $promedio_final; ?>" disabled>
                            </div>
                            <h2>Ficha de Evaluación:</h2>
                            <div class="campo">
                                <label>Fecha:</label>
                                <input name="fechaRegistro" id="fechaRegistro" type="date" class="date-picker" required>
                            </div>
                            <div class="campo">
                                <label for="evaluacion">Adjuntar ficha de evaluación en formato pdf:</label>
                                <input id="evaluacion" name="evaluacion" accept=".pdf" type="file" onchange="loadPDF2(event)" required>
                            </div>
                            <div id="preview-container3" style="display: none;">
                                <iframe id="pdf-preview3" width="105%" height="430px" style="border: 1px solid black; margin-top: 10px;"></iframe>
                            </div>
                            <div class="campo">
                                <button id="evalua_coordinador" name="evalua_coordinador" type="submit" class="btn-small">Enviar ficha de evaluación</button>
                            </div>
                    </form>
                    </div>
                <div class="ficha-evaluacion" style="<?php echo $mostrarDiv === 17 ? 'display:block;' : 'display:none;'; ?>">
                    <form action="assets/controladores/enviar_informe_coordinador.php" method="post" enctype="multipart/form-data">
                    <h2>Informe Final de Evaluación de Prácticas Pre Profesionales</h2>
                    <p>Descargue el formato aquí: <a href="https://web.unfv.edu.pe/facultades/fiei/images/oficinas/practicas_preprofesionales/formato_6_informe_final.pdf" target="_blank">descargar</a></p>
                        <h2>Datos del practicante:</h2>
                    <input type="text" name="codigo_a" id="codigo_a" value="<?php echo $codigo; ?>" style="display: none;">
                        <div class="campo">
                            <label>Nombre:</label>
                            <input id="estudiante" type="text" value="<?php echo $nombre_alumno_completo; ?>" readonly>
                        </div>
                        <div class="campo">
                            <label>Escuela Profesional:</label>
                            <input id="escuela" type="text" value="<?php echo $escuela; ?>" readonly>
                        </div>
                        <div class="campo">
                        <label>Empresa:</label>
                        <input id="empresa" type="text" value="<?php echo $nombre_empresa; ?>" readonly>
                        </div>
                    <h2>Calificaciones:</h2>
                    <div class="campo">
                                <label>Nota de evaluación de informes:</label>
                                <input type="text" id="nota_informes" name="nota_informes" value="<?php echo $trabajo_final; ?>" disabled>
                            </div>
                            <div class="campo">
                                <label>Nota de examen:</label>
                                <input type="text" id="nota_examen" name="nota_examen" value="<?php echo $examen_final; ?>" disabled>
                            </div>
                            <div class="campo">
                                <label>Nota de apreciación del docente:</label>
                                <input type="text" id="nota_docente" name="nota_docente" value="<?php echo $apreciacion; ?>" disabled>
                            </div>
                            <div class="campo">
                                <label>Promedio:</label>
                                <input type="text" id="promedio" name="promedio" value="<?php echo $promedio_final; ?>" disabled>
                            </div>
                            <h2>Informe Final:</h2>
                            <div class="campo">
                        <label>Fecha:</label>
                        <input name="fechaInformeF" id="fechaInformeF" type="date" class="date-picker" required>
                    </div>
                    <div class="campo">
                        <label for="informe">Adjuntar informe final en formato pdf:</label>
                        <input id="informe" name="informe" accept=".pdf" type="file" onchange="loadPDF3(event)" required>
                    </div>
                    <div id="preview-container4" style="display: none;">
                        <iframe id="pdf-preview4" width="105%" height="430px" style="border: 1px solid black; margin-top: 10px;"></iframe>
                    </div>
                    <div class="campo">
                        <button id="informe_coordinador" name="informe_coordinador" type="submit" class="btn-small">Enviar informe final</button>
                    </div>
                    </form>
                </div>
                <div class="ficha-evaluacion" style="<?php echo $mostrarDiv >= 18 ? 'display:block;' : 'display:none;'; ?>">
                    <h2>Proceso completado</h2>
                    <p>*Ya has enviado todos los informes respectivos a este alumno</p>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes4.js"></script>
</body>
</html>
