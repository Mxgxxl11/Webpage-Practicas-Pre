<!-- Esta página muestra TODOS los usuarios registrados en el sistema
 IMPORTANTE: Pertenece al apartado de ADMINISTRADORES-->
<?php
session_start();
include './assets/controladores/bd.php';
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
    <title>Ver Usuarios - Administración</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/modern-theme.css">
    <link rel="stylesheet" href="assets/css/mesadepartes.css">
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

        .badge-role {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-admin {
            background: #FFE5E5;
            color: #D32F2F;
        }

        .badge-docente {
            background: #E3F2FD;
            color: #1976D2;
        }

        .badge-alumno {
            background: #F3E5F5;
            color: #7B1FA2;
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
        <main class="main-content" style="max-width: 1400px; margin: 0 auto;">
            <div class="card">
                <h2 class="card-title">👥 Gestión de Usuarios</h2>
                <p style="color: #7F8C8D; margin-bottom: 1.5rem;">Visualiza y busca todos los usuarios registrados en el sistema.</p>

                <!-- Barra de búsqueda -->
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                    <div class="search-bar">
                        <div>
                            <label for="codigo">Código de Usuario</label>
                            <input type="number" id="codigo" name="codigo" autocomplete="off" placeholder="Ej: 2019123456">
                        </div>
                        <div>
                            <label for="rol">Rol</label>
                            <input type="text" id="rol" name="rol" autocomplete="off" placeholder="Ej: Alumno, Docente, Administrador">
                        </div>
                        <button type="submit" name="enviar" class="btn btn-primary" style="margin-bottom: 0;">
                            🔍 Buscar
                        </button>
                    </div>
                </form>

                <!-- Botones de acción -->
                <div class="action-buttons">
                    <a href="ver_usuarios.php" class="btn btn-outline">
                        📋 Mostrar Todos
                    </a>
                    <a href="assets/controladores/reporte_usuarios.php" class="btn btn-secondary">
                        📥 Descargar Informe
                    </a>
                </div>

                <!-- Tabla de usuarios -->
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre Completo</th>
                                <th>Escuela</th>
                                <th>Rol</th>
                                <th>Correo Electrónico</th>
                                <th>Fecha de Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_POST['enviar'])) {
                                //Búsqueda filtrada
                                $codigo = $_POST['codigo'];
                                $rol = $_POST['rol'];
                                if (empty($codigo) and empty($rol)) {
                                    echo '<script>
                                    alert("Ingresa algún dato para buscar");
                                    window.location = "./ver_usuarios.php"; 
                                    </script>';
                                } else {
                                    if (empty($rol)) {
                                        $busqueda = "SELECT a.id_usuario,r.nombre_rol,u.codigo,u.nombre1,u.apellido1, u.correo,u.fecha_creacion,e.escuela  
                                            FROM usuario u
                                            JOIN acceso a ON u.codigo = a.id_usuario
                                            JOIN roles r ON a.id_rol = r.id_rol
                                            JOIN escuelas e ON e.id_escuela = u.id_escuela
                                            WHERE u.codigo like '%" . $codigo . "%'";
                                    }
                                    if (empty($codigo)) {
                                        $busqueda = "SELECT a.id_usuario,r.nombre_rol,u.codigo,u.nombre1,u.apellido1, u.correo,u.fecha_creacion,e.escuela  
                                        FROM usuario u
                                        JOIN acceso a ON u.codigo = a.id_usuario
                                        JOIN roles r ON a.id_rol = r.id_rol
                                        JOIN escuelas e ON e.id_escuela = u.id_escuela
                                        WHERE r.nombre_rol like '%" . $rol . "%'";
                                    }
                                    if (!empty($rol) and !empty($codigo)) {
                                        $busqueda = "SELECT a.id_usuario,r.nombre_rol,u.codigo,u.nombre1,u.apellido1, u.correo,u.fecha_creacion, e.escuela  
                                        FROM usuario u
                                        JOIN acceso a ON u.codigo = a.id_usuario
                                        JOIN roles r ON a.id_rol = r.id_rol
                                        JOIN escuelas e ON e.id_escuela = u.id_escuela
                                        WHERE u.codigo like '%" . $codigo . "%' and r.nombre_rol like '%" . $rol . "%'";
                                    }
                                }
                                $ejec = mysqli_query($conexion, $busqueda);
                                if ($ejec) {
                                    while ($filas = mysqli_fetch_assoc($ejec)) { 
                                        $rol_class = '';
                                        if ($filas['nombre_rol'] == 'Administrador') $rol_class = 'badge-admin';
                                        elseif ($filas['nombre_rol'] == 'Docente') $rol_class = 'badge-docente';
                                        else $rol_class = 'badge-alumno';
                                        ?>
                                        <tr>
                                            <td><strong><?php echo $filas['codigo'] ?></strong></td>
                                            <td><?php echo $filas['nombre1'] . ' ' . $filas['apellido1']; ?></td>
                                            <td><?php echo $filas['escuela']; ?></td>
                                            <td>
                                                <span class="badge-role <?php echo $rol_class; ?>">
                                                    <?php echo $filas['nombre_rol'] ?>
                                                </span>
                                            </td>
                                            <td><?php echo $filas['correo']; ?></td>
                                            <td style="text-align:center;"><?php echo $filas['fecha_creacion']; ?></td>
                                        </tr>
                                    <?php }
                                }
                            } else {
                                //Mostrar todos los usuarios
                                $consulta = "SELECT a.id_usuario,r.nombre_rol,u.codigo,u.nombre1,u.apellido1,e.escuela, u.correo,u.fecha_creacion  
                                            FROM usuario u
                                            JOIN acceso a ON u.codigo = a.id_usuario
                                            JOIN roles r ON a.id_rol = r.id_rol
                                            JOIN escuelas e ON e.id_escuela = u.id_escuela;";
                                $ejecucion = mysqli_query($conexion, $consulta);
                                while ($filas = mysqli_fetch_assoc($ejecucion)) { 
                                    $rol_class = '';
                                    if ($filas['nombre_rol'] == 'Administrador') $rol_class = 'badge-admin';
                                    elseif ($filas['nombre_rol'] == 'Docente') $rol_class = 'badge-docente';
                                    else $rol_class = 'badge-alumno';
                                    ?>
                                    <tr>
                                        <td><strong><?php echo $filas['codigo'] ?></strong></td>
                                        <td><?php echo $filas['nombre1'] . ' ' . $filas['apellido1']; ?></td>
                                        <td><?php echo $filas['escuela']; ?></td>
                                        <td>
                                            <span class="badge-role <?php echo $rol_class; ?>">
                                                <?php echo $filas['nombre_rol'] ?>
                                            </span>
                                        </td>
                                        <td><?php echo $filas['correo']; ?></td>
                                        <td style="text-align:center;"><?php echo $filas['fecha_creacion']; ?></td>
                                    </tr>
                            <?php }
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