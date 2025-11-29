<!-- NOTIFICACIONES DOCENTE-->
<?php
session_start();
include './assets/controladores/bd.php';
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>  
    alert("Para continuar debe iniciar sesión");  
    window.location = "index.html";   
    </script>';
}
$codigo = $_SESSION['codigo_institucional'];
$id_docente = 0;
try {
    // Preparar consulta  
    $stmt = $conexion->prepare("SELECT id_docente FROM docente WHERE id_usuario = ?");
    $stmt->bind_param("i", $codigo);
    $stmt->execute();
    $stmt->bind_result($id_docente);
    $stmt->fetch();
    $stmt->close();
} catch (Exception $e) {
    echo 'Error en la consulta: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones - Prácticas Pre Profesionales</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/modern-theme.css" />
    <link rel="stylesheet" href="assets/css/mesadepartes.css" />
    <style>
        .notifications-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .notification-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-left: 4px solid #FFCC00;
            transition: all 0.3s ease;
            display: flex;
            gap: 1.5rem;
            align-items: start;
        }
        
        .notification-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
            transform: translateX(5px);
        }
        
        .notification-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #FFCC00 0%, #FFD633 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        
        .notification-content {
            flex: 1;
        }
        
        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 0.75rem;
            gap: 1rem;
        }
        
        .notification-sender {
            font-weight: 600;
            color: #2C3E50;
            font-size: 1.1rem;
        }
        
        .notification-date {
            color: #6c757d;
            font-size: 0.875rem;
            white-space: nowrap;
        }
        
        .notification-message {
            color: #495057;
            line-height: 1.6;
            font-size: 0.938rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #6c757d;
        }
        
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
    </style>
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container" style="display: block;">
        <main class="main-content notifications-container">
            
            <div class="card" style="padding: 0;">
                <?php
                // Corregido y puesto en el contexto correcto  
                $consulta = "  
                SELECT u.nombre1, u.apellido1, n.mensaje, n.fecha_notificacion, n.leido   
                FROM notificaciones n   
                JOIN usuario u ON u.codigo = n.id_usuario  
                WHERE (n.id_profesor = '$id_docente' AND (tipo_notificacion = 'Examen Final Resuelto' OR tipo_notificacion = 'Informe Final'))";

                $ejecucion = mysqli_query($conexion, $consulta);
                $total_notificaciones = mysqli_num_rows($ejecucion);
                
                if ($total_notificaciones > 0) {
                    echo '<div style="padding: 1.5rem;">';
                    while ($filas = mysqli_fetch_assoc($ejecucion)) {
                ?>
                        <div class="notification-card">
                            <div class="notification-icon">📨</div>
                            <div class="notification-content">
                                <div class="notification-header">
                                    <div class="notification-sender">
                                        <?php echo htmlspecialchars($filas['nombre1'] . ' ' . $filas['apellido1']); ?>
                                    </div>
                                    <div class="notification-date">
                                        <?php echo date('d/m/Y H:i', strtotime($filas['fecha_notificacion'])); ?>
                                    </div>
                                </div>
                                <div class="notification-message">
                                    <?php echo nl2br(htmlspecialchars($filas['mensaje'])); ?>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                    echo '</div>';
                } else {
                ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">📥</div>
                        <h3 style="color: #2C3E50; margin-bottom: 0.5rem;">No tienes notificaciones</h3>
                        <p>Cuando tu docente envíe mensajes, aparecerán aquí.</p>
                    </div>
                <?php
                }
                ?>
            </div>
        </main>
    </div>
            <?php mysqli_close($conexion) ?>
        </article>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>