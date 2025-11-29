<?php
session_start();
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "index.html"; 
    </script>';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alumnos - Docente</title>
    <link rel="stylesheet" href="assets/css/modern-theme.css" />
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .container {
            display: block;
            padding: 0;
        }

        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page-badge {
            background: linear-gradient(135deg, #2C3E50 0%, #34495E 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .page-badge h1 {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .back-button {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .schools-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .school-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .school-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
        }

        .school-card-header {
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .school-card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0.1;
            z-index: 0;
        }

        .school-card.tele .school-card-header {
            background: linear-gradient(135deg, #16A085 0%, #138D75 100%);
        }

        .school-card.info .school-card-header {
            background: linear-gradient(135deg, #3498DB 0%, #2980B9 100%);
        }

        .school-card.meca .school-card-header {
            background: linear-gradient(135deg, #9B59B6 0%, #8E44AD 100%);
        }

        .school-card.elec .school-card-header {
            background: linear-gradient(135deg, #E74C3C 0%, #C0392B 100%);
        }

        .school-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .school-name {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .school-card-body {
            padding: 2rem;
        }

        .school-description {
            color: #7f8c8d;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .school-button {
            width: 100%;
            padding: 0.875rem;
            background: #FFCC00;
            color: #2C3E50;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .school-button:hover {
            background: #FFD700;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 204, 0, 0.3);
        }

        @media (max-width: 768px) {
            .schools-grid {
                grid-template-columns: 1fr;
            }

            .main-content {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <main class="main-content">
            <div class="page-badge">
                <h1>👥 Alumnos por Escuela Profesional</h1>
                <a href="menusecretaria.php" class="back-button">← Volver al inicio</a>
            </div>

            <div class="schools-grid">
                <!-- Telecomunicaciones -->
                <a href="buscar-telecomunicaones.php" class="school-card tele">
                    <div class="school-card-header">
                        <div class="school-icon">📡</div>
                        <h2 class="school-name">TELECOMUNICACIONES</h2>
                    </div>
                    <div class="school-card-body">
                        <p class="school-description">
                            Busca y visualiza los alumnos de la Escuela Profesional de Ingeniería de Telecomunicaciones.
                        </p>
                        <button class="school-button">Buscar Alumnos →</button>
                    </div>
                </a>

                <!-- Informática -->
                <a href="buscar-informatica.php" class="school-card info">
                    <div class="school-card-header">
                        <div class="school-icon">💻</div>
                        <h2 class="school-name">INFORMÁTICA</h2>
                    </div>
                    <div class="school-card-body">
                        <p class="school-description">
                            Busca y visualiza los alumnos de la Escuela Profesional de Ingeniería Informática.
                        </p>
                        <button class="school-button">Buscar Alumnos →</button>
                    </div>
                </a>

                <!-- Mecatrónica -->
                <a href="buscar-mecatronica.php" class="school-card meca">
                    <div class="school-card-header">
                        <div class="school-icon">⚙️</div>
                        <h2 class="school-name">MECATRÓNICA</h2>
                    </div>
                    <div class="school-card-body">
                        <p class="school-description">
                            Busca y visualiza los alumnos de la Escuela Profesional de Ingeniería Mecatrónica.
                        </p>
                        <button class="school-button">Buscar Alumnos →</button>
                    </div>
                </a>

                <!-- Electrónica -->
                <a href="buscar-electronica.php" class="school-card elec">
                    <div class="school-card-header">
                        <div class="school-icon">⚡</div>
                        <h2 class="school-name">ELECTRÓNICA</h2>
                    </div>
                    <div class="school-card-body">
                        <p class="school-description">
                            Busca y visualiza los alumnos de la Escuela Profesional de Ingeniería Electrónica.
                        </p>
                        <button class="school-button">Buscar Alumnos →</button>
                    </div>
                </a>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>