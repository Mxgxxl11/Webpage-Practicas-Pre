<?php
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "login.html"; 
    </script>';
}
$nombre_completo = $_SESSION['primer_nombre'] . ' ' . $_SESSION['segundo_nombre'] . ' ' . $_SESSION['primer_apellido'] . ' ' . $_SESSION['segundo_apellido'];
$nombre_fut = $_SESSION['primer_apellido'] . ' ' . $_SESSION['segundo_apellido'] . ' ' . $_SESSION['primer_nombre'] . ' ' . $_SESSION['segundo_nombre'];
$mostrarDiv = isset($_SESSION['paso_cp']) ? $_SESSION['paso_cp'] : '';  
$empresa_guardada = isset($_SESSION['empresa_guardada']) ? $_SESSION['empresa_guardada'] : '';

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
            <!-- INICIA FORM DE REGISTRO-->
            <div class="profile-form" id="Next-step" style="<?php echo $mostrarDiv === '1' ? 'display:block;' : 'display:none'; ?>">
                <form action="assets/controladores/registro_cp.php" method="POST" enctype="multipart/form-data">
                    <div class="profile-fields">
                        <div>
                            <label for="codigo">Código:</label>
                            <input type="text" id="codigo" name="codigo" value="<?php echo $_SESSION['codigo_institucional']; ?>" readonly/>
                            <div class="error-message" id="codigo-error"></div>
                        </div>
                        <div>
                            <label for="name">Nombres y Apellidos:</label>
                            <input type="text" id="name" name="name" value="<?php echo $nombre_completo; ?>" readonly/>
                            <div class="error-message" id="name-error"></div>
                        </div>
                        <div>
                            <label for="distrito">Distrito:</label>
                            <input type="text" id="distrito" value="<?php echo $_SESSION['distrito']; ?>" readonly />
                        </div>
                        <div>
                            <label for="p-curricular">Plan curricular:</label>
                            <input type="text" id="p-curricular" name="p-curricular" required/>
                        </div>
                        <div>
                            <label for="base">Base:</label>
                            <input type="text" id="base" name="base" required/>
                        </div>
                        <div>
                            <label for="semestre">Semestre:</label>
                            <input type="text" id="semestre" name="semestre" required/>
                        </div>
                        <div>
                            <label for="seccion">Sección:</label>
                            <input type="text" id="seccion" name="seccion" required/>
                        </div>
                        <label for="condicion">Condición:</label>
                        <select id="condicion" name="condicion" required>
                            <option value="1">Estudiante</option>
                            <option value="2">Egresado</option>
                        </select>
                        <div class="form-buttons">
                            <button style="margin-top: 10px;" type="submit">Siguiente</button>
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <!-- INICIA SEGUNDO FORM-->
            <div id="segundo" style="<?php echo $mostrarDiv === '2' ? 'display:block;' : 'display:none;'; ?>">
                <!-- DATOS PARA LLENAR EL FUT-->
                <input type="text" id="dependencia" value="DECANO DE LA FIEI" style="display: none;">
                <input type="text" id="nro_tramite" value="Solicitud de Carta Presentación" style="display: none;">
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
                <input type="text" id="fundamentacion" value="SOLICITO CARTA DE PRESENTACIÓN" style="display: none;">
                <input type="text" id="doc1" value="FUT" style="display: none;">
                <input type="text" id="doc2" value="Record Academico" style="display: none;">
                <input type="text" id="doc3" value="Ficha de matricula (9no ciclo)" style="display: none;">
                <input type="text" id="doc4" value="Ficha de datos de la empresa" style="display: none;">
                <input type="text" id="doc5" value="Comprobante de pago" style="display: none;">
                <input type="text" id="folios" value="" style="display: none;">
                <!-- DATOS PARA LLENAR EL FUT-->
                <div class="container2">
                    <h2>Primer Requisito: FORMULARIO ÚNICO DE TRÁMITE</h2>
                    <div class="form-group">
                        <label for="nombreDocumento">Nombre del Documento:</label>
                        <input type="text" id="nombreDocumento" value="FUT" readonly>
                    </div>
                    <div class="form-group">
                        <label for="fechaRegistro">Fecha de Registro (Hoy):</label>
                        <input type="date" name="fechaRegistro" id="fechaRegistro" class="date-picker">
                    </div>
                    <div class="form-group">
                            <label for="firma">Subir firma:</label>
                            <input type="file" name="firma" id="firma" accept="image/*" onchange="previewImage(event)" required>
                            <div id="imagePreviewContainer">  
                                <img id="imagePreview" src="" alt="Vista previa" style="display: none; max-width:400px; max-height: 300px;"/>  
                            </div>
                        </div>
                    <div class="form-group">
                        <label for="archivo1">Archivo:</label>
                        <div class="buttons">
                            <button id="pre" type="button" class="btn-small" style="background-color: red;">Cargar Información en el FUT</button>
                        </div>
                    </div>
                    <div id="preview-container">
                        <iframe id="pdf-preview" width="100%" height="430px" style="border: 1px solid black;"></iframe>
                    </div>
                </div>
                <div class="container2">
                    <h2>Segundo Requisito: RECORD ACADÉMICO</h2>
                    <div class="form-group">
                        <label for="nombreRecord">Nombre:</label>
                        <input type="text" id="nombreRecord" value="Record Académico de Notas" readonly>
                    </div>
                    <div class="form-group">
                        <label for="fechaRecord">Fecha de Record de Notas de OCRAC:</label>
                        <input type="date" name="fechaRecord" id="fechaRecord" class="date-picker" required>
                    </div>
                    <div class="form-group">
                        <label for="archivo2">Archivo:</label>
                        <input accept="aplication/pdf" id="archivo2" type="file" value="enviar record">
                    </div>
                  
                </div>

                <div class="container2">
                    <h2>Tercer Requisito: FICHA DE MATRÍCULA</h2>
                    <div class="form-group">
                        <label for="nombreFicha">Nombre:</label>
                        <input type="text" id="nombreFicha" value="Ficha de Matrícula" readonly>
                    </div>
                    <div class="form-group">
                        <label for="archivo3">Archivo:</label>
                        <input accept="aplication/pdf" id="archivo3" type="file" value="enviar ficha">
                    </div>
                    
                </div>


    <!-- DATOS DE LA EMPRESA    ---------------------------->              
      <form id="empresaForm" method="POST" enctype="multipart/form-data">
    <div class="container2">
        <h2>Cuarto Requisito: DATOS DE LA EMPRESA</h2>
        <div class="form-group">
            <label for="nombreEmpresa">Nombre:</label>
            <input type="text" id="nombreEmpresa" name="nombre_empresa" placeholder="Nombre de la empresa" required>
        </div>
        <div class="form-group">
            <label for="rucEmpresa">RUC:</label>
            <input type="text" id="rucEmpresa" name="ruc_empresa" placeholder="RUC de la empresa" required>
        </div>
        <div class="form-group">
            <label for="celularRepresentante">Celular del Representante:</label>
            <input type="text" id="celularRepresentante" name="celular_repre" placeholder="Celular del representante" required>
        </div>
        <div class="form-group">
            <label for="emailRepresentante">Email del Representante:</label>
            <input type="email" id="emailRepresentante" name="email_repre" placeholder="Email del representante" required>
        </div>
        <div class="form-group">
            <label for="provinciaEmpresa">Provincia:</label>
            <input type="text" id="provinciaEmpresa" name="provincia_empre" placeholder="Provincia" required>
        </div>
        <div class="form-group">
            <label for="departamentoRepresentante">Departamento:</label>
            <input type="text" id="departamentoRepresentante" name="departamento_empre" placeholder="Departamento" required>
        </div>
        <div class="form-group">
            <label for="DistritoEmpresa">Distrito:</label>
            <input type="text" id="DistritoEmpresa" name="distrito_empre" placeholder="Distrito" required>
        </div>

        <h3>DATOS DEL REPRESENTANTE DE LA EMPRESA</h3>
        <div class="form-group">
            <label for="nombreRepresentante">Nombre del Representante:</label>
            <input type="text" id="nombreRepresentante" name="representante" placeholder="Nombre del representante" required>
        </div>
        <div class="form-group">
            <label for="dniRepresentante">DNI del Representante:</label>
            <input type="text" id="dniRepresentante" name="dni_repre" placeholder="DNI del representante" required>
        </div>
        <div class="form-group">
            <label for="direccionRepresentante">Dirección del Representante:</label>
            <input type="text" id="direccionRepresentante" name="direccion_empre" placeholder="Dirección del representante" required>
        </div>
       
        <div class="form-group">
            <div class="buttons">
                <button type="submit" class="btn-small">Guardar</button>
                <button id="ModificarDoc" type="button " class="btn-small">Modificar</button>
                <button id="Previsualizacion" type="button" class="btn-small">Previsualizar</button>
            </div>
            
        </div>
        <div id="preview-container">
                        <iframe id="pdf-preview2" width="100%" height="430px" style="border: 1px solid black;"></iframe>
                    </div>
           </div>
          </form>
              <!---------------------------------  -------------------------------------------->              


                <div class="container2">
                    <h2>Quinto Requisito: COMPROBANTE DE PAGO</h2>
                    <div class="form-group">
                        <label for="nombreComprobante">Nombre:</label>
                        <input type="text" id="nombreComprobante" value="Comprobante de Pago" readonly>
                    </div>
                    <div class="form-group">
                        <label for="numLiquidacion">Número de Liquidación:</label>
                        <input type="text" name="numLiquidacion" id="numLiquidacion" placeholder="Ingrese el número de liquidación" required>
                    </div>
                    <div class="form-group">
                        <label for="archivo4">Archivo:</label>
                        <input accept="aplication/pdf" id="archivo4" type="file" value="enviar comprobante">

                        <div class="buttons">

                            <button type="button" class="btn-small">Eliminar</button>
                        </div>
                    </div>
                   
                </div>

                <div class="container2">
                    <h2>DOCUMENTO</h2>
                    <div class="form-group">

                        <p>Realice la solicitud por esta página: <a href="https://tramite.unfv.edu.pe/Solicitud_Tramite/" target="_blank">https://tramite.unfv.edu.pe/Solicitud_Tramite/</a></p>
                        <div class="form-group">
                    <div class="buttons">
                        <button id="DocFinal" type="button" class="btn-small">Descargar Documento</button>
                </div>

                    </div>
                </div>
            </div>
            <div class="form-buttons">
                <button onclick="closeProfileForm()" class="close-btn"> Cerrar</button>
            </div>
            <br>
            
        </main>
        <div id="complete" class="container2" style="<?php echo $mostrarDiv === '3' ? 'display:block;' : 'display:none;'; ?>">
                <h2>Proceso ya completado</h2>
                <p>Realice la solicitud por esta página: <a href="https://tramite.unfv.edu.pe/Solicitud_Tramite/" target="_blank">https://tramite.unfv.edu.pe/Solicitud_Tramite/</a></p>
                <div class="form-buttons">
                    <button onclick="closeProfileForm()" class="close-btn">
                        Cerrar
                    </button>
                </div>
            </div>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>
</html>
