<?php
session_start();
include './assets/controladores/bd.php';
if (empty($_SESSION['codigo_institucional'])) {
    echo '<script>
    alert("Para continuar debe iniciar sesión");
    window.location = "index.html"; 
    </script>';
}
//ESTE CODIGO ES PARA ASIGNAR UN DOCENTE DESDE EL PORTAL DE ADMINISTRADOR
//TOTALMENTE FUNCIONAL
//Para que los alumnos registrados salgan en este portal, deben primero
//completar el form del portal alumno de la carta de presentacion

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Docentes - Administración</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/modern-theme.css">
    <link rel="stylesheet" href="assets/css/mesadepartes.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
    <style>
        .search-bar {
            display: flex;
            gap: 1rem;
            align-items: end;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .search-bar > div {
            flex: 1;
            min-width: 200px;
            display: flex;
            flex-direction: column;
        }

        .search-bar label {
            font-weight: 600;
            color: #2C3E50;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .search-bar input {
            padding: 0.875rem 1rem;
            border: 2px solid #ECF0F1;
            border-radius: 12px;
            font-size: 0.95rem;
            background: #f8f9fa;
            color: #2C3E50;
        }

        .search-bar input:focus {
            outline: none;
            border-color: #FFCC00;
            box-shadow: 0 0 0 3px rgba(255, 204, 0, 0.1);
            background: #FFFFFF;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .table-container {
            overflow-x: auto;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        thead {
            background: linear-gradient(135deg, #2C3E50 0%, #34495E 100%);
            color: white;
        }

        thead th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr {
            border-bottom: 1px solid #ECF0F1;
            transition: background-color 0.2s ease;
        }

        tbody tr:hover {
            background-color: #FFF9E6;
        }

        tbody td {
            padding: 1rem;
            color: #2C3E50;
            font-size: 0.95rem;
        }

        .status-tag {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-asignado {
            background: #d4edda;
            color: #155724;
        }

        .status-no-asignado {
            background: #f8d7da;
            color: #721c24;
        }

        .action-link {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .action-link.asignar {
            background: #FFCC00;
            color: #2C3E50;
        }

        .action-link.asignar:hover {
            background: #E6B800;
            transform: translateY(-2px);
        }

        .action-link.actualizar {
            background: #3498DB;
            color: white;
        }

        .action-link.actualizar:hover {
            background: #2980B9;
            transform: translateY(-2px);
        }

        .action-link.oficio {
            background: #95A5A6;
            color: white;
        }

        .action-link.oficio:hover {
            background: #7F8C8D;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .search-bar {
                flex-direction: column;
            }

            .search-bar > div {
                width: 100%;
            }

            thead th {
                font-size: 0.8rem;
                padding: 0.75rem 0.5rem;
            }

            tbody td {
                font-size: 0.85rem;
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
</head>

<body>
    <header>
        <?php include './includes/header.php'; ?>
    </header>
    <div class="container" style="display: block;">
        <main class="main-content" style="max-width: 1600px; margin: 0 auto;">
            <div class="card">
                <h2 class="card-title">👨‍🏫 Asignar Docente a Alumno</h2>
                <p style="color: #7F8C8D; margin-bottom: 1.5rem;">
                    <strong>Nota:</strong> Solo aparecerán los alumnos que completaron el formulario de carta de presentación.
                </p>

                <!-- Barra de búsqueda -->
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="search-bar">
                        <div>
                            <label for="codigo">Código del Alumno</label>
                            <input type="number" id="codigo" name="codigo" autocomplete="off" placeholder="Ej: 2019123456">
                        </div>
                        <div>
                            <label for="nombre">Nombre (Alumno o Docente)</label>
                            <input type="text" id="nombre" name="nombre" autocomplete="off" placeholder="Ej: Juan, María">
                        </div>
                        <button type="submit" name="enviar" class="btn btn-primary" style="margin-bottom: 0;">
                            🔍 Buscar
                        </button>
                    </div>
                </form>

                <!-- Botones de acción -->
                <div class="action-buttons">
                    <a href="asignar_docente.php" class="btn btn-outline">
                        📋 Mostrar Todos
                    </a>
                    <a href="assets/controladores/generate_pdf.php" target="_blank" class="btn btn-secondary">
                        📥 Descargar Informe
                    </a>
                </div>

                <!-- Tabla de asignaciones -->
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre Alumno</th>
                                <th>Escuela</th>
                                <th>Sección</th>
                                <th>ID Docente</th>
                                <th>Docente Encargado</th>
                                <th>Acción</th>
                                <th>Generar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_POST['enviar'])) {
                                $codigo = $_POST['codigo'];
                                $nombre = $_POST['nombre'];
                                if (empty($codigo) and empty($nombre)) {
                                    echo '<script>
                                    alert("Ingresa algún dato para buscar");
                                    window.location = "./asignar_docente.php"; 
                                    </script>';
                                } else {
                                    if (empty($nombre)) {
                                        $busqueda = "SELECT u.codigo AS 'CODIGO_ALUMNO',
                                        CONCAT(u.nombre1, ' ', u.nombre2, ' ', u.apellido1, ' ', u.apellido2) AS 'NOMBRE_ALUMNO', 
                                        e.escuela, a.seccion, a.id_docente, 
                                        (SELECT GROUP_CONCAT(CONCAT(us.nombre1, ' ', us.apellido1) SEPARATOR ', ')
                                         FROM usuario us 
                                         JOIN docente dn ON dn.id_usuario = us.codigo 
                                         WHERE dn.id_docente = a.id_docente) AS 'NOMBRE_DOCENTE' 
                                         FROM usuario u 
                                         JOIN escuelas e ON e.id_escuela = u.id_escuela 
                                         JOIN alumno a ON a.id_usuario = u.codigo 
                                         JOIN acceso ac ON ac.id_usuario = u.codigo 
                                        WHERE u.codigo like '%" . $codigo . "%'";
                                    }
                                    if (empty($codigo)) {
                                        $busqueda = "SELECT u.codigo AS 'CODIGO_ALUMNO',
                                        CONCAT(u.nombre1, ' ', u.nombre2, ' ', u.apellido1, ' ', u.apellido2) AS 'NOMBRE_ALUMNO', 
                                        e.escuela, a.seccion, a.id_docente, 
                                        (SELECT GROUP_CONCAT(CONCAT(us.nombre1, ' ', us.apellido1) SEPARATOR ', ')
                                         FROM usuario us 
                                         JOIN docente dn ON dn.id_usuario = us.codigo 
                                         WHERE dn.id_docente = a.id_docente) AS 'NOMBRE_DOCENTE' 
                                         FROM usuario u 
                                         JOIN escuelas e ON e.id_escuela = u.id_escuela 
                                         JOIN alumno a ON a.id_usuario = u.codigo 
                                         JOIN acceso ac ON ac.id_usuario = u.codigo
                                         WHERE u.nombre1 LIKE '%" . $nombre . "%'
                                         OR u.nombre2 LIKE '%" . $nombre . "%'
                                         OR u.apellido1 LIKE '%" . $nombre . "%'
                                         OR u.apellido2 LIKE '%" . $nombre . "%'
                                         OR a.id_docente IN (SELECT dn.id_docente 
                                         FROM docente dn 
                                         JOIN usuario us ON us.codigo = dn.id_usuario
                                         WHERE us.nombre1 LIKE '%" . $nombre . "%' 
                                         OR us.apellido1 LIKE '%" . $nombre . "%');";
                                    }
                                    if (!empty($codigo) and !empty($nombre)) {
                                        $busqueda = "SELECT u.codigo AS 'CODIGO_ALUMNO',
                                        CONCAT(u.nombre1, ' ', u.nombre2, ' ', u.apellido1, ' ', u.apellido2) AS 'NOMBRE_ALUMNO', 
                                        e.escuela, a.seccion, a.id_docente, 
                                        (SELECT GROUP_CONCAT(CONCAT(us.nombre1, ' ', us.apellido1) SEPARATOR ', ')
                                         FROM usuario us 
                                         JOIN docente dn ON dn.id_usuario = us.codigo 
                                         WHERE dn.id_docente = a.id_docente) AS 'NOMBRE_DOCENTE' 
                                         FROM usuario u 
                                         JOIN escuelas e ON e.id_escuela = u.id_escuela 
                                         JOIN alumno a ON a.id_usuario = u.codigo 
                                         JOIN acceso ac ON ac.id_usuario = u.codigo
                                         WHERE u.codigo like '%" . $codigo . "%' and u.nombre1 LIKE '%" . $nombre . "%'
                                         OR u.nombre2 LIKE '%" . $nombre . "%'
                                         OR u.apellido1 LIKE '%" . $nombre . "%'
                                         OR u.apellido2 LIKE '%" . $nombre . "%'
                                         OR a.id_docente IN (SELECT dn.id_docente 
                                         FROM docente dn 
                                         JOIN usuario us ON us.codigo = dn.id_usuario
                                         WHERE us.nombre1 LIKE '%" . $nombre . "%' 
                                         OR us.apellido1 LIKE '%" . $nombre . "%');";
                                    }
                                }
                                $ejec = mysqli_query($conexion, $busqueda);
                                if ($ejec) {
                                    while ($filas = mysqli_fetch_assoc($ejec)) { ?>
                                        <tr>
                                            <td><strong><?php echo $filas['CODIGO_ALUMNO'] ?></strong></td>
                                            <td><?php echo $filas['NOMBRE_ALUMNO']; ?></td>
                                            <td><?php echo $filas['escuela'] ?></td>
                                            <td><?php echo $filas['seccion']; ?></td>
                                            <td>
                                                <?php 
                                                if (is_null($filas['id_docente'])) {
                                                    echo '<span class="status-tag status-no-asignado">Sin asignar</span>';
                                                } else {
                                                    echo $filas['id_docente'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if (is_null($filas['NOMBRE_DOCENTE'])) {
                                                    echo '<span class="status-tag status-no-asignado">No asignado</span>';
                                                } else {
                                                    echo $filas['NOMBRE_DOCENTE'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if (is_null($filas['id_docente'])) {
                                                    echo "<a class='action-link asignar' href='./actualizar_docente.php?CODIGO_ALUMNO=" . $filas['CODIGO_ALUMNO'] . "'>➕ Asignar</a>";
                                                } else {
                                                    echo "<a class='action-link actualizar' href='./actualizar_docente.php?id_docente=" . $filas['id_docente'] . "&CODIGO_ALUMNO=" . $filas['CODIGO_ALUMNO'] . "'>✏️ Actualizar</a>";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a class='action-link oficio' href='./generar_const_docente.php?codigo=<?php echo $filas["CODIGO_ALUMNO"]; ?>'>📄 Oficio</a>
                                            </td>
                                        </tr>
                                    <?php }
                                }
                            } else {
                                $consulta = "SELECT u.codigo AS 'CODIGO_ALUMNO',
                                CONCAT(u.nombre1, ' ', u.nombre2, ' ', u.apellido1, ' ', u.apellido2) AS 'NOMBRE_ALUMNO', 
                                e.escuela, a.seccion, a.id_docente, 
                                (SELECT GROUP_CONCAT(CONCAT(us.nombre1, ' ', us.apellido1) SEPARATOR ', ')
                                 FROM usuario us 
                                 JOIN docente dn ON dn.id_usuario = us.codigo 
                                 WHERE dn.id_docente = a.id_docente) AS 'NOMBRE_DOCENTE' 
                                 FROM usuario u 
                                 JOIN escuelas e ON e.id_escuela = u.id_escuela 
                                 JOIN alumno a ON a.id_usuario = u.codigo 
                                 JOIN acceso ac ON ac.id_usuario = u.codigo 
                                 WHERE ac.id_rol = 3";
                                $ejecucion = mysqli_query($conexion, $consulta);
                                if ($ejecucion) {
                                    while ($filas = mysqli_fetch_assoc($ejecucion)) { ?>
                                        <tr>
                                            <td><strong><?php echo $filas['CODIGO_ALUMNO'] ?></strong></td>
                                            <td><?php echo $filas['NOMBRE_ALUMNO']; ?></td>
                                            <td><?php echo $filas['escuela'] ?></td>
                                            <td><?php echo $filas['seccion']; ?></td>
                                            <td>
                                                <?php 
                                                if (is_null($filas['id_docente'])) {
                                                    echo '<span class="status-tag status-no-asignado">Sin asignar</span>';
                                                } else {
                                                    echo $filas['id_docente'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if (is_null($filas['NOMBRE_DOCENTE'])) {
                                                    echo '<span class="status-tag status-no-asignado">No asignado</span>';
                                                } else {
                                                    echo $filas['NOMBRE_DOCENTE'];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if (is_null($filas['id_docente'])) {
                                                    echo "<a class='action-link asignar' href='./actualizar_docente.php?CODIGO_ALUMNO=" . $filas['CODIGO_ALUMNO'] . "'>➕ Asignar</a>";
                                                } else {
                                                    echo "<a class='action-link actualizar' href='./actualizar_docente.php?id_docente=" . $filas['id_docente'] . "&CODIGO_ALUMNO=" . $filas['CODIGO_ALUMNO'] . "'>✏️ Actualizar</a>";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a class='action-link oficio' href='./generar_const_docente.php?codigo=<?php echo $filas["CODIGO_ALUMNO"]; ?>'>📄 Oficio</a>
                                            </td>
                                        </tr>
                            <?php }
                                } else {
                                    die('Error en la consulta: ' . mysqli_error($conexion));
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>
                <?php mysqli_close($conexion) ?>
            </div>
        </main>
    </div>
    <script src="assets/js/mesadepartes.js"></script>
</body>

</html>
