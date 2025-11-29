<?php
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "index.html"; 
    </script>';
}
$mostrarDiv = isset($_SESSION['paso_cp']) ? $_SESSION['paso_cp'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trámites - Prácticas Pre Profesionales</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/modern-theme.css" />
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <style>
        .tramites-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .tramite-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            border: 2px solid transparent;
        }
        
        .tramite-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            border-color: #FFCC00;
        }
        
        .tramite-icon {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 150px;
        }
        
        .tramite-icon img {
            max-width: 100px;
            max-height: 100px;
            object-fit: contain;
        }
        
        .tramite-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .tramite-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            gap: 1rem;
        }
        
        .tramite-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2C3E50;
            margin: 0;
            line-height: 1.3;
        }
        
        .tramite-status {
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.813rem;
            font-weight: 600;
            white-space: nowrap;
        }
        
        .status-completo {
            background: #d4edda;
            color: #155724;
        }
        
        .status-incompleto {
            background: #f8d7da;
            color: #721c24;
        }
        
        .tramite-requisitos {
            margin-top: 1rem;
            flex-grow: 1;
        }
        
        .requisitos-title {
            font-weight: 600;
            color: #2C3E50;
            font-size: 0.938rem;
            margin-bottom: 0.75rem;
        }
        
        .requisito-item {
            font-size: 0.875rem;
            color: #6c757d;
            margin: 0.5rem 0;
            padding-left: 1.25rem;
            position: relative;
        }
        
        .requisito-item::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #FFCC00;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        .tramite-button {
            margin-top: 1.5rem;
            width: 100%;
        }
        
        @media (max-width: 768px) {
            .tramites-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container" style="display: block;">
        <main class="main-content" style="max-width: 1400px; margin: 0 auto;">
            
            <div class="tramites-grid">
                <!-- Carta de Presentación -->
                <div class="tramite-card">
                    <div class="tramite-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/4706/4706330.png" alt="Carta de presentación">
                    </div>
                    <div class="tramite-content">
                        <div class="tramite-header">
                            <h3 class="tramite-title">1. CARTA DE PRESENTACIÓN</h3>
                            <span class="tramite-status <?php echo $mostrarDiv >= '3' ? 'status-completo' : 'status-incompleto'; ?>">
                                <?php echo $mostrarDiv >= '3' ? '✓ Completo' : '○ Incompleto'; ?>
                            </span>
                        </div>
                        
                        <div class="tramite-requisitos">
                            <p class="requisitos-title">Requisitos:</p>
                            <p class="requisito-item">Formulario FUT</p>
                            <p class="requisito-item">Record Académico</p>
                            <p class="requisito-item">Ficha de matrícula 9° ciclo</p>
                            <p class="requisito-item">Ficha de datos de la empresa</p>
                            <p class="requisito-item">Comprobante de pago</p>
                        </div>
                        
                        <button onclick="iniciar_cp()" class="btn btn-primary tramite-button">
                            🚀 Iniciar Trámite
                        </button>
                    </div>
                </div>

                <!-- Apertura de Carpeta -->
                <div class="tramite-card">
                    <div class="tramite-icon">
                        <img src="https://cdn-icons-png.freepik.com/512/9746/9746449.png" alt="Apertura de carpeta">
                    </div>
                    <div class="tramite-content">
                        <div class="tramite-header">
                            <h3 class="tramite-title">2. APERTURA DE CARPETA</h3>
                            <span class="tramite-status <?php echo $mostrarDiv >= '5' ? 'status-completo' : 'status-incompleto'; ?>">
                                <?php echo $mostrarDiv >= '5' ? '✓ Completo' : '○ Incompleto'; ?>
                            </span>
                        </div>
                        
                        <div class="tramite-requisitos">
                            <p class="requisitos-title">Requisitos:</p>
                            <p class="requisito-item">Formulario FUT</p>
                            <p class="requisito-item">Record Académico Actualizado</p>
                            <p class="requisito-item">Carta de presentación recepcionada</p>
                            <p class="requisito-item">Carta de aceptación de la empresa</p>
                            <p class="requisito-item">Ficha de inscripción</p>
                        </div>
                        
                        <button onclick="apertura_carpeta()" class="btn btn-primary tramite-button">
                            🚀 Iniciar Trámite
                        </button>
                    </div>
                </div>

                <!-- Informes -->
                <div class="tramite-card">
                    <div class="tramite-icon">
                        <img src="https://img.freepik.com/vector-premium/icono-carpeta-archivo-almacenamiento-datos-color-documentos-computadora_53562-18585.jpg" alt="Informes">
                    </div>
                    <div class="tramite-content">
                        <div class="tramite-header">
                            <h3 class="tramite-title">3. INFORMES</h3>
                            <span class="tramite-status <?php echo $mostrarDiv >= '10' ? 'status-completo' : 'status-incompleto'; ?>">
                                <?php echo $mostrarDiv >= '10' ? '✓ Completo' : '○ Incompleto'; ?>
                            </span>
                        </div>
                        
                        <div class="tramite-requisitos">
                            <p class="requisitos-title">Documentos:</p>
                            <p class="requisito-item">Primer Informe (30 días)</p>
                            <p class="requisito-item">Segundo Informe (60 días)</p>
                            <p class="requisito-item">Tercer Informe (90 días)</p>
                            <p class="requisito-item">Informe Final</p>
                        </div>
                        
                        <button onclick="abrir_informes()" class="btn btn-primary tramite-button">
                            🚀 Iniciar Trámite
                        </button>
                    </div>
                </div>

                <!-- Evaluación Final -->
                <div class="tramite-card">
                    <div class="tramite-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/4420/4420106.png" alt="Evaluación final">
                    </div>
                    <div class="tramite-content">
                        <div class="tramite-header">
                            <h3 class="tramite-title">4. EVALUACIÓN FINAL</h3>
                            <span class="tramite-status <?php echo $mostrarDiv >= '15' ? 'status-completo' : 'status-incompleto'; ?>">
                                <?php echo $mostrarDiv >= '15' ? '✓ Completo' : '○ Incompleto'; ?>
                            </span>
                        </div>
                        
                        <div class="tramite-requisitos">
                            <p class="requisitos-title">Documentos:</p>
                            <p class="requisito-item">Examen final resuelto</p>
                        </div>
                        
                        <button onclick="abrir_evaluacion()" class="btn btn-primary tramite-button">
                            🚀 Iniciar Trámite
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>
</html>
