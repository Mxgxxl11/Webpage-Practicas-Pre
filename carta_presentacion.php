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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mesa de partes</title>
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar.php'; ?>
        <main class="main-content">
            <!-- INICIA FORM DE REGISTRO-->
            <div class="profile-form" id="Next-step" style="<?php echo $mostrarDiv === '2' ? 'display:none;' : ''; ?>">
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
                        <div>
                            <label for="firma">Subir firma:</label>
                            <input type="file" name="firma" id="firma" accept="image/*" onchange="previewImage(event)" required>
                            <div id="imagePreviewContainer" style="margin-top: 10px;">  
                                <img id="imagePreview" src="" alt="Vista previa" style="display: none; max-width:400px; max-height: 300px;"/>  
                            </div>
                        </div>
                        <div class="form-buttons">
                            <button type="submit">Siguiente</button>
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
                        <label for="fechaRegistro">Fecha de Registro:</label>
                        <input type="date" id="fechaRegistro" class="date-picker">
                    </div>
                    <div class="form-group">
                        <label for="archivo1">Archivo:</label>
                        <div class="buttons">
                            <button id="pre" type="button" class="btn-small">Previsualizar Documento</button>
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
                        <input type="date" id="fechaRecord" class="date-picker">
                    </div>
                    <div class="form-group">
                        <label for="archivo2">Archivo:</label>
                        <input id="archivo2" type="file" value="enviar record">

                        <div class="buttons">
                            <button type="button" class="btn-small">Eliminar</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descripcionArchivo2">Descripción:</label>
                        <input type="text" id="descripcionArchivo2" placeholder="Adjuntar el archivo en formato pdf">
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
                        <input id="archivo3" type="file" value="enviar ficha">

                        <div class="buttons">
                            <button type="button" class="btn-small">Eliminar</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descripcionArchivo3">Descripción:</label>
                        <input type="text" id="descripcionArchivo3" placeholder="Adjuntar el archivo en formato pdf" readonly>
                    </div>
                </div>

                <div class="container2">
                    <h2>Cuarto Requisito: DATOS DE LA EMPRESA</h2>
                    <div class="form-group">
                        <label for="nombreEmpresa">Nombre:</label>
                        <input type="text" id="nombreEmpresa" placeholder="Nombre de la empresa">
                    </div>
                    <div class="form-group">
                        <label for="rucEmpresa">RUC:</label>
                        <input type="text" id="rucEmpresa" placeholder="RUC de la empresa">
                    </div>
                    <div class="form-group">
                        <label for="celularRepresentante">Celular del Representante:</label>
                        <input type="text" id="celularRepresentante" placeholder="Celular del representante">
                    </div>
                    <div class="form-group">
                        <label for="emailRepresentante">Email del Representante:</label>
                        <input type="email" id="emailRepresentante" placeholder="Email del representante">
                    </div>
                    <div class="form-group">
                        <label for="provincia">Provincia:</label>
                        <select id="provincia">
                            <option value="">Seleccione una provincia</option>
                            <!-- Tocara poner todo  -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="distrito">Distrito:</label>
                        <select id="distrito">
                            <option value="">Seleccione un distrito</option>

                            <option value="ANCON" default>ANCON</option>
                            <option value="ATE">ATE</option>
                            <option value="BARRANCO">BARRANCO</option>
                            <option value="BREÑA">BREÑA</option>
                            <option value="CARABAYLLO">CARABAYLLO</option>
                            <option value="CHACLACAYO">CHACLACAYO</option>
                            <option value="CHORRILLOS">CHORRILLOS</option>
                            <option value="CIENEGUILLA">CIENEGUILLA</option>
                            <option value="COMAS">COMAS</option>
                            <option value="EL AGUSTINO">EL AGUSTINO</option>
                            <option value="INDEPENDENCIA">INDEPENDENCIA</option>
                            <option value="JESUS MARIA">JESUS MARIA</option>
                            <option value="LA MOLINA">LA MOLINA</option>
                            <option value="LA VICTORIA">LA VICTORIA</option>
                            <option value="LIMA">LIMA</option>
                            <option value="LINCE">LINCE</option>
                            <option value="LOS OLIVOS">LOS OLIVOS</option>
                            <option value="LURIGANCHO">LURIGANCHO</option>
                            <option value="LURIN">LURIN</option>
                            <option value="M. del MAR">MAGDALENA DEL MAR</option>
                            <option value="MIRAFLORES">MIRAFLORES</option>
                            <option value="PACHACAMAC">PACHACAMAC</option>
                            <option value="PUCUSANA">PUCUSANA</option>
                            <option value="PUEBLO LIBRE">PUEBLO LIBRE</option>
                            <option value="PUENTE PIEDRA">PUENTE PIEDRA</option>
                            <option value="Punta Hermosa">PUNTA HERMOSA</option>
                            <option value="PUNTA NEGRA">PUNTA NEGRA</option>
                            <option value="RIMAC">RIMAC</option>
                            <option value="SAN BARTOLO">SAN BARTOLO</option>
                            <option value="SAN BORJA">SAN BORJA</option>
                            <option value="SAN ISIDRO">SAN ISIDRO</option>
                            <option value="SJL">SAN JUAN DE LURIGANCHO</option>
                            <option value="SJM">SAN JUAN DE MIRAFLORES</option>
                            <option value="SAN LUIS">SAN LUIS</option>
                            <option value="SMP">SAN MARTIN DE PORRES</option>
                            <option value="SAN MIGUEL">SAN MIGUEL</option>
                            <option value="SANTA ANITA">SANTA ANITA</option>
                            <option value="S.M. del Mar">SANTA MARIA DEL MAR</option>
                            <option value="SANTA ROSA">SANTA ROSA</option>
                            <option value="S. de Surco">SANTIAGO DE SURCO</option>
                            <option value="SURQUILLO">SURQUILLO</option>
                            <option value="VENTANILLA">VENTANILLA</option>
                            <option value="V.E.Salvador">VILLA EL SALVADOR</option>
                            <option value="VMT">VILLA MARIA DEL TRIUNFO</option>
                        </select>
                    </div>

                    <h3>DATOS DEL REPRESENTANTE DE LA EMPRESA</h3>
                    <div class="form-group">
                        <label for="nombreRepresentante">Nombre del Representante:</label>
                        <input type="text" id="nombreRepresentante" placeholder="Nombre del representante">
                    </div>
                    <div class="form-group">
                        <label for="dniRepresentante">DNI del Representante:</label>
                        <input type="text" id="dniRepresentante" placeholder="DNI del representante">
                    </div>
                    <div class="form-group">
                        <label for="direccionRepresentante">Dirección del Representante:</label>
                        <input type="text" id="direccionRepresentante" placeholder="Dirección del representante">
                    </div>
                    <div class="form-group">
                        <label for="departamentoRepresentante">Departamento:</label>
                        <input type="text" id="departamentoRepresentante" placeholder="Departamento">
                    </div>

                    <div class="form-group buttons">
                        <button type="button">Guardar</button>
                        <button type="button">Modificar</button>
                    </div>
                </div>

                <div class="container2">
                    <h2>Quinto Requisito: COMPROBANTE DE PAGO</h2>
                    <div class="form-group">
                        <label for="nombreComprobante">Nombre:</label>
                        <input type="text" id="nombreComprobante" value="Comprobante de Pago" readonly>
                    </div>
                    <div class="form-group">
                        <label for="numeroLiquidacion">Número de Liquidación:</label>
                        <input type="text" id="numeroLiquidacion" placeholder="Ingrese el número de liquidación">
                    </div>
                    <div class="form-group">
                        <label for="archivo4">Archivo:</label>
                        <input id="archivo4" type="file" value="enviar comprobante">

                        <div class="buttons">

                            <button type="button" class="btn-small">Eliminar</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descripcionArchivo4">Descripción:</label>
                        <input type="text" id="descripcionArchivo4" placeholder="Adjuntar el comprobante de pago en formato pdf" readonly>
                    </div>
                </div>

                <div class="container2">
                    <h2>DOCUMENTO</h2>
                    <div class="form-group">

                        <p>Realice la solicitud por esta página: <a href="https://tramite.unfv.edu.pe/Solicitud_Tramite/" target="_blank">https://tramite.unfv.edu.pe/Solicitud_Tramite/</a></p>

                        <div class="buttons">
                            <button type="button">Descargar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-buttons">
                <button onclick="closeProfileForm()" class="close-btn">
                    Cerrar
                </button>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>
