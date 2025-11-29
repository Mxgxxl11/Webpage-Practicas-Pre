<?php
session_start();
include './assets/controladores/bd.php';
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>  
    alert("Para continuar debe iniciar sesión");  
    window.location = "index.html";   
    </script>';
}
$codigo_admin = $_SESSION['codigo_institucional'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones - Administrador</title>
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
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .container {
            display: block;
            padding: 0;
        }

        .main-content {
            max-width: 1600px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .page-header {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .page-header h1 {
            color: #2C3E50;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #7f8c8d;
            font-size: 14px;
        }

        .search-bar {
            background: white;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        .search-bar form {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 15px;
            align-items: end;
        }

        .search-bar .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .search-bar label {
            font-size: 14px;
            font-weight: 600;
            color: #2C3E50;
        }

        .search-bar input[type="number"],
        .search-bar input[type="text"] {
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s;
        }

        .search-bar input:focus {
            outline: none;
            border-color: #FFCC00;
            box-shadow: 0 0 0 3px rgba(255, 204, 0, 0.1);
        }

        .search-bar button {
            padding: 12px 30px;
            background: #FFCC00;
            color: #2C3E50;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
        }

        .search-bar button:hover {
            background: #e6b800;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 204, 0, 0.3);
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .action-buttons a {
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-show-all {
            background: white;
            color: #2C3E50;
            border: 2px solid #FFCC00;
        }

        .btn-show-all:hover {
            background: #FFCC00;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 204, 0, 0.2);
        }

        .btn-download {
            background: #2C3E50;
            color: white;
        }

        .btn-download:hover {
            background: #1a252f;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(44, 62, 80, 0.3);
        }

        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, #2C3E50 0%, #3d5a80 100%);
        }

        thead th {
            padding: 18px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s;
        }

        tbody tr:hover {
            background-color: #FFF9E6;
        }

        tbody td {
            padding: 16px;
            font-size: 14px;
            color: #2C3E50;
        }

        tbody td:first-child {
            font-weight: 600;
            color: #FFCC00;
        }

        .message-cell {
            max-width: 400px;
            line-height: 1.5;
        }

        .date-cell {
            color: #7f8c8d;
            font-size: 13px;
            white-space: nowrap;
        }

        .no-results {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
            font-size: 14px;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: white;
            color: #2C3E50;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            margin-bottom: 20px;
            border: 2px solid #e0e0e0;
        }

        .back-button:hover {
            border-color: #FFCC00;
            background: #FFF9E6;
            transform: translateX(-5px);
        }

        @media (max-width: 968px) {
            .search-bar form {
                grid-template-columns: 1fr;
            }

            .main-content {
                padding: 20px 10px;
            }

            table {
                font-size: 12px;
            }

            thead th, tbody td {
                padding: 12px 8px;
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
            <a href="menuadmin.php" class="back-button">
                ← Volver al Panel
            </a>

            <div class="page-header">
                <h1>📬 Notificaciones del Sistema</h1>
                <p>Gestión y seguimiento de todas las notificaciones de estudiantes</p>
            </div>

            <div class="search-bar">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="form-group">
                        <label for="codigo">Código de Alumno</label>
                        <input type="number" id="codigo" name="codigo" placeholder="Ej: 2020123456" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="alumno">Nombre de Alumno</label>
                        <input type="text" id="alumno" name="alumno" placeholder="Nombre o apellido" autocomplete="off">
                    </div>
                    <button type="submit" name="enviar">🔍 Buscar</button>
                </form>
            </div>

            <div class="action-buttons">
                <a href="notificaciones-admin.php" class="btn-show-all">📋 Mostrar Todas</a>
                <a href="assets/controladores/reporte_notificaciones.php" target="_blank" class="btn-download">📥 Descargar Informe</a>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre Alumno</th>
                            <th>Escuela</th>
                            <th>Mensaje</th>
                            <th>Fecha-Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                    <?php
                    if (isset($_POST['enviar'])) {
                        // Busqueda en notificaciones  
                        $codigo = $_POST['codigo'];
                        $alumno = $_POST['alumno'];
                        if (empty($codigo) && empty($alumno)) {
                            echo '<script>  
                        alert("Ingresa algún dato para buscar");  
                        window.location = "./notificaciones-admin.php";   
                        </script>';
                        } else {
                            if (empty($alumno)) {
                                $busqueda = "SELECT u.codigo,u.nombre1, u.apellido1, e.escuela, n.mensaje, n.fecha_notificacion   
                                FROM notificaciones n   
                                JOIN usuario u ON u.codigo = n.id_usuario
                                JOIN escuelas e ON e.id_escuela = u.id_escuela  
                                WHERE n.id_usuario <> '$codigo_admin' AND u.codigo LIKE '%" . $codigo . "%'";
                            } else if (empty($codigo)) {
                                $busqueda = "SELECT u.codigo,u.nombre1, u.apellido1, e.escuela, n.mensaje, n.fecha_notificacion   
                                FROM notificaciones n   
                                JOIN usuario u ON u.codigo = n.id_usuario
                                JOIN escuelas e ON e.id_escuela = u.id_escuela  
                                WHERE n.id_usuario <> '$codigo_admin' AND (u.nombre1 LIKE '%" . $alumno . "%'  
                                OR u.apellido1 LIKE '%" . $alumno . "%')";
                            } else {
                                $busqueda = "SELECT u.codigo,u.nombre1, u.apellido1, e.escuela, n.mensaje, n.fecha_notificacion   
                                FROM notificaciones n   
                                JOIN usuario u ON u.codigo = n.id_usuario
                                JOIN escuelas e ON e.id_escuela = u.id_escuela
                                WHERE n.id_usuario <> '$codigo_admin' AND u.codigo LIKE '%" . $codigo . "%'
                                AND (u.nombre1 LIKE '%" . $alumno . "%'  
                                OR u.apellido1 LIKE '%" . $alumno . "%')";
                            }
                        }
                        $ejec = mysqli_query($conexion, $busqueda);
                        if ($ejec && mysqli_num_rows($ejec) > 0) {
                            while ($filas = mysqli_fetch_assoc($ejec)) { ?>
                                <tr>
                                    <td><strong><?php echo $filas['codigo']; ?></strong></td>
                                    <td><?php echo $filas['nombre1'] . ' ' . $filas['apellido1']; ?></td>
                                    <td><?php echo $filas['escuela']; ?></td>
                                    <td class="message-cell"><?php echo $filas['mensaje']; ?></td>
                                    <td class="date-cell"><?php echo $filas['fecha_notificacion']; ?></td>
                                </tr>
                            <?php }
                        } else {
                            echo '<tr><td colspan="5" class="no-results">❌ No se encontraron notificaciones con los criterios especificados.</td></tr>';
                        }
                    } else {
                        // Mostrar todas las notificaciones  
                        $consulta = "SELECT u.codigo,u.nombre1, u.apellido1, e.escuela, n.mensaje, n.fecha_notificacion   
                    FROM notificaciones n   
                    JOIN usuario u ON u.codigo = n.id_usuario
                    JOIN escuelas e ON e.id_escuela = u.id_escuela  
                    WHERE n.id_usuario <> '$codigo_admin'";

                        $ejecucion = mysqli_query($conexion, $consulta);
                        while ($filas = mysqli_fetch_assoc($ejecucion)) { ?>
                            <tr>
                                <td><strong><?php echo $filas['codigo']; ?></strong></td>
                                <td><?php echo $filas['nombre1'] . ' ' . $filas['apellido1']; ?></td>
                                <td><?php echo $filas['escuela']; ?></td>
                                <td class="message-cell"><?php echo $filas['mensaje']; ?></td>
                                <td class="date-cell"><?php echo $filas['fecha_notificacion']; ?></td>
                            </tr>
                    <?php }
                    } ?>
                    </tbody>
                </table>
            </div>
            <?php mysqli_close($conexion) ?>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>