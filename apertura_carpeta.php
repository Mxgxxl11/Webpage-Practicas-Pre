<?php
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "index.html"; 
    </script>';
}
$nombre_completo = $_SESSION['primer_nombre'] . ' ' . $_SESSION['segundo_nombre'] . ' ' . $_SESSION['primer_apellido'] . ' ' . $_SESSION['segundo_apellido'];
$nombre_fut = $_SESSION['primer_apellido'] . ' ' . $_SESSION['segundo_apellido'] . ' ' . $_SESSION['primer_nombre'] . ' ' . $_SESSION['segundo_nombre'];
$apellidos = $_SESSION['primer_apellido'] . ' ' . $_SESSION['segundo_apellido'];
$nombre = $_SESSION['primer_nombre'] . ' ' . $_SESSION['segundo_nombre'];
$nt_fut = 'NT:' . $_SESSION['nt'];
$mostrarDiv = isset($_SESSION['paso_cp']) ? $_SESSION['paso_cp'] : '';
$ciclo = '';
if (date('m') < 9) {
    $ciclo = date('Y') . ' - 1';
} else {
    $ciclo = date('Y') . ' - 2';
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
    <div class="container" style="display: block;">
        <main class="main-content" style="max-width: 1200px; margin: 0 auto;">
        <div id="complete" class="container2" style="<?php echo $mostrarDiv < '3' ? 'display:block;' : 'display:none;' ?>">
                <h2>Necesitas completar el proceso anterior</h2>
            </div>
            <div id="complete" class="container2" style="<?php echo $mostrarDiv === '3' ? 'display:block;' : 'display:none;' ?>">
                <h2>Necesitas completar el NT para continuar con este tramite</h2>
                <p>*Ingresar número de tramite sin el año</p>
                <div class="form-group">
                    <label for="nt">NT :</label>
                    <input type="number" name="nt" id="nt" required>
                </div>
                <div class="form-group">
                    <div class="buttons">
                        <button onclick="closeProfileForm()" class="btn-small">Cerrar</button>
                        <button id="send" name="send" type="button" class="btn-small">Enviar</button>
                    </div>
                </div>
            </div>
            <div id="segundo" style="<?php echo $mostrarDiv === '4' ? 'display:block;' : 'display:none;'; ?>">
                <!-- DATOS PARA LLENAR EL FUT-->
                <input type="text" id="dependencia" value="DECANO DE LA FIEI" style="display: none;">
                <input type="text" id="nro_tramite" value="Solicitud de Apertura de Carpeta" style="display: none;">
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
                <input type="text" id="fundamentacion" value="SOLICITO APERTURA DE CARPETA" style="display: none;">
                <input type="text" id="doc1" value="- FUT" style="display: none;">
                <input type="text" id="doc2" value="- Record Academico Actualizado" style="display: none;">
                <input type="text" id="doc3" value="- Carta de presentación recepcionada por la empresa" style="display: none;">
                <input type="text" id="doc4" value="- Ficha de inscripción" style="display: none;">
                <input type="text" id="folios" value="" style="display: none;">
                <input type="text" id="nt" value="<?php echo $nt_fut; ?>" style="display: none;">
                <!-- DATOS PARA LLENAR EL FUT-->
                <div class="container2">
                    <h2>Primer Requisito: FORMULARIO ÚNICO DE TRÁMITE</h2>

                    <div class="form-group">
                        <label for="fechaRegistroS">Fecha de Registro (Hoy):</label>
                        <input type="date" name="fechaRegistroS" id="fechaRegistroS" class="date-picker" required>
                    </div>
                    <div class="form-group">
                        <label for="firma">Subir firma:</label>
                        <input type="file" name="firma" id="firma" accept="image/*" onchange="previewImage(event)" required>
                        <div id="imagePreviewContainer">
                            <img id="imagePreview" src="" alt="Vista previa" style="display: none; max-width:400px; max-height: 300px;" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="archivo1">Archivo:</label>
                        <div class="buttons">
                            <button id="futapertura" style="background-color: red;" type="button" class="btn-small">Cargar datos al FUT</button>
                        </div>
                    </div>
                    <div id="preview-container">
                        <iframe id="pdf-preview" width="100%" height="430px" style="border: 1px solid black;"></iframe>
                    </div>
                </div>
            



            <div class="container2">
                <h2>Segundo Requisito: Record Académico</h2>

                <div class="form-group">
                    <label for="fechaRecord">Fecha del record académico de notas de OCRAC:</label>
                    <input type="date" name="fechaRecord" id="fechaRecord" class="date-picker" required>
                </div>

                <div class="form-group">
                    <label for="RecordAca">Archivo:</label>
                    <input name="RecordAca" id="RecordAca" accept=".pdf" type="file" onchange="loadPDF4(event)" required>


                </div>
                <div id="preview-container4" style="display: none;">
                    <iframe id="pdf-preview4" width="105%" height="430px" style="border: 1px solid black;"></iframe>
                </div>
            </div>





            <div class="container2">
                <h2>Tercer Requisito: Carta de Presentación Recepcionada</h2>


                <div class="form-group">
                    <label for="CartaRec">Archivo:</label>
                    <input id="CartaRec" name="CartaRec" accept=".pdf" type="file" onchange="loadPDF5(event)" required>


                </div>
                <div id="preview-container5" style="display: none;">
                    <iframe id="pdf-preview5" width="105%" height="430px" style="border: 1px solid black;"></iframe>
                </div>
            </div>

            <div class="container2">
                <h2>Cuarto Requisito: Carta de Aceptación de la Empresa</h2>

                <div class="form-group">
                    <label for="fechaInicio">Fecha de Inicio:</label>
                    <input type="date" name="fechaInicio" id="fechaInicio" class="date-picker" required>
                </div>
                <div class="form-group">
                    <label for="fechaCulminacion">Fecha de Culminación:</label>
                    <input type="date" name="fechaCulminacion" id="fechaCulminacion" class="date-picker" required>
                </div>

                <div class="form-group">
                    <label for="CartaAceptacion">Archivo:</label>
                    <input name="CartaAceptacion" id="CartaAceptacion" accept=".pdf" type="file" onchange="loadPDF6(event)" required>


                </div>
                <div id="preview-container6" style="display: none;">
                    <iframe id="pdf-preview6" width="105%" height="430px" style="border: 1px solid black;"></iframe>
                </div>
            </div>

            <form id="empresaForm" method="POST" enctype="multipart/form-data">
                <input type="text" id="apellidos" value="<?php echo $apellidos; ?>" style="display: none;">
                <input type="text" id="nombre" value="<?php echo $nombre; ?>" style="display: none;">
                <input type="text" id="escuela_profesional" value="<?php echo $_SESSION['escuela_profesional']; ?>" style="display: none;">
                <input type="text" id="codigo_ins" value="<?php echo $_SESSION['codigo_institucional']; ?>" style="display: none;">
                <input type="text" id="semestre" value="<?php echo $ciclo; ?>" style="display: none;">
                <input type="text" id="celular" value="<?php echo $_SESSION['celular']; ?>" style="display: none;">
                <input type="text" id="correo" value="<?php echo $_SESSION['Correo_Institucional']; ?>" style="display: none;">


                <div class="container2">
                
                <h2>Quinto Requisito: Ficha de Inscripción</h2>

                <h2>Datos de la Empresa</h2>
                <div class="form-group">
                    <label for="nombreEmpresa">Nombre Empresa:</label>
                    <input type="text" name="nombreEmpresa" id="nombreEmpresa" value="<?php echo $_SESSION['nombre_empresa']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="rucEmpresa">RUC:</label>
                    <input type="text" name="rucEmpresa" id="rucEmpresa" value="<?php echo $_SESSION['ruc_empresa']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="direccionEmpresa">Direccion:</label>
                    <input type="text" name="direccionEmpresa" id="direccionEmpresa" value="<?php echo $_SESSION['direccion_empre']; ?>" readonly>
                </div>

                <div class="container2" style="border: 0;">
                    <h2>Completar Datos</h2>
                    <div class="form-group">
                        <label for="jefeInmediato">Jefe Inmediato:</label>
                        <input type="text" name="jefeInmediato" id="jefeInmediato" placeholder="Jefe Inmediato" required>
                    </div>
                    <div class="form-group">
                        <label for="areaTrabajo">Área de Trabajo:</label>
                        <input type="text" name="areaTrabajo" id="areaTrabajo" placeholder="Área de Trabajo" required>
                    </div>
                    <div class="form-group">
                        <label for="telefonoCelular">Teléfono o Celular:</label>
                        <input type="text" name="telefonoCelular" id="telefonoCelular" placeholder="Teléfono o Celular" required>
                    </div>

                    <div class="form-group">
                        <div class="buttons">
                            <button id="g" type="button" style="background-color: red;" class="btn-small">Guardar</button>
                            <button id="visualizar" type="button" style="background-color: red;" class="btn-small">Visualizar</button>
                        </div>
                    </div>
                    <div id="preview-container">
                        <iframe id="pdf-preview2" width="100%" height="430px" style="border: 1px solid black;"></iframe>
                    </div>
                </div>

            </div>
            </form>

            <div class="container2">
                <h2>Documento Final</h2>

                <div class="form-group">
                <p>Realice la solicitud por esta página: <a href="https://tramite.unfv.edu.pe/Solicitud_Tramite/" target="_blank">https://tramite.unfv.edu.pe/Solicitud_Tramite/</a></p>
                    <div class="buttons">
                        <button id="descargar" type="button" style="background-color: red;" class="btn-small">Descargar PDF Solicitud</button>
                    </div>
                </div>
            </div>
            </div>
            <div id="complete" class="container2" style="<?php echo $mostrarDiv >= '5' ? 'display:block;' : 'display:none;'; ?>">
                <h2>Proceso ya completado</h2>
                <p>Realice la solicitud por esta página: <a href="https://tramite.unfv.edu.pe/Solicitud_Tramite/" target="_blank">https://tramite.unfv.edu.pe/Solicitud_Tramite/</a></p>
                <p>Debe de enviar el archivo PDF antes descargado al link de arriba</p>
                <div class="form-buttons">
                    <button onclick="closeProfileForm()" class="close-btn">Cerrar</button>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes3.js"></script>
</body>
</html>
