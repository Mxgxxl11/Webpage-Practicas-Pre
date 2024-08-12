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
    <link rel="stylesheet" href="assets/css/menu_tramites.css">
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <?php include './includes/sidebar.php'; ?>
        <main class="main-content">
            <div class="responsive">
                <div class="gallery">
                    <img src="https://cdn-icons-png.flaticon.com/512/4706/4706330.png" alt="carta_presentacion">
                    <div class="desc">
                        <div class="ambos">
                            <p class="texto_izquierdo" id="text3"><strong>CARTA DE PRESENTACIÓN</strong></p>
                        </div>
                        <p class="texto_derecho" id="text2"><strong><?php echo $mostrarDiv >= '3' ? 'Completo' : 'Incompleto'; ?></strong></p>
                        <p class="texto_izquierdo" id="text1"><strong>Requisitos:</strong></p>
                        <p class="texto_izquierdo" id="text4">- Formulario FUT</p>
                        <p class="texto_izquierdo" id="text4">- Record Acádemico</p>
                        <p class="texto_izquierdo" id="text4">- Ficha de matricula 9 ciclo</p>
                        <p class="texto_izquierdo" id="text4">- Ficha de datos de la empresa</p>
                        <p class="texto_izquierdo" id="text4">- Comprobante de pago</p>
                        <button onclick="iniciar_cp()">Iniciar</button>
                    </div>
                </div>
            </div>
            <div class="responsive">
                <div class="gallery">
                    <img src="https://cdn-icons-png.freepik.com/512/9746/9746449.png" alt="apertura_carpeta">
                    <div class="desc">
                        <div class="ambos">
                            <p class="texto_izquierdo" id="text3"><strong>APERTURA DE CARPETA</strong></p>
                        </div>
                        <p class="texto_derecho" id="text2"><strong><?php echo $mostrarDiv >= '4' ? 'Completo' : 'Incompleto'; ?></strong></p>
                        <p class="texto_izquierdo" id="text1"><strong>Requisitos:</strong></p>
                        <p class="texto_izquierdo" id="text4">- Formulario FUT</p>
                        <p class="texto_izquierdo" id="text4">- Record Acádemico Actualizado</p>
                        <p class="texto_izquierdo" id="text4">- Carta de presentación recepcionada por la empresa</p>
                        <p class="texto_izquierdo" id="text4">- Carta de aceptación de la empresa</p>
                        <p class="texto_izquierdo" id="text4">- Ficha de inscripción</p>
                        <button onclick="apertura_carpeta()">Iniciar</button>
                    </div>
                </div>
            </div>

            <div class="responsive">
                <div class="gallery">
                    <img src="https://img.freepik.com/vector-premium/icono-carpeta-archivo-almacenamiento-datos-color-documentos-computadora_53562-18585.jpg" alt="informes">
                    <div class="desc">
                        <div class="ambos">
                            <p class="texto_izquierdo" id="text3"><strong>INFORMES</strong></p>
                        </div>
                        <p class="texto_derecho" id="text2"><strong><?php echo $mostrarDiv >= '9' ? 'Completo' : 'Incompleto'; ?></strong></p>
                        <p class="texto_izquierdo" id="text1"><strong>Documentos:</strong></p>
                        <p class="texto_izquierdo" id="text4">- Primer Informe (30 dias)</p>
                        <p class="texto_izquierdo" id="text4">- Segundo Informe (60 dias)</p>
                        <p class="texto_izquierdo" id="text4">- Tercer Informe (90 dias)</p>
                        <p class="texto_izquierdo" id="text4">- Informe Final</p>
                        <button onclick="abrir_informes()">Iniciar</button>
                    </div>
                </div>
            </div>

            <div class="responsive">
                <div class="gallery">
                    <img src="https://cdn-icons-png.flaticon.com/512/4420/4420106.png" alt="constancia">
                    <div class="desc">
                        <div class="ambos">
                            <p class="texto_izquierdo" id="text3"><strong>CONSTANCIA</strong></p>
                        </div>
                        <p class="texto_derecho" id="text2"><strong>Incompleto</strong></p>
                        <p class="texto_izquierdo" id="text1"><strong>Documentos:</strong></p>
                        <p class="texto_izquierdo" id="text4">- Constancia de Practicas Pre Profesionales</p>
                        <button onclick="abrir_constancia()">Iniciar</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>
</html>
