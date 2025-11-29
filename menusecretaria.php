<!-- NO SE SI ELIMINAREMOS ESTE MENU O NO. LO HABLAMOS EN EL SPRINT 6 -->
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Docente - UNFV</title>
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

        .welcome-badge {
            background: linear-gradient(135deg, #2C3E50 0%, #34495E 100%);
            color: white;
            padding: 1.5rem 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .welcome-badge h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .welcome-badge p {
            font-size: 1rem;
            line-height: 1.6;
            opacity: 0.95;
            margin: 0;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
            border: 2px solid transparent;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            border-color: #FFCC00;
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        .card h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 0.75rem;
        }

        .card p {
            font-size: 0.95rem;
            color: #7f8c8d;
            line-height: 1.6;
        }

        .card-badge {
            display: inline-block;
            background: linear-gradient(135deg, #FFCC00 0%, #FFD700 100%);
            color: #2C3E50;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container">
        <main class="main-content">
            <div class="welcome-badge">
                <h1>👨‍🏫 Portal de Docente de Prácticas Pre Profesionales</h1>
                <p>Este espacio está diseñado para facilitar la gestión y supervisión de los trámites de las prácticas pre profesionales de los estudiantes. Aquí encontrarás todas las herramientas necesarias para monitorear el progreso de tus alumnos y supervisar el avance de sus documentos.</p>
            </div>

            <div class="cards-grid">
                <a href="perfil-docente.php" class="card">
                    <span class="card-icon">👤</span>
                    <h2>Mi Perfil</h2>
                    <p>Visualiza y actualiza tu información personal, datos de contacto y configuración de cuenta.</p>
                    <span class="card-badge">Ver Perfil</span>
                </a>

                <a href="ver-alumno.php" class="card">
                    <span class="card-icon">👥</span>
                    <h2>Alumnos</h2>
                    <p>Consulta la lista de estudiantes bajo tu supervisión, revisa sus carpetas virtuales y evalúa su progreso.</p>
                    <span class="card-badge">Ver Alumnos</span>
                </a>

                <a href="noti_docente.php" class="card">
                    <span class="card-icon">🔔</span>
                    <h2>Notificaciones</h2>
                    <p>Revisa las notificaciones y alertas importantes sobre los trámites de tus estudiantes.</p>
                    <span class="card-badge">Ver Notificaciones</span>
                </a>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>
</html>
