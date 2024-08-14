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
                <div class="ficha-evaluacion">
                    <h2>Ficha de evaluación del coordinador_FIEI Práctica PRE PROFESIONAL Y PROFESIONAL</h2>
                    
                        <div class="campo">
                            <label>Estudiante:</label>
                            <input id="estudiante" type="text" value="<?php echo $nombre_alumno_completo; ?>" disabled>
                        </div>
                        <div class="campo">
                            <label>Escuela Profesional:</label>
                            <input id="escuela" type="text" value="<?php echo $escuela; ?>" disabled>
                        </div>
                        <div class="campo">
                            <label>Empresa:</label>
                            <input id="empresa" type="text" value="<?php echo $nombre_empresa; ?>" disabled>
                        </div>
                        <div class="campo">
                            <label>Coordinador:</label>
                            <input id="coordinador" type="text" value="<?php echo $nombre_docente_completo; ?>" disabled>
                        </div>
                        <div class="campo">
                            <label>Fecha:</label>
                            <input name="fechaRegistro" id="fechaRegistro" type="date" class="date-picker">
                        </div>
                    
                    <div class="criterios-evaluacion">
                        <h3>CRITERIOS DE EVALUACIÓN</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>NIVEL</th>
                                    <th>SIGNIFICADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>5</td>
                                    <td>Muy bueno - Desempeño notable, cumplimiento extraordinario de requerimientos</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Bueno - Buen desempeño, cumplimiento de requerimientos</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Regular - Ni bueno, Ni malo, cumplimiento parcial de los requerimientos</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Malo - Pobre y/o incompleto. No se enfoca en el problema</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>No aplica - No aplica</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="diseno-ingenieria">
                        <h3>1. Diseño en Ingeniería</h3>
                        <p>Diseña sistemas y procesos de su especialidad para obtener bienes o servicios que satisfacen requerimientos, así como restricciones económicas, legales, sociales y de sostenibilidad.</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Criterio</th>
                                    <th>5</th>
                                    <th>4</th>
                                    <th>3</th>
                                    <th>2</th>
                                    <th>1</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Interpreta requerimientos y necesidades y los traduce a un proyecto de su especialidad.</td>
                                    <td><label><input type="radio" name="criterio1" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio1" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio1" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio1" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio1" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Formula las especificaciones de un proyecto considerando las variables de orden técnico y las restricciones del contexto económico, legal, social y ambiental.</td>
                                    <td><label><input type="radio" name="criterio2" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio2" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio2" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio2" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio2" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Propone y evalúa alternativas y tecnologías de solución y selecciona la más apropiada, haciendo uso de las normas y estándares vigentes.</td>
                                    <td><label><input type="radio" name="criterio3" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio3" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio3" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio3" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio3" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Presenta y describe la solución en forma gráfica mediante planos, mapas, diagramas y especificaciones.</td>
                                    <td><label><input type="radio" name="criterio4" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio4" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio4" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio4" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio4" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Propone el proceso de implementación de la alternativa seleccionada usando normas y estándares apropiados.</td>
                                    <td><label><input type="radio" name="criterio5" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio5" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio5" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio5" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio5" value="1"></label></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="criterios-evaluacion">
                        <h3>2. Solución de problemas de Ingeniería</h3>
                        <p>Identifica, diagnostica, formula y resuelve problemas usando las técnicas, métodos, herramientas y normas en el dominio de la ingeniería.</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Criterio</th>
                                    <th>5</th>
                                    <th>4</th>
                                    <th>3</th>
                                    <th>2</th>
                                    <th>1</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Formula soluciones apropiadas y realizables usando normas y estándares vigentes.</td>
                                    <td><label><input type="radio" name="criterio6" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio6" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio6" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio6" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio6" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Utiliza las técnicas y metodologías de la ingeniería de su especialidad para describir, analizar y resolver los problemas.</td>
                                    <td><label><input type="radio" name="criterio7" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio7" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio7" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio7" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio7" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Maneja equipos e instrumentos y utiliza software especializado propio del ejercicio profesional.</td>
                                    <td><label><input type="radio" name="criterio8" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio8" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio8" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio8" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio8" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Modela y simula sistemas y procesos para evaluar y optimizar su comportamiento y predecir sus resultados.</td>
                                    <td><label><input type="radio" name="criterio9" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio9" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio9" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio9" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio9" value="1"></label></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="criterios-evaluacion">
                        <h3>3. Aplicación de las ciencias</h3>
                        <p>Aplica los conocimientos y habilidades en matemáticas, ciencias e ingeniería para la solución de problemas de ingeniería de su especialidad.</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Criterio</th>
                                    <th>5</th>
                                    <th>4</th>
                                    <th>3</th>
                                    <th>2</th>
                                    <th>1</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Identifica las variables relevantes de un sistema, define sus métricas y establece sus relaciones de dependencia.</td>
                                    <td><label><input type="radio" name="criterio10" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio10" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio10" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio10" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio10" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Aplica modelos matemáticos para analizar, simular y predecir el comportamiento de procesos y sistemas de producción y gestión.</td>
                                    <td><label><input type="radio" name="criterio11" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio11" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio11" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio11" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio11" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Aplica el conocimiento de matemáticas, ciencias e ingeniería a la solución de problemas.</td>
                                    <td><label><input type="radio" name="criterio12" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio12" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio12" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio12" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio12" value="1"></label></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="criterios-evaluacion">
                        <h3>4. Gestión de Proyectos</h3>
                        <p>Planifica y gestiona proyectos de ingeniería de su especialidad con criterios de calidad, eficiencia, productividad y rentabilidad.</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Criterio</th>
                                    <th>5</th>
                                    <th>4</th>
                                    <th>3</th>
                                    <th>2</th>
                                    <th>1</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Formula los objetivos y restricciones de un proyecto y plantea las estrategias para su logro.</td>
                                    <td><label><input type="radio" name="criterio13" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio13" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio13" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio13" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio13" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Aplica sistemas de costeo apropiados y calcula la rentabilidad del proyecto.</td>
                                    <td><label><input type="radio" name="criterio14" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio14" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio14" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio14" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio14" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Determina los alcances del proyecto, sus actividades y prioridades y formula cronogramas de ejecución.</td>
                                    <td><label><input type="radio" name="criterio15" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio15" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio15" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio15" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio15" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Identifica y planifica el aprovechamiento de los recursos humanos, materiales, tecnológicos y económicos para el desarrollo del proyecto.</td>
                                    <td><label><input type="radio" name="criterio16" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio16" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio16" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio16" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio16" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Determina la factibilidad técnica y económica de un proyecto de ingeniería, así como su viabilidad social y ambiental.</td>
                                    <td><label><input type="radio" name="criterio17" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio17" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio17" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio17" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio17" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Plantea los indicadores para supervisar el correcto desarrollo de los procesos involucrados, considerando aspectos de calidad, productividad, efectividad y seguridad.</td>
                                    <td><label><input type="radio" name="criterio18" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio18" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio18" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio18" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio18" value="1"></label></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="criterios-evaluacion">
                        <h3>5. Práctica de la ingeniería moderna</h3>
                        <p>Usa las herramientas y técnicas modernas de la ingeniería necesarias para la práctica profesional de la ingeniería a la que pertenece.</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Criterio</th>
                                    <th>5</th>
                                    <th>4</th>
                                    <th>3</th>
                                    <th>2</th>
                                    <th>1</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Usa software moderno y especializado propios del ejercicio profesional.</td>
                                    <td><label><input type="radio" name="criterio19" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio19" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio19" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio19" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio19" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Aplica metodologías modernas en el análisis, diseño, implementación y gestión de sistemas y procesos.</td>
                                    <td><label><input type="radio" name="criterio20" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio20" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio20" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio20" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio20" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Maneja herramientas y tecnologías modernas para la automatización y gestión de procesos.</td>
                                    <td><label><input type="radio" name="criterio21" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio21" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio21" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio21" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio21" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Aplica técnicas y métodos modernos satisfaciendo normas y estándares nacionales e internacionales, así como buenas prácticas y lecciones aprendidas.</td>
                                    <td><label><input type="radio" name="criterio22" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio22" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio22" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio22" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio22" value="1"></label></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="criterios-evaluacion">
                        <h3>6. Conciencia ambiental y responsabilidad social</h3>
                        <p>Considera la importancia de la preservación y mejora del medio ambiente en el desarrollo de sus actividades profesionales.</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Criterio</th>
                                    <th>5</th>
                                    <th>4</th>
                                    <th>3</th>
                                    <th>2</th>
                                    <th>1</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Identifica y prioriza el uso de materiales, tecnologías, procesos y servicios amigables con el medio ambiente.</td>
                                    <td><label><input type="radio" name="criterio27" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio27" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio27" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio27" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio27" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Hace un uso racional de los recursos naturales y tecnológicos reconociendo su importancia en la vida de las personas.</td>
                                    <td><label><input type="radio" name="criterio28" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio28" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio28" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio28" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio28" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Participa en actividades y campañas de conservación del medio ambiente y sus ecosistemas.</td>
                                    <td><label><input type="radio" name="criterio29" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio29" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio29" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio29" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio29" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Practica y difunde el desarrollo sostenible en sus actividades profesionales y aplica normas de gestión ambiental.</td>
                                    <td><label><input type="radio" name="criterio30" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio30" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio30" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio30" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio30" value="1"></label></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="criterios-evaluacion">
                        <h3>7. Aprendizaje continuo</h3>
                        <p>Reconoce la importancia y se compromete con un aprendizaje continuo para permanecer vigente y actualizado en su campo de desarrollo profesional.</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Criterio</th>
                                    <th>5</th>
                                    <th>4</th>
                                    <th>3</th>
                                    <th>2</th>
                                    <th>1</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Identifica las áreas de conocimientos relevantes para su desarrollo profesional.</td>
                                    <td><label><input type="radio" name="criterio31" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio31" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio31" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio31" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio31" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Se actualiza sobre las nuevas tendencias y tecnologías aplicables a la ingeniería a la que pertenece y sus diversas aplicaciones.</td>
                                    <td><label><input type="radio" name="criterio32" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio32" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio32" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio32" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio32" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Muestra autonomía en su proceso de aprendizaje.</td>
                                    <td><label><input type="radio" name="criterio33" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio33" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio33" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio33" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio33" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Forma parte de grupos de investigación y de ramas estudiantiles de sociedades profesionales.</td>
                                    <td><label><input type="radio" name="criterio34" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio34" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio34" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio34" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio34" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Asiste y participa en eventos de desarrollo personal y profesional.</td>
                                    <td><label><input type="radio" name="criterio35" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio35" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio35" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio35" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio35" value="1"></label></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="criterios-evaluacion">
                        <h3>8. Responsabilidad ética y profesional</h3>
                        <p>Evalúa sus decisiones y acciones desde una perspectiva ética y asume responsabilidad por los trabajos y proyectos realizados.</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Criterio</th>
                                    <th>5</th>
                                    <th>4</th>
                                    <th>3</th>
                                    <th>2</th>
                                    <th>1</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Anticipa las implicancias de sus decisiones, así como los resultados de sus acciones.</td>
                                    <td><label><input type="radio" name="criterio36" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio36" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio36" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio36" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio36" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Valora el cumplimiento puntual y responsable de sus actividades personales y profesionales.</td>
                                    <td><label><input type="radio" name="criterio37" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio37" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio37" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio37" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio37" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Prioriza el interés común y el beneficio social.</td>
                                    <td><label><input type="radio" name="criterio38" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio38" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio38" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio38" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio38" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Respeta la propiedad intelectual.</td>
                                    <td><label><input type="radio" name="criterio39" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio39" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio39" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio39" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio39" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Conoce y actúa de acuerdo al código deontológico del Colegio de Ingenieros del Perú.</td>
                                    <td><label><input type="radio" name="criterio40" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio40" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio40" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio40" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio40" value="1"></label></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="criterios-evaluacion">
                        <h3>9. Comunicación</h3>
                        <p>Se comunica de manera clara y convincente en forma oral, escrita y gráfica según los diferentes tipos de interlocutores o audiencias.</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Criterio</th>
                                    <th>5</th>
                                    <th>4</th>
                                    <th>3</th>
                                    <th>2</th>
                                    <th>1</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Se expresa con claridad y de manera concisa usando el soporte tecnológico adecuado</td>
                                    <td><label><input type="radio" name="criterio41" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio41" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio41" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio41" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio41" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Elabora documentación técnica clara y precisa usando normas, simbología y terminología propias de la ingeniería de su especialidad.</td>
                                    <td><label><input type="radio" name="criterio42" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio42" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio42" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio42" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio42" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Adecúa su discurso según el tipo de audiencia para lograr un buen entendimiento</td>
                                    <td><label><input type="radio" name="criterio43" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio43" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio43" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio43" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio43" value="1"></label></td>
                                </tr>
                                <tr>
                                    <td>Comprende textos técnicos en inglés y practica conversación básica en inglés.</td>
                                    <td><label><input type="radio" name="criterio44" value="5"></label></td>
                                    <td><label><input type="radio" name="criterio44" value="4"></label></td>
                                    <td><label><input type="radio" name="criterio44" value="3"></label></td>
                                    <td><label><input type="radio" name="criterio44" value="2"></label></td>
                                    <td><label><input type="radio" name="criterio44" value="1"></label></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="criterios-evaluacion">
                        <h3>10. Trabajo en equipo e inteligencia emocional</h3>
                        <p>Reconoce la importancia del trabajo grupal y se integra y participa en forma efectiva en equipos multidisciplinarios de trabajo.</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Criterio</th>
                                    <th>5</th>
                                    <th>4</th>
                                    <th>3</th>
                                    <th>2</th>
                                    <th>1</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Se desempeña como líder o miembro activo de un equipo de trabajo aportando con iniciativa para alcanzar las metas propuestas.</td>
                                    <td><input type="radio" name="criterio45" value="5"></td>
                                    <td><input type="radio" name="criterio45" value="4"></td>
                                    <td><input type="radio" name="criterio45" value="3"></td>
                                    <td><input type="radio" name="criterio45" value="2"></td>
                                    <td><input type="radio" name="criterio45" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Propone y acepta ideas que conduzcan al alcance de los objetivos.</td>
                                    <td><input type="radio" name="criterio46" value="5"></td>
                                    <td><input type="radio" name="criterio46" value="4"></td>
                                    <td><input type="radio" name="criterio46" value="3"></td>
                                    <td><input type="radio" name="criterio46" value="2"></td>
                                    <td><input type="radio" name="criterio46" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Valora las diferencias y respeta los acuerdos.</td>
                                    <td><input type="radio" name="criterio47" value="5"></td>
                                    <td><input type="radio" name="criterio47" value="4"></td>
                                    <td><input type="radio" name="criterio47" value="3"></td>
                                    <td><input type="radio" name="criterio47" value="2"></td>
                                    <td><input type="radio" name="criterio47" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Escucha empáticamente, negocia conflictos y usa inteligencia emocional.</td>
                                    <td><input type="radio" name="criterio48" value="5"></td>
                                    <td><input type="radio" name="criterio48" value="4"></td>
                                    <td><input type="radio" name="criterio48" value="3"></td>
                                    <td><input type="radio" name="criterio48" value="2"></td>
                                    <td><input type="radio" name="criterio48" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Promueve el debate, concierta y busca consensos.</td>
                                    <td><input type="radio" name="criterio49" value="5"></td>
                                    <td><input type="radio" name="criterio49" value="4"></td>
                                    <td><input type="radio" name="criterio49" value="3"></td>
                                    <td><input type="radio" name="criterio49" value="2"></td>
                                    <td><input type="radio" name="criterio49" value="1"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="criterios-evaluacion">
                        <h3>11. Sobre el informe presentado</h3>
                        <p>Desarrolla su informe de acuerdo a lo solicitado, con las condiciones de un trabajo real en el cual el practicante ha participado en la empresa.</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Criterio</th>
                                    <th>5</th>
                                    <th>4</th>
                                    <th>3</th>
                                    <th>2</th>
                                    <th>1</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tiene un procedimiento que puede ser seguido sin tener que hacerles consultas o aclaraciones.</td>
                                    <td><input type="radio" name="criterio50" value="5"></td>
                                    <td><input type="radio" name="criterio50" value="4"></td>
                                    <td><input type="radio" name="criterio50" value="3"></td>
                                    <td><input type="radio" name="criterio50" value="2"></td>
                                    <td><input type="radio" name="criterio50" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Se encuentra fácilmente la información que da fundamento a sus afirmaciones.</td>
                                    <td><input type="radio" name="criterio51" value="5"></td>
                                    <td><input type="radio" name="criterio51" value="4"></td>
                                    <td><input type="radio" name="criterio51" value="3"></td>
                                    <td><input type="radio" name="criterio51" value="2"></td>
                                    <td><input type="radio" name="criterio51" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Demuestra poder creativo para adaptar la metodología que debe aplicar en las condiciones reales que se presenta.</td>
                                    <td><input type="radio" name="criterio52" value="5"></td>
                                    <td><input type="radio" name="criterio52" value="4"></td>
                                    <td><input type="radio" name="criterio52" value="3"></td>
                                    <td><input type="radio" name="criterio52" value="2"></td>
                                    <td><input type="radio" name="criterio52" value="1"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="criterios-evaluacion">
                        <h3>12. Sobre la sustentación de su informe</h3>
                        <p>El informe presentado, deberá sustentarlo sobre la metodología empleada y obtención de la información</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Criterio</th>
                                    <th>5</th>
                                    <th>4</th>
                                    <th>3</th>
                                    <th>2</th>
                                    <th>1</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Puede sostener con fundamento la metodología que ha empleado.</td>
                                    <td><input type="radio" name="criterio53" value="5"></td>
                                    <td><input type="radio" name="criterio53" value="4"></td>
                                    <td><input type="radio" name="criterio53" value="3"></td>
                                    <td><input type="radio" name="criterio53" value="2"></td>
                                    <td><input type="radio" name="criterio53" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Puede sostener con fundamento la información que ha obtenido.</td>
                                    <td><input type="radio" name="criterio54" value="5"></td>
                                    <td><input type="radio" name="criterio54" value="4"></td>
                                    <td><input type="radio" name="criterio54" value="3"></td>
                                    <td><input type="radio" name="criterio54" value="2"></td>
                                    <td><input type="radio" name="criterio54" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Puede sostener con fundamento las Conclusiones.</td>
                                    <td><input type="radio" name="criterio55" value="5"></td>
                                    <td><input type="radio" name="criterio55" value="4"></td>
                                    <td><input type="radio" name="criterio55" value="3"></td>
                                    <td><input type="radio" name="criterio55" value="2"></td>
                                    <td><input type="radio" name="criterio55" value="1"></td>
                                </tr>
                                <tr>
                                    <td>Puede sostener con fundamento las Recomendaciones.</td>
                                    <td><input type="radio" name="criterio56" value="5"></td>
                                    <td><input type="radio" name="criterio56" value="4"></td>
                                    <td><input type="radio" name="criterio56" value="3"></td>
                                    <td><input type="radio" name="criterio56" value="2"></td>
                                    <td><input type="radio" name="criterio56" value="1"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="criterios-evaluacion">
                        <h3>13. Calificación</h3>
                        <p>Para la obtención de las notas de Prácticas Pre Profesionales se tiene:</p>
                        <div style="text-align: center; margin: 20px 0;">
                            <strong>PROMEDIO = (T + E + A) / 3</strong>
                        </div>
                        <p><strong>T</strong> = Nota de Evaluación de los Informes</p>
                        <p><strong>E</strong> = Nota de Examen</p>
                        <p><strong>A</strong> = Nota de Apreciación Docente (Supervisor) Criterio del profesor sobre la puntualidad, cumplimiento y desenvolvimiento del (la) practicante.</p>
                    </div>

                    <div class="criterios-evaluacion">
                        <h3>Calificación y Envío de Evaluación</h3>
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
                            <div class="campo">
                                <label>Adjuntar Firma:</label>
                                <input type="file" accept="image/*" id="firma" name="firma" required>
                            </div>
                            <div class="campo">
                                <p>*Suba los datos al PDF antes de enviar</p>
                            </div>
                            <div class="campo">
                                <button id="subir" type="button" class="btn-small" style="background-color: red;">Subir datos al PDF</button>
                                <button type="button" class="btn-small">Enviar evaluación</button>
                            </div>
                            <div id="preview-container">
                                <iframe id="pdf-preview" width="100%" height="430px" style="border: 1px solid black;"></iframe>
                            </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes4.js"></script>
</body>
</html>
