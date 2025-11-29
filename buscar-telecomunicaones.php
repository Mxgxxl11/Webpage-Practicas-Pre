<?php
session_start();
include './assets/controladores/bd.php';

if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "index.html"; 
    </script>';
    exit();
}

$id_escuela_telecomunicaciones = 2;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos Telecomunicaciones - Docente</title>
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
            max-width: 1600px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page-badge {
            background: linear-gradient(135deg, #16A085 0%, #138D75 100%);
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

        .search-container {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .search-bar {
            display: flex;
            gap: 1rem;
            align-items: flex-end;
        }

        .search-field {
            flex: 1;
        }

        .search-field label {
            display: block;
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .search-field input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .search-field input:focus {
            outline: none;
            border-color: #16A085;
            background: #FFFEF8;
        }

        .btn {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .btn-primary {
            background: #16A085;
            color: white;
        }

        .btn-primary:hover {
            background: #138D75;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(22, 160, 133, 0.3);
        }

        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        .table-container {
            overflow-x: auto;
        }

        thead {
            background: linear-gradient(135deg, #2C3E50 0%, #34495E 100%);
            color: white;
        }

        thead th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.95rem;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: #FFF9E6;
        }

        tbody td {
            padding: 1rem;
            color: #2C3E50;
            font-size: 0.9rem;
        }

        tbody td:first-child {
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .action-link {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            border: none;
            cursor: pointer;
        }

        .action-link.evaluar {
            background: #3498DB;
            color: white;
        }

        .action-link.evaluar:hover {
            background: #2980B9;
            transform: translateY(-2px);
        }

        .action-link.informe {
            background: #9B59B6;
            color: white;
        }

        .action-link.informe:hover {
            background: #8E44AD;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .search-bar {
                flex-direction: column;
            }

            .btn {
                width: 100%;
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
                <h1>📡 Alumnos de Telecomunicaciones</h1>
                <a href="ver-alumno.php" class="back-button">← Volver</a>
            </div>

            <div class="search-container">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="search-bar">
                        <div class="search-field">
                            <label for="codigo">Código o Nombre del Alumno</label>
                            <input type="text" id="codigo" name="codigo" placeholder="Ingrese código o nombre">
                        </div>
                        <button type="submit" name="enviar" class="btn btn-primary">Buscar</button>
                    </div>
                </form>
            </div>

            <div class="table-container">
                <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Base</th>
                        <th>Semestre</th>
                        <th>Sección</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="team-member-rows">
                    <?php
                    if (isset($_POST['enviar'])) {
                        $codigo = $_POST['codigo'];
                        if (empty($codigo)) {
                            echo '<script>
                                alert("Ingresa algún dato para buscar");
                                </script>';
                        } else {
                            $busqueda = "SELECT u.codigo, CONCAT(u.nombre1, ' ', u.apellido1) AS nombre_completo, a.base, a.semestre, a.seccion 
                                        FROM alumno a
                                        JOIN usuario u ON a.id_usuario = u.codigo
                                        JOIN escuelas es ON u.id_escuela = es.id_escuela
                                        WHERE es.id_escuela = '$id_escuela_telecomunicaciones' AND 
                                              (u.codigo LIKE '%$codigo%' OR u.nombre1 LIKE '%$codigo%' OR u.apellido1 LIKE '%$codigo%')";
                            $ejec = mysqli_query($conexion, $busqueda);
                            if ($ejec) {
                                while ($filas = mysqli_fetch_assoc($ejec)) { ?>
                                    <tr>
                                        <td><?php echo $filas['codigo'] ?></td>
                                        <td><?php echo $filas['nombre_completo'] ?></td>
                                        <td><?php echo $filas['base'] ?></td>
                                        <td><?php echo $filas['semestre'] ?></td>
                                        <td><?php echo $filas['seccion'] ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="docente-evalua.php?codigo=<?php echo $filas['codigo']; ?>" class="action-link evaluar">✏️ Evaluar</a>
                                                <a href="ficha-evaluacion-alui.php?codigo=<?php echo $filas['codigo']; ?>" class="action-link informe">📋 Enviar informe</a>
                                            </div>
                                        </td>
                                    </tr>
                            <?php }
                            }
                        }
                    } else {
                        $consulta = "SELECT u.codigo, CONCAT(u.nombre1, ' ', u.apellido1) AS nombre_completo, a.base, a.semestre, a.seccion 
                                    FROM alumno a
                                    JOIN usuario u ON a.id_usuario = u.codigo
                                    JOIN escuelas es ON u.id_escuela = es.id_escuela
                                    WHERE es.id_escuela = '$id_escuela_telecomunicaciones'";
                        $ejecucion = mysqli_query($conexion, $consulta);
                        while ($filas = mysqli_fetch_assoc($ejecucion)) { ?>
                            <tr>
                                <td><?php echo $filas['codigo'] ?></td>
                                <td><?php echo $filas['nombre_completo'] ?></td>
                                <td><?php echo $filas['base'] ?></td>
                                <td><?php echo $filas['semestre'] ?></td>
                                <td><?php echo $filas['seccion'] ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="docente-evalua.php?codigo=<?php echo $filas['codigo']; ?>" class="action-link evaluar">✏️ Evaluar</a>
                                        <a href="ficha-evaluacion-alui.php?codigo=<?php echo $filas['codigo']; ?>" class="action-link informe">📋 Enviar informe</a>
                                    </div>
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
