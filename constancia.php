<?php
include 'assets/controladores/bd.php';
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "index.html"; 
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
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Constancia - Prácticas Pre Profesionales</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/modern-theme.css" />
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .step-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border: 2px solid #f8f9fa;
            transition: all 0.3s ease;
            clear: both;
            width: 100%;
            box-sizing: border-box;
        }
        
        .step-card:hover {
            border-color: #FFCC00;
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }
        
        .step-card h2 {
            color: #2C3E50;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
        
        .step-card p {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        .alert-box {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            clear: both;
            width: 100%;
            box-sizing: border-box;
        }
        
        .alert-box h2 {
            color: #856404;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }
        
        .alert-box p {
            color: #856404;
            margin: 0;
        }
        
        .form-group {
            margin-bottom: 1.25rem;
            clear: both;
            width: 100%;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 0.5rem;
            font-size: 0.938rem;
        }
        
        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #ECF0F1;
            border-radius: 8px;
            font-size: 0.938rem;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #FFCC00;
            box-shadow: 0 0 0 3px rgba(255, 204, 0, 0.1);
        }
        
        .form-group input[readonly] {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }
        
        #imagePreviewContainer,
        #preview-container,
        #preview-container2,
        #preview-container3,
        #preview-container4 {
            margin-top: 1rem;
            border-radius: 8px;
            overflow: hidden;
        }
        
        #imagePreview {
            max-width: 300px;
            max-height: 200px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        iframe {
            border-radius: 8px;
            border: 2px solid #ECF0F1 !important;
        }
        
        .action-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .action-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border: 2px solid #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            border-color: #FFCC00;
        }
        
        .action-card-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
        }
        
        .action-card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 1rem;
        }
        
        .action-card-description {
            color: #6c757d;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
    </style>
</head>

<body>
<header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container" style="display: block;">
        <main class="main-content" style="max-width: 1200px; margin: 0 auto;">
            <div class="page-header">
                <h1>📜 Gestión de Constancias</h1>
                <p>Solicita o descarga tu constancia de prácticas pre-profesionales</p>
            </div>
            
            <!-- Sección de Selección -->
            <div id="selection-section">
                <div class="action-cards-grid">
                    <div class="action-card" onclick="showSolicitud()" style="cursor: pointer;">
                        <div class="action-card-icon">📝</div>
                        <h3 class="action-card-title">Solicitar Constancia</h3>
                        <p class="action-card-description">
                            Completa el formulario para solicitar tu constancia de prácticas pre-profesionales.
                        </p>
                        <button class="btn btn-primary" style="width: 100%; pointer-events: none;">
                            🚀 Iniciar Solicitud
                        </button>
                    </div>
                    
                    <div class="action-card" style="cursor: default;">
                        <div class="action-card-icon">📥</div>
                        <h3 class="action-card-title">Descargar Constancia</h3>
                        <p class="action-card-description">
                            Descarga tu constancia aprobada en formato PDF.
                        </p>
                        <input type="hidden" value="<?php echo $codigo; ?>" id="id_alumno_descarga">
                        <button type="button" id="btn_descargar" class="btn btn-secondary" style="width: 100%;" onclick="event.stopPropagation(); descargarConstancia();">
                            📥 Descargar Constancia
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Sección de Solicitud -->
            <div id="solicitud-section" style="display: none;">
                <div style="margin-bottom: 2rem;">
                    <button onclick="showSelection()" class="btn btn-outline">
                        ← Volver
                    </button>
                </div>
            <div class="alert-box" style="<?php echo $mostrarDiv < 15 ? 'display:block;' : 'display:none;' ?>">
                <h2>⚠️ Proceso Incompleto</h2>
                <p>Necesitas completar el proceso anterior antes de solicitar tu constancia.</p>
            </div>
            <div class="alert-box" style="<?php echo $mostrarDiv === 15 ? 'display:block;' : 'display:none;' ?>">
                <h2>⏳ En Espera</h2>
                <p>Tu docente asignado aún no ha enviado su comentario.</p>
            </div>
            <div class="alert-box" style="<?php echo $mostrarDiv === 16 ? 'display:block;' : 'display:none;' ?>">
                <h2>⏳ En Espera</h2>
                <p>Tu docente asignado aún no ha enviado su ficha de evaluación (coordinador).</p>
            </div>
            <div class="alert-box" style="<?php echo $mostrarDiv === 17 ? 'display:block;' : 'display:none;' ?>">
                <h2>⏳ En Espera</h2>
                <p>Tu docente asignado aún no ha enviado su informe final de evaluación (coordinador).</p>
            </div>
            
        <div style="<?php echo $mostrarDiv >= 18 ? 'display:block;' : 'display:none;'?>">
            <div style="display: none;">
                <input type="text" id="dependencia" value="DECANO DE LA FIEI">
                <input type="text" id="nro_tramite" value="Constancia de Practica Pre Profesional">
                <input type="text" id="datos_solicitante" value="X">
                <input type="text" id="nombre_fut" value="<?php echo $nombre_fut; ?>">
                <input type="text" id="facultad" value="Facultad de Ingeniería Electrónica e Informática">
                <input type="text" id="escuela_profesional" value="<?php echo $_SESSION['escuela_profesional']; ?>">
                <input type="text" id="codigo_ins" value="<?php echo $_SESSION['codigo_institucional']; ?>">
                <input type="text" id="dni" value="<?php echo $_SESSION['documento']; ?>">
                <input type="text" id="direccion" value="<?php echo $_SESSION['direccion']; ?>">
                <input type="text" id="nro_dpto" value="<?php echo $_SESSION['departamento']; ?>">
                <input type="text" id="distrito" value="<?php echo $_SESSION['distrito']; ?>">
                <input type="text" id="celular" value="<?php echo $_SESSION['celular']; ?>">
                <input type="text" id="correo" value="<?php echo $_SESSION['Correo_Institucional']; ?>">
                <input type="text" id="fundamentacion" value="SOLICITO CONSTANCIA DE PRÁCTICA PRE PROFESIONAL">
                <input type="text" id="doc1" value="- Constancia de culminación de Prácticas Pre Profesionales de la empresa.">
                <input type="text" id="doc2" value="- Formulario Único de Tramite FUT dirigida al Decano de la FIEI.">
                <input type="text" id="doc3" value="- Dos fotos tamaño carnet a color con fondo blanco, sin lentes.">
                <input type="text" id="doc4" value="- Comprobante de pago por concepto de Constancia de Práctica Pre-Profesional">
                <input type="text" id="folios" value="">
                <input type="text" id="nt" value="<?php echo $nt_fut; ?>">
            </div>
            
            <div class="card">
                <h2 class="card-title">📋 Solicitud de Constancia de Prácticas Pre Profesionales</h2>
                <div class="card-content">
                    <p style="color: #856404; background: #fff3cd; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                        <strong>⚠️ Importante:</strong> Asegúrate de haber recibido la nota final antes de completar este formulario
                    </p>
                    <div class="form-group">
                        <label for="Fechaconstancia">Fecha de Solicitud *</label>
                        <input type="date" id="Fechaconstancia" name="Fechaconstancia" class="date-picker" required>
                    </div>
                </div>
            </div>

            <div class="step-card">
                <h2>📄 Formulario Único de Trámite (FUT)</h2>
                <div class="form-group">
                    <label for="FUTconstancia">Nombre del Documento</label>
                    <input type="text" id="FUTconstancia" value="Constancia de Práctica Pre Profesional" readonly>
                </div>
                <div class="form-group">
                    <label for="firma">Subir Firma *</label>
                    <input type="file" name="firma" id="firma" accept="image/*" onchange="previewImage(event)" required>
                    <div id="imagePreviewContainer">  
                        <img id="imagePreview" src="" alt="Vista previa" style="display: none;"/>  
                    </div>
                </div>
                <div class="form-group">
                    <label>Previsualizar Documento</label>
                    <p style="font-size: 0.875rem; color: #6c757d; margin-bottom: 0.75rem;">Presiona el botón para cargar datos en el FUT</p>
                    <button id="pre" type="button" class="btn btn-secondary">👁️ Previsualizar Documento</button>
                </div>
                <div id="preview-container" style="margin-top: 1rem;">
                    <iframe id="pdf-preview" width="100%" height="428px"></iframe>
                </div>
            </div>

            <div class="step-card">
                <h2>📸 Fotos Tamaño Carnet</h2>
                <p><strong>Nota:</strong> Suba 2 fotos tamaño carnet en un solo documento PDF</p>
                <p style="font-size: 0.875rem; color: #6c757d;"><strong>Recuerda:</strong> Fondo blanco y sin lentes</p>
                <div class="form-group">
                    <label for="Fotoscarnet">Adjuntar archivo en formato PDF *</label>
                    <input id="Fotoscarnet" name="Fotoscarnet" accept=".pdf" type="file" onchange="loadPDF(event)" required>
                </div>
                <div id="preview-container2" style="display: none;">
                    <iframe id="pdf-preview2" width="100%" height="430px"></iframe>
                </div>
            </div>

            <div class="step-card">
                <h2>🏢 Constancia por parte de la Empresa</h2>
                <p>Suba su constancia de culminación de Prácticas Pre Profesionales de la empresa (640 hrs.)</p>
                <div class="form-group">
                    <label for="ConsEmpresa">Adjuntar archivo en formato PDF *</label>
                    <input id="ConsEmpresa" name="ConsEmpresa" accept=".pdf" type="file" onchange="loadPDF2(event)" required>
                </div>
                <div id="preview-container3" style="display: none;">
                    <iframe id="pdf-preview3" width="100%" height="430px"></iframe>
                </div>
            </div>

            <div class="step-card">
                <h2>💳 Comprobantes de Pago</h2>
                <div class="form-group">
                    <label for="NumeroLiquidacion">Número de Liquidación *</label>
                    <input type="text" id="NumeroLiquidacion" placeholder="Ingrese el número que aparece en el voucher" required>
                </div>
                <div class="form-group">
                    <label for="Comprobante">Adjuntar Comprobante de Pago *</label>
                    <p style="font-size: 0.875rem; color: #6c757d; margin-bottom: 0.75rem;">
                        Suba su comprobante de pago (original y copia) por concepto de Constancia de Práctica Pre Profesional en un solo PDF
                    </p>
                    <input id="Comprobante" name="Comprobante" accept=".pdf" type="file" onchange="loadPDF3(event)" required>
                </div>
                <div id="preview-container4" style="display: none;">
                    <iframe id="pdf-preview4" width="100%" height="430px"></iframe>
                </div>
            </div>

            <div class="form-group" style="margin-top: 2rem;">
                <button id="DocFinal" type="button" class="btn btn-primary" style="width: 100%; padding: 1rem;">
                    ✅ Finalizar y Enviar Solicitud
                </button>
            </div>
        </div>
            </div>
        </main>
    </div>
    
    <!-- Modal de notificación -->
    <div id="notification-modal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: white; border-radius: 16px; padding: 2rem; max-width: 400px; text-align: center; box-shadow: 0 8px 32px rgba(0,0,0,0.2);">
            <div id="notification-icon" style="font-size: 4rem; margin-bottom: 1rem;"></div>
            <h3 id="notification-title" style="color: #2C3E50; margin-bottom: 0.5rem;"></h3>
            <p id="notification-message" style="color: #6c757d; margin-bottom: 1.5rem;"></p>
            <button onclick="closeNotification()" class="btn btn-primary" style="width: 100%;">Entendido</button>
        </div>
    </div>
    
    <script>
        function showSelection() {
            document.getElementById('selection-section').style.display = 'block';
            document.getElementById('solicitud-section').style.display = 'none';
        }
        
        function showSolicitud() {
            document.getElementById('selection-section').style.display = 'none';
            document.getElementById('solicitud-section').style.display = 'block';
        }
        
        function showNotification(icon, title, message) {
            document.getElementById('notification-icon').textContent = icon;
            document.getElementById('notification-title').textContent = title;
            document.getElementById('notification-message').textContent = message;
            document.getElementById('notification-modal').style.display = 'flex';
        }
        
        function closeNotification() {
            document.getElementById('notification-modal').style.display = 'none';
        }
        
        // Función para descargar constancia con manejo de errores
        function descargarConstancia() {
            var id_alumno = $('#id_alumno_descarga').val();
            
            // Intentar la descarga directamente
            window.location.href = 'assets/controladores/descargar_constancia.php?codigo_a=' + encodeURIComponent(id_alumno);
        }
        
        // Función separada para depuración (opcional)
        function debugConstancia() {
            $.ajax({
                url: 'assets/controladores/descargar_constancia.php?debug=1',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Debug Info:', response.debug);
                    
                    if (response.debug) {
                        var debugMsg = '=== INFORMACIÓN DE DEPURACIÓN ===\n';
                        debugMsg += 'Código alumno: ' + response.debug.codigo_alumno + '\n';
                        debugMsg += 'Nombre archivo buscado: ' + response.debug.nombre_archivo_buscado + '\n';
                        debugMsg += 'Ruta en BD: ' + response.debug.ruta_en_bd + '\n';
                        debugMsg += 'ID Alumno: ' + response.debug.id_alumno + '\n';
                        debugMsg += 'ID Carpeta: ' + response.debug.id_carpeta + '\n';
                        debugMsg += 'Nombre Carpeta: ' + response.debug.nombre_carpeta + '\n';
                        
                        if (response.debug.archivos_en_carpeta && response.debug.archivos_en_carpeta.length > 0) {
                            debugMsg += '\nArchivos encontrados en la carpeta:\n';
                            response.debug.archivos_en_carpeta.forEach(function(archivo) {
                                debugMsg += '  - ' + archivo.nombre_archivo + ' -> ' + archivo.ruta + '\n';
                            });
                        }
                        
                        if (response.debug.ruta_absoluta_calculada) {
                            debugMsg += '\nRuta absoluta calculada: ' + response.debug.ruta_absoluta_calculada + '\n';
                            debugMsg += 'Archivo existe: ' + response.debug.archivo_existe + '\n';
                        }
                        
                        console.log(debugMsg);
                        alert(debugMsg);
                    }
                },
                error: function(xhr) {
                    console.error('Error en debug:', xhr);
                }
            });
        }
    </script>
    <script src="assets/js/mesadepartes2.js"></script>
</body>
</html>
