<?php
session_start();
include './assets/controladores/bd.php';
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "index.html"; 
    </script>';
}
$direccion_carpeta = "./assets/carpetas_virtuales/";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carpetas Telecomunicaciones - Administrador</title>
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
            max-width: 1800px;
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

        .page-header .school-badge {
            display: inline-block;
            background: linear-gradient(135deg, #16A085 0%, #138D75 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 10px;
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
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1200px;
        }

        thead {
            background: linear-gradient(135deg, #2C3E50 0%, #3d5a80 100%);
        }

        thead th {
            padding: 18px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
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
            padding: 16px 12px;
            font-size: 13px;
            color: #2C3E50;
        }

        tbody td:first-child {
            font-weight: 600;
            color: #FFCC00;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            background: #E3F2FD;
            color: #1976D2;
        }

        .action-link {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s;
            margin: 2px;
        }

        .action-link.download {
            background: #9C27B0;
            color: white;
        }

        .action-link.download:hover {
            background: #7B1FA2;
            transform: translateY(-2px);
        }

        .action-link.generate-carta {
            background: #4CAF50;
            color: white;
        }

        .action-link.generate-carta:hover {
            background: #388E3C;
            transform: translateY(-2px);
        }

        .action-link.generate-constancia {
            background: #FF9800;
            color: white;
        }

        .action-link.generate-constancia:hover {
            background: #F57C00;
            transform: translateY(-2px);
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
        }
    </style>
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>

    <div class="container">
        <main class="main-content">
            <a href="carpeta_virtual.php" class="back-button">
                ← Volver a Carpetas Virtuales
            </a>

            <div class="page-header">
                <h1>📡 Carpetas Virtuales - Telecomunicaciones</h1>
                <span class="school-badge">Escuela Profesional de Ingeniería de Telecomunicaciones</span>
            </div>

            <div class="search-bar">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="form-group">
                        <label for="codigo">Código de Alumno</label>
                        <input type="number" id="codigo" name="codigo" placeholder="Ej: 2020123456" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre de Alumno</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Nombre o apellido" autocomplete="off">
                    </div>
                    <button type="submit" name="enviar">🔍 Buscar</button>
                </form>
            </div>

            <div class="action-buttons">
                <a href="carpetas_telecomunicaciones.php" class="btn-show-all">📋 Mostrar Todos</a>
                <a href="assets/controladores/reporte_tele.php" target="_blank" class="btn-download">📥 Descargar Informe</a>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Escuela</th>
                            <th>Semestre</th>
                            <th>Sección</th>
                            <th>Proceso Culminado</th>
                            <th>Descargar</th>
                            <th colspan="2">Generar Documentos</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($_POST['enviar'])) {
                        //aca es para la busqueda
                        $codigo = $_POST['codigo'];
                        $nombre = $_POST['nombre'];
                        if (empty($codigo) and empty($nombre)) { // si no funciona codigo cambiar a $_POST['codigo']
                            echo '<script>
                            alert("Ingresa algún dato para buscar");
                            window.location = "./carpetas_telecomunicaciones.php"; 
                            </script>';
                        } else {
                            if (empty($nombre)) {
                                $busqueda = "SELECT u.codigo, u.nombre1, u.apellido1, u.correo, e.escuela, al.semestre, al.seccion, car.nombre_carpeta, p.paso 
                                FROM usuario u 
                                JOIN acceso a ON u.codigo = a.id_usuario 
                                JOIN escuelas e ON e.id_escuela = u.id_escuela 
                                JOIN alumno al ON al.id_usuario = u.codigo 
                                JOIN carpeta_virtual car ON car.id_alumno = al.id_alumno 
                                JOIN paso_cp p ON p.id_usuario = u.codigo
                                WHERE e.id_escuela = 2 and u.codigo like '%" . $codigo . "%'";
                            }
                            if (empty($codigo)) {
                                $busqueda = "SELECT u.codigo, u.nombre1, u.apellido1, u.correo, e.escuela, al.semestre, al.seccion, car.nombre_carpeta, p.paso 
                                FROM usuario u 
                                JOIN acceso a ON u.codigo = a.id_usuario 
                                JOIN escuelas e ON e.id_escuela = u.id_escuela 
                                JOIN alumno al ON al.id_usuario = u.codigo 
                                JOIN carpeta_virtual car ON car.id_alumno = al.id_alumno 
                                JOIN paso_cp p ON p.id_usuario = u.codigo
                                WHERE e.id_escuela = 2 AND (u.nombre1 LIKE '%" . $nombre . "%' OR u.nombre2 LIKE '%" . $nombre . "%' OR u.apellido1 LIKE '%" . $nombre . "%' OR u.apellido2 LIKE '%" . $nombre . "%')";
                            }
                            if (!empty($nombre) and !empty($codigo)) {
                                $busqueda = "SELECT u.codigo, u.nombre1, u.apellido1, u.correo, e.escuela, al.semestre, al.seccion, car.nombre_carpeta, p.paso 
                                FROM usuario u 
                                JOIN acceso a ON u.codigo = a.id_usuario 
                                JOIN escuelas e ON e.id_escuela = u.id_escuela 
                                JOIN alumno al ON al.id_usuario = u.codigo 
                                JOIN carpeta_virtual car ON car.id_alumno = al.id_alumno 
                                JOIN paso_cp p ON p.id_usuario = u.codigo
                                WHERE e.id_escuela = 2 and u.codigo like '%" . $codigo . "%' 
                                and (
                                 u.nombre1 LIKE '%" . $nombre . "%'
                                 OR u.nombre2 LIKE '%" . $nombre . "%'
                                 OR u.apellido1 LIKE '%" . $nombre . "%'
                                 OR u.apellido2 LIKE '%" . $nombre . "%'
                                 )";
                            }
                        }
                        $ejec = mysqli_query($conexion, $busqueda);
                        if ($ejec) {
                            while ($filas = mysqli_fetch_assoc($ejec)) {
                                $ruta_carpeta = $direccion_carpeta . $filas['nombre_carpeta'];
                    ?>
                                <tr>
                                    <td><strong><?php echo $filas['codigo'] ?></strong></td>
                                    <td><?php echo $filas['nombre1'] . ' ' . $filas['apellido1']; ?></td>
                                    <td><?php echo $filas['escuela'] ?></td>
                                    <td><?php echo $filas['semestre']; ?></td>
                                    <td><?php echo $filas['seccion']; ?></td>
                                    <td>
                                        <span class="status-badge">
                                        <?php
                                        $estado = $filas['paso'];
                                        switch ($estado) {
                                            case 1: echo "Inicio del proceso"; break;
                                            case 2: echo "Formulario datos del Alumno"; break;
                                            case 3: echo "Carta de Presentación"; break;
                                            case 4: echo "Subida de NT"; break;
                                            case 5: echo "Apertura de Carpeta"; break;
                                            case 6: echo "1er Informe"; break;
                                            case 7: echo "2do Informe"; break;
                                            case 8: echo "3er Informe"; break;
                                            case 9: echo "Constancia de culminación"; break;
                                            case 10: echo "Informe Final"; break;
                                            case 11: echo "Examen Final"; break;
                                            case 12: echo "Examen Final Subido por el docente"; break;
                                            case 13: echo "Examen Final Resuelto"; break;
                                            case 14: echo "Examen Final Calificado por el docente"; break;
                                            case 15: echo "Nota de apreciación subida"; break;
                                            case 16: echo "Docente le envió comentario"; break;
                                            case 17: echo "Docente envió ficha de evaluación (coordinador)"; break;
                                            case 18: echo "Docente envió informe final de evaluación (coordinador)"; break;
                                            case 19: echo "Solicitud de Constancia de Culminación"; break;
                                        }
                                        ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a class="action-link download" href="descargar_carpeta.php?carpeta=<?php echo urlencode($ruta_carpeta); ?>&nombre_carpeta=<?php echo urlencode($filas['nombre_carpeta']); ?>">
                                            📁 Carpeta
                                        </a>
                                    </td>
                                    <td>
                                        <a class="action-link generate-carta" href="generar_carta.php?codigo=<?php echo urlencode($filas['codigo']); ?>&carpeta=<?php echo urlencode($ruta_carpeta); ?>&nombre_carpeta=<?php echo urlencode($filas['nombre_carpeta']); ?>">
                                            📄 Carta
                                        </a>
                                    </td>
                                    <td>
                                        <a class="action-link generate-constancia" href="generar_constancia.php?codigo=<?php echo urlencode($filas['codigo']); ?>&carpeta=<?php echo urlencode($ruta_carpeta); ?>&nombre_carpeta=<?php echo urlencode($filas['nombre_carpeta']); ?>">
                                            📋 Constancia
                                        </a>
                                    </td>
                                </tr>
                            <?php }
                        }
                    } else {
                        //Mostrar todos los registros de los alumnos de telecomunicaciones
                        $consulta = "SELECT u.codigo, u.nombre1, u.apellido1, u.correo, e.escuela, al.semestre, al.seccion, car.nombre_carpeta, p.paso 
                        FROM usuario u 
                        JOIN acceso a ON u.codigo = a.id_usuario 
                        JOIN escuelas e ON e.id_escuela = u.id_escuela 
                        JOIN alumno al ON al.id_usuario = u.codigo 
                        JOIN carpeta_virtual car ON car.id_alumno = al.id_alumno 
                        JOIN paso_cp p ON p.id_usuario = u.codigo
                        WHERE a.id_rol=3 and e.id_escuela=2";
                        $ejecucion = mysqli_query($conexion, $consulta);
                        while ($filas = mysqli_fetch_assoc($ejecucion)) {
                            $ruta_carpeta = $direccion_carpeta . $filas['nombre_carpeta'];
                            ?>
                            <tr>
                                <td><strong><?php echo $filas['codigo']; ?></strong></td>
                                <td><?php echo $filas['nombre1'] . ' ' . $filas['apellido1']; ?></td>
                                <td><?php echo $filas['escuela']; ?></td>
                                <td><?php echo $filas['semestre']; ?></td>
                                <td><?php echo $filas['seccion']; ?></td>
                                <td>
                                    <span class="status-badge">
                                        <?php
                                        $estado = $filas['paso'];
                                        switch ($estado) {
                                            case 1: echo "Inicio del proceso"; break;
                                            case 2: echo "Formulario datos del Alumno"; break;
                                            case 3: echo "Carta de Presentación"; break;
                                            case 4: echo "Subida de NT"; break;
                                            case 5: echo "Apertura de Carpeta"; break;
                                            case 6: echo "1er Informe"; break;
                                            case 7: echo "2do Informe"; break;
                                            case 8: echo "3er Informe"; break;
                                            case 9: echo "Constancia de culminación"; break;
                                            case 10: echo "Informe Final"; break;
                                            case 11: echo "Examen Final"; break;
                                            case 12: echo "Examen Final Subido por el docente"; break;
                                            case 13: echo "Examen Final Resuelto"; break;
                                            case 14: echo "Examen Final Calificado por el docente"; break;
                                            case 15: echo "Nota de apreciación subida"; break;
                                            case 16: echo "Docente le envió comentario"; break;
                                            case 17: echo "Docente envió ficha de evaluación (coordinador)"; break;
                                            case 18: echo "Docente envió informe final de evaluación (coordinador)"; break;
                                            case 19: echo "Solicitud de Constancia de Culminación"; break;
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="descargar_carpeta.php?carpeta=<?php echo urlencode($ruta_carpeta); ?>&nombre_carpeta=<?php echo urlencode($filas['nombre_carpeta']); ?>" class="action-link download">
                                        📁 Descargar
                                    </a>
                                </td>
                                <td>
                                    <a href="generar_carta.php?codigo=<?php echo urlencode($filas['codigo']); ?>&carpeta=<?php echo urlencode($ruta_carpeta); ?>&nombre_carpeta=<?php echo urlencode($filas['nombre_carpeta']); ?>" class="action-link generate-carta">
                                        📄 Generar Carta
                                    </a>
                                </td>
                                <td>
                                    <a href="generar_constancia.php?codigo=<?php echo urlencode($filas['codigo']); ?>&carpeta=<?php echo urlencode($ruta_carpeta); ?>&nombre_carpeta=<?php echo urlencode($filas['nombre_carpeta']); ?>" class="action-link generate-constancia">
                                        📋 Generar Constancia
                                    </a>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>
        <?php mysqli_close($conexion); ?>
    </main>
</div>
<script src="assets/js/mesadepartes.js"></script>
</body>
</html>