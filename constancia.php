<?php
include 'assets/controladores/bd.php';
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "login.html"; 
    </script>';
}
$codigo = $_SESSION['codigo_institucional'];
$nombre_fut = $_SESSION['primer_apellido'] . ' ' . $_SESSION['segundo_apellido'] . ' ' . $_SESSION['primer_nombre'] . ' ' . $_SESSION['segundo_nombre'];
$nt_fut = 'NT:' . $_SESSION['nt'];
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
        <div id="complete" class="container2" style="<?php echo $mostrarDiv < 15 ? 'display:block;' : 'display:none;' ?>">
                <h2>Necesitas completar el proceso anterior</h2>
            </div>
            <div id="complete" class="container2" style="<?php echo $mostrarDiv === 15 ? 'display:block;' : 'display:none;' ?>">
                <h2>Aún no puedes continuar</h2>
                <p>*Tu docente asignado aún no envia su comentario</p>
            </div>
            <div id="complete" class="container2" style="<?php echo $mostrarDiv === 16 ? 'display:block;' : 'display:none;' ?>">
                <h2>Aún no puedes continuar</h2>
                <p>*Tu docente asignado aún no envia su ficha de evaluacion (coordinador)</p>
            </div>
            <div id="complete" class="container2" style="<?php echo $mostrarDiv === 17 ? 'display:block;' : 'display:none;' ?>">
                <h2>Aún no puedes continuar</h2>
                <p>*Tu docente asignado aún no envia su informe final de evaluación (coordinador)</p>
            </div>
        <div class="container2" style="<?php echo $mostrarDiv >= 18 ? 'display:block;' : 'display:none;'?>">
            <div class="container2" style="border: 0;">
                <input type="text" id="dependencia" value="DECANO DE LA FIEI" style="display: none;">
                <input type="text" id="nro_tramite" value="Constancia de Practica Pre Profesional" style="display: none;">
                <input type="text" id="datos_solicitante" value="X" style="display: none;">
                <input type="text" id="nombre_fut" value="<?php echo $nombre_fut; ?>" style="display: none;">
                <input type="text" id="facultad" value="Facultad de Ingeniería Electrónica e Informática" style="display: none;">
                <input type="text" id="escuela_profesional" value="<?php echo $_SESSION['escuela_profesional']; ?>" style="display: none;">
                <input type="text" id="codigo_ins" value="<?php echo $_SESSION['codigo_institucional']; ?>" style="display: none;">
                <input type="text" id="dni" value="<?php echo $_SESSION['documento']; ?>" style="display: none;">
                <input type="text" id="direccion" value="<?php echo $_SESSION['direccion']; ?>" style="display: none;">
                <input type="text" id="nro_dpto" value="<?php echo $_SESSION['departamento']; ?>" style="display: none;">
                <input type="text" id="distrito" value="<?php echo $_SESSION['distrito']; ?>" style="display: none;">
                <input type="text" id="celular" value="<?php echo $_SESSION['celular']; ?>" style="display: none;">
                <input type="text" id="correo" value="<?php echo $_SESSION['Correo_Institucional']; ?>" style="display: none;">
                <input type="text" id="fundamentacion" value="SOLICITO CONSTANCIA DE PRÁCTICA PRE PROFESIONAL" style="display: none;">
                <input type="text" id="doc1" value="- Constancia de culminación de Prácticas Pre Profesionales de la empresa." style="display: none;">
                <input type="text" id="doc2" value="- Formulario Único de Tramite FUT dirigida al Decano de la FIEI." style="display: none;">
                <input type="text" id="doc3" value="- Dos fotos tamaño carnet a color con fondo blanco, sin lentes." style="display: none;">
                <input type="text" id="doc4" value="- Comprobante de pago por concepto de Constancia de Práctica Pre-Profesional" style="display: none;">
                <input type="text" id="folios" value="" style="display: none;">
                <input type="text" id="nt" value="<?php echo $nt_fut; ?>" style="display: none;">
                <h2>SOLICITUD DE CONSTANCIA DE PRACTICAS PRE PROFESIONALES</h2>
                <p>*Asegurate de haber recibido la nota final antes de completar este formulario</p>
                <div class="form-group">
                    <label for="Fechaconstancia">Fecha de Solicitud:</label>
                    <input type="date" id="Fechaconstancia" name="Fechaconstancia" class="date-picker" required>
                    </div>
                </div>

                <div class="container2" style="border:0">
                <h2> Formulario Unico de Tramite</h2>
                <div class="form-group">
                        <label for="FUTconstancia">Nombre del Documento:</label>
                        <input type="text" id="FUTconstancia" value="Constancia de Práctica Pre Profesional" readonly>
                    </div>
                    <div class="form-group">
                            <label for="firma">Subir firma:</label>
                            <input type="file" name="firma" id="firma" accept="image/*" onchange="previewImage(event)" required>
                            <div id="imagePreviewContainer">  
                                <img id="imagePreview" src="" alt="Vista previa" style="display: none; max-width:400px; max-height: 300px;"/>  
                            </div>
                        </div>
                    <div class="form-group">
                        <label for="FUTT">Documento:</label>
                        <p>*Presionar para cargar datos en el FUT</p>
                        <div class="buttons">
                            <button id="pre" type="button" class="btn-small" style="background-color: red;">Previsualizar Documento</button>
                        </div>
                    </div>
                    <div id="preview-container">
                        <iframe id="pdf-preview" width="100%" height="428px" style="border: 1px solid black;"></iframe>
                    </div>
                </div>

                <div class="container2" style="border:0">
                    <h2> Fotos Tamaño Carnet</h2>
                    <p>Nota: Suba 2 fotos tamaño carnet en un solo documento pdf
                        Recuerda: Fondo blanco y sin lentes
                    </p>
                
                    <div class="form-group">
                            <label for="Fotoscarnet">Adjuntar archivo en formato pdf</label>
                            <input id="Fotoscarnet" name="Fotoscarnet" accept=".pdf" type="file" onchange="loadPDF(event)" required>
                    </div>
                    <div id="preview-container2" style="display: none;">
                        <iframe id="pdf-preview2" width="105%" height="430px" style="border: 1px solid black;"></iframe>
                    </div>
                </div>

                <div class="container2" style="border:0">
                <h2> Constancia por parte de la Empresa</h2>
                <p> Suba su constancia de culminacion de Prácticas Pre Profesionales de la empresa (640 hrs.)
                </p>
               
                <div class="form-group">
                        <label for="ConsEmpresa">Adjuntar archivo en formato pdf</label>
                        <input id="ConsEmpresa" name="ConsEmpresa" accept=".pdf" type="file" onchange="loadPDF2(event)" required>
                    </div>
                    <div id="preview-container3" style="display: none;">
                        <iframe id="pdf-preview3" width="105%" height="430px" style="border: 1px solid black;"></iframe>
                    </div>
                </div>

                <div class="container2" style="border:0">
                <h2> Comprobantes de Pago</h2>
                <div class="form-group">
                        <label for="NumeroLiquidacion">Número de Liquidacion (que aparece en el voucher):</label>
                        <input type="text" id="NumeroLiquidacion" placeholder="Numero de liquidacion" required>
                    </div>
                <div class="form-group">

                        <label for="Comprobante">Adjuntar Documento:</label>
                        <p>Suba su comprobante de pago (original y copia) por concepto de Constancia de Práctica Pre Profesional en un solo PDF</p>
                        <input id="Comprobante" name="Comprobante" accept=".pdf" type="file" onchange="loadPDF3(event)" required>
                    </div>
                    <div id="preview-container4" style="display: none;">
                        <iframe id="pdf-preview4" width="105%" height="430px" style="border: 1px solid black;"></iframe>
                    </div>
                </div>

                <div class="form-group">
                        <div class="buttons">
                            <button id="DocFinal" type="button" class="btn-small"> Finalizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes2.js"></script>
</body>
</html>
