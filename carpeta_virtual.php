<?php
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "index.html"; 
    </script>';
}
//este archivo pertenece al portal ADMIN
//para que los registros de los alumnos salgan en las tablas de cada escuela
//los alumnos deben haber llenado previamente el form que les sale antes 
//de iniciar el tramite de carta de presentacion

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Carpetas Virtuales - Administración</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/modern-theme.css" />
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <style>
        .carpetas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .carpeta-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            border: 2px solid transparent;
        }
        
        .carpeta-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            border-color: #FFCC00;
        }
        
        .carpeta-icon {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 150px;
        }
        
        .carpeta-icon img {
            max-width: 100px;
            max-height: 100px;
            object-fit: contain;
        }
        
        .carpeta-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .carpeta-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2C3E50;
            margin: 0 0 1rem 0;
            text-align: center;
        }
        
        .carpeta-button {
            margin-top: auto;
            width: 100%;
        }
        
        @media (max-width: 768px) {
            .carpetas-grid {
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
            <div class="card" style="padding: 1.5rem; margin-bottom: 2rem;">
                <h2 class="card-title">📁 Carpetas Virtuales por Escuela</h2>
                <p style="color: #7F8C8D; margin-bottom: 0;">Selecciona una escuela para visualizar las carpetas virtuales de los estudiantes.</p>
            </div>
            
            <div class="carpetas-grid">
                <!-- Informática -->
                <div class="carpeta-card">
                    <div class="carpeta-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/4706/4706330.png" alt="Informática">
                    </div>
                    <div class="carpeta-content">
                        <h3 class="carpeta-title">INFORMÁTICA</h3>
                        <button onclick="location.href='./carpetas_informatica.php'" class="btn btn-primary carpeta-button">
                            📂 Ver Carpetas
                        </button>
                    </div>
                </div>

                <!-- Electrónica -->
                <div class="carpeta-card">
                    <div class="carpeta-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/4706/4706330.png" alt="Electrónica">
                    </div>
                    <div class="carpeta-content">
                        <h3 class="carpeta-title">ELECTRÓNICA</h3>
                        <button onclick="location.href='./carpetas_electronica.php'" class="btn btn-primary carpeta-button">
                            📂 Ver Carpetas
                        </button>
                    </div>
                </div>

                <!-- Mecatrónica -->
                <div class="carpeta-card">
                    <div class="carpeta-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/4706/4706330.png" alt="Mecatrónica">
                    </div>
                    <div class="carpeta-content">
                        <h3 class="carpeta-title">MECATRÓNICA</h3>
                        <button onclick="location.href='./carpetas_mecatronica.php'" class="btn btn-primary carpeta-button">
                            📂 Ver Carpetas
                        </button>
                    </div>
                </div>

                <!-- Telecomunicaciones -->
                <div class="carpeta-card">
                    <div class="carpeta-icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/4706/4706330.png" alt="Telecomunicaciones">
                    </div>
                    <div class="carpeta-content">
                        <h3 class="carpeta-title">TELECOMUNICACIONES</h3>
                        <button onclick="location.href='./carpetas_telecomunicaciones.php'" class="btn btn-primary carpeta-button">
                            📂 Ver Carpetas
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>